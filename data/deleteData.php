<?php
require '../vendor/autoload.php'; 

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bdnr->tes_uas;
// $flightsCollection = $client->travel_agency->Flights;
// $bookingsCollection = $client->travel_agency->Booking;

$data = json_decode(file_get_contents('php://input'), true);
$flightId = $data['_id'];


$filter = ['_id' => new MongoDB\BSON\ObjectId($flightId)];

// Delete flight ticket
$collectionResult = $collection->deleteOne($filter);
// $flightResult = $flightsCollection->deleteOne($filter);


// $bookingFilter = ['ticket_id' => new MongoDB\BSON\ObjectId($flightId)];
// $bookingResult = $bookingsCollection->deleteMany($bookingFilter);

header('Content-Type: application/json'); 

if ($collectionResult->getDeletedCount() === 1) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete flight data']);
}

// if ($flightResult->getDeletedCount() === 1) {
//     echo json_encode(['success' => true, 'deletedBookings' => $bookingResult->getDeletedCount()]);
// } else {
//     echo json_encode(['success' => false, 'error' => 'Failed to delete flight data']);
// }
?>