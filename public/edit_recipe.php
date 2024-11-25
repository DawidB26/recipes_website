<?php
require_once "../includes/db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $recipeId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Pobierz przepis do edycji
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $recipeId, ':user_id' => $userId]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        echo "Nie znaleziono przepisu.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $prepTime = $_POST['prep_time'];
    $userId = $_SESSION['user_id'];

    // Aktualizacja przepisu
    $stmt = $pdo->prepare("
        UPDATE recipes
        SET title = :title, description = :description, prep_time = :prep_time
        WHERE recipe_id = :id AND user_id = :user_id
    ");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':prep_time' => $prepTime,
        ':id' => $recipeId,
        ':user_id' => $userId
    ]);

    header("Location: my_recipes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Przepis</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once "../blocks/header.php"; ?>

    <h1>Edytuj Przepis</h1>
    <form method="POST" action="edit_recipe.php">
        <input type="hidden" name="id" value="<?= $recipe['recipe_id'] ?>">
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required>
        
        <label for="description">Opis:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($recipe['description']) ?></textarea>
        
        <label for="prep_time">Czas przygotowania (minuty):</label>
        <input type="number" id="prep_time" name="prep_time" value="<?= htmlspecialchars($recipe['prep_time']) ?>" required>
        
        <button type="submit">Zapisz zmiany</button>
    </form>
</body>
</html>
