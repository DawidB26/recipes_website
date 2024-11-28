<div id="login-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Logowanie</h1>
        <form method="POST" action="../strona_z_przepisami/public/login.php">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Zaloguj</button>
        </form>
        <h2>Lub zaloguj się przez</h2>
        <button id="google-login">Google</button>
        <button id="facebook-login">Facebook</button>
    </div>
</div>