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

$tableName = 'ThibaultMagyMovies';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <form class="" action="" method="post">
      <select class="region" name="region">
        <?php
        $tableName = 'ThibaultMagyCountries';
        $params = [
            'TableName' => $tableName,
            'KeyConditionExpression' => 'region = :v_hash',
            'ExpressionAttributeValues' =>  array (
                  ':v_hash'  => array('S' => 'Hash_Value')
             )
        ];

        try {
            $result = $dynamodb->query($params);
            echo "Query succeeded.\n";

            foreach ($result['Items'] as $country) {
                ?>
                    <option value="<?php echo $marshaler->unmarshalValue($country['nom']) ?>"><?php echo $marshaler->unmarshalValue($country['nom']) ?></option> <?php
                }
        } catch (DynamoDbException $e) {
                echo "Unable to query:\n";
                echo $e->getMessage() . "\n";
        }

        ?>
      </select>
    </form>

  </body>
</html>
