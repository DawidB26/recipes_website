<?php
require_once "../includes/db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/dashboard/strona_z_przepisami/not-login.php");
    exit();
}
echo "Witaj, " . htmlspecialchars($_SESSION['username']);
$userId = $_SESSION['user_id'];

// Pobranie przepisów użytkownika
$stmt = $pdo->prepare("
    SELECT recipe_id, title, description, prep_time
    FROM recipes
    WHERE user_id = :user_id
");
$stmt->execute([':user_id' => $userId]);
$myRecipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Przepisy</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once "../blocks/header.php"; ?>

    <h1>Twoje Przepisy</h1>
    <?php if (!empty($myRecipes)): ?>
        <div class="recipe-list">
            <?php foreach ($myRecipes as $recipe): ?>
                <div class="recipe">
                    <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                    <p><?= htmlspecialchars($recipe['description']) ?></p>
                    <p>Czas przygotowania: <?= htmlspecialchars($recipe['prep_time']) ?> minut</p>
                    <a href="edit_recipe.php?id=<?= $recipe['recipe_id'] ?>">Edytuj</a>
                    <form method="POST" action="delete_recipe.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $recipe['recipe_id'] ?>">
                        <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć ten przepis?')">Usuń</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nie masz jeszcze żadnych przepisów.</p>
    <?php endif; ?>
</body>
</html>
