<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najpyszniejsze Przepisy</title>
    <link rel="stylesheet" href="http://localhost/dashboard/strona_z_przepisami/css/style.css">
</head>
<body>
    <!-- Nagłówek -->
    <?php require_once "../blocks/header.php";?>

<!-- Sekcja główna z przepisami i reklamami -->
<section id="content">
        <!-- Reklama po lewej stronie -->
        <div id="left-ad" class="ad">
            <p>Reklama 1</p>
        </div>

    <div class="recipes">
                <?php
                session_start();
                require_once "../includes/db.php";

                // Sprawdzenie, czy użytkownik jest zalogowany
                if (!isset($_SESSION['user_id'])) {
                    header("Location: http://localhost/dashboard/strona_z_przepisami/not-login.php"); // Jeśli niezalogowany, przekierowanie do logowania
                    exit();
                }
                echo "Witaj, " . htmlspecialchars($_SESSION['username']);
                // Pobieranie ulubionych przepisów użytkownika
                $user_id = $_SESSION['user_id'];
                $stmt = $pdo->prepare("SELECT r.recipe_id, r.title, r.description 
                                    FROM favorites f 
                                    JOIN recipes r ON f.recipe_id = r.recipe_id 
                                    WHERE f.user_id = :user_id");
                $stmt->execute(['user_id' => $user_id]);
                $favorites = $stmt->fetchAll();
                ?>

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
    <!-- Reklama po prawej stronie -->
    <div id="right-ad" class="ad">
        <p>Reklama 2</p>
    </div>
</section>

<!-- Okno logowania -->
<?php require_once "../blocks/login-modal.php"; ?>
<?php require_once "../blocks/register-modal.php"; ?>

<script src="../js/main.js"></script>
<script src="../js/auth.js"></script>
    
</body>
</html>
