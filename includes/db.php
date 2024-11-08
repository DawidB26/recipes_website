<?php
$host = 'localhost';
$dbname = 'strona z przepisami';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Połączenie z bazą danych zostało nawiązane!";
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>