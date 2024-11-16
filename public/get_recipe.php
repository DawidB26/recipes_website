<?php
<<<<<<< HEAD
echo realpath('../includes/db.php');
require_once(__DIR__ . '/../includes/db.php');
=======
require_once 'includes/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
>>>>>>> 2c4005b21d342aa461ad4f1fb1d4c6288ab5b638

if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];

    // Pobranie szczegółów przepisu z widoku `detailed_recipe`
    $stmt = $pdo->prepare("SELECT * FROM detailed_recipe_info WHERE recipe_id = 1");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();

    // Pobranie składników przepisu
    $stmt = $pdo->prepare("
        SELECT i.name, ri.quantity, i.unit 
        FROM recipe_ingredients ri 
        JOIN ingredients i ON ri.ingredient_id = i.ingredient_id 
        WHERE ri.recipe_id = 1");
    $stmt->execute([$recipe_id]);
    $ingredients = $stmt->fetchAll();

    echo json_encode([
        'recipe' => $recipe,
        'ingredients' => $ingredients
    ]);
}
?>