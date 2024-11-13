<?php
include 'db.php';

if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];

    // Pobranie szczegółów przepisu z widoku `detailed_recipe`
    $stmt = $pdo->prepare("SELECT * FROM detailed_recipe WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();

    // Pobranie składników przepisu
    $stmt = $pdo->prepare("
        SELECT i.name, ri.quantity, i.unit 
        FROM recipe_ingredients ri 
        JOIN ingredients i ON ri.ingredient_id = i.ingredient_id 
        WHERE ri.recipe_id = ?");
    $stmt->execute([$recipe_id]);
    $ingredients = $stmt->fetchAll();

    echo json_encode([
        'recipe' => $recipe,
        'ingredients' => $ingredients
    ]);
}
?>