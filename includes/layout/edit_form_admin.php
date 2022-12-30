<?php
    require_once(dirname(__DIR__) . '../components/calendar.php');
    require_once(dirname(__DIR__) . '../helpers/db.php');
?>
<?php
    $sql = 'SELECT * FROM users';
    $stmt = $db_conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
?>

<div class="dashboard">
    <div class="dashboard__sidebar">
        <?php include_once(dirname(__DIR__) . '../layout/sidebar.php'); ?>
    </div>
    <div class="dashboard__content">
        <span class="sidebar__open">
        <i class="fa-solid fa-bars"></i>
        </span>
        <div class="info">
            
            <table>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Płeć</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <form method="get">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button name="lista" type="submit">Wybierz</button>
                        </form>
                        
                    </td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php if (isset($_GET['user_id'])): ?>
                <?php
                $sql = 'SELECT * FROM users WHERE id=:user_id';
                $stmt = $db_conn->prepare($sql);
                $stmt->execute(array(':user_id' => $_GET['user_id']));
                $user = $stmt->fetch();
                ?>
                <h2>Szczegóły użytkownika</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <td><?php echo $user['id']; ?></td>
                    </tr>
                    <tr>
                        <th>Login</th>
                        <td><?php echo $user['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Imię</th>
                        <td><?php echo $user['firstname']; ?></td>
                    </tr>
                    <tr>
                        <th>Nazwisko</th>
                        <td><?php echo $user['lastname']; ?></td>
                    </tr>
                    <tr>
                        <th>Adres email:</th>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Płeć</th>
                        <td><?php echo $user['gender']; ?></td>
                    </tr>
                    <tr>
                        <th>Admin?</th>
                        <td><?php echo $user['is_admin']; ?></td>
                    </tr>
                    <tr>
                        <th>Doktor?</th>
                        <td><?php echo $user['is_doctor']; ?></td>
                    </tr>
                    <tr>
                        <th>Usuń użytkownika:</th>
                        <td>
                            <?php echo $user['id'];?>
                            <form method="post">
                                <input type="hidden" name="user_id1" value="<?php echo $user['id']; ?>">
                                <button type="submit">Usuń</button>
                            </form>
                            <?php
                            if (isset($_POST["user_id1"])) {
                                $user_id = $_POST["user_id1"];
                                $sql = 'SELECT id FROM users WHERE username=:username';
                                $stmt = $db_conn->prepare($sql);
                                $stmt->execute(array(':username' => $_SESSION['username']));
                                $user = $stmt->fetch();
                                $session_id = $user['id'];
                                if ($user_id === $session_id) {
                                    echo '<div class="alert alert-success" id="delete-message">Nie możesz usunąć swojego konta.</div>';
                                } else {
                                    $sql = 'DELETE FROM users WHERE id=:user_id';
                                    $stmt = $db_conn->prepare($sql);
                                    $stmt->execute(array(':user_id' => $user_id));
                                    echo '<div class="alert alert-success" id="delete-message">Użytkownik został usunięty z bazy danych.</div>';
                            }
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('delete-message').style.display = 'none';
    }, 3000);
</script>
