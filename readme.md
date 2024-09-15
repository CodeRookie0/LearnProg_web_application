# Aplikacja e-learningowa do nauki C++

Projekt zakłada stworzenie aplikacji e-learningowej, która umożliwia użytkownikom naukę języka programowania C++. Aplikacja ta skupia się na dostarczeniu kursów na trzy poziomy zaawansowania: dla początkujących, średniozaawansowanych i zaawansowanych. Każdy kurs składa się z serii lekcji oraz zadań, które pozwalają użytkownikom na systematyczną naukę oraz sprawdzenie swoich umiejętności.

## Wymagania systemowe

- Wersja Apache : Apache/2.4.41 (Ubuntu)
- Wersja PHP: 7.4.3-4ubuntu2.22
- Wersja MariaDB: 10.3.39-MariaDB-0ubuntu0.20.04.2

## Instalacja

# Polski

1. Prześlij dostarczone pliki na serwer Manticore za pomocą programu "WinSCP".
2. Otwórz stronę https://manticore.uni.lodz.pl/~maria_sh/php_project/my_project/pages/index.php .
3. Aplikacja automatycznie sprawdzi swój stan i rozpocznie instalację. Od tego momentu użytkownicy muszą tylko postępować zgodnie z instrukcjami instalatora.
4. Utwórz plik con.fig.php za pomocą programu "Putty", na przykład touch con.fig.php, a następnie odśwież stronę, np. klikając "Odśwież stronę".
5. Zmień uprawnienia dla pliku con.fig.php, na przykład chmod o+w con.fig.php, a następnie odśwież stronę, np. klikając "Odśwież stronę".
6. Wypełnij formularz odpowiednimi danymi:
   Nazwa lub adres serwera – informacje uzyskane od administratora serwera (w ramach tworzenia aplikacji używany był localhost).
   Nazwa bazy danych – z phpMyAdmin.
   Nazwa użytkownika – z phpMyAdmin.
   Hasło – powiązane z nazwą użytkownika z phpMyAdmin.
7. Po poprawnym wprowadzeniu danych w krokach 2-4 instalator w tle utworzy plik konfiguracyjny, strukturę i wstawi dane. Wystarczy kliknąć odpowiednie przyciski, aby przejść do kroku 5.
8. Instalator wyświetli formularz do utworzenia pierwszego konta, czyli konta administratorskiego. W górnej części formularza na czerwono będą wyświetlane wytyczne, które musi spełniać konto do stworzenia. Zostaniesz poinformowany, jeśli konto spełnia wszystkie wymagania.
9. W kroku 6 instalacja jest prawie zakończona. Zmień prawa dostępu do pliku con.fig.php, np. chmod o-w con.fig.php. Gdy jesteś pewny, że aplikacja działa poprawnie, usuń plik install.php, np. rm install.php. Aby uzyskać dostęp do działającej strony, możesz skorzystać z linku z punktu 2 lub kliknąć w link "Home Page" w instalatorze.

# English

1. Upload the provided files to the Manticore server using the "WinSCP" program.
2. Open the page https://manticore.uni.lodz.pl/~maria_sh/php_project/my_project/pages/index.php .
3. The application will automatically check its status and proceed to installation. From this point, users only need to follow the installer's instructions.
4. Create a file con.fig.php using the "Putty" program, for example, touch con.fig.php, and then refresh the page, e.g., by clicking "Refresh page".
5. Change permissions for the con.fig.php file, for example, chmod o+w con.fig.php, and then refresh the page, e.g., by clicking "Refresh page".
6. Fill out the form with appropriate data:
   Server name or address – information obtained from the server administrator (localhost was used during application development).
   Database name – from phpMyAdmin.
   Username – from phpMyAdmin.
   Password – associated with the username from phpMyAdmin.
7. Upon providing correct information in steps 2-4, the installer will silently create the configuration file, structure, and insert data. Simply click the buttons corresponding to each step until you reach step 5.
8. The installer will display a form to create the first account, which is the administrative account. Guidelines that must be met for creating the account will be highlighted in red at the top of the form. You will be informed if the account meets all requirements.
9. At step 6, installation is nearly complete. Change access rights to con.fig.php, for example, chmod o-w con.fig.php. Once confident that the application is working, delete install.php, for example, rm install.php. To access the operational site, you can use the link from step 2 or click the "Home Page" link in the installer.

## Autor

- **Maria Shyliankova**

## Wykorzystane zewnętrzne biblioteki

- Bootstrap (wersja : 5.2.3)
- Bootstrapi Icons (wersja 1.4.1)
- Font Awesome (wersja : 6.3.0)
- Simple DataTables (wersja : 7.1.2)
- DataTables Bootstrap 5 (wersja : 2.0.7)
- Chart.js (wersja : 2.8.0)
- Sortable.js (wersja : 1.14.0)
- jQuery (wersja : 3.6.0)
