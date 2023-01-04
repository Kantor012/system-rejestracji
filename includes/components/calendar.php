<?php
  date_default_timezone_set('Europe/Warsaw');

  if (isset($_GET['ym'])) $ym = $_GET['ym'];
  else $ym = date('Y-m');

  $timestamp = strtotime($ym . '-01');

  if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
  }

  $today = date('Y-m-j', time());
  $html_title = date('Y / m', $timestamp);

  $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
  $prev = date('Y-m', strtotime('-1 month', $timestamp));

  $day_count = date('t', $timestamp);
  $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

  $weeks = array();
  $week = '';

  $week .= str_repeat('<td></td>', $str);

  for ( $day = 1; $day <= $day_count; $day++, $str++) {
    $date = $ym . '-' . $day;

    if ($today == $date) {
      if (date('N', strtotime($date)) >= 6) {
        $weekend = 'class="weekend"';
      } else {
        $weekend = '';
      }

      $params = '';

      if (isset($_GET['ym'])) {
        $params = '&ym=' . $_GET['ym'];
      }

      $selected = '';

      if (isset($_GET['day'])) {
        if ($date == $_GET['day']) $selected = ' selected';
      }

      $previous = '';

      if (strtotime($today) > strtotime(@$_GET['day'])) $previous = ' previous';
      $fullClass = ' class="today ' . $weekend . $selected . $previous . '"';

      if (isset($_GET['day'])) if ($date == $_GET['day']) $selected = 'class="selected"';

      $week .= '<td ' . $fullClass . ' data-date="' . $date . '"' . $weekend . '>' . '<a href="?day=' . $date . $params . '">' . $day . '</a>';
    } else {
      if (date('N', strtotime($date)) >= 6) $weekend = 'weekend';
      else $weekend = '';

      $params = '';
      if (isset($_GET['ym'])) $params =  '&ym=' . $_GET['ym'];

      $selected = '';
      if (isset($_GET['day'])) if ($date == $_GET['day']) $selected = 'selected';

      $previous = '';
      if (strtotime($date) < strtotime($today)) {
        $previous = 'previous';
      }

      $fullClass = 'class="' . $weekend . ' ' . $selected . ' ' . $previous . '"';
      $week .= '<td data-date="' . $date . '"' . $fullClass . '>' . '<a href="?day=' . $date  . $params . '">' . $day . '</a>';
    }
    $week .= '</td>';

    if ($str % 7 == 6 || $day == $day_count) {
      if ($day == $day_count) $week .= str_repeat('<td></td>', 6 - ($str % 7));
      $weeks[] = '<tr>' . $week . '</tr>';
      $week = '';
    }
  }