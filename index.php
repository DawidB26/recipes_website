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