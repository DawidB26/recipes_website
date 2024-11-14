<?php
require_once '../includes/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = $_POST['recipe_id'];
    $title = $_POST['title'];
    $instructions = $_POST['instructions'];
    $category_id = $_POST['category_id'];
    $ingredients = $_POST['ingredients']; // Tablica składników i ilości
    $tags = $_POST['tags']; // Tablica tagów

    // Aktualizacja tytułu i instrukcji przepisu
    $stmt = $pdo->prepare("UPDATE recipes SET title = ?, instructions = ? WHERE recipe_id = ?");
    $stmt->execute([$title, $instructions, $recipe_id]);

    // Aktualizacja kategorii przepisu
    $stmt = $pdo->prepare("DELETE FROM recipe_categories WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);

    $stmt = $pdo->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (?, ?)");
    $stmt->execute([$recipe_id, $category_id]);

    // Aktualizacja składników przepisu
    $stmt = $pdo->prepare("DELETE FROM recipe_ingredients WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);

    foreach ($ingredients as $ingredient) {
        $ingredient_id = $ingredient['ingredient_id'];
        $quantity = $ingredient['quantity'];
        $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$recipe_id, $ingredient_id, $quantity]);
    }

    // Aktualizacja tagów przepisu
    $stmt = $pdo->prepare("DELETE FROM recipe_tags WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);

    foreach ($tags as $tag_id) {
        $stmt = $pdo->prepare("INSERT INTO recipe_tags (recipe_id, tag_id) VALUES (?, ?)");
        $stmt->execute([$recipe_id, $tag_id]);
    }

    echo "Przepis został zaktualizowany!";
}
?>
