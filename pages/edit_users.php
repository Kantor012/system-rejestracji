<?php

require_once(dirname(__DIR__) . '/includes/helpers/uid.php');
require_once(dirname(__DIR__) . '/includes/helpers/db.php');

session_start();

$stmt = $db_conn->query('SELECT * FROM users');

if( isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true ) : ?>

  <?php include_once(dirname(__DIR__) . '/includes/layout/header.php'); ?>
  <?php include_once(dirname(__DIR__) . '/includes/layout/edit_form_admin.php'); ?>
  <?php include_once(dirname(__DIR__) . '/includes/layout/footer.php'); ?>

<?php else : ?>
  <?php header('Location: login.php'); ?>
<?php endif; ?>
