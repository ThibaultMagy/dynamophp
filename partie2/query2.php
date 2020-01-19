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

  $eav = $marshaler->marshalJson('
      {
          ":africa": "Africa",
          ":lowArea": 400000,
          ":highArea": 500000
      }
  ');

  $params = [
      'TableName' => $tableName,
      'ProjectionExpression' => 'nom, area',
      'KeyConditionExpression' => '#rg = :africa and area between :lowArea and :highArea',
      'ExpressionAttributeNames'=> [ '#rg' => 'region' ],
      'ExpressionAttributeValues'=> $eav
  ];

  try {
      $result = $dynamodb->query($params);

      foreach ($result['Items'] as $i) {
          $countries = $marshaler->unmarshalItem($i);
          print $countries['nom'] . " " . $countries['area'];

          ?><br><?php
      }

  } catch (DynamoDbException $e) {
      echo "Unable to query:\n";
      echo $e->getMessage() . "\n";
  }
?>
