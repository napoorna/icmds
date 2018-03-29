<?php
session_start();
require 'connection.php';

if (isset($_SESSION['icmds_login'])) {
  header('location: index');
}

if (isset($_POST['btnreset'])) {
  $mysqli->real_escape_string($_POST['email']);

  $sql = $mysqli->query("SELECT id FROM admin WHERE email='$email'");
  if ($sql->num_rows == 0) {
    echo '<script language="javascript">';
    echo 'alert("No Record Found with This Email ID");';
    echo '</script>';
  } else {
        $str = "0123456789qwertyuiopasdfghjklzxcvbnm";
        $str = str_shuffle($str);
        $str = substr($str, 0, 15);
        $newurl = "http://icmds.org/icmds/reset?token=$str&email=$email";

        $updatequery = $mysqli->query("UPDATE admin SET token='$str' WHERE email='$email'");
        # mail send
        use db\PHPMailer\PHPMailer\PHPMailer;
        require_once "db/PHPMailer/PHPMailer.php";
        require_once "db/PHPMailer/Exception.php";

        $mail = new PHPMailer();
        $mail->addAddress($email);     // Add a recipient
  	    $mail->setFrom("no-reply@icmds.org", "Admin");
  	    $mail->Subject = "Reset Password of ICMDS Database";
  	    $mail->isHTML(true);

        $mail->Body    = 'Hello Admin,
        It looks like you have requested a password reset for your <b>ICMDS Admin Portal</b>
        To Reset it just follow this link-> '.$newurl.'.
        If You think it happend by mistake, just Ignore this mail, Thank You';

        if ($mail->send()) {
          $_SESSION['icmds_message'] = "Please Check your mail to Reset Password";
          header('location: login');
          $mysqli->close();
        } else {
          $_SESSION['icmds_message'] = "Something Went Wrong, please try again";
          header('location: login');
          $mysqli->close();
        }

  }


}
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
                <form id="reset_form" method="POST" action="resetemail">
                    <div class="msg">Enter Account Email ID</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email ID" required >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <center><button class="btn btn-block btn-success waves-effect" name="btnreset" type="submit">Request Reset</button></center>
                        </div>
                        <div class="col-xs-6">
                            <center><a href="login"><button class="btn btn-block btn-primary waves-effect" type="button">Login Here</button></a></center>
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
