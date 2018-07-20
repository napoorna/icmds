<?php

  require '../connection.php';
  include "class.phpmailer.php";
  include "class.smtp.php";

  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = "icmds.org";
  $mail->SMTPAuth= true;
  $mail->Username= "tickets@icmds.org";
  $mail->Password= "Tickets@123";
  $mail->Port =587;
  $mail->From="tickets@icmds.org";
  $mail->FromName="Admin";
  $mail->IsHTML(true);
?>
