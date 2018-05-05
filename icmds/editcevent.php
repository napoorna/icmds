<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
require_once 'connection.php';

if (isset($_GET['eventid']) || (isset($_POST['updateeventbtn']) && isset($_POST['eventid'])) || isset($_POST['addcdocbtn']) || (isset($_POST['pic']) && isset($_POST['eventid']))) {

  if (isset($_POST['pic']) && isset($_POST['eventid'])) {
    $eventid = $mysqli->real_escape_string($_POST['eventid']);
    $UploadFolder = "db/images";
      $temp = $_FILES["cover"]["tmp_name"];
      $name = $_FILES["cover"]["name"];
      $temp1 = explode(".", $name);
      $newfilename = round(microtime(true)) . '.' . end($temp1);
      if (move_uploaded_file($temp, $UploadFolder."/" . $newfilename)) {
        $insertqry = "UPDATE cevent SET cover='$newfilename' WHERE event_id='$eventid'";
        if ($mysqli->query($insertqry)) {
          echo '<script language="javascript">';
          echo 'alert("Community Event Cover Updated");';
          echo 'window.location.href = "editcevent?eventid='.$eventid.'"';
          echo '</script>';
        } else {
          echo '<script language="javascript">';
          echo 'alert("Failed To Update Community Event Cover! Try Again");';
          echo 'window.location.href = "editcevent?eventid='.$eventid.'"';
          echo '</script>';
        }

      }
  }

  if (isset($_POST['addcdocbtn'])) {
    $eventid = $mysqli->real_escape_string($_POST['eventid']);
    $qry = $mysqli->query("SELECT id FROM cevent WHERE event_id='$eventid'");
    if ($qry->num_rows == 0) {
      echo '<script language="javascript">';
      echo 'alert("Data Not Found");';
      echo 'window.location.href = "cevents"';
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
        $mysqli->query("INSERT INTO ceventdocs(event_id,docs) VALUES ('$eventid','$newfilename');");
      }
    }

  if ($size==0) {

    echo '<script language="javascript">';
    echo 'alert("Events Images Uploaded");';
    echo 'window.location.href = "editcevent?eventid='.$eventid.'"';
    echo '</script>';
  }
  }


  if (isset($_POST['updateeventbtn']) && isset($_POST['eventid'])) {

    $event_id= $mysqli->real_escape_string($_POST['eventid']);
    $event_name= $mysqli->real_escape_string($_POST['event_name']);
    $event_venue= $mysqli->real_escape_string($_POST['event_venue']);
    $event_description= $mysqli->real_escape_string($_POST['event_description']);
    $starttime= $mysqli->real_escape_string($_POST['event_starttime']);
    $endtime= $mysqli->real_escape_string($_POST['event_endtime']);

    $updatesql = "UPDATE cevent SET event_name = '$event_name', event_description = '$event_description', event_venue = '$event_venue', start_time = '$starttime', end_time = '$endtime' WHERE event_id = '$event_id'";
    if ($mysqli->query($updatesql)) {
      echo '<script type="text/javascript">';
      echo 'alert("Community Event Details Updated Successfully");';
      echo 'window.location.href="cevents"';
      echo '</script>';
    } else {
      echo '<script type="text/javascript">';
      echo 'alert("Failed To Update Community Event Details, Try Again");';
      echo 'window.location.href="cevents"';
      echo '</script>';
    }

  }

  if (isset($_GET['eventid'])) {
  $eventid = $mysqli->real_escape_string($_GET['eventid']);
  $sql = $mysqli->query("SELECT * FROM cevent WHERE event_id='$eventid'");
  if ($sql->num_rows == 0) {
      echo '<script type="text/javascript">';
      echo 'alert("Event Not Found");';
      echo 'window.location.href="cevents";';
      echo '</script>';
  }
  $row = $sql->fetch_assoc();
?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Edit Community Event | ICMDS</title>
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
                          <li class="active">
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
                                <form id="form_validation" method="POST" action="editcevent">
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
                                    <center><button class="btn btn-primary waves-effect" type="submit" name="updateeventbtn">UPDATE</button></center>
                                </form>
                                <hr>
                                <div class="row container-fluid">
                                  <center><h4>Change Community Event Cover</h4></center>
                                  <form action="editcevent" method="post" enctype="multipart/form-data">
                                    <div class="col-sm-6">
                                      <input type="file" id="f" name="cover" required>
                                      <input type="hidden" name="eventid" value="<?php echo $_GET['eventid']?>">
                                    </div>
                                    <input type="submit" class="col-sm-6 btn btn-success" name="pic" value="Update Cover Image">
                                  </form>
                                </div>
                                <hr>
                                <br><br>
                            </div>
                            <div class="header">
                                <center><h3>GALLERY</h3></center>
                            </div>
                            <div class="body">
                                <div class="col-sm-12">
                                  <form action="editcevent" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="col-sm-6" id="file" name="files[]" required multiple>
                                    <input type="hidden" name="eventid" value="<?php echo $eventid;?>">
                                    <input type="submit" name="addcdocbtn" class="btn btn-success col-sm-6" value="Add To Gallery">
                                  </form>
                                </div>
                                <center><h3>All Documents</h3></center>
                                <hr>
                                <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                  <?php $sql = $mysqli->query("SELECT id, docs FROM ceventdocs WHERE event_id='$eventid'");
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

            var l = this.files.length;
            if (l>20) {
              alert('You can\'t choose more than 20 files at a time');
              $("#file").val('');
            }

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
    $(document).ready(function(){

    var _URL = window.URL || window.webkitURL;
        $("#f").change(function(e) {

            var image, file;

            // for (var i = this.files.length - 1; i >= 0; i--) {

          file = this.files[0]

              image = new Image();
              var fileType = file["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
                   // invalid file type code goes here.
                   alert('File Format Not Supported, File must be in jpg, jpeg or png Format');
                   $("#f").val('');
              }

                image.src = _URL.createObjectURL(file);


        });
      });
    </script>


    <script type="text/javascript">
      function remove(f,t){
        var v = confirm('Confirm Remove ?');
        if (v == true) {
          var eventid = <?php echo $eventid;?>;
          var e = "cevent";
          var dataString = 'fileid='+ f + '&eventid='+ eventid + '&name='+ t + '&backlink='+ e;
          jQuery.ajax({
            url: "db/removefile.php",
            data: dataString,
            type: "POST",
            success:function(data){
                alert(data);
                window.location.href="editcevent?eventid="+eventid;
            },
            error:function (data){
                alert(data);
                window.location.href="editcevent?eventid="+eventid;
            }
          });
        }

      }
    </script>
</body>

</html>
<?php
}
} else {
  header('location: cevents');
}
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
 ?>
