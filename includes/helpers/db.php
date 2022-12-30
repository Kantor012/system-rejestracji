<?php
  $dbhost = 'localhost';
  $dbname = 'gabinet';
  $dbuser = 'root';
  $dbpassword = '';

  $db_conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpassword);