<?php
require '../../vendor/autoload.php';

use MongoDB\Client;

function getTableData($indicator)
{
    $client = new Client('mongodb://localhost:27017');
    $collection = $client->bdnr->goal_6;

    $filter = ['Indicator' => $indicator];
    $options = [];

    $data = $collection->find($filter, $options);

    return $data;
}

if (isset($_GET['indicator'])) {
    $indicator = $_GET['indicator'];
    $response = getTableData($indicator);

    $indicatorData = [];
    foreach ($response as $indicator) {
        $indicatorData[] = [
            '_id' => (string) $indicator['_id'],
            'goal' => $indicator['Goal'],
            'target' => $indicator['Target'],
            'indicator' => $indicator['Indicator'],
            'description' => $indicator['SeriesDescription'],
            'value' => $indicator['Value'],
            'year' => $indicator['TimePeriod'],
            'source' => $indicator['Source'],
            'unit' => $indicator['[Units]'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($indicatorData);
}
?>