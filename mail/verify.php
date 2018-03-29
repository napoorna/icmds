<?php
if (isset($_POST['email']) && isset($_POST['mid']) && isset($_POST['total']) && isset($_POST['eventid'])) {
    if ($_POST['email']=="") {
      echo "Email Field Can not be blank";
    } elseif ($_POST['total']=="Total Fare $0.00") {
      echo "Total Fare Can Not Be Zero";
    } elseif ($_POST['email']!="" && $_POST['total']!="Total Fare $0.00") {
      require '../connection.php';
      $email = $mysqli->real_escape_string($_POST['email']);
      $total = $mysqli->real_escape_string($_POST['total']);
      $mid = $mysqli->real_escape_string($_POST['mid']);
      $eventid = $mysqli->real_escape_string($_POST['eventid']);

      $sql = $mysqli->query("SELECT m.membership_id AS memid, m.end_date AS medate FROM member m INNER JOIN users u ON u.user_id=m.user_id AND u.email='$email'");
      if ($sql->num_rows == 0) {
        echo "This Email does not have any Membership";
      } else {
        $flag = $sql->num_rows;
        $value = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
          $flag -= 1;
          if ($row['memid'] == $mid) {

              $expire = $row['medate'];
              $today = time();

              $expire_dt = new DateTime($expire." 23:59");
              $expire = $expire_dt->getTimestamp();

              if ($expire >= $today) {
                $valid = 1;
              } else {
                $valid = 0;
              }

            $value = 1;
          }
        }

        if ($flag == 0) {
          if ($value == 0) {
            echo "Invalid Membership ID";
          } elseif ($value == 1) {
            if ($valid == 1) {
              $sql = $mysqli->query("SELECT discount FROM event WHERE event_id='$eventid'");
              $res = $sql->fetch_assoc();
              $discount = $res['discount'];
              if ($discount=="" || $discount==0) {
                echo "No discount";
              } else {
                echo $discount;
              }
            } elseif ($valid == 0) {
              echo "Subscription Expired, Buy a New Subscription";
            }
          }

        }
      }

    }
}
?>
