<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../pages/login.php');
}
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

//Realtime database connection
$factory = (new Factory)
    ->withServiceAccount('react-native-course-fa387-firebase-adminsdk-gapwx-c3c9bd5a12.json')
    ->withDatabaseUri('https://react-native-course-fa387-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

//Storage bucket for images
$storage = (new Factory)
    ->withServiceAccount('react-native-course-fa387-firebase-adminsdk-gapwx-c3c9bd5a12.json')
    ->withDefaultStorageBucket('react-native-course-fa387.appspot.com')
    ->createStorage();

$bucket = $storage->getBucket();
$bucket_name = $bucket->name();
?>