<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$pageTitle = 'Home';
$stmt = $pdo->query("SELECT f.*, c.name AS category_name FROM food_items f LEFT JOIN categories c ON c.id=f.category_id WHERE f.is_available=1 ORDER BY f.created_at DESC LIMIT 6");
$foods = $stmt->fetchAll();
require 'includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">WELCOME TO FOODHUB</span>
    <h1>Delicious food,<br><span>delivered with love.</span></h1>
    <p>Explore our menu, order your favourites, or reserve a table for a great dining experience.</p>
    <div class="hero-actions"><a class="btn" href="menu.php">Explore Menu</a><a class="btn btn-outline" href="reservation.php">Book a Table</a></div>
  </div>
  <div class="hero-art"><div class="food-circle">🍔</div><div class="floating-card">⭐ Fresh & tasty<br><small>Made for you</small></div></div>
</section>
<section class="section">
  <div class="section-heading"><div><span class="eyebrow">OUR MENU</span><h2>Popular dishes</h2></div><a href="menu.php" class="text-link">View all →</a></div>
  <div class="food-grid">
    <?php foreach ($foods as $food): ?>
      <article class="food-card">
        <div class="food-image"><?= e($food['image_url'] ?: '🍽') ?></div>
        <div class="food-info"><span class="category"><?= e($food['category_name'] ?? 'Special') ?></span><h3><?= e($food['name']) ?></h3><p><?= e($food['description']) ?></p><div class="food-bottom"><strong><?= money($food['price']) ?></strong><a class="small-btn" href="menu.php">Order</a></div></div>
      </article>
    <?php endforeach; ?>
    <?php if (!$foods): ?><p>No menu items yet. Admin can add items from the dashboard.</p><?php endif; ?>
  </div>
</section>
<section class="cta-strip"><div><span class="eyebrow">YOUR TABLE IS WAITING</span><h2>Make your next meal special.</h2></div><a class="btn" href="reservation.php">Reserve a Table</a></section>
<?php require 'includes/footer.php'; ?>
