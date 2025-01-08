<?php
require '../../vendor/autoload.php';

// Database connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bdnr->goal_4;

// Get input data
$data = json_decode(file_get_contents('php://input'), true);

// Prepare data for MongoDB insertion
$insertData = [
    'Goal' => $data['goal'],
    'Target' => $data['target'],
    'Indicator' => $data['indicator'],
    'SeriesCode' => "",
    'SeriesDescription' => $data['description'],
    'GeoAreaCode' => "",
    'GeoAreaName' => "",
    'TimePeriod' => $data['year'],
    'Value' => $data['value'],
    'Time_Detail' => "",
    'Source' => $data['source'],
    '[Units]' => $data['unit'],
];

// Insert data into MongoDB
$result = $collection->insertOne($insertData);

header('Content-Type: application/json');

// Response
if ($result->getInsertedCount() === 1) {
    echo json_encode(['success' => true, 'sdgs' => $insertData]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to add sdgs.']);
}
?>
