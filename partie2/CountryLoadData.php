<?php

require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'endpoint'   => 'http://localhost:8000',
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'credentials' => [
        'key' => 'not-a-real-key',
        'secret' => 'not-a-real-secret',
    ],
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'ThibaultMagyCountries';

$countries = json_decode(file_get_contents('countries.json'), true);

foreach ($countries as $country) {

    $nom = $country['name']['common'];
    $region = $country['region'];
    $languages = $country['languages'];;
    $area = $country['area'];


    $json = json_encode([
        'nom' => $nom,
        'region' => $region,
        'languages' => $languages,
        'area' => $area,
    ]);

    $params = [
        'TableName' => $tableName,
        'Item' => $marshaler->marshalJson($json)
    ];

    try {
        $result = $dynamodb->putItem($params);
        echo "Added country: " . $country['name'] . " " . $country['cca2'] . " " . $country['area'] . " " . $country['languages'] . "\n";
    } catch (DynamoDbException $e) {
        echo "Unable to add country:\n";
        echo $e->getMessage() . "\n";
        break;
    }

}

?>
