<?php
  require_once(dirname(__DIR__) . '/components/calendar.php');
  require_once(dirname(__DIR__) . '/helpers/db.php');

  if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $sql = '
        INSERT INTO visits (user_id, doctor_id, date, time, status)
        VALUES (:user_id, :doctor_id, :date, :time, :status)
      ';

    $stmt = $db_conn->prepare($sql);

    $stmt->execute(array(
      ':user_id' => $_SESSION['uid'],
      ':doctor_id' => $_POST['doctor_id'],
      ':date' => $_POST['visit_date'],
      ':time' => $_POST['available_hours'],
      ':status' => 'pending',
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
    <div class="visit">
      <h3 class="visit__currentTitle">
        <a href="?ym=<?php echo $prev; ?>">
          <i class="fa-solid fa-arrow-left"></i>
        </a>
        <?php echo '<span class="visit__current">' . $html_title . '</span>'?>
        <a href="?ym=<?php echo $next; ?>">
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </h3>
      <table class="table table-bordered">
        <tr>
          <th>Nd</th>
          <th>Pon</th>
          <th>Wt</th>
          <th>Śr</th>
          <th>Czw</th>
          <th>Pt</th>
          <th>Sob</th>
        </tr>
        <?php
          foreach ($weeks as $week) {
            echo $week;
          }
        ?>
      </table>
      <form method="POST" action="register.php">
        <p class="register__formLabel">Data wizyty:</p>
        <input
          name="visit_date"
          class="date"
          type="text"
          placeholder="Wybierz datę..."
          value="<?=@$_GET['day']?>"
          required
        />
        <br />

        <?php
          $hours = [
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00'
          ];
        ?>

        <p class="register__formLabel">Godzina wizyty:</p>
        <select name="available_hours" required >
          <?php for($hour = 0; $hour < count($hours); $hour++) : ?>
            <?='<option>' . $hours[$hour] . '</option>'?>
          <?php endfor; ?>
        </select> <br />

        <p class="register__formLabel">Stomatolog</p>
        <select name="doctor_id" required>
          <?php
            $stmt = $db_conn->query('SELECT * FROM users WHERE is_doctor="1"');

            while($row = $stmt->fetch()) {
              echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
            }
          ?>
        </select>

        <button type="submit">Zarezerwuj</button>
      </form>
    </div>
  </div>
</div>