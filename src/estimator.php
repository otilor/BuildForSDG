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
  

      $severeCasesByRequestedTime = intval(severeCasesByRequestedTime($currentlyInfected, $timeToElapse, $periodType));
      $severeCasesByRequestedTimeWorstCase = intval(severeCasesByRequestedTime($currentlyInfectedWorstCase, $timeToElapse, $periodType));
  
      $availableBeds = 0.35 * $totalBeds;

  $data = [
    "data" => $data,
    "impact" => [
      "currentlyInfected" => $currentlyInfected,
      "infectionsByRequestedTime" => intval(infectionsByRequestedTime($currentlyInfected, $timeToElapse, $periodType)),
      "severeCasesByRequestedTime" => $severeCasesByRequestedTime,
      "hospitalBedsByRequestedTime" => $availableBeds - $severeCasesByRequestedTime
    ],
    "severeImpact" => [
      "currentlyInfected" => $currentlyInfectedWorstCase,
      "infectionsByRequestedTime" => intval(infectionsByRequestedTime($currentlyInfectedWorstCase, $timeToElapse, $periodType)),
      "severeCasesByRequestedTime" => $severeCasesByRequestedTimeWorstCase,
      "hospitalBedsByRequestedTime" => $availableBeds - $severeCasesByRequestedTimeWorstCase
      
    ]
  ];

  return $data;
  
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
//header('Content-Type: application/json');
//echo covid19ImpactEstimator($decoded);