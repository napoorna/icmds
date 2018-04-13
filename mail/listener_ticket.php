<?php

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('location: index');
    } else {
      include "class.phpmailer.php";
      include "class.smtp.php";
      require '../connection.php';
      session_start();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=_notify-validate&" . http_build_query($_POST));
        $response = curl_exec($ch);
        curl_close($ch);

        // file_put_contents("test.txt", $response);

          // $value = "Product Count ".$_POST['item_name'].", Event ID".$_POST['item_number'].", Total ".$_POST['mc_gross'].", Count ".$_POST['quantity'].", Price count ".$_POST['custom'].", Email ".$_POST['payer_email'].", Name ".$_POST['address_name'].", Phone ".$_POST['address_street'].", Payment: ".$_POST['payment_status'];

          $_SESSION['product_count'] = $_POST['item_name'];
          $_SESSION['eventid'] = $eventid = $_POST['item_number'];
          $_SESSION['total'] = $total = $_POST['mc_gross'];
          // $_SESSION['count'] = $_POST['quantity'];
          $_SESSION['price_count'] = $_POST['custom'];
          $email = $_POST['payer_email'];
          // $_SESSION['name'] = $name = $_POST['address_name'];
          $phone = $_POST['address_street'];
          $currency = $_POST['mc_currency'];
          $paymentStatus = $_POST['payment_status'];
          $unit = explode(",",$_SESSION['price_count']);
          $_SESSION['count'] = $unit[0];
          $username = $_SESSION['name'] = $unit[1];
          $userphone = $unit[2];
          $useremail = $_SESSION['email'] = $unit[3];


          // file_put_contents("test.txt", $paymentStatus);

        if ($currency=="USD" && $paymentStatus == "Completed") {

          $timedate = $_POST['payment_date'];

          // Store This Transaction To The Database
          $mysqli->query("INSERT INTO transaction(email,timedate,amount) VALUES ('$email','$timedate','$total')");

            // Process Of Creating Unique USER ID
            $sql1 = "SELECT * FROM event WHERE event_id='$eventid'";
            if ($sql2 = $mysqli->query($sql1)) {

            $row = $sql2->fetch_assoc();
            $_SESSION['event_name'] = $row['event_name'];
            $_SESSION['venue'] = $row['event_venue'];
            $_SESSION['time'] = $row['start_time'];

            $sql = $mysqli->query("SELECT ticket_id FROM tickets ORDER BY ticket_id DESC LIMIT 1");
            $row1 = $sql->fetch_assoc();
            $pastid = $row1['ticket_id'];
            $old = substr($pastid,0,6);
            $current = date('Ym');
            if($old == $current){ $ticketid = $pastid+1; } else { $ticketid = $current."00001";}
            $_SESSION['ticketid'] = $ticketid;

           // Storing Ticket Data To the DATABASE
             $insert ="INSERT INTO tickets (ticket_id,event_id,name,email,payer_email,phone,ticket_price) VALUES ('$ticketid','$eventid','$username','$useremail','$email','$userphone','$total')";
             if ($mysqli->query($insert)) {

            require 'fpdf/fpdf.php';
            class PDF extends FPDF{
              function Header(){

                  $test=$this;

                       $this->Image('ticket.png', 0, 0, 180, 122);
                       $this->SetFont('Arial','',11);
                       $this->Cell(25,24,'',0,1);
                       $this->Cell(25,6,'',0,0);
                       $this->Cell(25,4,$_SESSION['event_name'],0,1);
                       $this->Cell(25,3,'',0,0);
                       $this->Cell(25,5,$_SESSION['venue'],0,1);
                       $this->Cell(25,3,'',0,0);
                       $this->Cell(25,5,$_SESSION['ticketid'],0,0);

                       $this->Cell(50,3,'',0,0);
                       $this->Cell(25,5,$_SESSION['time'],0,1);
                       $this->Cell(25,3,'',0,0);
                       $this->Cell(25,5,$_SESSION['name'],0,0);
                       $this->Cell(55,3,'',0,0);
                       $this->Cell(25,5,$_SESSION['email'],0,1);
                       $this->Cell(25,5,'',0,0);
                       $this->Cell(30,5,"$".$_SESSION['total'],0,0);
                       $this->Cell(55,3,'',0,0);
                       $this->Cell(20,5,$_SESSION['count'],0,1);
                       $this->Cell(25,3,'',0,1);

                       $this->Cell(9,10,'',0,1);

                 }
               }

                       $pdf = new PDF('L','mm',array(180,122));
                       $pdf->AddPage();

                       $product_c = explode(",",$_SESSION['product_count']);
                       $unit_p = explode(",",$_SESSION['price_count']);
                       foreach ($product_c as $key => $product) {
                         $k = $key+4;
                         $category = substr($product, 0, -1);
                         $quantity = substr($product, -1);
                         $unit_price = $unit_p[$k];
                         $tid = $_SESSION['ticketid'];
                         $eid = $_SESSION['eventid'];

                         $mysqli->query("INSERT INTO ticket_category_map(ticket_id,event_id,category,seat,price) VALUES ('$tid','$eid','$category','$quantity','$unit_price')");

                         $pdf->Cell(10,5,$category,0,0);
                         $pdf->Cell(70,5,'',0,0);
                         $pdf->Cell(10,5,"x ".$quantity,0,0);
                         $pdf->Cell(33,5,'',0,0);
                         $pdf->Cell(37,5,"$ ".$unit_price,0,1);

                       }

                       $filename = "tickets/".$ticketid.".pdf";
                       $pdfname = $ticketid.".pdf";
                       $pdf->Output($filename,"F");

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
                       $mail->Subject = "ICMDS Event Ticket";
                       $mail->AddAttachment($filename, $pdfname,  $encoding = 'base64', $type = 'application/pdf');
                       $mail->Body = "
                           Thank You! Your Ticket has been generated with Ticket No $ticketid. Your ticket is Attached please bring a print out at the venue.<br><br>

                           Kind regards,
                           ICMDS
                       ";

                         $mail->send();

              }



            }
        }


     }



?>
