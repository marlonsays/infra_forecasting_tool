<?php
include_once 'Forecast.class.php';

$data = json_decode(file_get_contents("php://input"));
$results = Forecast::compute($data->studies_per_day, $data->studies_growth_per_month/100, $data->months);

echo $results;
exit;

?>