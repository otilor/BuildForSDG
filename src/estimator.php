<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class estimator {

  /**
   * Estimator function
   * 
   * @param string $data
   * @return string|null
   */
  
  public function covid19ImpactEstimator($data)
  {
    
    $totalBeds = $data["totalHospitalBeds"];
    $takenBeds = $totalBeds * 0.65;
    $availableBeds = $totalBeds - $takenBeds;
    
    $factor = 9;
    $currentlyInfected = $data["reportedCases"] * 10;
    $infectionsByRequestedTime = $currentlyInfected * 2 ^ $factor;
    $severeCasesByRequestedTime = intval(0.15 * $infectionsByRequestedTime);
    
    
    $hospitalBedsByRequestedTime = intval($availableBeds - $severeCasesByRequestedTime);
    

    $currentlyInfectedWorstCase = $data["reportedCases"] * 50;
    $infectionsByRequestedTimeWorstCase = $currentlyInfectedWorstCase * 2 ^ $factor;
    $severeCasesByRequestedTimeWorstCase = intval(0.15 * $infectionsByRequestedTimeWorstCase);
    $hospitalBedsByRequestedTimeWorstCase = intval($availableBeds - $severeCasesByRequestedTimeWorstCase);
    
    $data = [
      "data" => $data, // input data
      "impact" => [
        "currentlyInfected" => $currentlyInfected,
        "infectionsByRequestedTime" => $infectionsByRequestedTime,
        "severeCasesByRequestedTime" =>  $severeCasesByRequestedTime,
        "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTime,
        
      ], // best case
      "severeImpact" => [
        "currentlyInfected" => $currentlyInfectedWorstCase,
        "infectionsByRequestedTime" => $infectionsByRequestedTimeWorstCase,
        "severeCasesByRequestedTime" => intval(0.15 * $infectionsByRequestedTimeWorstCase),
        "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTimeWorstCase,
      ] // worst case
    ];
    // return $data->reportedCases;
    $data = json_encode($data);
    return $data;
  }

  /**
   * Gives out the Data.
   */
  public function covidData()
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
//      return json_decode(json_encode($data));
      return $data;
    }
}


//echo covidData()->region->name;


// For errors
$new_estimation = new estimator;
$data = $new_estimation->covidData();
$new = $new_estimation->covid19ImpactEstimator($data);

echo $new;