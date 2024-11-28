<?php
session_start();
require_once "../includes/db.php"; // Połączenie z bazą danych

// Sprawdzenie, czy formularz został wysłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Pobranie nazwy użytkownika z formularza
    $password = $_POST['password']; // Pobranie hasła z formularza

    // Weryfikacja, czy dane zostały przesłane
    if (empty($username) || empty($password)) {
        echo "Wszystkie pola muszą zostać wypełnione.";
        exit();
    }

    // Sprawdzenie, czy użytkownik istnieje w bazie danych
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(); // Pobranie wyników zapytania

    // Jeśli użytkownik istnieje i hasło jest poprawne
    if ($user && password_verify($password, $user['password_hash'])) {
        // Zapisanie danych użytkownika w sesji
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];

        // Przekierowanie użytkownika na stronę główną lub do strony, na którą próbował się dostać
        header("Location: http://localhost/dashboard/strona_z_przepisami/index.php"); // Można zmienić, jeśli chcesz inne przekierowanie
        exit();
    } else {
        // Jeśli dane logowania są niepoprawne
        echo "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
<form method="POST" action="login.php">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Zaloguj</button>
        </form>
</body>
</html>