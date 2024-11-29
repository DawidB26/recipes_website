# recipes_website
1. Pobierz i zainstaluj XAMPP
Pobierz instalator XAMPP z oficjalnej strony.
Zainstaluj XAMPP na swoim komputerze, wybierając opcje:
Apache (wymagany do obsługi serwera WWW),
MySQL (do obsługi bazy danych),
Opcjonalnie inne komponenty, jak PHPMyAdmin.
2. Przygotuj pliki projektu
Spakuj pliki strony z githuba https://github.com/DawidB26/strona_z_przepisami/tree/main:
Upewnij się, że cała zawartość projektu (np. katalog recipes_website, folder includes, pliki PHP, CSS, JS) jest zebrana w jednym folderze.
Przenieś pliki projektu do katalogu XAMPP:
Skopiuj folder z plikami do katalogu C:\xampp\htdocs.
Twoje pliki powinny znajdować się w ścieżce:
C:\xampp\htdocs\recipes_website.
3. Przygotuj bazę danych
Uruchom XAMPP Control Panel:
Kliknij na Start obok Apache i MySQL.
Wejdź do PHPMyAdmin:
Otwórz przeglądarkę i wpisz adres:
http://localhost/phpmyadmin.
Zaimportuj bazę danych:
Stwórz nową bazę danych:
W PHPMyAdmin kliknij New po lewej stronie.
Nazwij bazę danych (np. recipes_db).
Zaimportuj plik SQL:
Kliknij Import.
Wybierz plik SQL swojej bazy danych (powinien znajdować się w folderze projektu lub być dostarczony).
Kliknij Go, aby załadować dane do bazy.
4. Skonfiguruj pliki projektu
Plik konfiguracyjny do bazy danych:
Otwórz plik db.php (lub podobny plik w folderze includes).
Upewnij się, że ustawienia połączenia z bazą danych są prawidłowe:
php
Skopiuj kod
$host = 'localhost';
$dbname = 'recipes_db'; // Nazwa bazy danych, którą utworzyłeś
$username = 'root';     // Domyślny użytkownik w XAMPP
$password = '';         // Hasło puste w domyślnej konfiguracji XAMPP
Zapisz zmiany.
5. Uruchom stronę
Otwórz przeglądarkę.
Wejdź na lokalny adres strony:
Jeśli folder projektu to recipes_website, wpisz:
http://localhost/strona_z_przepisami