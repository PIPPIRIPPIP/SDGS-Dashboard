<?php
header('Content-Type: application/json');

require '../vendor/autoload.php'; // Include the Composer autoloader

// Database connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bdnr->tes_uas;

// Get input data
$data = json_decode(file_get_contents('php://input'), true);

// Prepare data for MongoDB insertion
$insertData = [
    'Goal' => $data['goal'],
    'Target' => $data['target'],
    'Indicator' => $data['indicator'],
    'SeriesCode' => $data['seriesCode'],
    'SeriesDescription' => $data['seriesDesc'],
    'GeoAreaCode' => $data['geoAreaCode'],
    'GeoAreaName' => $data['geoAreaName'],
    'TimePeriod' => $data['timePeriod'],
    'Value' => $data['value'],
    'Time_Detail' => $data['time_Detail'],
    'Source' => $data['source'],
];

// Insert data into MongoDB
$result = $collection->insertOne($insertData);

// Response
if ($result->getInsertedCount() === 1) {
    echo json_encode(['success' => true, 'flight' => $insertData]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to add flight.']);
}
?>
