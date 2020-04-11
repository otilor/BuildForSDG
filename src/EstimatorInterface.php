<?php
namespace src;
interface EstimatorInterface 
{
    public static function covid19ImpactEstimator($data);
    public static function covidData();
}
