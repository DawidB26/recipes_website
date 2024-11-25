<?php
require_once '../includes/db.php';
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Przekierowanie na stronę logowania
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = $_POST['recipe_id'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];

    // Dodanie komentarza
    $stmt = $pdo->prepare("INSERT INTO comments (recipe_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$recipe_id, $user_id, $content]);

    echo "Komentarz został dodany!";
}
?>
