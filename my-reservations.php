<?php
require_once 'config/database.php';require_once 'includes/functions.php';require_login();$s=$pdo->prepare("SELECT * FROM reservations WHERE user_id=? ORDER BY reservation_date DESC,reservation_time DESC");$s->execute([$_SESSION['user']['id']]);$rows=$s->fetchAll();$pageTitle='My Bookings';require 'includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">YOUR VISITS</span><h1>My Reservations</h1></section>
<?php if(!$rows): ?><div class="empty-state">No reservations yet. <a href="reservation.php">Book a table</a>.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>Date</th><th>Time</th><th>Guests</th><th>Status</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['reservation_date']) ?></td><td><?= e(substr($r['reservation_time'],0,5)) ?></td><td><?= (int)$r['guests'] ?></td><td><span class="status"><?= e($r['status']) ?></span></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
<?php require 'includes/footer.php'; ?>
