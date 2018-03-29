<?php
if (isset($_POST['eventid'])) {
  $tag = 0;
  require '../connection.php';
  $eventid = $mysqli->real_escape_string($_POST['eventid']);
  $sql = $mysqli->query("SELECT SUM(seat) as total FROM event_ticket_category_map WHERE event_id='$eventid'");
  $res = $sql->fetch_assoc();
  $total = $res['total'];

  $qry = $mysqli->query("SELECT SUM(seat) AS sum FROM ticket_category_map WHERE event_id='$eventid'");
  $row = $qry->fetch_assoc();
  $booked = $row['sum'];

  if ($total>$booked) {
    echo "success";
  } else {
    echo "All Seats of This Event has been Booked";
  }
}
?>
