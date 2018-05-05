<?php
session_start();
require '../connection.php';

if (isset($_SESSION['icmds_login'])) {
  if ($_SESSION['logged_tag']=="admin" && isset($_GET['aid'])) {
    $aid = $mysqli->real_escape_string($_GET['aid']);
    if ($mysqli->query("DELETE FROM admin WHERE id='$aid'")) {
      echo '<script language="javascript">';
      echo 'alert("Account Removed Successfully");';
      echo 'window.location.href = "../admins"';
      echo '</script>';
    } else {
      echo '<script language="javascript">';
      echo 'alert("Failed to Remove Account, try Again");';
      echo 'window.location.href = "../admins"';
      echo '</script>';
    }
  }
}
?>
