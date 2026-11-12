<?php
require '_init.php';$pageTitle='Admin Dashboard';
$stats=['Food items'=>(int)$pdo->query("SELECT COUNT(*) FROM food_items")->fetchColumn(),'Customers'=>(int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),'Orders'=>(int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),'Reservations'=>(int)$pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn()];
$orders=$pdo->query("SELECT o.*,u.name FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC LIMIT 8")->fetchAll();
require '../includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">CONTROL CENTER</span><h1>Admin Dashboard</h1><p>Manage your restaurant operations.</p></section>
<div class="stats-grid"><?php foreach($stats as $label=>$value): ?><div class="stat-card"><span><?= e($label) ?></span><strong><?= $value ?></strong></div><?php endforeach; ?></div>
<div class="admin-links"><a href="foods.php">🍔 Manage Food Menu</a><a href="categories.php">📂 Manage Categories</a><a href="orders.php">🧾 Manage Orders</a><a href="reservations.php">🪑 Manage Reservations</a></div>
<h2 class="subheading">Recent orders</h2><div class="table-wrap"><table><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead><tbody><?php foreach($orders as $o): ?><tr><td>#<?= (int)$o['id'] ?></td><td><?= e($o['name']) ?></td><td><?= money($o['total_amount']) ?></td><td><?= e($o['status']) ?></td><td><?= e($o['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php require '../includes/footer.php'; ?>
