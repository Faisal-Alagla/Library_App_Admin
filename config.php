<?php
require __DIR__.'db/vendor/autoload.php';
//a
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount('react-native-course-fa387-firebase-adminsdk-gapwx-c3c9bd5a12.json')
    ->withDatabaseUri('https://react-native-course-fa387-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
?>