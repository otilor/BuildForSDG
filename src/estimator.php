<?php

/**
 * Estimates the impact of Covid19
 * 
 * @param string $data
 * @return string $data|null
 */
function covid19ImpactEstimator($data)
{
  return $data;
}
// For errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Gives out the Data.
 */
function covidData()
{
  
  $region = "";
  $data = [
    "region" =>  [
      "name" => "Africa",
      "avgAge" => 19.7,
      "avgDailyIncomeInUSD" => 5,
      "avgDailyIncomePopulation" => 0.71,
    ],
    "periodType" => "days",
    "timeToElapse" => 58,
    "reportedCases" => 674,
    "population" => 66622705,
    "totalHospitalBeds" => 1380614
  ];
  return json_decode(json_encode($data));
}

echo covidData()->region->name;


// For errors

