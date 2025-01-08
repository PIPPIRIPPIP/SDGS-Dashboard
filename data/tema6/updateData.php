<?php
require '../../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bdnr->goal_6;


$data = json_decode(file_get_contents('php://input'), true);
$isi = $data['sdgs'];


$filter = ['_id' => new MongoDB\BSON\ObjectId($isi['_id'])];
$update = [
    '$set' => [
        'TimePeriod' => (int) $isi['year'],
        'SeriesDescription' => $isi['description'],
        'Value' => (int) $isi['value'],
        'Source' => $isi['source'],
    ]
];

$result = $collection->updateOne($filter, $update);


header('Content-Type: application/json'); 

if ($result->getModifiedCount() === 1) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update sdgs data or related bookings']);
}
?>