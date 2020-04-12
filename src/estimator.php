<?php


function covid19ImpactEstimator($data)
{
  $reportedCases = $data["reportedCases"];
  // Currently Infected for both cases
  $currentlyInfected = currentlyInfected($reportedCases, 10);
  $currentlyInfectedWorstCase = currentlyInfected($reportedCases, 50);

  $timeToElapse = $data["timeToElapse"];
  $periodType = $data["periodType"];
  
  
  $data = [
    "data" => $data,
    "impact" => [
      "currentlyInfected" => $currentlyInfected,
      "infectionsByRequestedTime" => intval(infectionsByRequestedTime($currentlyInfected, $timeToElapse, $periodType))

    ],
    "severeImpact" => [
      "currentlyInfected" => $currentlyInfectedWorstCase,
      "infectionsByRequestedTime" => intval(infectionsByRequestedTime($currentlyInfectedWorstCase, $timeToElapse, $periodType))
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
$content = trim(file_get_contents("php://input"));

$decoded = json_decode($content, true);
header('Content-Type: application/json');
echo covid19ImpactEstimator($decoded);