<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: not-login.php");
    exit();
}

$recipe_id = $_POST['recipe_id'] ?? $_GET['recipe_id'];
if (!$recipe_id) {
    echo "Błąd: Nie podano ID przepisu.";
    exit();
}

// Sprawdzenie uprawnień
$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'] ?? 0;

// Jeśli to zwykły użytkownik, może usunąć tylko swoje przepisy
if (!$is_admin) {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = :recipe_id AND user_id = :user_id");
    $stmt->execute(['recipe_id' => $recipe_id, 'user_id' => $user_id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        echo "Błąd: Nie możesz usunąć tego przepisu.";
        exit();
    }
}

// Usuń przepis
$stmt = $pdo->prepare("DELETE FROM recipes WHERE recipe_id = :recipe_id");
$stmt->execute(['recipe_id' => $recipe_id]);

echo "Przepis został usunięty.";
header("Location: user_recipes.php");
exit();
?>
