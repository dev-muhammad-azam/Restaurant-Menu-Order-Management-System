<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'FoodHub Restaurant';
$basePath = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/') ? '../' : '';
$flash = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | FoodHub</title>
  <link rel="stylesheet" href="<?= $basePath ?>assets/css/style.css">
  <script defer src="<?= $basePath ?>assets/js/app.js"></script>
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="brand" href="<?= $basePath ?>index.php">🍽 Food<span>Hub</span></a>
    <button class="menu-toggle" type="button" aria-label="Toggle navigation">☰</button>
    <nav class="nav-links">
      <a href="<?= $basePath ?>index.php">Home</a>
      <a href="<?= $basePath ?>menu.php">Menu</a>
      <a href="<?= $basePath ?>reservation.php">Book a Table</a>
      <?php if (is_logged_in()): ?>
        <a href="<?= $basePath ?>my-orders.php">My Orders</a>
        <a href="<?= $basePath ?>my-reservations.php">My Bookings</a>
        <?php if (is_admin()): ?><a href="<?= $basePath ?>admin/dashboard.php">Admin</a><?php endif; ?>
        <span class="nav-user">Hi, <?= e($_SESSION['user']['name']) ?></span>
        <a class="nav-button" href="<?= $basePath ?>logout.php">Logout</a>
      <?php else: ?>
        <a href="<?= $basePath ?>login.php">Login</a>
        <a class="nav-button" href="<?= $basePath ?>register.php">Register</a>
      <?php endif; ?>
      <a class="cart-link" href="<?= $basePath ?>cart.php">Cart (<?= array_sum($_SESSION['cart'] ?? []) ?>)</a>
    </nav>
  </div>
</header>
<main class="container main-content">
<?php if ($flash): ?>
  <div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>
