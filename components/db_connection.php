<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "notes_app";

global $conn;
$conn= new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection successful";
} catch(PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}