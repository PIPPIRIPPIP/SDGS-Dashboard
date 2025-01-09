<?php
require '../../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$collection = $client->bdnr->goal_7;

$pipeline = [
    ['$group' => ['_id' => '$Indicator']],
    ['$count' => 'JumlahJenisIndicator']
];

$result = $collection->aggregate($pipeline)->toArray();

$data = [
    'jumlah' => $result[0]['JumlahJenisIndicator']
];

header('Content-Type: application/json');
echo json_encode(($data));
?>