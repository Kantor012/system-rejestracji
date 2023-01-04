<?php if ( isset($_SESSION) AND $_SESSION['is_doctor'] == '0' ) : ?>
  <span class="sidebar__open">
    <i class="fa-solid fa-bars"></i>
  </span>

  <a class="registerVisit" href="/system-rejestracji/pages/register.php">
    <i class="text-icon-right fa-solid fa-person-chalkboard"></i>
    Umów wizytę
  </a>

  <?php
    require_once(dirname(__DIR__) . '/helpers/db.php');
    $stmt = $db_conn->query('SELECT * FROM visits WHERE user_id="' . $_SESSION['uid'] . '"');

    if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
      if (isset($_GET['cancel']) AND isset($_GET['visit'])) {
        $sql = "DELETE FROM visits WHERE id=?";
        $deletestmt= $db_conn->prepare($sql);
        $deletestmt->execute([$_GET['visit']]);

        header('Location: index.php');
        exit();
      }
    }
  ?>
  <div class="yourVisits">
    <h1 class="title">Twoje wizyty</h1>
    <div class="yourVisits__wrapper">
      <?php
        while($row = $stmt->fetch()) {

          $stmt2 = $db_conn->query('SELECT * FROM users WHERE id="' . $row['doctor_id'] . '"');

          $status = array(
            'pending' => 'Oczekujące',
            'cancelled' => 'Anulowane',
            'completed' => 'Zakończone',
          );

          echo '<div class="yourVisits__visit">';
          echo '<p class="yourVisits__date">Data: ' . $row['date'] . '</p>';
          echo '<p class="yourVisits__hour">Godzina: ' . $row['time'] . '</p>';

          while($row2 = $stmt2->fetch()) {
            echo 'Doktor: ' . $row2['firstname'] . ' ' . $row2['lastname'];
          }

          if (!empty($row['status'])) {
            echo '<p class="yourVisits__status">Status: ' . @$status[$row['status']] . '</p>';
          } else echo '<p class="yourVisits__status">Status: Zakończone' . '</p>';

          if ($row['status'] == 'pending') {
            echo '<a class="yourVisits__option" href="?cancel=1&visit=' . $row['id'] . '">Anuluj wizytę</a>';
          }

          echo '</div>';
        }
      ?>
    </div>
  </div>
<?php elseif ( $_SESSION['is_doctor'] == '1' ) : ?>
  <?php
    require_once(dirname(__DIR__) . '/helpers/db.php');
    $stmt = $db_conn->query('SELECT * FROM visits WHERE doctor_id="' . $_SESSION['uid'] . '"');

    if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
      if (isset($_GET['cancel']) AND isset($_GET['visit'])) {
        $sql = "DELETE FROM visits WHERE id=?";
        $deletestmt= $db_conn->prepare($sql);
        $deletestmt->execute([$_GET['visit']]);

        header('Location: index.php');
        exit();
      }
    }

    if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
      if (isset($_GET['submit']) AND isset($_GET['visit'])) {
        $sql = "UPDATE visits SET status=? WHERE id=?";
        $updatestmt= $db_conn->prepare($sql);
        $updatestmt->execute(['completed', $_GET['visit']]);

        header('Location: index.php');
        exit();
      }
    }
  ?>
  <div class="yourVisits">
    <h1 class="title">Twoi pacjenci</h1>
    <div class="yourVisits__wrapper">
      <?php
        while($row = $stmt->fetch()) {

          $stmt2 = $db_conn->query('SELECT * FROM users WHERE id="' . $row['user_id'] . '"');

          echo '<div class="yourVisits__visit">';

          $gender = array(
            'm' => 'Mężczyzna',
            'f' => 'Kobieta',
            'o' => 'Inna'
          );

          while($row2 = $stmt2->fetch()) {
            if (!empty($row2['firstname']) AND !empty($row2['firstname'])) {
              echo '<p class="yourVisits__name">Pacjent: ' . $row2['firstname'] . ' ' . $row2['lastname'] . '</p>';
            } else echo '<p class="yourVisits__name">Pacjent: ' . $row2['username'] . '</p>';

            $status = array(
              'pending' => 'Oczekujące',
              'cancelled' => 'Anulowane',
              'completed' => 'Zakończone',
            );

            echo '<p class="yourVisits__date">Data: ' . $row['date'] . '</p>';
            echo '<p class="yourVisits__hour">Godzina: ' . $row['time'] . '</p>';
            echo '<p class="yourVisits__gender">Płeć: ' . $gender[$row2['gender']] . '</p>';

            if (!empty($row['status'])) {
              echo '<p class="yourVisits__status">Status: ' . $status[$row['status']] . '</p>';
            } else echo '<p class="yourVisits__status">Status: Zakończone' . '</p>';

            echo '<div class="yourVisits__options">';

            if ($_SESSION['is_doctor'] == '1') {
              if ($row['status'] == 'pending') {
                echo '<a class="yourVisits__option yourVisits__option--submit" href="?submit=1&visit=' . $row['id'] . '">Potwierdź wizytę</a>';
              }
            }
            if ($row['status'] == 'pending') {
              echo '<a class="yourVisits__option" href="?cancel=1&visit=' . $row['id'] . '">Anuluj wizytę</a>';
            }

            echo '</div>';
          }

          echo '</div>';
        }
      ?>
    </div>
  </div>
<?php endif; ?>