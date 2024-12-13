<header>
    <h1>Najpyszniejsze Przepisy</h1>
        <nav>
            <ul>
                <li><a href="http://localhost/strona_z_przepisami/index.php">Strona Główna</a></li>
                <li><a href="http://localhost/strona_z_przepisami/search.php">Wyszukiwarka</a></li>
                <li><a href="http://localhost/strona_z_przepisami/add_recipe.php">Dodaj przepis</a></li>
                <li><a href="http://localhost/strona_z_przepisami/public/favorites.php">Ulubione</a></li>
                <li><a href="http://localhost/strona_z_przepisami/public/my_recipes.php">Moje Przepisy</a></li>
                <li><a href="#" id="login-btn">Zaloguj się</a></li>
                <li><a href="#" id="register-btn">Zarejestruj się</a></li>
                <li><a href="http://localhost/strona_z_przepisami/public/logout.php">Wyloguj</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <li><a href="http://localhost/strona_z_przepisami/public/admin_dashboard.php">Panel admina</a></li>
                <?php endif; ?>

            </ul>
        </nav>
</header>