<?php
  session_start();

  $_SESSION['username'] = null;
  $_SESSION['logged_in'] = null;

  session_destroy();

  header('Location: login.php');
  exit;