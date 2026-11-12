<?php
require_once 'config/database.php'; require_once 'includes/functions.php';
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 if(isset($_POST['add'])){ $id=(int)($_POST['food_id']??0); $s=$pdo->prepare("SELECT id FROM food_items WHERE id=? AND is_available=1"); $s->execute([$id]); if($s->fetch()) $_SESSION['cart'][$id]=min(20,($_SESSION['cart'][$id]??0)+1); set_flash('Item added to cart.'); redirect('cart.php'); }
 if(isset($_POST['update'])){ foreach(($_POST['qty']??[]) as $id=>$qty){$id=(int)$id;$qty=(int)$qty;if($qty<=0)unset($_SESSION['cart'][$id]);else $_SESSION['cart'][$id]=min(20,$qty);} set_flash('Cart updated.'); redirect('cart.php'); }
 if(isset($_POST['remove'])){unset($_SESSION['cart'][(int)$_POST['food_id']]);set_flash('Item removed.');redirect('cart.php');}
}
$pageTitle='Shopping Cart'; $items=[];$total=0;
if($_SESSION['cart']){ $ids=array_keys($_SESSION['cart']);$marks=implode(',',array_fill(0,count($ids),'?'));$s=$pdo->prepare("SELECT * FROM food_items WHERE id IN ($marks) AND is_available=1");$s->execute($ids);foreach($s->fetchAll() as $f){$f['qty']=$_SESSION['cart'][$f['id']];$f['line_total']=$f['qty']*$f['price'];$total+=$f['line_total'];$items[]=$f;} }
require 'includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">YOUR SELECTION</span><h1>Shopping Cart</h1></section>
<?php if(!$items): ?><div class="empty-state">Your cart is empty. <a href="menu.php">Browse the menu</a>.</div><?php else: ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="table-wrap"><table><thead><tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr></thead><tbody>
<?php foreach($items as $item): ?><tr><td><?= e($item['name']) ?></td><td><?= money($item['price']) ?></td><td><input class="qty-input" type="number" min="0" max="20" name="qty[<?= (int)$item['id'] ?>]" value="<?= (int)$item['qty'] ?>"></td><td><?= money($item['line_total']) ?></td></tr><?php endforeach; ?>
</tbody></table></div><div class="cart-summary"><button class="btn btn-outline" name="update">Update cart</button><h2>Total: <?= money($total) ?></h2><a class="btn" href="checkout.php">Proceed to checkout</a></div></form>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
