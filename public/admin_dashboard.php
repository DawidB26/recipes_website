<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Brak dostępu.";
    exit();
}

// Pobierz wszystkie przepisy
$stmt = $pdo->query("SELECT * FROM recipes");
$recipes = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administratora</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Panel administratora</h1>
    <table>
        <thead>
            <tr>
                <th>Tytuł</th>
                <th>Autor</th>
                <th>Opcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?= htmlspecialchars($recipe['title']) ?></td>
                    <td><?= htmlspecialchars($recipe['user_id']) ?></td>
                    <td>
                        <a href="edit_recipe.php?id=<?= $recipe['recipe_id'] ?>">Edytuj</a>
                        <form method="POST" action="delete_recipe.php" style="display:inline;">
                            <input type="hidden" name="recipe_id" value="<?= $recipe['recipe_id'] ?>">
                            <button type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
