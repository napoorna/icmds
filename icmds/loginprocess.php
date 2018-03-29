<?php
session_start();
require 'connection.php';
if (isset($_SESSION['icmds_login'])) {
    header('location: index');
} else {
  if (isset($_POST['signinbtn'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $password = md5($mysqli->real_escape_string($_POST['password']));

    $sql = $mysqli->query("SELECT * FROM admin WHERE email='$email' AND password='$password'");
    if ($sql->num_rows == 0) {
      $_SESSION['icmds_message'] = "Wrong Credentials";
      header('location: login');
    } else {
      $row = $sql->fetch_assoc();
      $_SESSION['logged_email'] = $row['email'];
      $_SESSION['logged_name'] = $row['name'];
      $_SESSION['logged_tag'] = $row['designation'];
      $_SESSION['icmds_login'] = 1;
      
      header('location: index');
    }
  } else {
    header('location: index');
  }
}
?>
