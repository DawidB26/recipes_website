<?php
require_once "includes/db.php"; // Połączenie z bazą danych

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/dashboard/strona_z_przepisami/not-login.php"); // Przekierowanie na stronę logowania
    exit();
}

echo "Witaj, " . htmlspecialchars($_SESSION['username']);

// Obsługa formularza dodawania przepisu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Pobranie danych z formularza
        $title = $_POST['title'];
        $description = $_POST['description'];
        $instructions = $_POST['instructions'];
        $prep_time = $_POST['prep_time'];
        $cook_time = $_POST['cook_time'];
        $servings = $_POST['servings'];
        $categories = $_POST['categories']; // Tablica z kategoriami
        $ingredients = $_POST['ingredients']; // Tablica składników
        $user_id = $_SESSION['user_id']; // ID aktualnie zalogowanego użytkownika

        // Rozpoczęcie transakcji
        $pdo->beginTransaction();

        // Wstawienie przepisu do tabeli `recipes`
        $stmt = $pdo->prepare("INSERT INTO recipes (title, description, instructions, servings, prep_time, cook_time, user_id, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $description, $instructions, $servings, $prep_time, $cook_time, $user_id]);

        // Pobranie ID dodanego przepisu
        $recipe_id = $pdo->lastInsertId();

        // Wstawienie kategorii do tabeli `recipe_categories`
        if (!empty($categories)) {
            $stmt = $pdo->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (?, ?)");
            foreach ($categories as $category_id) {
                $stmt->execute([$recipe_id, $category_id]);
            }
        }

        // Wstawienie składników do tabeli `recipe_ingredients`
        if (!empty($ingredients)) {
            $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_name, quantity, unit) 
                                   VALUES (?, ?, ?, ?)");
            foreach ($ingredients as $ingredient) {
                $stmt->execute([$recipe_id, $ingredient['ingredient_name'], $ingredient['quantity'], $ingredient['unit']]);
            }
        }

        // Zatwierdzenie transakcji
        $pdo->commit();

        echo "<p>Przepis został pomyślnie dodany!</p>";
    } catch (Exception $e) {
        // Wycofanie transakcji w przypadku błędu
        $pdo->rollBack();
        echo "<p>Wystąpił błąd podczas dodawania przepisu: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj przepis</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once "blocks/header.php"; ?>

    <h1>Dodaj nowy przepis</h1><br/><br/>

    <form method="POST" action="add_recipe.php">
        <label for="title">Nazwa przepisu:</label><br/>
        <input type="text" id="title" name="title" required><br/><br/>

        <label for="description">Opis:</label><br/>
        <textarea id="description" name="description" required></textarea><br/><br/>

        <label for="instructions">Instrukcje przygotowania:</label><br/>
        <textarea id="instructions" name="instructions" required></textarea><br/><br/>

        <label for="prep_time">Czas przygotowania (minuty):</label><br/>
        <input type="number" id="prep_time" name="prep_time" required><br/><br/>

        <label for="cook_time">Czas gotowania (minuty):</label><br/>
        <input type="number" id="cook_time" name="cook_time" required><br/><br/>

        <label for="servings">Liczba porcji:</label><br/>
        <input type="number" id="servings" name="servings" required><br/><br/>

        <label for="categories">Kategorie:</label><br/>
        <select id="categories" name="categories[]" multiple>
            <?php
            // Pobranie dostępnych kategorii z bazy danych
            $stmt = $pdo->query("SELECT category_id, name FROM categories");
            while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$category['category_id']}'>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select><br/><br/>

        <label for="ingredients">Składniki:</label>
        <div id="ingredients-container">
            <!-- Szablon dla składników -->
            <div class="ingredient">
                <input type="text" name="ingredients[0][ingredient_name]" placeholder="Nazwa składnika" required>
                <input type="number" name="ingredients[0][quantity]" placeholder="Ilość" required>
                <input type="text" name="ingredients[0][unit]" placeholder="Jednostka (np. g, ml)" required>
            </div>
        </div>
        <button type="button" id="add-ingredient">Dodaj składnik</button>

        <button type="submit">Dodaj przepis</button>
    </form>

    <script>
        // Skrypt do dynamicznego dodawania składników
        document.getElementById('add-ingredient').addEventListener('click', function () {
            const container = document.getElementById('ingredients-container');
            const count = container.children.length;

            const ingredientTemplate = `
                <div class="ingredient">
                    <input type="text" name="ingredients[${count}][ingredient_name]" placeholder="Nazwa składnika" required>
                    <input type="number" name="ingredients[${count}][quantity]" placeholder="Ilość" required>
                    <input type="text" name="ingredients[${count}][unit]" placeholder="Jednostka (np. g, ml)" required>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', ingredientTemplate);
        });
    </script>
</body>
</html>