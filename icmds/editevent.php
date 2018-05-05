<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
require_once 'connection.php';

if (isset($_GET['eventid']) || (isset($_POST['updateeventbtn']) && isset($_POST['eventid'])) || (isset($_POST['pic']) && isset($_POST['eventid']))) {

  if (isset($_POST['pic']) && isset($_POST['eventid'])) {
    $eventid = $mysqli->real_escape_string($_POST['eventid']);
    $UploadFolder = "db/images";
      $temp = $_FILES["cover"]["tmp_name"];
      $name = $_FILES["cover"]["name"];
      $temp1 = explode(".", $name);
      $newfilename = round(microtime(true)) . '.' . end($temp1);
      if (move_uploaded_file($temp, $UploadFolder."/" . $newfilename)) {
        $insertqry = "UPDATE event SET cover='$newfilename' WHERE event_id='$eventid'";
        if ($mysqli->query($insertqry)) {
          echo '<script language="javascript">';
          echo 'alert("Event Cover Updated");';
          echo 'window.location.href = "editevent?eventid='.$eventid.'"';
          echo '</script>';
        } else {
          echo '<script language="javascript">';
          echo 'alert("Failed To Update Event Cover! Try Again");';
          echo 'window.location.href = "editevent?eventid='.$eventid.'"';
          echo '</script>';
        }

      }
  }

  if (isset($_POST['updateeventbtn']) && isset($_POST['eventid'])) {

    $event_id= $mysqli->real_escape_string($_POST['eventid']);
    $event_name= $mysqli->real_escape_string($_POST['event_name']);
    $event_venue= $mysqli->real_escape_string($_POST['event_venue']);
    $event_description= $mysqli->real_escape_string($_POST['event_description']);
    $starttime= $mysqli->real_escape_string($_POST['event_starttime']);
    $endtime= $mysqli->real_escape_string($_POST['event_endtime']);
    $status = $_POST['status'];
    if (isset($_POST['event_discount'])) {$discount= $mysqli->real_escape_string($_POST['event_discount']);}else{ $discount="";}

    $result = explode(" ", $starttime, 6);
    $date = $result[1];
    $month = $result[2];
    $year = $result[3];

    if ($status == 0) {
        $updatesql = "UPDATE event SET event_name = '$event_name', event_description = '$event_description', event_venue = '$event_venue', start_time = '$starttime', end_time = '$endtime', day = '$date', month = '$month', year = '$year', discount = '0' WHERE event_id = '$event_id'";
    } else {
        $updatesql = "UPDATE event SET event_name = '$event_name', event_description = '$event_description', event_venue = '$event_venue', start_time = '$starttime', end_time = '$endtime', day = '$date', month = '$month', year = '$year', discount = '$discount' WHERE event_id = '$event_id'";
    }

    if ($mysqli->query($updatesql)) {
      echo '<script type="text/javascript">';
      echo 'alert("Event Details Updated Successfully");';
      echo 'window.location.href="editevent?eventid='.$event_id.'"';
      echo '</script>';
    } else {
      echo '<script type="text/javascript">';
      echo 'alert("Failed To Update Event Details, Try Again");';
      echo 'window.location.href="editevent?eventid='.$event_id.'"';
      echo '</script>';
    }

  }

  if (isset($_GET['eventid'])) {
  $id = $mysqli->real_escape_string($_GET['eventid']);
  $sql = $mysqli->query("SELECT * FROM event WHERE event_id='$id'");
  if ($sql->num_rows == 0) {
      echo '<script type="text/javascript">';
      echo 'alert("Event Not Found");';
      echo 'window.location.href="events";';
      echo '</script>';
  }
  $row = $sql->fetch_assoc();

  $starttime = $row['start_time'];
  $result = explode(" ", $starttime, 6);
  $date = $result[1];$month = $result[2];$year = $result[3];$time = $result[5];
  $check = strtotime($date.' '.$month.' '.$year.' '.$time);
  $current = strtotime(date("Y-m-d H:i", strtotime("-5 hours")));
  if ($check<=$current) {
    echo '<script type="text/javascript">';
    echo 'alert("You Can\'t Edit a Past Event");';
    echo 'window.location.href="events";';
    echo '</script>';
  }


?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Edit Event | ICMDS</title>
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

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <style media="screen">
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
      }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index">ICMDS Admin Portal</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="images/logo.jpg" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['logged_name'];?></div>
                    <div class="email"><?php echo $_SESSION['logged_email'];?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                          <?php if ($_SESSION['logged_tag'] == "admin"): ?>
                            <li><a href="profile"><i class="material-icons">person</i>Profile</a></li>
                          <?php endif; ?>
                            <li><a href="logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li>
                        <a href="index">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['logged_tag']=="admin"): ?>
                    <li>
                        <a href="admins">
                            <i class="material-icons">person</i>
                            <span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="members">
                            <i class="material-icons">group</i>
                            <span>Members</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">event</i>
                            <span>Events</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="addevent">
                                    Add Event
                                </a>
                            </li>
                            <li>
                                <a href="events">
                                    All Events
                                </a>
                            </li>
                            <li>
                                <a href="addcevent">
                                    Add Community Event
                                </a>
                            </li>
                            <li>
                                <a href="cevents">
                                    All Community Events
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="logout?backlink=true">
                            <i class="material-icons">person</i>
                            <span>Sign Out And Back To ICMDS</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 <a href="index">ICMDS Admin Portal</a>.
                </div>
                <div class="version">
                    Developed By: <b><a href="http://www.onclavesystems.com" style="text-decoration:none;color: inherit;" target="_blank">Onclave Systems</a></b>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>Edit Event <?php echo $row['event_name'];?></h2>
                            </div>

                            <div class="body">
                              <div class="row text-center">
                                <img src="db/images/<?php echo $row['cover'];?>" height="150px" alt="No Image">
                              </div>
                              <hr>
                                <form id="form_validation" method="POST" action="editevent">
                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="hidden" name="eventid" value="<?php echo $row['event_id'];?>">
                                                <input type="text" class="form-control" name="event_name" value="<?php echo $row['event_name'];?>" required>
                                                <label class="form-label">Event Name</label>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="event_venue" value="<?php echo $row['event_venue'];?>" required>
                                                <label class="form-label">Event Venue</label>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                      <div class="col-sm-12">
                                        <div class="col-sm-12">

                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <textarea cols="30" rows="5" name="event_description" class="form-control no-resize" required><?php echo $row['event_description'];?></textarea>
                                                <label class="form-label">Event Description</label>
                                            </div>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="event_starttime" onchange="cleardata();" class="datetimepicker form-control" name="event_starttime" value="<?php echo $row['start_time'];?>" required placeholder="Please choose start date & time...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="event_endtime" class="datetimepicker1 form-control" name="event_endtime" value="<?php echo $row['end_time'];?>" required placeholder="Please choose end date & time...">
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                      <?php if ($row['status'] != 0): ?>
                                        <div class="col-sm-12">
                                          <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="event_discount" value="<?php echo $row['discount'];?>" min="1">
                                                    <label class="form-label">Membership Discount</label>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                      <?php endif; ?>
                                      <input type="hidden" name="status" value="<?php echo $row['status'];?>">
                                    <center><button class="btn btn-primary waves-effect" type="submit" name="updateeventbtn">UPDATE</button></center>
                                </form>
                                <hr>
                                <div class="row container-fluid">
                                  <center><h3>Change Event Cover</h3></center>
                                  <form action="editevent" method="post" enctype="multipart/form-data">
                                    <div class="col-sm-6">
                                      <input type="file" id="file" name="cover" required>
                                      <input type="hidden" name="eventid" value="<?php echo $_GET['eventid']?>">
                                    </div>
                                    <input type="submit" class="col-sm-6 btn btn-success" name="pic" value="Update Cover Image">
                                  </form>
                                </div>
                                <hr>
                                <br><br>
                                <?php if ($row['status'] != 0): ?>
                                  <div class="table-responsive">
                                      <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                          <thead>
                                              <tr>
                                                  <th class="text-center">Category</th>
                                                  <th class="text-center">Seat</th>
                                                  <th class="text-center">Price</th>
                                                  <th class="text-center">Action</th>
                                              </tr>
                                          </thead>
                                            <tbody>
                                              <?php $sql = $mysqli->query("SELECT * FROM event_ticket_category_map WHERE event_id='$id'");
                                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                                <tr>
                                                  <td class="text-center"><?php echo $row['category'];?></td>
                                                  <td class="text-center"><?php echo $row['seat'];?></td>
                                                  <td class="text-center"><?php echo $row['price'];?></td>
                                                  <td class="text-center"><a href="event_category_process?cid=<?php echo $row['id'];?>&eventid=<?php echo $id;?>"><button type="button" class="btn btn-success" name="button">Edit</button></a></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                      </table>
                                  </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <script src="js/pages/forms/form-validation.js"></script>
    <script src="js/pages/forms/basic-form-elements.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <script type="text/javascript">
      function alertme(){
        var div = document.getElementById('percent');
        if (div.style.display == 'block') {
          div.style.display = 'none';
        } else {
          div.style.display = 'block';
        }
      }
    </script>

    <script type="text/javascript">
      function cleardata(){
        document.getElementById('event_endtime').value = "";
      }
    </script>

    <script type="text/javascript">
    $(document).ready(function(){

    var _URL = window.URL || window.webkitURL;
        $("#file").change(function(e) {

            var image, file;

            // for (var i = this.files.length - 1; i >= 0; i--) {

          file = this.files[0]

              image = new Image();
              var fileType = file["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
                   // invalid file type code goes here.
                   alert('File Format Not Supported, File must be in jpg, jpeg or png Format');
                   $("#file").val('');
              }

                image.src = _URL.createObjectURL(file);


        });
      });
    </script>
</body>

</html>
<?php
}
} else {
  header('location: events');
}
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
 ?>
