// Obsługuje otwieranie i zamykanie okna logowania
const loginBtn = document.getElementById('login-btn');
const modal = document.getElementById('login-modal');
const closeBtn = document.querySelector('.close');

// Otwórz modal po kliknięciu na przycisk logowania
loginBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Zamknij modal po kliknięciu na "X"
closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Zamknij modal, jeśli klikniesz poza jego obszarem
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
