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

  $params = [
      'TableName' => $tableName,
      'ProjectionExpression' => 'nom, languages',
  ];

  try {
     while (true) {
         $result = $dynamodb->scan($params);

         foreach ($result['Items'] as $i) {
             $countries = $marshaler->unmarshalItem($i);
             if(in_array("Dutch", $countries['languages'])){
                 echo $countries['nom'];
                 ?><br><?php
             }
         }

         if (isset($result['LastEvaluatedKey'])) {
             $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
         } else {
             break;
         }
     }

 } catch (DynamoDbException $e) {
     echo "Unable to scan:\n";
     echo $e->getMessage() . "\n";
 }
?>
