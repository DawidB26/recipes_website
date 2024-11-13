<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = $_POST['recipe_id'];

    // Usunięcie przepisu (oraz powiązanych rekordów dzięki ON DELETE CASCADE)
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);

    echo "Przepis został usunięty!";
}
?>
