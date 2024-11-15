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
		
        <section id="add-recipe">
            <form action="public/add_recipe.php" method="POST">
                <label for="title">Nazwa przepisu:</label>
                <input type="text" id="title" name="title" required>
                <br/>
                <br/>

                <label for="ingredients">ingredienty</label>
                <textarea id="ingredients" name="ingredients" required></textarea>
                <br/>
                <br/>
            
                <label for="instructions">Instrukcje:</label>
                <textarea id="instructions" name="instructions" required></textarea>
                <br/>
                <br/>
            
                <label for="category_id">Kategoria:</label>
                <input type="number" id="category_id" name="category_id" required>
                <br/>
                <br/>
            
                <button type="submit"><a href="index.html">Dodaj przepis</a></button>
            </form>        
        </section>    

    </section>

    <!-- Okno logowania -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Zaloguj się</h2>
            <button id="google-login">Zaloguj przez Google</button>
            <button id="facebook-login">Zaloguj przez Facebook</button>
            <button id="instagram-login">Zaloguj przez Instagram</button>
            <button id="x-login">Zaloguj przez X</button>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>