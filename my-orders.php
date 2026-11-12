<?php
require_once 'config/database.php';require_once 'includes/functions.php';require_login();
$s=$pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");$s->execute([$_SESSION['user']['id']]);$orders=$s->fetchAll();$pageTitle='My Orders';require 'includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">ORDER HISTORY</span><h1>My Orders</h1></section>
<?php if(!$orders): ?><div class="empty-state">You have not placed any orders yet. <a href="menu.php">Order now</a>.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th><th>Items</th></tr></thead><tbody><?php foreach($orders as $o): $d=$pdo->prepare("SELECT f.name,oi.quantity FROM order_items oi JOIN food_items f ON f.id=oi.food_id WHERE oi.order_id=?");$d->execute([$o['id']]); ?><tr><td>#<?= (int)$o['id'] ?></td><td><?= e($o['created_at']) ?></td><td><?= money($o['total_amount']) ?></td><td><span class="status"><?= e($o['status']) ?></span></td><td><?php foreach($d->fetchAll() as $it): ?><?= e($it['name']) ?> × <?= (int)$it['quantity'] ?><br><?php endforeach; ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
<?php require 'includes/footer.php'; ?>
