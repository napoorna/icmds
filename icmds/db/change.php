<?php
require '../connection.php';
session_start();
if (isset($_SESSION['icmds_login'])) {
  if ($_POST['eventid']) {

    $eventid = $mysqli->real_escape_string($_POST['eventid']);
    $track = $mysqli->real_escape_string($_POST['track']);

    if ($track=="cevent") {

      $no = $mysqli->query("SELECT active FROM cevent WHERE event_id='$eventid'")->fetch_assoc();
      if ($no['active'] == 1) {
            $sql = "UPDATE cevent SET active = '0' WHERE event_id='$eventid'";
            $tag = 0;
      } else {
            $sql = "UPDATE cevent SET active = '1' WHERE event_id='$eventid'";
            $tag = 1;
      }
      if ($mysqli->query($sql)) {
        if ($tag == 1) {
          echo 1;
          exit;
        } else {
          echo 2;
          exit;
        }
      } else {
        echo 3;
        exit;
      }


    }

  }
}
?>
