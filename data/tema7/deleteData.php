<?php
require '../../vendor/autoload.php'; 

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bdnr->goal_7;

$data = json_decode(file_get_contents('php://input'), true);
$sdgsId = $data['_id'];


$filter = ['_id' => new MongoDB\BSON\ObjectId($sdgsId)];

// Delete sdgs ticket
$collectionResult = $collection->deleteOne($filter);

header('Content-Type: application/json'); 

if ($collectionResult->getDeletedCount() === 1) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete sdgs data']);
}
?>