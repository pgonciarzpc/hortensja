# To jest repozytorium RestAPI

Projekt jest podzielony na 2 podkatalogi:
- api - właściwe pliki API odpowiedzialne za tworzenie (create.php), 
        odczyt listy (list.php), 
        usuwanie (delete.php) czy aktualizację (update.php) użytkownika. 
        Dodatkowo znajduje się tam skrypt createTables.php do utworzenia 
        bazy danych i utworzenia tabeli users w tej bazie.
- classes - główny katalog klas do obsługi zadań wykonywanych w API.

Uwaga!
Projekt uruchamiamy z katalogu w którym został wgrany poleceniem z konsoli:
php -S localhost:8000

Aby odnieść się do odczytu listy 'użytkowników' to wykorzystujemy link:
- http://localhost:8000/api/list.php
Do utworzenia nowego użytkownika:
- http://localhost:8000/api/create.php
Do aktualizacji istniejącego:
- http://localhost:8000/api/update.php
Do usunięcia:
- http://localhost:8000/api/delete.php
Do utworzenia tabel:
- http://localhost:8000/api/createTables.php
