<?php


function covid19ImpactEstimator($data)
{
  $reportedCases = $data["reportedCases"];
  // Currently Infected for both cases
  $currentlyInfected = currentlyInfected($reportedCases, 10);
  $currentlyInfectedWorstCase = currentlyInfected($reportedCases, 50);

  $timeToElapse = $data["timeToElapse"];
  $totalBeds = $data["totalHospitalBeds"];
  $periodType = $data["periodType"];

  $avgDailyIncomePopulation = $data["region"]["avgDailyIncomePopulation"];
  $avgDailyIncomeInUSD = $data["region"]["avgDailyIncomeInUSD"];
  

      $severeCasesByRequestedTime = intval(severeCasesByRequestedTime($currentlyInfected, $timeToElapse, $periodType));
      $severeCasesByRequestedTimeWorstCase = intval(severeCasesByRequestedTime($currentlyInfectedWorstCase, $timeToElapse, $periodType));
  
      $availableBeds = 0.35 * $totalBeds;
      $hospitalBedsByRequestedTime = intval($availableBeds - $severeCasesByRequestedTime);
      $hospitalBedsByRequestedTimeWorstCase = intval($availableBeds - $severeCasesByRequestedTimeWorstCase);


      $infectedByRequestedTime = intval(infectionsByRequestedTime($currentlyInfected, $timeToElapse, $periodType));
      $infectedByRequestedTimeWorstCase = intval(infectionsByRequestedTime($currentlyInfectedWorstCase, $timeToElapse, $periodType));


      $casesForICUByRequestedTime = 0.05 * $infectedByRequestedTime;
      $casesForICUByRequestedTimeWorstCase = 0.05 * $infectedByRequestedTimeWorstCase;

  $data = [
    "data" => $data,
    "impact" => [
      "currentlyInfected" => $currentlyInfected,
      "infectionsByRequestedTime" => $infectedByRequestedTime,
      "severeCasesByRequestedTime" => $severeCasesByRequestedTime,
      "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTime,
      "casesForICUByRequestedTime" => $casesForICUByRequestedTime,
      
    ],
    "severeImpact" => [
      "currentlyInfected" => $currentlyInfectedWorstCase,
      "infectionsByRequestedTime" => $infectedByRequestedTimeWorstCase,
      "severeCasesByRequestedTime" => $severeCasesByRequestedTimeWorstCase,
      "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTimeWorstCase,
      "casesForICUByRequestedTime" => $casesForICUByRequestedTimeWorstCase
      
    ]
  ];

  return json_encode($data);
  
}

// challenge - 1
// currentlyInfected function

function currentlyInfected($reportedCases, $multiplier)
{
  $currentlyInfected = $reportedCases * $multiplier;
  return $currentlyInfected; // Number of currentlyInfected
}


// normalize date function
function normalizeDate($periodType, $timeToElapse)
{
  switch(strtolower($periodType))
  
  {
    case 'days':
      return $timeToElapse;
      break;
    case 'weeks':
      return $timeToElapse * 7;
      break;
    case 'months':
      return $timeToElapse * 30;
      break;
  }
}

// infectionsByRequestedTime function
function infectionsByRequestedTime($currentlyInfected, $timeToElapse, $periodType)
{
  $factor = intval(normalizeDate($periodType, $timeToElapse) / 3);
  return $currentlyInfected * pow(2, $factor);
}
function severeCasesByRequestedTime($currentlyInfected, $timeToElapse, $periodType)
{
  $severeCasesByRequestedTime = 0.15 * intval(infectionsByRequestedTime($currentlyInfected, $timeToElapse, $periodType));
  return $severeCasesByRequestedTime;
}

$content = trim(file_get_contents("php://input"));

$decoded = json_decode($content, true);
header('Content-Type: application/json');
echo covid19ImpactEstimator($decoded);