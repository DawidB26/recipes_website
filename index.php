<?php 
require_once 'includes/db.php';
?>
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
    <header>
        <h1>Najpyszniejsze Przepisy</h1>
        <nav>
            <ul>
                <li><a href="#">Strona Główna</a></li>
                <li><a href="#">Przepisy</a></li>
                <li><a href="#">Ulubione</a></li>
                <li><a href="#">Moje Przepisy</a></li>
                <li><a href="#" id="login-btn">Zaloguj się</a></li>
                <li><a href="#" id="register-btn">Zarejestruj się</a></li>
            </ul>
        </nav>
    </header>

	<!-- Sekcja główna z przepisami i reklamami -->
    <section id="content">

		<!-- Sekcja przepisów z reklamami po lewej i prawej -->
		<section id="content">
			<!-- Reklama po lewej stronie -->
			<div id="left-ad" class="ad">
				<p>Reklama 1</p>
			</div>
	

        <!-- Przepisy będą generowane dynamicznie przez JavaScript -->
		<section id="recipes">
            <p>Tu są przepisy</p>
        </section>

        <!-- Reklama po prawej stronie -->
        <div id="right-ad" class="ad">
            <p>Reklama 2</p>
        </div>
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
    <!-- Okno rejestracji -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Zarejestruj się</h2>
            <form id="register-form">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required><br>
                
                <label for="email">Adres email:</label>
                <input type="email" id="email" name="email" required><br>
                
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br>
                
                <label for="confirm-password">Powtórz hasło:</label>
                <input type="password" id="confirm-password" name="confirm-password" required><br>
                
                <button type="submit">Zarejestruj się</button>
            </form>
            <p id="form-message"></p>
        </div>
    </div>

    <script>
        // Obsługa okien modalnych
        const loginModal = document.getElementById('login-modal');
        const registerModal = document.getElementById('register-modal');

        const loginBtn = document.getElementById('login-btn');
        const registerBtn = document.getElementById('register-btn');

        const closeButtons = document.querySelectorAll('.close');

        // Pokaż okno logowania
        loginBtn.addEventListener('click', () => {
            loginModal.style.display = 'block';
        });

        // Pokaż okno rejestracji
        registerBtn.addEventListener('click', () => {
            registerModal.style.display = 'block';
        });

        // Zamknij modalne okna
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                loginModal.style.display = 'none';
                registerModal.style.display = 'none';
            });
        });

        document.getElementById('register-form').addEventListener('submit', async (event) => {
            event.preventDefault(); // Zapobiega odświeżeniu strony

            const formData = new FormData(event.target);
            const messageElement = document.getElementById('form-message');
            messageElement.textContent = ''; // Resetowanie komunikatu

            try {
                const response = await fetch('includes/register.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    messageElement.textContent = result.message;
                    messageElement.style.color = 'green';
                    // Ukryj okno rejestracji i zresetuj formularz
                    registerModal.style.display = 'none';
                    event.target.reset();
                } else {
                    messageElement.textContent = result.message;
                    messageElement.style.color = 'red';
                }
            } catch (error) {
                console.error('Błąd podczas rejestracji:', error);
                messageElement.textContent = 'Wystąpił błąd podczas rejestracji.';
                messageElement.style.color = 'red';
            }
        });
        
        // Zamknij okno modalne po kliknięciu poza jego treść
        window.addEventListener('click', (event) => {
            if (event.target === loginModal) {
                loginModal.style.display = 'none';
            }
            if (event.target === registerModal) {
                registerModal.style.display = 'none';
            }
        });
    </script>
    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>