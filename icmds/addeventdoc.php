<?php
session_start();
if (isset($_SESSION['icmds_login'])) {

require 'connection.php';
if (isset($_GET['eventid']) || isset($_POST['adddocbtn'])) {

  if (isset($_GET['eventid'])) {
    $eventid = $mysqli->real_escape_string($_GET['eventid']);
    $qry = $mysqli->query("SELECT * FROM event WHERE event_id='$eventid'");
    if ($qry->num_rows == 0) {
      echo '<script language="javascript">';
      echo 'alert("Data Not Found");';
      echo 'window.location.href = "events"';
      echo '</script>';
    }
    $row = $qry->fetch_assoc();

    $starttime = $row['start_time'];
    $result = explode(" ", $starttime, 6);
    $date = $result[1];$month = $result[2];$year = $result[3];
    $check = strtotime($date.' '.$month.' '.$year);
    $current = strtotime(date("Y-m-d H:i", strtotime($date . "-5 hours")));
    if ($check>$current) {
      echo '<script type="text/javascript">';
      echo 'alert("You Can\'t add documents to a Upcoming Event");';
      echo 'window.location.href="events";';
      echo '</script>';
    }

  }


  if (isset($_POST['adddocbtn'])) {
    $eventid = $mysqli->real_escape_string($_POST['eventid']);
    $qry = $mysqli->query("SELECT id FROM event WHERE event_id='$eventid'");
    if ($qry->num_rows == 0) {
      echo '<script language="javascript">';
      echo 'alert("Data Not Found");';
      echo 'window.location.href = "events"';
      echo '</script>';
    }
    $UploadFolder = "db/images";
    $counter = 0;
    $size = sizeof($_FILES["files"]["tmp_name"]);
    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
      $temp = $_FILES["files"]["tmp_name"][$key];
      $name = $_FILES["files"]["name"][$key];
      $temp1 = explode(".", $name);

      if(empty($temp)) {break;}

      $counter++;
      $newfilename = round(microtime(true)) . $counter . '.' . end($temp1);
      if (move_uploaded_file($temp, $UploadFolder."/" . $newfilename)) {
        $size--;
        $mysqli->query("INSERT INTO eventdocs(event_id,docs) VALUES ('$eventid','$newfilename');");
      }
    }

  if ($size==0) {

    echo '<script language="javascript">';
    echo 'alert("Events Images Uploaded");';
    echo 'window.location.href = "addeventdoc?eventid='.$eventid.'"';
    echo '</script>';
  }
  }

?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Add Event Docs | ICMDS</title>
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

    <!-- Light Gallery Plugin Css -->
    <link href="plugins/light-gallery/css/lightgallery.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
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
          <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="card">
                      <div class="header">
                          <h2>
                              GALLERY
                          </h2>
                      </div>
                      <div class="body">
                          <div class="col-sm-12">
                            <form action="addeventdoc" method="POST" enctype="multipart/form-data">
                              <input type="file" class="col-sm-6" id="file" name="files[]" required multiple>
                              <input type="hidden" name="eventid" value="<?php echo $eventid;?>">
                              <input type="submit" name="adddocbtn" class="btn btn-success col-sm-6" value="Add To Gallery">
                            </form>
                          </div>
                          <center><h3>All Documents</h3></center>
                          <hr>
                          <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            <?php $sql = $mysqli->query("SELECT id, docs FROM eventdocs WHERE event_id='$eventid'");
                            while ($row = mysqli_fetch_assoc($sql)) {
                            ?>
                              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                  <a href="db/images/<?php echo $row['docs'];?>" data-sub-html="File Name: <?php echo $row['docs'];?>">
                                      <img class="img-responsive thumbnail" src="db/images/<?php echo $row['docs'];?>">
                                  </a>
                              <center><button type="button" class="btn btn-danger" onclick="remove('<?php echo $row['id'];?>','<?php echo $row['docs'];?>')" name="button">Remove</button></center>
                              </div>
                              <?php } ?>
                          </div>
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

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Light Gallery Plugin Js -->
    <script src="plugins/light-gallery/js/lightgallery-all.js"></script>

    <!-- Custom Js -->
    <script src="js/pages/medias/image-gallery.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <script type="text/javascript">

    $(document).ready(function(){

    var _URL = window.URL || window.webkitURL;
        $("#file").change(function(e) {

            var image, file;

            for (var i = this.files.length - 1; i >= 0; i--) {

          if ((file = this.files[i])) {

              image = new Image();
              var fileType = file["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
                   // invalid file type code goes here.
                   alert('File Format Not Supported, File must be in jpg, jpeg or png Format');
                   $("#file").val('');
              }
                image.onload = function() {

                  var h = this.height;
                  var w = this.width;
                    if(h>w){
                      alert("Please Choose a Horizontal Image");
                      $("#file").val('');
                    } else {
                      if (l==1) {
                        alert('You can also select multiple files at once');
                      }
                    }
                };

                image.src = _URL.createObjectURL(file);
            }
            }

        });
      });
    </script>

    <script type="text/javascript">
      function remove(f,t){
        var v = confirm('Confirm Remove ?');
        if (v == true) {
          var eventid = <?php echo $eventid;?>;
          var e = "event";
          var dataString = 'fileid='+ f + '&eventid='+ eventid + '&name='+ t + '&backlink='+ e;
          jQuery.ajax({
            url: "db/removefile.php",
            data: dataString,
            type: "POST",
            success:function(data){
                alert(data);
                window.location.href="addeventdoc?eventid="+eventid;
            },
            error:function (data){
                alert(data);
                window.location.href="addeventdoc?eventid="+eventid;
            }
          });
        }

      }
    </script>
</body>

</html>
<?php
} else {
  header('location: events');
}
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
?>
