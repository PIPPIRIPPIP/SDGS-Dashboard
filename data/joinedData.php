<?php
require '../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$db = $client->bdnr;

$collections = ['goal_3', 'goal_4', 'goal_6', 'goal_7'];

$totalGoals = 0;
$totalIndicators = 0;

foreach ($collections as $collectionName) {
    $collection = $db->$collectionName;
    $pipeline = [
        [
            '$group' => [
                '_id' => null,
                'uniqueGoals' => ['$addToSet' => '$Goal'],
                'uniqueIndicators' => ['$addToSet' => '$Indicator']
            ]
        ],
        [
            '$project' => [
                'goalCount' => ['$size' => '$uniqueGoals'],
                'indicatorCount' => ['$size' => '$uniqueIndicators']
            ]
        ]
    ];

    $result = $collection->aggregate($pipeline)->toArray();
    if (!empty($result)) {
        $totalGoals += $result[0]['goalCount'];
        $totalIndicators += $result[0]['indicatorCount'];
    }
}

$data = [
    'totalGoals' => $totalGoals,
    'totalIndicators' => $totalIndicators,
];

header('Content-Type: application/json');
echo json_encode($data);
?>