<?php
$host = 'localhost';
$dbname = 'strona_z_przepisami';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h6>Połączenie z bazą danych zostało nawiązane!</h6>";
} catch (PDOException $e) {
    echo "<h6>Błąd połączenia: </h6>" . $e->getMessage();
}
?>