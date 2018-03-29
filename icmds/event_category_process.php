<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
require 'connection.php';
if (isset($_POST['addeventbtn']) || isset($_POST['btneventcategory']) || (isset($_GET['cid']) && isset($_GET['eventid'])) || isset($_POST['updatecategory'])) {

  if (isset($_POST['addeventbtn'])) {
    $_SESSION['count']=1;
    $_SESSION['event_id'] = $event_id= $mysqli->real_escape_string($_POST['finalid']);
    $event_name= $mysqli->real_escape_string($_POST['event_name']);
    $event_venue= $mysqli->real_escape_string($_POST['event_venue']);
    $event_description= $mysqli->real_escape_string($_POST['event_description']);
    $starttime= $mysqli->real_escape_string($_POST['event_starttime']);
    $endtime= $mysqli->real_escape_string($_POST['event_endtime']);
    $_SESSION['event_category']= $mysqli->real_escape_string($_POST['event_category']);
    if (isset($_POST['event_discount'])) {$discount= $mysqli->real_escape_string($_POST['event_discount']);}else{ $discount="";}
    $result = explode(" ", $starttime, 6);
    $date = $result[1];
    $month = $result[2];
    $year = $result[3];

    $mysqli->query("INSERT INTO event (event_id,event_name,event_description,event_venue,start_time,end_time,day,month,year,discount) VALUES ('$event_id','$event_name','$event_description','$event_venue','$starttime','$endtime','$date','$month','$year','$discount')");

  }
  if (isset($_POST['btneventcategory'])) {
    $_SESSION['count'] = $_SESSION['count']+1;
    $_SESSION['event_category'] = $_SESSION['event_category']-1;
    if ($_SESSION['event_category']==0) {
      $event_id = $_SESSION['event_id'];
      $category_name= $mysqli->real_escape_string($_POST['category_name']);
      $event_seat= $mysqli->real_escape_string($_POST['event_seat']);
      $event_fare= $mysqli->real_escape_string($_POST['event_fare']);
      $mysqli->query("INSERT INTO event_ticket_category_map (event_id,Category,seat,price) VALUES ('$event_id','$category_name','$event_seat','$event_fare')");
      echo '<script type="text/javascript">';
      echo 'alert("Event Categories Created");';
      echo 'window.location.href="addevent"';
      echo '</script>';
    } else {
      $event_id = $_SESSION['event_id'];
      $category_name= $mysqli->real_escape_string($_POST['category_name']);
      $event_seat= $mysqli->real_escape_string($_POST['event_seat']);
      $event_fare= $mysqli->real_escape_string($_POST['event_fare']);
      $mysqli->query("INSERT INTO event_ticket_category_map (event_id,Category,seat,price) VALUES ('$event_id','$category_name','$event_seat','$event_fare')");

    }
  }

  if (isset($_POST['updatecategory'])) {
      $name = $mysqli->real_escape_string($_POST['category_name']);
      $seat = $mysqli->real_escape_string($_POST['event_seat']);
      $fare = $mysqli->real_escape_string($_POST['event_fare']);
      $eventid = $mysqli->real_escape_string($_POST['eventid']);
      $id = $mysqli->real_escape_string($_POST['cid']);

      $updatesql = "UPDATE event_ticket_category_map SET category='$name', seat='$seat', price='$fare' WHERE id='$id' AND event_id='$eventid'";
      if ($mysqli->query($updatesql)) {
        echo '<script type="text/javascript">';
        echo 'alert("Event Category Updated Successfully");';
        echo 'window.location.href="editevent?eventid='.$eventid.'"';
        echo '</script>';
      } else {
        echo '<script type="text/javascript">';
        echo 'alert("Failed To Update, Try Again");';
        echo 'window.location.href="editevent?eventid='.$eventid.'"';
        echo '</script>';
      }
  }

  if (isset($_GET['cid']) && isset($_GET['eventid'])) {
    $eventid = $mysqli->real_escape_string($_GET['eventid']);
    $cid = $mysqli->real_escape_string($_GET['cid']);
    $sql = $mysqli->query("SELECT * FROM event_ticket_category_map WHERE event_id='$eventid' AND id='$cid'");
    if ($sql->num_rows == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Data Mismatch");';
        echo 'window.location.href="events";';
        echo '</script>';
    }

    $sql1 = $mysqli->query("SELECT * FROM event WHERE event_id='$eventid'");
    $row = $sql1->fetch_assoc();

    $starttime = $row['start_time'];
    $result = explode(" ", $starttime, 6);
    $date = $result[1];$month = $result[2];$year = $result[3];
    $check = strtotime($date.' '.$month.' '.$year);
    $current = strtotime(date('d F Y'));
    if ($check<=$current) {
      echo '<script type="text/javascript">';
      echo 'alert("You Can\'t Edit a Past Event");';
      echo 'window.location.href="events";';
      echo '</script>';
    }
  }

?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Event Category Selection | ICMDS</title>
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
                                <h2>Update Event Categories</h2>
                            </div>
                            <div class="body">
                                <form id="form_validation" method="POST" action="event_category_process">
                                  <?php if (!isset($_GET['cid'])): ?>
                                    <center>
                                      <h3>Category <?php echo $_SESSION['count'];?><br><br></h3>
                                    </center>
                                  <?php else:
                                    $eveid=$_GET['eventid'];
                                    $cid=$_GET['cid'];
                                    $sql = $mysqli->query("SELECT e.event_name, etcm.* FROM event e INNER JOIN event_ticket_category_map etcm ON e.event_id=etcm.event_id AND (e.event_id='$eveid' AND etcm.id='$cid')");
                                    $res = $sql->fetch_assoc();
                                    ?>

                                    <center>
                                      <h3>Modify Event <?php echo $res['event_name'];?><br><br></h3>
                                    </center>
                                  <?php endif; ?>

                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                              <?php if (!isset($_GET['cid'])): ?>
                                                <input type="text" class="form-control" name="category_name" required>
                                              <?php else: ?>
                                                <input type="text" class="form-control" name="category_name" value="<?php echo $res['category'];?>" required>
                                              <?php endif; ?>
                                                <label class="form-label">Category Name</label>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                              <?php if (!isset($_GET['cid'])): ?>
                                                <input type="number" class="form-control" name="event_seat" min="1" required>
                                              <?php else: ?>
                                                <input type="hidden" name="eventid" value="<?php echo $eveid;?>">
                                                <input type="hidden" name="cid" value="<?php echo $cid;?>">
                                                <input type="number" class="form-control" name="event_seat" value="<?php echo $res['seat'];?>" min="<?php echo $res['seat'];?>" required>
                                              <?php endif; ?>
                                                <label class="form-label">Total No Of Seats</label>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                      <div class="col-sm-12">
                                        <div class="col-sm-12">
                                        <center>
                                          <div class="form-group form-float">
                                              <div class="form-line">
                                                <?php if (!isset($_GET['cid'])): ?>
                                                  <input type="number" class="form-control" name="event_fare" min="1" required>
                                                <?php else: ?>
                                                  <input type="number" class="form-control" name="event_fare" value="<?php echo $res['price'];?>" min="1" required>
                                                <?php endif; ?>
                                                  <label class="form-label">Fare</label>
                                              </div>
                                          </div>
                                        </center>
                                      </div>
                                      </div>
                                      <?php if (!isset($_GET['cid'])): ?>
                                          <center><button class="btn btn-primary waves-effect" type="submit" name="btneventcategory">SUBMIT</button></center>
                                      <?php else: ?>
                                          <center><button class="btn btn-primary waves-effect" type="submit" name="updatecategory">UPDATE</button>
                                            <button type="button" name="button" onclick="history.go(-1)" class="btn btn-success">Go Back</button>
                                          </center>
                                      <?php endif; ?>
                                </form>
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

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>
    <script src="js/pages/forms/basic-form-elements.js"></script>

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

</body>

</html>
<?php
} else {
  header('location: addevent');
}
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
?>
