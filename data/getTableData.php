<?php
require '../vendor/autoload.php'; // Pastikan path ini sesuai dengan lokasi autoload.php dari Composer

use MongoDB\Client;

function getTableData($indicator) {
    $client = new Client("mongodb://localhost:27017"); // Ganti dengan koneksi MongoDB Anda
    $collection = $client->bdnr->tes_uas; // Ganti dengan nama database dan koleksi Anda

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
            'description' => $indicator['SeriesDescription'],
            'value' => $indicator['Value'],
            'year' => $indicator['TimePeriod'],
            'source' => $indicator['Source'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($indicatorData);
}
?>