<?php
require_once '../includes/db.php'; // Połączenie z bazą danych

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Przekierowanie, jeśli użytkownik nie jest zalogowany
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id']; // Pobranie user_id z sesji
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
            $ingredient_name = $ingredient['name']; // Poprawne odwołanie
            $quantity = $ingredient['quantity'];
            $unit = $ingredient['unit'];

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
            $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity, unit) VALUES (?, ?, ?, ?)");
            $stmt->execute([$recipe_id, $ingredient_id, $quantity, $unit]);
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

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj przepis</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once "../blocks/header.php"; ?>

    <section id="content">
        <h1>Dodaj nowy przepis</h1>
        <form method="POST" action="add_recipe.php">
            <label for="title">Tytuł przepisu:</label>
            <input type="text" id="title" name="title" required>

            <label for="instructions">Instrukcje:</label>
            <textarea id="instructions" name="instructions" required></textarea>

            <label for="category_id">Kategoria:</label>
            <select id="category_id" name="category_id" required>
                <option value="1">Śniadanie</option>
                <option value="2">Obiad</option>
                <option value="3">Kolacja</option>
            </select>

            <h3>Składniki:</h3>
            <div id="ingredients">
                <div class="ingredient">
                    <label>Nazwa składnika:</label>
                    <input type="text" name="ingredients[0][name]" placeholder="Np. Mąka" required>
                    <label>Ilość:</label>
                    <input type="number" step="0.01" name="ingredients[0][quantity]" placeholder="Np. 100" required>
                    <label>Jednostka:</label>
                    <input type="text" name="ingredients[0][unit]" placeholder="Np. gram" required>
                </div>
            </div>
            <button type="button" id="add-ingredient">Dodaj kolejny składnik</button>

            <button type="submit">Dodaj przepis</button>
        </form>
    </section>

    <script>
        let ingredientCount = 1;

        document.getElementById('add-ingredient').addEventListener('click', () => {
            const ingredientsDiv = document.getElementById('ingredients');
            const newIngredient = document.createElement('div');
            newIngredient.classList.add('ingredient');
            newIngredient.innerHTML = `
                <label>Nazwa składnika:</label>
                <input type="text" name="ingredients[${ingredientCount}][name]" placeholder="Np. Cukier" required>
                <label>Ilość:</label>
                <input type="number" step="0.01" name="ingredients[${ingredientCount}][quantity]" placeholder="Np. 200" required>
                <label>Jednostka:</label>
                <input type="text" name="ingredients[${ingredientCount}][unit]" placeholder="Np. gram" required>
            `;
            ingredientsDiv.appendChild(newIngredient);
            ingredientCount++;
        });
    </script>
</body>
</html>
