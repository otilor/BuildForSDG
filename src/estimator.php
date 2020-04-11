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
    $casesForICUByRequestedTime = intval(0.05 * $infectionsByRequestedTime);
    $casesForVentilatorsByRequestedTime = intval(0.02 * $infectionsByRequestedTime);
    $dollarsInFlight = intval($infectionsByRequestedTime * 0.65 * 1.5);
    

    $currentlyInfectedWorstCase = $data["reportedCases"] * 50;
    $infectionsByRequestedTimeWorstCase = $currentlyInfectedWorstCase * 2 ^ $factor;
    $severeCasesByRequestedTimeWorstCase = intval(0.15 * $infectionsByRequestedTimeWorstCase);
    $hospitalBedsByRequestedTimeWorstCase = intval($availableBeds - $severeCasesByRequestedTimeWorstCase);
    $casesForICUByRequestedTimeWorstCase = intval(0.05 * $infectionsByRequestedTimeWorstCase);
    $casesForVentilatorsByRequestedTimeWorstCase = intval(0.02 * $infectionsByRequestedTimeWorstCase);
    $dollarsInFlightWorstCase = intval($infectionsByRequestedTimeWorstCase * 0.65 * 1.5);
    $data = [
      "data" => $data, // input data
      "impact" => [
        "currentlyInfected" => $currentlyInfected,
        "infectionsByRequestedTime" => $infectionsByRequestedTime,
        "severeCasesByRequestedTime" =>  $severeCasesByRequestedTime,
        "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTime,
        "casesForICUByRequestedTime" => $casesForICUByRequestedTime,
        "casesForVentilatorsByRequestedTime" => $casesForVentilatorsByRequestedTime,
        "dollarsInFlight" => $dollarsInFlight,
        
      ], // best case
      "severeImpact" => [
        "currentlyInfected" => $currentlyInfectedWorstCase,
        "infectionsByRequestedTime" => $infectionsByRequestedTimeWorstCase,
        "severeCasesByRequestedTime" => intval(0.15 * $infectionsByRequestedTimeWorstCase),
        "hospitalBedsByRequestedTime" => $hospitalBedsByRequestedTimeWorstCase,
        "casesForICUByRequestedTime" => $casesForICUByRequestedTimeWorstCase,
        "casesForVentilatorsByRequestedTime" => $casesForVentilatorsByRequestedTimeWorstCase,
        "dollarsInFlight" => $dollarsInFlightWorstCase,
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