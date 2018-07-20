<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
  if ($_SESSION['logged_tag'] == "sub_admin") {
    header('location: index');
  }
  require 'connection.php';

  if (isset($_GET['uid'])) {
    $uid = $mysqli->real_escape_string($_GET['uid']);
    $qry = $mysqli->query("SELECT * FROM users WHERE user_id='$uid'");
    if ($qry->num_rows == 0) {
      header('location: members');
    } else {
      $res = $qry->fetch_assoc();
    }
  }


  if (isset($_POST['ajax'])) {
    $mid = $mysqli->real_escape_string($_POST['mid']);
    $userid = $mysqli->real_escape_string($_POST['userid']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $level = $mysqli->real_escape_string($_POST['level']);
    $starttime = $mysqli->real_escape_string($_POST['start_date']);

    $check = $mysqli->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
      echo 1;
    } else {
      $mysqli->autocommit(FALSE);
      $mysqli->commit();
      $endtime = '31-12-'.date('Y');
      $insert = "INSERT INTO users VALUES (NULL,'$userid','$name','$email','$phone','')";
      $insert1 = "INSERT INTO member VALUES (NULL,'$userid','$mid','$level','$starttime','$endtime')";
      if ($mysqli->query($insert) && $mysqli->query($insert1)) {
        echo $email.','.$userid.','.$level.','.$endtime.','.$mid.',2';
      } else {
        $mysqli->rollback();
        echo 3;
      }
    }
    $mysqli->commit();
    $mysqli->autocommit(TRUE);
    exit;
  }

  if (isset($_POST['ajaxadd'])) {
    $mid = $mysqli->real_escape_string($_POST['mid']);
    $userid = $mysqli->real_escape_string($_POST['userid']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $level = $mysqli->real_escape_string($_POST['level']);
    $starttime = $mysqli->real_escape_string($_POST['start_date']);
    $endtime = '31-12-'.date('Y');

    if ($mysqli->query("INSERT INTO member VALUES(NULL,'$userid','$mid','$level','$starttime','$endtime')")) {
      echo $email.','.$userid.','.$level.','.$endtime.','.$mid.',4';
    } else {
      echo 7;
    }
    exit;
  }

  if (isset($_POST['send'])) {
    $mid = $mysqli->real_escape_string($_POST['mid']);
    $userid = $mysqli->real_escape_string($_POST['userid']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $level = $mysqli->real_escape_string($_POST['level']);
    $endtime = $mysqli->real_escape_string($_POST['endtime']);
    echo 5;
    require 'db/mail_config.php';
    $mail->AddAddress ($email);
    $mail->Subject = "Your Membership Details";
    $mail->Body = "
        Hello, <br><br>
        Welcome to ICMDS.<br>Your Unique UserID is $userid. And Membership number is $mid, Membership Plan is $level, Valid till $endtime.<br><br>

        Kind regards,<br>
        ICMDS
    ";
    if ($mail->send()) {
        echo 5;
    } else {
        echo 6;
    }
    exit;
  }


  // Process Of Creating Unique USER ID
  $sql1 = $mysqli->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
  $row = $sql1->fetch_assoc();
  $pastid = $row['user_id'];

  $old = substr($pastid,0,8);$current = date('Ymd');

  if($old == $current){ $finalid = $pastid+1; } else { $finalid = $current."0001"; }
 // END Process Of Creating Unique USER ID

 // Process Of Creating User Membership ID
   $sql2 = $mysqli->query("SELECT membership_id FROM member ORDER BY membership_id DESC LIMIT 1");
   $row2 = $sql2->fetch_assoc();
   $pastid2 = $row2['membership_id'];

   $old2 = substr($pastid2,0,8); $current2 = date('Ymd');

   if($old2 == $current2){ $finalid2 = $pastid2+1; } else { $finalid2 = $current2."001"; }
 // END Process Of Creating User Membership ID

?>
﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php if (isset($_GET['uid'])): ?>
      <title>Add Membership | ICMDS</title>
    <?php else: ?>
      <title>Add Members | ICMDS</title>
    <?php endif; ?>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="css/loader.css">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />

    <style media="screen">
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        }
      input[type="number"] { -moz-appearance: textfield; }
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
                    <li class="active">
                        <a href="members">
                            <i class="material-icons">group</i>
                            <span>Members</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li>
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
              <div class="card">

                <div class="header">
                    <h2>
                      <?php if (isset($_GET['uid'])): ?>
                        Add New Membership
                      <?php else: ?>
                        Add New Member
                      <?php endif; ?>
                    </h2>
                </div>
                <div class="body">
                    <div class="h3 row text-center">
                      <?php if (isset($_GET['uid'])): ?>
                        User Database
                      <?php else: ?>
                        New Membership
                      <?php endif; ?>
                    </div>
                    <form id="addmem" action="addmember" method="POST">
                      <fieldset>
                        <?php if (!isset($_GET['uid'])): ?>
                          <input type="hidden" name="userid" value="<?php echo $finalid;?>">
                        <?php else: ?>
                          <input type="hidden" name="userid" value="<?php echo $res['user_id'];?>">
                        <?php endif; ?>
                        <input type="hidden" name="mid" value="<?php echo $finalid2;?>">
                      <div class="body">

                        <div class="row">
                         <div class="col-sm-4">
                         <div class="input-group form-float">
                          <label for="name" class="form-label" >Name *:</label>
                            <div class="form-line">
                              <?php if (isset($_GET['uid'])): ?>
                                <input type="text" class="form-control" name="name" readonly value="<?php echo $res['name'];?>">
                              <?php else: ?>
                                <input type="text" class="form-control" name="name" required>
                              <?php endif; ?>
                            </div>
                         </div>
                         </div>
                         <div class="col-sm-4">
                         <div class="input-group form-float">
                          <label for="email" class="form-label" >Email *:</label>
                            <div class="form-line">
                              <?php if (isset($_GET['uid'])): ?>
                                <input type="email" class="form-control" name="email" readonly value="<?php echo $res['email'];?>">
                              <?php else: ?>
                                <input type="email" class="form-control" name="email" required>
                              <?php endif; ?>
                            </div>
                         </div>
                         </div>
                         <div class="col-sm-4">
                         <div class="input-group form-float">
                          <label for="phone" class="form-label" >Contact :</label>
                            <div class="form-line">
                              <?php if (isset($_GET['uid'])): ?>
                                <input type="number" class="form-control" min="0" maxlength="10" minlength="10" name="phone" readonly value="<?php echo $res['phone'];?>">
                              <?php else: ?>
                                <input type="number" class="form-control" min="0" maxlength="10" minlength="10" name="phone">
                              <?php endif; ?>
                            </div>
                         </div>
                         </div>
                        </div>
                        <div class="row text-center h3">
                          Membership Details
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group form-float">
                                 <label for="category" class="form-label" >Membership Package :</label>
                                 <select class="form-control" name="level">
                                   <option>Patron Family Members</option>
                                   <option>Extended Family membership</option>
                                   <option>Full-Society Family Members</option>
                                   <option>Senior Family Members</option>
                                   <option>Patron Individual Members</option>
                                   <option>Individual Members</option>
                                   <option>Student / Senior Citizen</option>
                                   <option>Premier Membership</option>
                                 </select>
                             </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="form-label" >Start Date *:</label>
                                  <div class='form-line input-group date' id='start_date'>
                                   <input type='text' class="form-control" required name="start_date"/>
                                   <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                   </span>
                                 </div>
                               </div>
                          </div>
                        </div>

                        <div class="row text-center">
                          <?php if (isset($_GET['uid'])): ?>
                            <input type="hidden" name="ajaxadd" value="1">
                            <input type="hidden" name="email" value="<?php echo $res['email'];?>">
                            <button type="submit" name="button" id="submitbtn" class="btn btn-success waves-effect">ADD MEMBERSHIP</button>
                          <?php else: ?>
                            <input type="hidden" name="ajax" value="1">
                            <button type="submit" name="button" id="submitbtn" class="btn btn-success waves-effect">ADD MEMBER</button>
                          <?php endif; ?>
                        </div>
                      </div>
                     </fieldset>
                    </form>
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

    <!-- SweetAlert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- Moment Plugin Js -->
    <script src="plugins/momentjs/moment.js"></script>

    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap-datetimepicker -->
    <script src="vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


    <!-- Custom Js -->
    <script src="js/admin.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <script type="text/javascript">
    $(function () {
      $('#addmem').validate({
          highlight: function (input) {
              $(input).parents('.form-line').addClass('error');
          },
          unhighlight: function (input) {
              $(input).parents('.form-line').removeClass('error');
          },
          errorPlacement: function (error, element) {
              $(element).parents('.input-group').append(error);
              $(element).parents('.form-group').append(error);
          }
      });
    });
    </script>

    <script type="text/javascript">
         $('#start_date').datetimepicker({
           format: 'DD-MM-YYYY'
         });
    </script>


    <script type='text/javascript'>
        $("#addmem").submit(function(event) {
          event.preventDefault();
          var formEl = $(this);
          if(formEl.valid()){
            $('#submitbtn').prop('disabled', true);
            $.ajax({
              type: 'POST',
              url: formEl.prop('action'),
              data: formEl.serialize()
            }).done(function(data) {
              var s = data.split(',');
              if (data == 1) {
                swal({
                  title: "User Found",
                  text: "<span style=\"color: #dd1828\">User Already Exists with This Email</span>",
                  type: "error",
                  html: true,
                  confirmButtonColor: "#686fed",
                  confirmButtonText: "CLOSE",
                }, function(){
                  $('#submitbtn').prop('disabled', false);
                });
              } else if (s[5] == 2) {
                swal({
                  title: "SUCCESS!",
                  text: "<span style=\"color: #225bcc\">User has been Created And Membership is Active Now</span>",
                  type: "success",
                  confirmButtonColor: "#686fed",
                  html: true,
                  confirmButtonText: "SEND CONFIRMATION",
                  showLoaderOnConfirm: true,
                  closeOnConfirm: false,
                },function(){
                  var dataString = 'email=' + s[0] + '&userid=' + s[1] + '&level=' + s[2] + '&endtime=' + s[3] + '&mid=' + s[4] + '&send=1';
                  jQuery.ajax({
                    url: "addmember.php",
                    data: dataString,
                    type: "POST",
                    success:function(data){
                          if (data == 5 ||data == 55) {
                            swal({
                              title: "Done!",
                              text: "<span style=\"color: #2c35e8\">Welcome Mail with Membership ID has Been Sent</span>.",
                              imageUrl: "images/thumbs-up.png",
                              html:true,
                              allowEscapeKey: false,
                              confirmButtonColor: "#686fed",
                              confirmButtonText: "CLOSE",
                              closeOnConfirm: false,
                            },function(){
                              swal.close();
                              var delay = 150;
                              setTimeout(function(){ window.location = "members"; }, delay);
                            });
                          } else {
                            swal({
                              title: "Failed!",
                              text: "<span style=\"color: #CC0000\">Failed To Send Welcome Mail</span>.",
                              type: "error",
                              html:true,
                              allowEscapeKey: false,
                              confirmButtonColor: "#CC0000",
                              confirmButtonText: "CLOSE",
                              closeOnConfirm: false,
                            },function(){
                              swal.close();
                              var delay = 150;
                              setTimeout(function(){ window.location = "members"; }, delay);
                            });
                          }
                    },
                    error:function (data){
                        setTimeout(function () {
                            swal(data);
                        }, 1500);
                    }
                  });
                });

              } else if (s[5] == 4) {
                swal({
                  title: "SUCCESS!",
                  text: "<span style=\"color: #225bcc\">Membership of This User is Active Now</span>",
                  type: "success",
                  allowEscapeKey: false,
                  confirmButtonColor: "#686fed",
                  confirmButtonText: "SEND CONFIRMATION",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                  html: true
                },function(){
                  var dataString = 'email=' + s[0] + '&userid=' + s[1] + '&level=' + s[2] + '&endtime=' + s[3] + '&mid=' + s[4] + '&send=1';
                  jQuery.ajax({
                    url: "addmember.php",
                    data: dataString,
                    type: "POST",
                    success:function(data){
                          if (data == 5 || data == 55) {
                            swal({
                              title: "Done!",
                              text: "<span style=\"color: #2c35e8\">Welcome Mail with Membership ID has Been Sent</span>.",
                              imageUrl: "images/thumbs-up.png",
                              html:true,
                              allowEscapeKey: false,
                              confirmButtonColor: "#686fed",
                              confirmButtonText: "CLOSE",
                              closeOnConfirm: false,
                            },function(){
                              swal.close();
                              var delay = 150;
                              setTimeout(function(){ window.location = "members"; }, delay);
                            });
                          } else {
                            swal({
                              title: "Failed!",
                              text: "<span style=\"color: #CC0000\">Failed To Send Welcome Mail</span>.",
                              type: "error",
                              html:true,
                              allowEscapeKey: false,
                              confirmButtonColor: "#CC0000",
                              confirmButtonText: "CLOSE",
                              closeOnConfirm: false,
                            },function(){
                              swal.close();
                              var delay = 150;
                              setTimeout(function(){ window.location = "members"; }, delay);
                            });
                          }
                    },
                    error:function (data){
                        setTimeout(function () {
                            swal(data);
                        }, 1500);
                    }
                  });
                });

              } else {
                swal({
                  title: "Opps!",
                  text: "<span style=\"color: #dd1828\">Something Went Wrong, Try Again</span>",
                  type: "error",
                  html: true,
                  confirmButtonColor: "#686fed",
                  confirmButtonText: "CLOSE",
                  closeOnConfirm: false,
                },function(){
                  swal.close();
                  var delay = 150;
                  setTimeout(function(){ window.location = "members"; }, delay);
                });
              }
            });
          } else {
            return false;
          }
        });
    </script>

</body>

</html>
<?php
} else {
  $_SESSION['icmds_message'] = "Login First To Access That Page";
  header('location: login');
}
?>
