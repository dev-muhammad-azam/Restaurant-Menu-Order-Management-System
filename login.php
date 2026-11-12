<?php
require_once 'config/database.php'; require_once 'includes/functions.php';
if(is_logged_in()) redirect('index.php');
$pageTitle='Login'; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $email=strtolower(trim($_POST['email']??'')); $password=$_POST['password']??'';
 $stmt=$pdo->prepare("SELECT id,name,email,password,role FROM users WHERE email=?"); $stmt->execute([$email]); $user=$stmt->fetch();
 if($user && password_verify($password,$user['password'])){ session_regenerate_id(true); unset($user['password']); $_SESSION['user']=$user; set_flash('Welcome back, '.$user['name'].'!'); redirect(is_admin()?'admin/dashboard.php':'index.php'); }
 $error='Invalid email or password.';
}
require 'includes/header.php';
?>
<div class="form-card narrow"><span class="eyebrow">WELCOME BACK</span><h1>Log in</h1><p class="muted">Access your FoodHub account.</p>
<?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="stack-form"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>Email address<input type="email" name="email" required value="<?= e($_POST['email']??'') ?>"></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn full">Login</button></form><p class="form-foot">New customer? <a href="register.php">Create an account</a></p></div>
<?php require 'includes/footer.php'; ?>
