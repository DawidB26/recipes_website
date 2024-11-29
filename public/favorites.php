<?php
session_start();
require_once "../includes/db.php"; // Połączenie z bazą danych

// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/strona_z_przepisami/not-login.php");
    exit();
}


// Pobieramy user_id z sesji
$user_id = $_SESSION['user_id'];

// Sprawdzamy, czy formularz został przesłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id'])) {
    $recipe_id = $_POST['recipe_id'];

    // Sprawdzamy, czy przepis już znajduje się w ulubionych użytkownika
    $checkStmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND recipe_id = :recipe_id");
    $checkStmt->execute(['user_id' => $user_id, 'recipe_id' => $recipe_id]);
    $favorite = $checkStmt->fetch();

    if ($favorite) {
        // Jeśli przepis jest już w ulubionych, informujemy użytkownika
        echo "<p>Przepis już znajduje się w Twoich ulubionych!</p>";
    } else {
        // Dodajemy przepis do ulubionych
        $insertStmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (:user_id, :recipe_id)");
        $insertStmt->execute(['user_id' => $user_id, 'recipe_id' => $recipe_id]);

        echo "<p>Dodano przepis do ulubionych!</p>";
    }
}

// Przekierowanie na stronę z ulubionymi przepisami
header("Location: favorites.php");
exit();
?>

<!DOCTYPE html> 
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najpyszniejsze Przepisy</title>
    <link rel="stylesheet" href="http://localhost/strona_z_przepisami/css/style.css">
</head>
<body>
    <!-- Nagłówek -->
    <?php require_once "../blocks/header.php";?>

    <!-- Sekcja główna z ulubionymi przepisami -->
    <section id="content">
        <div class="recipes">
            <h1>Twoje ulubione przepisy</h1>
            <?php if (!empty($favorites)): ?>
                <?php foreach ($favorites as $recipe): ?>
                    <div>
                        <h2><?= htmlspecialchars($recipe['title']) ?></h2>
                        <p><?= htmlspecialchars($recipe['description']) ?></p>
                        <a href="detailed.php?id=<?= $recipe['recipe_id'] ?>">Zobacz przepis</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nie masz jeszcze ulubionych przepisów.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Okno logowania -->
    <?php require_once "../blocks/login-modal.php"; ?>
    <?php require_once "../blocks/register-modal.php"; ?>

    <script src="../js/main.js"></script>
    <script src="../js/auth.js"></script>
</body>
</html>
