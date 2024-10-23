<?php
// config/database.php

$host = 'localhost';
$db = 'task-manager';
$user = 'root';
$pass = '';
try {
    $connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>