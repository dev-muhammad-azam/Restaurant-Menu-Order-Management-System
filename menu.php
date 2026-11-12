<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$pageTitle = 'Menu';
$q = trim($_GET['q'] ?? '');
$category = (int)($_GET['category'] ?? 0);
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$sql = "SELECT f.*, c.name AS category_name FROM food_items f LEFT JOIN categories c ON c.id=f.category_id WHERE f.is_available=1";
$params = [];
if ($q !== '') { $sql .= " AND (f.name LIKE ? OR f.description LIKE ?)"; $params[]="%{$q}%"; $params[]="%{$q}%"; }
if ($category > 0) { $sql .= " AND f.category_id=?"; $params[]=$category; }
$sql .= " ORDER BY f.name";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $foods=$stmt->fetchAll();
require 'includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">FRESH FROM OUR KITCHEN</span><h1>Our Menu</h1><p>Find something delicious for every craving.</p></section>
<form class="filter-bar" method="get">
  <input name="q" value="<?= e($q) ?>" placeholder="Search food by name..." aria-label="Search food">
  <select name="category"><option value="0">All categories</option><?php foreach($categories as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $category===(int)$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select>
  <button class="btn" type="submit">Search</button>
</form>
<div class="food-grid">
<?php foreach($foods as $food): ?>
  <article class="food-card"><div class="food-image"><?= e($food['image_url'] ?: '🍽') ?></div><div class="food-info"><span class="category"><?= e($food['category_name'] ?? 'Special') ?></span><h3><?= e($food['name']) ?></h3><p><?= e($food['description']) ?></p><div class="food-bottom"><strong><?= money($food['price']) ?></strong><form method="post" action="cart.php"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="food_id" value="<?= (int)$food['id'] ?>"><button class="small-btn" name="add" value="1">Add to cart</button></form></div></div></article>
<?php endforeach; ?>
<?php if(!$foods): ?><div class="empty-state">No matching food items found. Try another search.</div><?php endif; ?>
</div>
<?php require 'includes/footer.php'; ?>
