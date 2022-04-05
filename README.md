# Projekt zaliczeniowy z przedmiotu: _**Aplikacje internetowe**_

# Temat projektu: Internetowy sklep z roślinami
## Specyfikacja projektu
### Cel projektu : Ułatwienie zakupów roślin do domu i ogrodu.
#### Cele szczegółowe:
   1. Możliwość doboru rośliń pod umiejętności klientów sklepu.
   2. Możliwość zakupu nawozów do danych roślin.
   3. Opis produktu zawiera informacje o roślinie.
###  Funkcjonalności:
   1. Rejestracja użytkowników.
   2. Koszyk na zakupy.
   3. Sortowanie produktów.
   4. Generowanie spersonalizowanej listy produktów na podstawie wyboru opcji.
   5. Uwzględnianie kodów rabatowych.
   6. W szczegółach produktów propozycje nawozów do produktów.
   7. Możliwość sprawdzenia kiedy roślina pyli.
   8. Możliwość sprawdzenia statusu zamówienia oraz wcześniejszych zamówień.
   9. Panel administratora - z możliwość dodawanie/edycji/usuwania produktów oraz zmiany statusu zamówienia.
### Interfejs serwisu

   <details>
       <summary>Ekran główny </summary>
	
![home](https://github.com/SebaPL21/Plant_Store/blob/main/images/home1.JPG)

   </details>
	<details>
       <summary>Ekran rejestracji</summary>
<img src="images/register.JPG">

   </details>
   <details>
       <summary>Ekran logowania</summary>
<img src="images/login.JPG">

   </details>
   <details>
       <summary>Informacja o produkcie</summary>
<img src="images/product_detail.JPG">

   </details>
   <details>
       <summary>Koszyk</summary>
<img src="images/cart.JPG">

   </details>
      <details>
       <summary>Składnie zamówień</summary>
<img src="images/order.JPG">

   </details>
   <details>
       <summary>Potwierdzenie zamówienia</summary>
<img src="images/order_confirmation.JPG">

   </details>
      <details>
       <summary>Brak strony 404</summary>
<img src="images/not_found.JPG">

   </details>
       <details>
       <summary>Panel administratora </summary>
<img src="images/admin_panel.jpg">
   </details>
       <details>
       <summary>Zamówienia </summary>
<img src="images/order_admin.jpg">

   </details>
          <details>
       <summary>Szczegóły zamówienia </summary>
<img src="images/order_details_admin.jpg">
<img src="images/order_details_cd_admin.jpg">
   </details>
   
   <details>
       <summary>Użytkownicy </summary>
<img src="images/users_admin.jpg">

   </details>
      <details>
       <summary>Produkty </summary>
<img src="images/products_admin.jpg">

   </details>
         <details>
       <summary>Edycja produktów </summary>
<img src="images/products_edit_admin.jpg">

   </details>
            <details>
       <summary>Dodawanie produktów </summary>
<img src="images/products_add_admin.jpg">

   </details>
          <details>
       <summary>Płatności </summary>
<img src="images/payments_admin.jpg">

   </details>
         <details>
       <summary>Edycja płatności </summary>
<img src="images/payments_edit_admin.jpg">

   </details>
            <details>
       <summary>Dodawanie metod płatności </summary>
<img src="images/payments_add_admin.jpg">

   </details>
     <details>
       <summary>Kategorie </summary>
<img src="images/categories_admin.jpg">

   </details>
      <details>
       <summary>Edycja kategorii </summary>
<img src="images/categories_edit_admin.jpg">

   </details>
   <details>
       <summary>Dodawianie kategorii </summary>
<img src="images/categories_add_admin.jpg">

   </details>
   
### Baza danych
####	Diagram ERD
![alt text][logo]

[logo]: https://github.com/SebaPL21/Plant_Store/blob/main/DiagramERD.jpeg "DiagramERD"

####	Skrypt do utworzenia struktury bazy danych
[plantstoredb.sql](https://github.com/SebaPL21/Plant_Store/blob/main/plantstoredb.sql)
## Wykorzystane technologie

PHP, HTML, CSS, Bootstrap, JQuery, JS, MySQL

## Proces uruchomienia aplikacji (krok po kroku)

1. Pobrać repozytorium z github'a
2. Projekt strony umieścić w folderze "xampp\htdocs"
3. Utworzyć nową baze danych MySQL o nazwie "plantstoredb"
4. W programie xampp w pliku my.ini wyszukać i zmienić wartość zmiennej "max_allowed_packet=16M"
5. Zaimportować baze danych z pliku "plantstoredb.sql"
6. W pliku db_connection.php należy ustawić odpowiednie dane użytkownika do logowania w bazie danych
7. Po wykonaniu tych kroków można uruchomić projekt sklepu wpisując w pasek wyszukiwania adres: localhost/plant%20store

### Potrzebne nazwy użytkowników do uruchomienia aplikacji

1. Konto Administratora:
	* login: Admin
	* hasło: zaq1@WSX 
	
2. Konto Klienta:
	* login: Klient
	* hasło: zaq1@WSX 



[Przydatny link przy tworzeniu plików *.md ](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)

[logo]: https://gallery.dpcdn.pl/imgc/UGC/34567/g_-_960x640_-_s_x20131110194052_0.jpg "Strona główna"
