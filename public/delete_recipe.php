<?php
session_start();
require_once "../includes/db.php"; // Połączenie z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: not-login.php");
    exit();
}

// Sprawdzenie, czy 'recipe_id' został przesłany
if (isset($_POST['recipe_id'])) {
    $recipe_id = $_POST['recipe_id'];
} elseif (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
} else {
    echo "Błąd: Nie przekazano ID przepisu do usunięcia.";
    exit();
}

// Upewniamy się, że użytkownik może usunąć tylko swoje przepisy
$user_id = $_SESSION['user_id'];

// Pobranie przepisu i sprawdzenie, czy należy do użytkownika
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = :recipe_id AND user_id = :user_id");
$stmt->execute(['recipe_id' => $recipe_id, 'user_id' => $user_id]);
$recipe = $stmt->fetch();

if ($recipe) {
    // Usuń przepis
    $delete_stmt = $pdo->prepare("DELETE FROM recipes WHERE recipe_id = :recipe_id AND user_id = :user_id");
    $delete_stmt->execute(['recipe_id' => $recipe_id, 'user_id' => $user_id]);

    echo "Przepis został pomyślnie usunięty.";
    header("Location: user_recipes.php"); // Przekierowanie do listy przepisów użytkownika
    exit();
} else {
    echo "Błąd: Nie można usunąć przepisu, ponieważ nie należy do Ciebie lub nie istnieje.";
}
?>
