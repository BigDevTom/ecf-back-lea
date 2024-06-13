<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eco_pratices";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connected Failed: " .$e->getMessage(); 
}
?>