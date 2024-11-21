<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najpyszniejsze Przepisy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Nagłówek -->
    <?php require_once "blocks/header.php"; ?>

    <?php
    // Ustawienia ciasteczka
    $cookieName = "visit_counter"; // Nazwa ciasteczka
    $cookieExpire = time() + (30 * 24 * 60 * 60); // Czas wygaśnięcia: 30 dni

    // Sprawdzanie, czy ciasteczko istnieje
    if (isset($_COOKIE[$cookieName])) {
        // Jeśli ciasteczko istnieje, zwiększamy licznik
        $visitCount = (int)$_COOKIE[$cookieName] + 1;
    } else {
        // Jeśli ciasteczko nie istnieje, to jest to pierwsza wizyta
        $visitCount = 1;
    }

    // Ustawianie ciasteczka z nową wartością
    setcookie($cookieName, $visitCount, $cookieExpire);

    // Wyświetlanie komunikatu dla użytkownika
    if ($visitCount === 1) {
        echo "Witaj! To Twoja pierwsza wizyta na naszej stronie.";
    } else {
        echo "Witaj ponownie! Odwiedziłeś nas już $visitCount razy.";
    }
    ?>

	<!-- Sekcja główna z przepisami i reklamami -->
    <section id="content">
			<!-- Reklama po lewej stronie -->
			<div id="left-ad" class="ad">
				<p>Reklama 1</p>
			</div>
	

        <!-- Przepisy będą generowane dynamicznie przez JavaScript -->
		<div class="recipes">
            <?php require_once "public/get_recipe.php"; ?>
        </div>        

        <!-- Reklama po prawej stronie -->
        <div id="right-ad" class="ad">
            <p>Reklama 2</p>
        </div>
    </section>

    <!-- Okno logowania -->
    <?php require_once "blocks/login-modal.php"; ?>
    <?php require_once "blocks/register-modal.php"; ?>

    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>