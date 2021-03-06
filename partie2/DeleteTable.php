<?php

require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;

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

$params = [
    'TableName' => 'ThibaultMagyCountries'
];

try {
    $result = $dynamodb->deleteTable($params);
    echo "Deleted table.\n";

} catch (DynamoDbException $e) {
    echo "Unable to delete table:\n";
    echo $e->getMessage() . "\n";
}

?>
