<?php 

// session_start();


$host = 'localhost';
$dbname = 'cicero';
$username = 'root';
$password = '';
global $pdo;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}



// $host = 'localhost';
// $dbname = 'u714680025_abarateira';
// $username = 'u714680025_abarateira';
// $password = '+7bE~;fOVdU';
// global $pdo;

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// } catch (PDOException $e) {
//     die("Could not connect to the database $dbname :" . $e->getMessage());
// }





?>