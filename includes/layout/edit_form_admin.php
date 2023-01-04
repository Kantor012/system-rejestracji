<?php
    require_once(dirname(__DIR__) . '/components/calendar.php');
    require_once(dirname(__DIR__) . '/helpers/db.php');
?>
<?php
    $sql = 'SELECT * FROM users';
    $stmt = $db_conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
?>

<div class="dashboard">
    <div class="dashboard__sidebar">
        <?php include_once(dirname(__DIR__) . '/layout/sidebar.php'); ?>
    </div>
    <div class="dashboard__content">
        <span class="sidebar__open">
        <i class="fa-solid fa-bars"></i>
        </span>
        <div class="info">
            
            <table>
                <tr>
                    <th>&emsp;ID</th>
                    <th>&emsp;Imię</th>
                    <th>&emsp;Nazwisko</th>
                    <th>&emsp;Płeć</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <form method="get">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button name="lista" type="submit">Wybierz</button>
                        </form>
                        
                    </td>
                    <td>&emsp;<?php echo $user['username']; ?></td>
                    <td>&emsp;<?php echo $user['firstname']; ?></td>
                    <td>&emsp;<?php echo $user['lastname']; ?></td>
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
                <h2><br><br>Szczegóły użytkownika</h2>
                <table>
                    <tr>
                        <th><br>ID</th>
                        <td><br><?php echo $user['id']; ?></td>
                    </tr>
                    <tr>
                        <th><br>Login</th>
                        <td><br><?php echo $user['username']; ?></td>
                    </tr>
                    <tr>
                        <th><br>Imię</th>
                        <td><br><?php echo $user['firstname']; ?></td>
                    </tr>
                    <tr>
                        <th><br>Nazwisko</th>
                        <td><br><?php echo $user['lastname']; ?></td>
                    </tr>
                    <tr>
                        <th><br>Adres email:</th>
                        <td><br><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <th><br>Płeć</th>
                        <td><br><?php echo $user['gender']; ?></td>
                    </tr>
                    <form action="update_user.php" method="POST">
                        <tr>
                            <th><br>Admin?</th>
                            <?php if($user['id'] === "e708860e6cb8c") { ?>
                            <td><br>
                                <input type="radio" name="is_admin" value="1" <?php if ($user['is_admin']) echo 'checked'; ?> disabled> Tak
                                <input type="radio" name="is_admin" value="0" <?php if (!$user['is_admin']) echo 'checked'; ?> disabled> Nie
                            </td> <?php }
                            else
                            { ?>
                            <td><br>
                                <input type="radio" name="is_admin" value="1" <?php if ($user['is_admin']) echo 'checked'; ?> > Tak
                                <input type="radio" name="is_admin" value="0" <?php if (!$user['is_admin']) echo 'checked'; ?> > Nie
                            </td> <?php } ?>
                        </tr>
                        <tr>
                            <th><br>Doktor?</th>
                            <td><br>
                                <input type="radio" name="is_doctor" value="1" <?php if ($user['is_doctor']) echo 'checked'; ?>> Tak
                                <input type="radio" name="is_doctor" value="0" <?php if (!$user['is_doctor']) echo 'checked'; ?>> Nie
                            </td>
                        </tr>
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <tr>
                            <td colspan="2">
                                <br><input type="submit" value="Zapisz zmiany"><br><br>
                                <?php echo 'Wprowadzone zmiany będą obowiązywać od nowej sesji logowania.'; ?>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <th><br><br><br>Usuń użytkownika:</th>
                        <td>
                            <form method="post">
                                <input type="hidden" name="user_id1" value="<?php echo $user['id']; ?>">
                                <br><br><br><button type="submit">Usuń</button>
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
                                }
                                else if ($user_id === "e708860e6cb8c"){
                                    echo '<div class="alert alert-success" id="delete-message">Nie możesz usunąć konta ROOTa.</div>';
                                }
                                else {
                                    $sql = 'DELETE FROM users WHERE id=:user_id';
                                    $stmt = $db_conn->prepare($sql);
                                    $stmt->execute(array(':user_id' => $user_id));
                                    echo '<div class="alert alert-success" id="delete-message">Użytkownik został usunięty z bazy danych. Odśwież, by zobaczyć zmiany.</div>';
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
    var refresh = true;
    setTimeout(function() {
        document.getElementById('delete-message').style.display = 'none';
    }, 5000);
</script>
	