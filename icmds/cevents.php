<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
  require 'connection.php';

  if (isset($_POST['remove'])) {
    $eid = $mysqli->real_escape_string($_POST['eid']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $a = array();
    $sql6 = $mysqli->query("SELECT docs FROM ceventdocs WHERE event_id='$eid'");
    while ($r = mysqli_fetch_assoc($sql6)) {
        $a[] = 'db/images/'.$r['docs'];
    }

    $sql1 = "DELETE FROM cevent WHERE event_id='$eid'";
    $sql2 = "DELETE FROM ceventdocs WHERE event_id='$eid'";
    if ($mysqli->query($sql1) && $mysqli->query($sql2)) {
      foreach ($a as $key => $value) {
        unlink($value);
      }
      echo $name.',1';
    } else {
      $mysqli->rollback();
      echo 2;
    }
    exit;
  }

?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Community Events | ICMDS</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

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
            <div class="row">
              <div class="card">

                <div class="header">
                    <h2>
                        All Community Events
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Event ID</th>
                                    <th>E.Name</th>
                                    <th>E.Venue</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <!-- <th>Status</th> -->
                                    <th>Event</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                              <tbody>
                                <?php $sql = $mysqli->query("SELECT * FROM cevent");
                                  while ($row = mysqli_fetch_assoc($sql)) { ?>
                                  <tr>
                                    <td><?php echo $row['event_id'];?></td>
                                    <td><?php echo $row['event_name'];?></td>
                                    <td><?php echo $row['event_venue'];?></td>
                                    <td><?php echo $row['start_time'];?></td>
                                    <td><?php echo $row['end_time'];?></td>
                                    <?php if ($row['active']==1): ?>
                                    <!-- <td class="text-center"><button type="button" onclick="change(<?php echo $row['event_id'];?>);" class="btn btn-success waves-effect" name="button">Active</button></td> -->
                                    <?php else: ?>
                                    <!-- <td class="text-center"><button type="button" onclick="change(<?php echo $row['event_id'];?>);" class="btn btn-danger waves-effect" name="button">Deactive</button></td> -->
                                    <?php endif; ?>
                                    <td> <button type="button" onclick="remove('<?php echo $row['event_name'].','.$row['event_id'];?>');" class="btn btn-danger waves-effect">REMOVE</button> </td>
                                    <td><a href="editcevent?eventid=<?php echo $row['event_id'];?>"><button type="button" class="btn btn-primary waves-effect" name="button">Edit Event</button></a></td>
                                  </tr>
                                  <?php } ?>
                              </tbody>
                        </table>
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

    <!-- Sweet Alert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

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
      function change(eventid){

        var dataString = 'eventid='+ eventid + '&track=cevent';
        // alert(dataString);
        jQuery.ajax({
        url: "db/change.php",
        data: dataString,
        type: "POST",
        success:function(data){
          if (data == 1) {
            swal({
              title: "Success!",
              text: "Community Event is now <span style=\"color: #225bcc\">Activated</span>",
              type: "success",
              html: true,
              confirmButtonColor: "#686fed",
              confirmButtonText: "CLOSE",
              closeOnConfirm: false,
            },function(){
              swal.close();
              var delay = 150;
              setTimeout(function(){ window.location = "cevents"; }, delay);
            });
          } else if (data == 2) {
            swal({
              title: "Success!",
              text: "Community Event is now <span style=\"color: #dd1828\">Deactivated</span>",
              type: "success",
              html: true,
              confirmButtonColor: "#686fed",
              confirmButtonText: "CLOSE",
              closeOnConfirm: false,
            },function(){
              swal.close();
              var delay = 150;
              setTimeout(function(){ window.location = "cevents"; }, delay);
            });
          } else {
            swal({
              title: "Failed!",
              text: "Something Went Wrong, Try Again!",
              type: "error",
              confirmButtonColor: "#686fed",
              confirmButtonText: "CLOSE",
              closeOnConfirm: false,
            },function(){
              swal.close();
              var delay = 150;
              setTimeout(function(){ window.location = "cevents"; }, delay);
            });
          }
          // var n = data.length;
          // if (n==2) {
          //     var totalval = total.substring(12);
          //     final = (parseFloat(totalval,10) - (parseFloat(totalval,10)*parseFloat(data,10)/100)).toFixed(2);
          //     document.getElementById('disc').innerHTML = "Membership discount: "+data+"%";
          //     document.getElementById('final').innerHTML = "Final Fare $"+final;
          // } else {
          //   alert(data);
          // }
        }
        });
      }
    </script>


    <script type="text/javascript">
      function remove(f){
        var a = f.split(",");
        swal({
            title: "<strong>All Data Will be Erased!</strong>",
            text: "<span style=\"color: #dd1828\">All Data of <span style=\"color: #225bcc\">"+a[0]+"</span> Community Event will be erased, Including all files of this Community Event. Are You Sure To Remove <span style=\"color: #225bcc\">"+a[0]+"</span> Community Event ?</span>",
            type: "info",
            html: true,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#dd1828",
            confirmButtonText: "REMOVE EVERYTHING",
            cancelButtonText: "NOT NOW",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                var dataString = 'eid='+ a[1] + '&remove=1&name='+ a[0];
                jQuery.ajax({
                  url: "cevents.php",
                  data: dataString,
                  type: "POST",
                  success:function(data){
                    setTimeout(function () {
                        var r = data.split(",");
                        if (r[1] == 1) {
                          swal({
                            title: "Removed!",
                            text: "All Record of <span style=\"color: #225bcc\">"+r[0]+"</span> Community Event has been Removed Successfully!",
                            type: "success",
                            html: true,
                            confirmButtonColor: "#686fed",
                            confirmButtonText: "CLOSE",
                            closeOnConfirm: false,
                          },function(){
                            swal.close();
                            var delay = 150;
                            setTimeout(function(){ window.location = "cevents"; }, delay);
                          });
                        } else {
                          swal({
                            title: "Failed!",
                            text: "Something Went Wrong, Try Again!",
                            type: "error",
                            confirmButtonColor: "#686fed",
                            confirmButtonText: "CLOSE",
                            closeOnConfirm: false,
                          },function(){
                            swal.close();
                            var delay = 150;
                            setTimeout(function(){ window.location = "cevents"; }, delay);
                          });
                        }
                    }, 1500);
                  },
                  error:function (data){
                      setTimeout(function () {
                          swal(data);
                      }, 1500);
                  }
                });
            } else {
                swal.close();
            }
        });
      }
    </script>
</body>

</html>
<?php
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
?>
