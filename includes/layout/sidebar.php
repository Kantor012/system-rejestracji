<?php
  include_once(dirname(__DIR__) . '/helpers/db.php');

  $stmt = $db_conn->query('SELECT firstname, lastname FROM users WHERE id="' . $_SESSION['uid'] . '"');
?>

<div class="sidebar">
  <div class="sidebar__close">x</div>
  <div class="sidebar__details">
    <div class="sidebar__profile">
      <p class="sidebar__username">
        <?php
          while ($row = $stmt->fetch()) {
            if (isset($row['firstname']) AND $row['firstname'] != '' AND isset($row['lastname']) AND $row['lastname'] != '') {
              echo $row['firstname'] . ' ' . $row['lastname'];
            } else echo $_SESSION['username'];
          }
        ?>
      </p>
      <p class="sidebar__role">
        <?php if ((int)$_SESSION['is_admin'] == 1) : ?>
          <span>Administrator</span>
        <?php else : ?>
          <span>
            <?=(int)$_SESSION['is_doctor'] == 1
              ? 'Stomatolog'
              : ($_SESSION['is_admin'] == 0
                ? 'Użytkownik'
                : ''
              )
            ?>
          </span>
        <?php endif; ?>
      </p>
    </div>
  </div>
  <div class="sidebar__menu">
    <a href="/system-rejestracji/index.php" class="sidebar__option">
      <i class="text-icon-right fa-solid fa-grip"></i>
      Dashboard
    </a>
    <?php if ($_SESSION['is_doctor'] == '0') : ?>
    <a href="/system-rejestracji/pages/register.php" class="sidebar__option">
      <i class="text-icon-right fa-solid fa-person-chalkboard"></i>
      Umów wizytę
    </a>
    <?php endif; ?>
    <?php if ($_SESSION['is_admin'] == '1') : ?>
    <a href="/system-rejestracji/pages/edit_users.php" class="sidebar__option">
      <i class="text-icon-right fa-solid fa-grip"></i>
      Edytuj dane użytkowników
    </a>
    <?php endif; ?>
    <?php if ($_SESSION['is_admin'] == '0') : ?>
    <a href="/system-rejestracji/pages/edit_info.php" class="sidebar__option">
      <i class="text-icon-right fa-solid fa-person-chalkboard"></i>
      Edytuj dane
    </a>
    <?php endif; ?>
  </div>
  <div class="sidebar__logout">
    <a href="/system-rejestracji/includes/auth/logout.php">
      <i class="text-icon-right fa-solid fa-door-open"></i>
      Wyloguj
    </a>
  </div>
</div>