<?php
session_start();
require 'connection.php';
if (isset($_SESSION['icmds_login'])) {
  header('location: index');
} else {

if ((isset($_GET['email']) && isset($_GET['token'])) || isset($_POST['btnupdate'])) {

    if (isset($_POST['btnupdate'])) {
      $password = md5($mysqli->real_escape_string($_POST['password']));
      $email = $mysqli->real_escape_string($_POST['email']);

      $update = "UPDATE admin SET password='$password', token='' WHERE email='$email'";
      if ($mysqli->query($update)) {

          $_SESSION['icmds_message']= "Password Updated Successfully";
          header('location: login');
      } else {
          $_SESSION['icmds_message']= "Failed To Update Password, Try Again";
          header('location: login');
      }
    }
    if (isset($_GET['email']) && isset($_GET['token'])) {

      $email = $mysqli->real_escape_string($_GET['email']);
      $token = $mysqli->real_escape_string($_GET['token']);

      $sql = $mysqli->query("SELECT id FROM admin WHERE email='$email' AND token='$token'");
      if ($sql->num_rows == 0) {
        $_SESSION['icmds_message'] = "Link Expired or has Been Used";
        header('location: login');
      } else {


?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Reset Password | ICMDS</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="http://icmds.org" target="_blank"><b>ICMDS</b></a>
            <small>Indian Classical Music & Dance Society</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="reset_form" method="POST" action="reset">
                    <div class="msg">Create a New Password</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" minlength="6" placeholder="New Password" required >
                        </div>
                    </div>
                    <input type="hidden" name="email" value="<?php echo $email;?>">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirm New Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <center><button class="btn btn-block btn-success waves-effect" name="btnupdate" type="submit">Update Password</button></center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/sign-in.js"></script>
</body>

</html>
<?php
}
}
} else {
  header('location: login');
}
}
?>
