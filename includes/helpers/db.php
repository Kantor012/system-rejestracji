<?php
  $dbhost = '127.0.0.1';
  $dbname = 'damek012';
  $dbuser = 'gabinet1113';
  $dbpassword = 'Gabinet1113?';

  $db_conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpassword);