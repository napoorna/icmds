<?php
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('location: ../');
    } else {
      include "class.phpmailer.php";
      include "class.smtp.php";
      require '../connection.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=_notify-validate&" . http_build_query($_POST));
    $response = curl_exec($ch);
    curl_close($ch);


      $unit = explode(",",$_POST['custom']);
      $username = $unit[0];
      $userphone = $unit[1];
      $useremail = $unit[2];
      $email = $_POST['payer_email'];

     $item_no = $_POST['item_number'];
     $item_name = $_POST['item_name'];
     $currency = $_POST['mc_currency'];
     $price = $_POST['mc_gross'];
     $paymentStatus = $_POST['payment_status'];

     if ($item_no==1 && $item_name=="Patron Family Members" && $currency=="USD" && $paymentStatus == "Completed" && $price == 250) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y'); //date('d-m-Y', strtotime(' +1 day'));
          // $enddate = date('d-m-Y', strtotime(' +364 day'));

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');//date('d-m-Y', strtotime(' +1 day'));

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==2 && $item_name=="Extended Family membership" && $currency=="USD" && $paymentStatus == "Completed" && $price == 180) {

       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==3 && $item_name=="Full-Society Family Members" && $currency=="USD" && $paymentStatus == "Completed" && $price == 150) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==4 && $item_name=="Senior Family Members" && $currency=="USD" && $paymentStatus == "Completed" && $price == 100) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==5 && $item_name=="Patron Individual Members" && $currency=="USD" && $paymentStatus == "Completed" && $price == 125) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";
               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==6 && $item_name=="Individual Members" && $currency=="USD" && $paymentStatus == "Completed" && $price == 75) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==7 && $item_name=="Student / Senior Citizen" && $currency=="USD" && $paymentStatus == "Completed" && $price == 50) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     } elseif ($item_no==8 && $item_name=="Premier Membership" && $currency=="USD" && $paymentStatus == "Completed" && $price == 1000) {
       require '../connection.php';

       $timedate = $_POST['payment_date'];

       // Store This Transaction To The Database
       $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");

       // Checking The User (New OR Existing)
       $sql = $mysqli->query("SELECT user_id FROM users WHERE email='$useremail'");

       if ($sql->num_rows == 0) {
         // New User

         // Process Of Creating Unique USER ID
         $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
         $row = $sql1->fetch_assoc();
         $pastid = $row['user_id'];

         $old = substr($pastid,0,8);$current = date('Ymd');

         if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
        // END Process Of Creating Unique USER ID

        // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
        // END Process Of Creating User Membership ID


        // Storing User Data To the DATABASE
          $insert ="INSERT INTO users (user_id, name, email, phone) VALUES ('$finalid','$username','$useremail','$userphone')";
          if ($mysqli->query($insert)) {

          $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

        // Storing Membership Details To The DATABASE
          $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
             if ($mysqli->query($inser2)) {
               $mail = new PHPMailer();
               $mail->isSMTP();
               $mail->Host = "icmds.org";
               $mail->SMTPAuth= true;
               $mail->Username= "tickets@icmds.org";
               $mail->Password= "Tickets@123";
               $mail->Port =587;
               $mail->From="tickets@icmds.org";
               $mail->FromName="Admin";
               $mail->AddAddress ($useremail);
               $mail->IsHTML(true);
               $mail->Subject = "Your Membership Details";
               $mail->Body = "
                   Hello, <br><br>
                   Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

                   Kind regards,
                   ICMDS
               ";

               $mail->send();
             }

           }


       } else {
         // Existing User

         $row = $sql->fetch_assoc();
         $finalid = $row['user_id'];

         // Process Of Creating User Membership ID
          $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
          $row2 = $sql2->fetch_assoc();
          $pastid2 = $row2['membership_id'];

          $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

          if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
         // END Process Of Creating User Membership ID


         $startdate = date('d-m-Y'); $enddate = date('31-12-Y');

         // Storing Membership Details To The DATABASE
         $inser2="INSERT INTO member (user_id,membership_id,level,start_date,end_date) VALUES ('$finalid','$finalid2','$item_name','$startdate','$enddate')";
         if ($mysqli->query($inser2)) {
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = "icmds.org";
           $mail->SMTPAuth= true;
           $mail->Username= "tickets@icmds.org";
           $mail->Password= "Tickets@123";
           $mail->Port =587;
           $mail->From="tickets@icmds.org";
           $mail->FromName="Admin";
           $mail->AddAddress ($useremail);
           $mail->IsHTML(true);
           $mail->Subject = "Your Membership Details";
           $mail->Body = "
               Hello, <br><br>
               Welcome to ICMDS. Your Unique UserID is $finalid. And Membership number is $finalid2, Membership Plan is $item_name, Valid till $enddate.<br><br>

               Kind regards,
               ICMDS
           ";

           $mail->send();
         }

       }

     }else {
       if ($paymentStatus == "Completed") {
         $timedate = $_POST['payment_date'];

         // Store This Transaction To The Database
         $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$price')");
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = "icmds.org";
         $mail->SMTPAuth= true;
         $mail->Username= "tickets@icmds.org";
         $mail->Password= "Tickets@123";
         $mail->Port =587;
         $mail->From="tickets@icmds.org";
         $mail->FromName="Admin";
         $mail->AddAddress ($useremail);
         $mail->IsHTML(true);
         $mail->Subject = "Your Membership Details";
         $mail->Body = "
             Hello, <br><br>
             Something Went Wrong, Kindly Contact Admin.<br><br>

             Kind regards,
             ICMDS
         ";

         $mail->send();

       }
     }

  }
?>
