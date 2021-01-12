<?php

include_once 'config.php';
include_once 'utilities.php';

class Forecast {

    public static function compute($studies_per_day, $studies_growth_per_month, $months) {
        $current_year = date('Y');
        $current_month = date('n');
        $number_of_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
    
        $records = [];
        
        for($ctr = 0; $ctr < $months; $ctr++) {
            $number_of_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            
            $record['studies'] = number_format($studies_per_day, 0, '',',');
            
            $record['month'] = date('M Y', strtotime($current_year."-".$current_month."-01"));
            
            $record['ram_cost'] = '$'.self::compute_ram_usage($studies_per_day, $number_of_days);
            
            $record['storage_cost'] = '$'.self::compute_storage_usage($studies_per_day);

            $records[] = $record;

            $studies_per_day = round($studies_per_day + ($studies_per_day * $studies_growth_per_month));

            $current_month += 1;
            
            if($current_month > 12) {
                $current_month = 1;
                $current_year += 1;
            }
        }
        
        return json_encode($records);
    }

    private function compute_ram_usage($studies_per_day, $number_of_days) {

        $actual_size = (RAM_SIZE * $studies_per_day) / RAM_STUDIES;
        $actual_size = convert_mb_to_gb($actual_size);
    
        $cost = ((RAM_USAGE_RATE * $actual_size) / RAM_USAGE_SIZE) * $number_of_days;
    
        return number_format($cost, 2, '.',',');
    }
    
    private function compute_storage_usage($studies_per_day) {
        
        $actual_size = (STORAGE_SIZE * $studies_per_day) / STORAGE_STUDIES;
        $actual_size = convert_mb_to_gb($actual_size);
    
        $cost = ((STORAGE_USAGE_RATE * $actual_size) / STORAGE_USAGE_SIZE);
    
        return number_format($cost, 2, '.',',');
    }
}

?>