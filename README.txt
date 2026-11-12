FOODHUB - RESTAURANT MENU AND ORDER MANAGEMENT SYSTEM
=====================================================

TECHNOLOGIES
------------
HTML5, CSS3, JavaScript, PHP 8+, MySQL/MariaDB, XAMPP, PDO.

INSTALLATION IN XAMPP
---------------------
1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Extract the "restaurant-management" folder into:
   C:\xampp\htdocs\
4. Open phpMyAdmin:
   http://localhost/phpmyadmin
5. Click Import, choose:
database/restaurant_management.sql
then click Import/Go.
   The SQL file creates the restaurant_management database and sample menu.
6. Check database settings in:
   restaurant-management/config/database.php
   Default XAMPP settings: host=localhost, user=root, password empty.
7. Open the website:
http://localhost/Restaurant-Menu-Order-Management-System/restaurant-management/
ADMIN LOGIN
-----------
Email: admin@foodhub.test
Password: password

IMPORTANT: This is a local classroom demo account. Change the admin password
before using the project beyond a local demonstration. The SQL seed password
is a PHP password_hash value.

FEATURES
--------
- Responsive landing page and food menu.
- Customer registration and login/logout.
- Password hashing and PHP sessions.
- Food search and category filter.
- Session-based shopping cart.
- Customer checkout and order history.
- Table reservation requests and reservation history.
- Admin dashboard and statistics.
- Admin food item Create, Read, Update, Delete.
- Admin category creation and deletion.
- Admin order status management.
- Admin reservation status management.
- PDO prepared statements, CSRF tokens, server-side validation,
  output escaping, and protected admin pages.

PROJECT NOTES / CLASSROOM SCOPE
-------------------------------
- Reservation requests are submitted as Pending. Admin confirms or cancels
  them. This starter project does not implement a live seat-capacity calendar.
- Food image field accepts an emoji or an image URL. Demo menu uses emoji
  so it works without downloading image files.
- Checkout stores an order and order items in MySQL. It is a classroom demo;
  no payment gateway or delivery API is connected.
- The project uses local Google Fonts if internet is available; system fonts
  are used as fallback.

GIT / GITHUB
------------
From the project folder, run:
  git init
  git add .
  git commit -m "Initial restaurant management system"
Then create a GitHub repository and follow GitHub's instructions to push.

TESTING CHECKLIST
-----------------
1. Register a new customer with a valid email.
2. Try registering the same email again; duplicate must be rejected.
3. Log in with wrong credentials; login must fail.
4. Add food to cart and place an order while logged in.
5. Check My Orders and confirm the order is stored.
6. Log in as admin and add/edit/delete a food item.
7. Search the menu for a food name and a category.
8. Submit a table reservation and update its status as admin.
9. Log out and try opening admin/dashboard.php; access must be denied.
10. Try empty required fields; browser/PHP validation must reject them.

TROUBLESHOOTING
---------------
- If database connection fails, make sure MySQL is running and SQL import
  completed. Check config/database.php credentials.
- If Apache does not start, another application may be using port 80.
- Use PHP 8 or newer if possible.
- Do not open PHP files by double-clicking. Run them through localhost.
