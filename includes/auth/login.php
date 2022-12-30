<?php
  require_once __DIR__ . '/../layout/header.php';
  require_once __DIR__ . '/../helpers/db.php';

  session_start();

  if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true) {
    header('Location: ../../index.php');
    exit;
  }

  if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if (
      isset($_POST['username'])
      AND $_POST['password'] != ''
      AND isset($_POST['username'])
      AND $_POST['password'] != ''
    ) {
      $stmt = $db_conn->query('SELECT id, username, password, is_admin, is_doctor FROM users');

      while($row = $stmt->fetch()) {
        if ($_POST['username'] == $row['username']) {
            if ($row['password'] == md5($_POST['password'])) {

              $_SESSION['uid'] = $row['id'];
              $_SESSION['username'] = $_POST['username'];
              $_SESSION['logged_in'] = true;
              $_SESSION['is_admin'] = $row['is_admin'];
              $_SESSION['is_doctor'] = $row['is_doctor'];

              header('Location: ' . $_SERVER['HTTP_REFERER']);
              exit;
            }
        } else {
  //        echo 'login or password incorrect...';
  //        break;
        }
      }
    }
  }
?>

<div class="wrapper">
  <div class="login">
    <form
      method="POST"
      action="login.php"
      class="login__form"
    >
      <label for="username">
        <span class="login__formLabel">
          Nazwa użytkownika
        </span>
        <input
          type="text"
          name="username"
          id="username"
          class="login__input"
          required
        />
      </label>
      <label for="password">
        <span class="login__formLabel">
          Hasło
        </span>
        <input
          type="password"
          name="password"
          id="password"
          class="login__input"
          required
        />
      </label>
      <?php
        if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
          $stmt = $db_conn->query('SELECT username, password FROM users');

          while ($row = $stmt->fetch()) {
            if ($_POST['username'] != $row['username'] or $row['password'] != md5($_POST['password'])) {
              echo '<p class="error">Nazwa użytkownika lub hasło jest nieprawidłowe...</p>';
              break;
            }
          }
        }
      ?>
      <button type="submit" class="login__submit">
        Zaloguj
      </button>
    </form>
    <small class="login__text">
      Nie posiadasz konta?
      <a href="register.php">
        Zarejestruj się
      </a>
    </small>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>