<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = $_POST['user_id'];
    $instructions = $_POST['instructions'];
    $category_id = $_POST['category_id'];
    $ingredients = $_POST['ingredients']; // Tablica składników i ilości

    // Dodanie przepisu
    $stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, instructions, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $title, $instructions]);
    $recipe_id = $pdo->lastInsertId();

    // Przypisanie kategorii do przepisu
    $stmt = $pdo->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (?, ?)");
    $stmt->execute([$recipe_id, $category_id]);

    // Przypisanie składników do przepisu
    foreach ($ingredients as $ingredient) {
        $ingredient_id = $ingredient['ingredient_id'];
        $quantity = $ingredient['quantity'];
        $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$recipe_id, $ingredient_id, $quantity]);
    }

    echo "Przepis dodany pomyślnie!";
}
?>