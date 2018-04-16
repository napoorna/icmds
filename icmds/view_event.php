<?php
session_start();
if (isset($_SESSION['icmds_login'])) {
require 'connection.php';
if (isset($_GET['eventid'])) {

  $eventid = $mysqli->real_escape_string($_GET['eventid']);
  $res = $mysqli->query("SELECT * FROM event WHERE event_id='$eventid'");
  if ($res->num_rows == 0) {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid User Data");';
    echo 'window.location.href="members"';
    echo '</script>';
  }
  $row = $res->fetch_assoc();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>View Event | ICMDS</title>
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

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
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
              <div class="card">
                <div class="body" style="padding:3%;">
                  <div class="row text-center">
                    <img src="db/images/<?php echo $row['cover'];?>" height="150px" alt="No Image">
                  </div>
                  <center><h3>Event Details</h3></center><br><br>
                  <form>
                    <div>
                    <div class="col-sm-6">
                      <label>Event ID</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['event_id']?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Event Name</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['event_name']?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Event Start Time</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['start_time']?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Event End Time</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['end_time']?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Event Venue</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['event_venue']?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Membership Discount</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php echo $row['discount']?>">
                          </div>
                      </div>
                    </div>
                    <?php $sql1 = $mysqli->query("SELECT SUM(seat) AS seat, SUM(price) AS total FROM ticket_category_map WHERE event_id='$eventid'"); $res1 = $sql1->fetch_assoc();?>
                    <div class="col-sm-6">
                      <label>Total Amount of Ticket Sold</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php if($res1['total']==""){echo "0";}else{echo $res1['total'];}?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>Total Amount of Seat Booked</label>
                      <div class="form-group">
                          <div class="form-line">
                              <input type="text" class="form-control" readonly value="<?php if($res1['seat']==""){echo "0";}else{echo $res1['seat'];}?>">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <label>Event Description</label>
                      <textarea cols="30" rows="5" name="event_description" readonly class="form-control no-resize"><?php echo $row['event_description'];?></textarea>
                    </div>
                    </div>
                      <br><hr>
                      <?php if ($row['status'] == 1): ?>

                      <h4 class="text-center">All Tickets</h4>
                              <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                      <thead>
                                          <tr>
                                              <th>Ticket ID</th>
                                              <th>Name</th>
                                              <th>Email</th>
                                              <th>Contact</th>
                                              <th>Total Price</th>
                                              <th>Action</th>
                                              <th>Ticket</th>
                                          </tr>
                                      </thead>
                                        <tbody>
                                          <?php $sql = $mysqli->query("SELECT * FROM tickets WHERE event_id='$eventid'");
                                            while ($rew = mysqli_fetch_assoc($sql)) { ?>
                                            <tr>
                                              <td class="text-center"><?php echo $rew['ticket_id'];?></td>
                                              <td class="text-center"><?php echo $rew['name'];?></td>
                                              <td class="text-center"><?php echo $rew['email'];?></td>
                                              <td class="text-center"><?php echo $rew['phone'];?></td>
                                              <td class="text-center"><?php echo $rew['ticket_price'];?></td>
                                              <td class="text-center"><a href="ticket_pdf?ticketid=<?php echo $rew['ticket_id'];?>"><button type="button" class="btn btn-primary waves-effect" name="button">Download</button></a></td>
                                              <td class="text-center"><a href="view_ticket?eventid=<?php echo $rew['event_id'];?>&ticketid=<?php echo $rew['ticket_id'];?>"><button type="button" class="btn btn-success waves-effect" name="button">View</button></a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                  </table>
                              </div>
                          <?php endif; ?>
                  </form>

                  <center><button type="button" name="button" onclick="history.go(-1)" class="btn btn-success">Go Back</button></center>
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
