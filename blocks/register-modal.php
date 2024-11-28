<div id="register-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Zarejestruj się</h2><br/><br/>
            <form id="register-form" method="post" action="../strona_z_przepisami/public/register.php">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required><br/><br/>
                
                <label for="email">Adres email:</label>
                <input type="email" id="email" name="email" required><br/><br/>
                
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br/><br/>
                
                <label for="confirm-password">Powtórz hasło:</label>
                <input type="password" id="confirm-password" name="confirm-password" required><br/><br/>
                
                <button type="submit">Zarejestruj się</button>
            </form>
    </div>
</div>