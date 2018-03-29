<?php
session_start();
require 'connection.php';
if (isset($_GET['backlink'])) {
  session_unset();
  $mysqli->close();
  header('location: ../');
  die();
} else {
  session_unset();
  $_SESSION['icmds_message'] = "You have logged out Successfully";
  $mysqli->close();
  header('location: login');
  die();
}
 ?>
