<?php
require_once '../includes/db.php'; // Połączenie z bazą danych

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = $_POST['user_id'];
    $instructions = $_POST['instructions'];
    $category_id = $_POST['category_id'];
    $ingredients = $_POST['ingredients']; // Tablica składników i ilości

    try {
        // Rozpoczęcie transakcji
        $pdo->beginTransaction();

        // Dodanie przepisu
        $stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, instructions, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$user_id, $title, $instructions]);
        $recipe_id = $pdo->lastInsertId();

        // Przypisanie kategorii do przepisu
        $stmt = $pdo->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (?, ?)");
        $stmt->execute([$recipe_id, $category_id]);

        // Przypisanie składników do przepisu
        foreach ($ingredients as $ingredient) {
            $ingredient_name = $ingredient['ingredient_name'];
            $quantity = $ingredient['quantity'];

            // Sprawdź, czy składnik już istnieje w tabeli `ingredients`
            $stmt = $pdo->prepare("SELECT ingredient_id FROM ingredients WHERE name = ?");
            $stmt->execute([$ingredient_name]);
            $existing_ingredient = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_ingredient) {
                // Jeśli składnik istnieje, pobierz jego `ingredient_id`
                $ingredient_id = $existing_ingredient['ingredient_id'];
            } else {
                // Jeśli składnik nie istnieje, dodaj go do tabeli `ingredients`
                $stmt = $pdo->prepare("INSERT INTO ingredients (name) VALUES (?)");
                $stmt->execute([$ingredient_name]);
                $ingredient_id = $pdo->lastInsertId();
            }

            // Dodaj składnik do tabeli `recipe_ingredients`
            $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$recipe_id, $ingredient_id, $quantity]);
        }

        // Zatwierdzenie transakcji
        $pdo->commit();

        echo "Przepis dodany pomyślnie!";
    } catch (Exception $e) {
        // Jeśli wystąpił błąd, wycofaj transakcję
        $pdo->rollBack();
        echo "Wystąpił błąd podczas dodawania przepisu: " . $e->getMessage();
    }
}
?>