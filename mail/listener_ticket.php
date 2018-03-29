<?php
use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer/PHPMailer.php";
require "PHPMailer/Exception.php";
session_start();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php');
        exit();
    }


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

        if ($response == "VERIFIED") {

          $_SESSION['product_count'] = $_POST['item_name'];
          $_SESSION['eventid'] = $eventid = $_POST['item_number'];
          $_SESSION['total'] = $total = $_POST['mc_gross'];
          $_SESSION['count'] = $_POST['quantity'];
          $_SESSION['price_count'] = $_POST['custom'];
          $_SESSION['email'] = $email = $_POST['payer_email'];
          $_SESSION['name'] = $name = $_POST['address_name'];
          $phone = $_POST['address_street'];
          $currency = $_POST['mc_currency'];
          $paymentStatus = $_POST['payment_status'];

          // file_put_contents("test.txt", $paymentStatus);

        if ($currency=="USD" && $paymentStatus == "Completed") {
          require '../connection.php';

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
             $insert ="INSERT INTO tickets (ticket_id,event_id,name,email,phone,ticket_price) VALUES ('$ticketid','$eventid','$name','$email','$phone','$total')";
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
                         $category = substr($product, 0, -1);
                         $quantity = substr($product, -1);
                         $unit_price = $quantity*$unit_p[$key];
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
                       $email = $_SESSION['email'];
                       $sname = $_SESSION['name'];

                         $mail = new PHPMailer();
                         $mail->setFrom("no-reply@icmds.org", "Admin");
                         $mail->addAddress($email, $sname);
                         $mail->isHTML(true);
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
