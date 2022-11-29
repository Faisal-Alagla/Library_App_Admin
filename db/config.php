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
    ->withServiceAccount('psu-library-app-firebase-adminsdk-cxqx6-545b38558c.json')
    ->withDatabaseUri('https://psu-library-app-default-rtdb.europe-west1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

//Storage for images
$storage = (new Factory)
    ->withServiceAccount('psu-library-app-firebase-adminsdk-cxqx6-545b38558c.json')
    ->withDefaultStorageBucket('psu-library-app.appspot.com')
    ->createStorage();

$bucket = $storage->getBucket();
$bucket_name = $bucket->name();
?>