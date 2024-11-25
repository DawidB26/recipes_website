<?php
require_once "includes/db.php"; // Połączenie z bazą danych

// Sprawdzamy, czy przepis jest dostępny przez 'id' w URL
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];

    // Pobieramy dane przepisu z widoku 'detailed_recipe_info'
    $stmt = $pdo->prepare("SELECT * FROM detailed_recipe_info WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) {
        // Jeśli przepis istnieje, wyświetlamy szczegóły
        ?>
        <!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($recipe['recipe_title']); ?></title>
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <!-- Nagłówek -->
            <?php require_once "blocks/header.php"; ?>

            <section id="content">
                <h1><?php echo htmlspecialchars($recipe['recipe_title']); ?></h1>

                <p><strong>Autor:</strong> <?php echo htmlspecialchars($recipe['author']); ?></p>
                <p><strong>Opis:</strong> <?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
                <p><strong>Składniki:</strong></p>
                <ul>
                    <?php
                    // Pobranie składników dla tego przepisu
                    $stmt = $pdo->prepare("SELECT name, quantity, unit FROM recipe_ingredients ri JOIN ingredients i ON ri.ingredient_id = i.ingredient_id WHERE ri.recipe_id = ?");
                    $stmt->execute([$recipe_id]);
                    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($ingredients as $ingredient) {
                        echo "<li>" . htmlspecialchars($ingredient['quantity']) . " " . htmlspecialchars($ingredient['unit']) . " " . htmlspecialchars($ingredient['name']) . "</li>";
                    }
                    ?>
                </ul>

                <p><strong>Instrukcje:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>

                <p><strong>Kategorie:</strong> <?php echo htmlspecialchars($recipe['categories']); ?></p>
                <p><strong>Tagi:</strong> <?php echo htmlspecialchars($recipe['tags']); ?></p>
                <form method="POST" action="favorites.php">
    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['recipe_id']) ?>">
    <button type="submit">Dodaj do ulubionych</button>
</form>

            </section>
        </html>
        <?php
    } else {
        // Jeśli przepis o danym ID nie istnieje
        echo "<p>Nie znaleziono przepisu o podanym ID.</p>";
    }
} else {
    // Jeśli nie przekazano ID
    echo "<p>Nie przekazano ID przepisu.</p>";
}
?>
