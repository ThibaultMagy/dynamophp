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

    <a href="query1.php">Noms des pays européens</a><br><hr><br>
    <a href="query2.php">Noms et superficie des pays africains triés par superficie de la 10ème à la 22ème position </a><br><hr><br>
    <a href="query3.php">Toutes les infos disponibles sur un pays donné</a><br><hr><br>
    <a href="query4.php">Noms des pays ayant le néerlandais parmi leurs langues officielles</a><br><hr><br>
    <a href="query5.php">Noms des pays qui commencent par une lettre donnée</a><br><hr><br>
    <a href="query6.php">Noms et superficie des pays ayant une superficie entre 400000 et 500000 km2</a>

  </body>
</html>
