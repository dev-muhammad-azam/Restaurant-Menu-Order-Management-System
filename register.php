<?php
require_once 'config/database.php'; require_once 'includes/functions.php';
if (is_logged_in()) redirect('index.php');
$pageTitle='Register'; $errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf();
 $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??'')); $phone=trim($_POST['phone']??'');
 $password=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
 if ($name==='' || strlen($name)>100) $errors[]='Enter a name (maximum 100 characters).';
 if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Enter a valid email address.';
 if (strlen($password)<8) $errors[]='Password must be at least 8 characters.';
 if ($password!==$confirm) $errors[]='Passwords do not match.';
 if (!$errors) {
  $check=$pdo->prepare("SELECT id FROM users WHERE email=?"); $check->execute([$email]);
  if ($check->fetch()) $errors[]='This email is already registered.';
  else { $stmt=$pdo->prepare("INSERT INTO users(name,email,phone,password) VALUES(?,?,?,?)"); $stmt->execute([$name,$email,$phone,password_hash($password,PASSWORD_DEFAULT)]); set_flash('Registration successful. Please log in.'); redirect('login.php'); }
 }
}
require 'includes/header.php';
?>
<div class="form-card narrow"><span class="eyebrow">JOIN FOODHUB</span><h1>Create account</h1><p class="muted">Register to place orders and reserve tables.</p>
<?php foreach($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="stack-form" data-validate><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>Full name<input name="name" maxlength="100" required value="<?= e($_POST['name']??'') ?>"></label>
<label>Email address<input type="email" name="email" required value="<?= e($_POST['email']??'') ?>"></label>
<label>Phone number<input name="phone" maxlength="30" value="<?= e($_POST['phone']??'') ?>"></label>
<label>Password<input type="password" name="password" minlength="8" required></label>
<label>Confirm password<input type="password" name="confirm_password" minlength="8" required></label>
<button class="btn full" type="submit">Create account</button></form><p class="form-foot">Already registered? <a href="login.php">Log in</a></p></div>
<?php require 'includes/footer.php'; ?>
