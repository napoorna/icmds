<?php
if (isset($_POST['email']) && isset($_POST['mid'])) {
  require '../connection.php';

  $email = $mysqli->real_escape_string($_POST['email']);
  $mid = $mysqli->real_escape_string($_POST['mid']);
  $price_array = $mysqli->real_escape_string($_POST['price']);
  $qnt_array = $mysqli->real_escape_string($_POST['qnt']);
  $eventid = $mysqli->real_escape_string($_POST['eventid']);
  $category = $mysqli->real_escape_string($_POST['cats']);

  if ($mid==99) {

    $err = 0;
    $cats = explode(',', $category);
    $qnt = explode(',', $qnt_array);
    $length = sizeof($cats);

    foreach ($cats as $key=>$cat) {
      $length -= 1;

        if ($qnt[$key]>0) {
          $required = $qnt[$key];
          $sql = $mysqli->query("SELECT SUM(seat) AS count FROM ticket_category_map WHERE event_id='$eventid' AND category='$cat'");
          $row = $sql->fetch_assoc();
          $booked = $row['count'];
          $sql2 = $mysqli->query("SELECT seat FROM event_ticket_category_map WHERE event_id='$eventid' AND category='$cat'");
          $row2 = $sql2->fetch_assoc();
          $total = $row2['seat'];
          if (($total-$booked) < $required) {
            $val = $total-$booked;
            $catval = $cat;
            $err = 1;
          }
        }
    }

    if ($length == 0) {
      if ($err == 0) {
        echo "success";
      } elseif ($err == 1) {
        if ($val == 0) {
          echo "No Seats are Available For $catval Category";
        } else {
          echo "Only $val Seat(s) are Available For $catval Category";
        }
      }
    }

  }elseif ($mid!=99){

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
          $err = 0;
          $cats = explode(',', $category);
          $qnt = explode(',', $qnt_array);
          $length = sizeof($cats);
          // echo $length;

          foreach ($cats as $key=>$cat) {
            $length -= 1;

              if ($qnt[$key]>0) {
                $required = $qnt[$key];
                $sql = $mysqli->query("SELECT SUM(seat) AS count FROM ticket_category_map WHERE event_id='$eventid' AND category='$cat'");
                $row = $sql->fetch_assoc();
                $booked = $row['count'];
                $sql2 = $mysqli->query("SELECT seat FROM event_ticket_category_map WHERE event_id='$eventid' AND category='$cat'");
                $row2 = $sql2->fetch_assoc();
                $total = $row2['seat'];
                if (($total-$booked) < $required) {
                  $val = $total-$booked;
                  $catval = $cat;
                  $err = 1;
                }
              }
          }

          if ($length == 0) {
            if ($err == 0) {
              echo "success";
            } elseif ($err == 1) {
              if ($val == 0) {
                echo "No Seats are Available For $catval Category";
              } else {
                echo "Only $val Seat(s) are Available For $catval Category";
              }
            }
          }

        } elseif ($valid == 0) {
          echo "Subscription Expired, Buy a New Subscription";
        }
      }

    }
  }
}

} else {
  header('location: ../');
}
?>
