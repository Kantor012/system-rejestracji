<?php
  require_once(dirname(__DIR__) . '/components/calendar.php');
  require_once(dirname(__DIR__) . '/helpers/db.php');

  if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $sql = "
          UPDATE users SET firstname=:firstname, lastname=:lastname, gender=:gender 
          WHERE id=:user_id
      ";

    $stmt = $db_conn->prepare($sql);

    $stmt->execute(array(
      ':user_id' => $_SESSION['uid'],
      ':firstname' => $_POST['firstname'],
      ':lastname' => $_POST['lastname'],
      ':gender' => $_POST['gender'],
    ));

    header('Location: ../index.php');
    exit;
  }
?>

<div class="dashboard">
  <div class="dashboard__sidebar">
    <?php include_once(dirname(__DIR__) . '/layout/sidebar.php'); ?>
  </div>
  <div class="dashboard__content">
    <span class="sidebar__open">
      <i class="fa-solid fa-bars"></i>
    </span>
    <div class="edit">
      <form method="POST" action="edit_info.php">
        <label for="firstname">Imię:</label><br>
        <input type="text" id="firstname" name="firstname"><br>
        <label for="lastname">Nazwisko:</label><br>
        <input type="text" id="lastname" name="lastname"><br>
        <label for="gender">Płeć:</label><br>
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="f") echo "checked";?>
        value="f">Female
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="m") echo "checked";?>
        value="m">Male
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="o") echo "checked";?>
        value="o">Other
        <button type="submit">Zaktualizuj</button>
      </form>
    </div>
  </div>
</div>