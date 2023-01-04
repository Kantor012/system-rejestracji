<?php
  require_once __DIR__ . '/../layout/header.php';
  require_once __DIR__ . '/../helpers/uid.php';
  require_once __DIR__ . '/../helpers/db.php';

  if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $error = '';

    if (
      isset($_POST['username'])
      AND $_POST['password'] != ''
      AND isset($_POST['username'])
      AND $_POST['password'] != ''
      AND isset($_POST['repeat_password'])
      AND $_POST['repeat_password'] != ''
    ) {
      if ($_POST['password'] == $_POST['repeat_password']) {

        $stmt = $db_conn->prepare('SELECT username FROM users WHERE username=?');
        $stmt->execute([$_POST['username']]);
        $user = $stmt->fetch();

        if (!$user) {
          $sql = '
              INSERT INTO users (id, firstname, lastname,  username, email, password, gender, is_admin, is_doctor, created_at)
              VALUES (:id, :firstname, :lastname, :username, :email, :password, :gender, :is_admin, :is_doctor, NOW())
            ';

          $stmt2 = $db_conn->prepare($sql);

          $stmt2->execute(array(
            ':id' => uid(),
            ':firstname' => $_POST['firstname'],
            ':lastname' => $_POST['lastname'],
            ':username' => $_POST['username'],
            ':email' => $_POST['email'],
            ':password' => md5($_POST['password']),
            ':gender' => $_POST['gender'],
            'is_admin' => '0',
            'is_doctor' => '0'
          ));

          header ('Location: login.php');
          exit;
        } else {
          $error = '<p class="error">Nazwa użytkownika jest już zajęta!</p>';
        }
      } else {
        $error = '<p class="error">Hasła nie są identyczne!</p>';
      }
    }
  }
?>
<div class="wrapper">
  <div class="register">
    <form method="POST" action="register.php" class="register__form">
      <label for="firstname">
        <span class="register__formLabel">
          Imię
        </span>
        <input
          type="text"
          name="firstname"
          id="firstname"
          class="register__input"
          required
        />
      </label>
      <label for="lastname">
        <span class="register__formLabel">
          Nazwisko
        </span>
        <input
          type="text"
          name="lastname"
          id="lastname"
          class="register__input"
          required
        />
      </label>
      <label for="gender">
        <span class="register__formLabel">
          Płeć
        </span>
        <select
          name="gender"
          id="gender"
          class="register__input"
          required
        >
          <option value="Wybierz..." disabled selected></option>
          <option value="f">Kobieta</option>
          <option value="m">Mężczyzna</option>
          <option value="o">Inna</option>
        </select>
      </label>
      <label for="email">
        <span class="register__formLabel">
          Adres e-mail
        </span>
        <input
          type="email"
          name="email"
          id="email"
          class="register__input"
          required
        />
      </label>
      <label for="username">
        <span class="register__formLabel">
          Nazwa użytkownika
        </span>
        <input
          type="text"
          name="username"
          id="username"
          class="register__input"
          required
        />
      </label>
      <label for="password">
        <span class="register__formLabel">
          Hasło
        </span>
        <input
          type="password"
          name="password"
          id="password"
          class="register__input"
          required
        />
      </label>
      <label for="repeat_password">
        <span class="register__formLabel">
          Powtórz hasło
        </span>
        <input
          type="password"
          name="repeat_password"
          id="repeat_password"
          class="register__input"
          required
        />
      </label>
      <button type="submit" class="register__submit">Register</button>
    </form>
    <p class="error">
      <?php
        if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
          echo $error;
        }
      ?>
    </p>
    <small class="register__text">
      Masz już konto?
      <a href="login.php">
        Zaloguj się
      </a>
    </small>
  </div>
</div>

<?php require_once(dirname(__DIR__ ). '/layout/footer.php'); ?>