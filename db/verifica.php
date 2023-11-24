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

?>
