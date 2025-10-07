<?php
// Zugangsdaten anpassen:
$DB_HOST = "localhost";
$DB_USER = "d044f9ee";
$DB_PASS = "6qBRcvjriR67mo2AJi48";
$DB_NAME = "d044f9ee";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date VARCHAR(20),
        title VARCHAR(255),
        `desc` TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
}
