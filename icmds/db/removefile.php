<?php
require '../connection.php';
if (isset($_POST['fileid']) && isset($_POST['eventid']) && isset($_POST['name']) && isset($_POST['backlink'])) {

  $id = $mysqli->real_escape_string($_POST['fileid']);
  $eventid = $mysqli->real_escape_string($_POST['eventid']);
  $name = $mysqli->real_escape_string($_POST['name']);
  $backlink = $mysqli->real_escape_string($_POST['backlink']);
  if ($backlink == "event") {
      $sql = $mysqli->query("SELECT id FROM eventdocs WHERE id='$id' AND event_id='$eventid' AND docs='$name'");
      if ($sql->num_rows == 0) {
        echo '<script language="javascript">';
        echo 'alert("Data Not Found");';
        echo 'window.location.href = "../";';
        echo '</script>';
      } else {
        $sql1 = "DELETE FROM eventdocs WHERE id='$id' AND event_id='$eventid' AND docs='$name'";
        if ($mysqli->query($sql1)) {
          unlink("images/".$name);
          echo "File Removed";
        } else {
          echo "Failed To Remove File, Try Again";
        }
      }

  } elseif ($backlink == "cevent") {
      $sql = $mysqli->query("SELECT id FROM ceventdocs WHERE id='$id' AND event_id='$eventid' AND docs='$name'");
      if ($sql->num_rows == 0) {
        echo '<script language="javascript">';
        echo 'alert("Data Not Found");';
        echo 'window.location.href = "../";';
        echo '</script>';
      } else {
        $sql1 = "DELETE FROM ceventdocs WHERE id='$id' AND event_id='$eventid' AND docs='$name'";
        if ($mysqli->query($sql1)) {
          unlink("images/".$name);
          echo "File Removed";
        } else {
          echo "Failed To Remove File, Try Again";
        }
      }
  }
} else {
  header('location: ../');
}
?>
