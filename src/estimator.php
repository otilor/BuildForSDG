<?php





  /**
   * Estimator function
   * 
   * @param string $data
   * @return string|null
   */
  
  function covid19ImpactEstimator($data)
  {
    
    $totalBeds = $data["totalHospitalBeds"];
    $takenBeds = $totalBeds * 0.65;
    $availableBeds = $totalBeds - $takenBeds;
    
    if ($data["periodType"] == "weeks")
    {
      // Converts the time in weeks to days
      $data["timeToElapse"] = intval($data["timeToElapse"] * 7);


    }
    elseif ($data["periodType"] == "months")
    {
      // Converts the time in months to days
      $data["timeToElapse"] = intval($data["timeToElapse"] * 30);

    }
    else
    {
      $data["timeToElapse"] = intval($data["timeToElapse"]);
    }
    
    $factor = intval($data["timeToElapse"] / 3);
    $currentlyInfected = $data["reportedCases"] * 10;
    $infectionsByRequestedTime = intval($currentlyInfected * (2 ^ $factor));
    $severeCasesByRequestedTime = intval(0.15 * $infectionsByRequestedTime);
    $hospitalBedsByRequestedTime = intval($availableBeds - $severeCasesByRequestedTime);
    $casesForICUByRequestedTime = intval(0.05 * $infectionsByRequestedTime);
    $casesForVentilatorsByRequestedTime = intval(0.02 * $infectionsByRequestedTime);
    $dollarsInFlight = intval(($infectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $data["timeToElapse"]);
    //$dollarsInFlight = intval($dollars / $data["timeToElapse"]);
    

    $currentlyInfectedWorstCase = $data["reportedCases"] * 50;
    $infectionsByRequestedTimeWorstCase = $currentlyInfectedWorstCase * 2 ^ $factor;
    $severeCasesByRequestedTimeWorstCase = intval(0.15 * $infectionsByRequestedTimeWorstCase);
    $hospitalBedsByRequestedTimeWorstCase = intval($availableBeds - $severeCasesByRequestedTimeWorstCase);
    $casesForICUByRequestedTimeWorstCase = intval(0.05 * $infectionsByRequestedTimeWorstCase);
    $casesForVentilatorsByRequestedTimeWorstCase = intval(0.02 * $infectionsByRequestedTimeWorstCase);
    $dollarsInFlightWorstCase = intval(($infectionsByRequestedTimeWorstCase * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $data["timeToElapse"]);

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
    
    return $data;
  }

  /**
   * Gives out the Data.
   */



// Rest API
function covid19ImpactEstimatorApi($data)
  {
    
    $totalBeds = $data["totalHospitalBeds"];
    $takenBeds = $totalBeds * 0.65;
    $availableBeds = $totalBeds - $takenBeds;
    
    if ($data["periodType"] == "weeks")
    {
      // Converts the time in weeks to days
      $data["timeToElapse"] = intval($data["timeToElapse"] * 7);


    }
    elseif ($data["periodType"] == "months")
    {
      // Converts the time in months to days
      $data["timeToElapse"] = intval($data["timeToElapse"] * 30);

    }
    else
    {
      $data["timeToElapse"] = intval($data["timeToElapse"]);
    }
    
    $factor = intval($data["timeToElapse"] / 3);
    $currentlyInfected = $data["reportedCases"] * 10;
    $infectionsByRequestedTime = intval($currentlyInfected * (2 ^ $factor));
    $severeCasesByRequestedTime = intval(0.15 * $infectionsByRequestedTime);
    $hospitalBedsByRequestedTime = intval($availableBeds - $severeCasesByRequestedTime);
    $casesForICUByRequestedTime = intval(0.05 * $infectionsByRequestedTime);
    $casesForVentilatorsByRequestedTime = intval(0.02 * $infectionsByRequestedTime);
    $dollarsInFlight = intval(($infectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $data["timeToElapse"]);
    //$dollarsInFlight = intval($dollars / $data["timeToElapse"]);
    

    $currentlyInfectedWorstCase = $data["reportedCases"] * 50;
    $infectionsByRequestedTimeWorstCase = $currentlyInfectedWorstCase * 2 ^ $factor;
    $severeCasesByRequestedTimeWorstCase = intval(0.15 * $infectionsByRequestedTimeWorstCase);
    $hospitalBedsByRequestedTimeWorstCase = intval($availableBeds - $severeCasesByRequestedTimeWorstCase);
    $casesForICUByRequestedTimeWorstCase = intval(0.05 * $infectionsByRequestedTimeWorstCase);
    $casesForVentilatorsByRequestedTimeWorstCase = intval(0.02 * $infectionsByRequestedTimeWorstCase);
    $dollarsInFlightWorstCase = intval(($infectionsByRequestedTimeWorstCase * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $data["timeToElapse"]);

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
    
    return json_encode($data);
  }

// For errors


$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
// header('Content-Type: application/json');

// echo covid19ImpactEstimator($decoded);