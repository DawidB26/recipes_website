<?php
$host = 'localhost';
$dbname = 'strona_z_przepisami';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Połączenie z bazą danych nie powiodło się: " . $e->getMessage());
}
?>