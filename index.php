<?php
require_once(__DIR__ . '/includes/helpers/uid.php');
require_once(__DIR__ . '/includes/helpers/db.php');

session_start();

$stmt = $db_conn->query('SELECT * FROM users');

if( isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true ) : ?>

  <?php include_once(__DIR__ . '/includes/layout/header.php'); ?>
  <?php include_once(__DIR__ . '/pages/dashboard.php'); ?>
  <?php include_once(__DIR__ . '/includes/layout/footer.php'); ?>

<?php else : ?>
  <?php header('Location: /system-rejestracji/includes/auth/login.php'); ?>
<?php endif; ?>
