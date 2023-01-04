<?php

$user_id = $_POST['user_id'];
$is_admin = $_POST['is_admin'];
$is_doctor = $_POST['is_doctor'];

require_once(dirname(__DIR__) . '/includes/helpers/uid.php');
require_once(dirname(__DIR__) . '/includes/helpers/db.php');

session_start();

$sql = 'SELECT * FROM users WHERE id=:user_id';
$stmt = $db_conn->prepare($sql);
$stmt->execute(array(':user_id' => $user_id));
$user = $stmt->fetch();

if($is_admin === NULL) $is_admin = $user['is_admin'];
if($is_doctor === NULL) $is_doctor = $user['is_doctor'];

$sql = 'UPDATE users SET is_admin=:is_admin , is_doctor=:is_doctor WHERE id=:user_id';
$stmt = $db_conn->prepare($sql);
$stmt->execute(array(
    ':is_admin' => $is_admin,
    ':is_doctor' => $is_doctor,
    ':user_id' => $user_id
));

if( isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true ) :
    include_once(dirname(__DIR__) . '/includes/layout/header.php');
    include_once(dirname(__DIR__) . '/includes/layout/edit_form_admin.php');
    include_once(dirname(__DIR__) . '/includes/layout/footer.php');
else :
    header('Location: ../index.php');
endif;
