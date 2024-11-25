<?php
require_once "includes/db.php"; // Połączenie z bazą danych
// Pobieranie 10 najpopularniejszych przepisów
$stmt = $pdo->query("
    SELECT recipe_id, recipe_title, author, avg_rating, total_comments 
    FROM popular_recipes
    LIMIT 10
");

$popular_recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($popular_recipes):
    echo "<h2>Najpopularniejsze przepisy</h2>";
    echo "<div class='popular-recipes'>";
    
    foreach ($popular_recipes as $recipe):
        // Wyświetlanie każdego przepisu w formacie linku
        echo "<div class='recipe'>";
        echo "<h3><a href='detailed.php?id=" . htmlspecialchars($recipe['recipe_id']) . "'>" . htmlspecialchars($recipe['recipe_title']) . "</a></h3>";
        echo "<p><strong>Autor:</strong> " . htmlspecialchars($recipe['author']) . "</p>";
        echo "<p><strong>Ocena:</strong> " . htmlspecialchars($recipe['avg_rating']) . " / 5</p>";
        echo "<p><strong>Komentarze:</strong> " . htmlspecialchars($recipe['total_comments']) . "</p>";
        echo "</div>";
    endforeach;

    echo "</div>";
else:
    echo "<p>Brak popularnych przepisów do wyświetlenia.</p>";
endif;
?>

