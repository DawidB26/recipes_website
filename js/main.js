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
