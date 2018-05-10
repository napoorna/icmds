<?php require 'connection.php';
session_start();
  // $current_time = strtotime(date('l d F Y H:m'));
  // $current_time -= 1800;
  $current_time = strtotime(date("Y-m-d H:i", strtotime("-5 hours -30 minutes")));


?>
<!DOCTYPE html>
<html lang="en">

 <head> <meta name="viewport" content="width=device-width, initial-scale=1" /> <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <!-- Document title -->
     <title>Tickets | ICMDS</title> <!-- Stylesheets & Fonts --> <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" /> <link href="css/plugins.css" rel="stylesheet"> <link href="css/style.css" rel="stylesheet"> <link href="css/responsive.css" rel="stylesheet"> </head>

<body>	<!-- Wrapper -->
	<div id="wrapper">

		 <!-- Topbar -->
        <div id="topbar" class="topbar-coloured">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="top-menu">

                            <li><a href="#">Email: questions@icmds.org</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 hidden-xs">
                        <div class="social-icons social-icons-colored-hover">
                            <ul>
                                <li class="social-facebook"><a href="https://www.facebook.com/ICMDS-1569280673289457"><i class="fa fa-facebook"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Topbar -->

        <!-- Header -->
        <header id="header" class="header-fullwidth coloured">
            <div id="header-wrap">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="index" class="logo" data-dark-logo="images/logo-dark.png">
                            <img src="images/logo-dark.png" alt="Polo Logo">ICMDS
                        </a>
                    </div>
                    <!--End: Logo-->
                    <!--Top Search Form-->

                    <!--end: Top Search Form-->

                    <!--Header Extras-->

                    <!--end: Header Extras-->

                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <button class="lines-button x"> <span class="lines"></span> </button>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->

                    <!--Navigation-->
                    <div id="mainMenu" class="light">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="index">Home</a></li>
                                    <li> <a href="about">About Us</a></li>
                                    <li class="dropdown"> <a href="#">Teachers</a>
                                        <ul class="dropdown-menu">
                                            <li> <a href="music-teachers">Music</a></li>
                                            <li> <a href="dance-teachers">Dance</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"> <a href="#">Events</a>
                                        <ul class="dropdown-menu">
                                            <li><span class="dropdown-menu-title-only"><a href="ticket">Upcoming Events</a></span></li>
                                            <li><span class="dropdown-menu-title-only"><a href="past-events">Past Events</a></span></li>
                                            <li><span class="dropdown-menu-title-only"><a href="community-events">Community Events</a></span></li>

                                        </ul>
                                    </li>
                                    <li> <a href="membership">Membership</a></li>
                                    <li> <a href="ticket">Tickets</a><span class="label label-default">BUY</span></li>
                                    <li> <a href="links">Links</a></li>
                                    <li> <a href="contact">Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
					<!--END: NAVIGATION-->
				</div>
			</div>
		</header>
		<!-- end: Header -->


		<!-- Page title -->
		<section id="page-title" data-parallax-image="images/parallax/ticket.jpg">
  <div class="container">
    <div class="page-title">
      <h1>TICKETS</h1>
       </div>

  </div>
</section>
<!-- end: Page title -->

<!-- Section -->
<section>
  <div class="container">
    <div class="heading heading-center">
      <h3>BUY TICKETS</h3>
          <div class="hr-title hr-long center"><abbr>BUY TICKETS TO OUR EVENTS</abbr> </div>
      <!-- Blog -->
      <div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item">

        <?php
        $sql1 = $mysqli->query("SELECT * FROM event WHERE status='1'");
        $change1 = 0;
        while ($row1 = mysqli_fetch_assoc($sql1)) {

          $eventid1 = $row1['event_id'];
          $sql2 = $mysqli->query("SELECT MIN(price) AS p FROM event_ticket_category_map WHERE event_id='$eventid1'");
          $row2 = $sql2->fetch_assoc();

          $result1 = explode(" ", $row1['start_time'], 6);
          $date1 = $result1[1];$month1 = $result1[2];$year1 = $result1[3];$day1 = $result1[0]; $display1 = $date1.' '.$month1.' '.$year1.' '.$day1; $time1 = $result1[5];
          $nmonth1 = date('m',strtotime($month1));
          $check1 = strtotime($year1.'-'.$nmonth1.'-'.$date1.' '.$time1);
          if ($check1>$current_time) {
            $change1 = 1;
            $_SESSION[$row1['event_id']]=1;
        ?>

          <!-- Post item-->
          <div class="post-item border">
              <div class="post-item-wrap">
                  <div class="post-image">
                        <img alt="No Image" height="350px" src="icmds/db/images/<?php echo $row1['cover'];?>">
                  </div>
                  <div class="post-item-description">
                      <span class="post-meta-date"><i class="fa fa-calendar-o"></i><?php echo $row1['start_time']?></span>

                      <h2><?php echo $row1['event_name']?></h2>
                      <p><?php echo $row1['event_description']?></p>
                      <button class="btn btn-success" onclick="check(<?php echo $row1['event_id'];?>);">BUY NOW (<?php echo '$'.$row2['p'];?>)</button>

                  </div>
              </div>
          </div>
          <!-- end: Post item-->
          <?php
            }
          }
          if ($change1==0) {
           ?>
           <h5 class="text-center">Currently No Upcoming Events are There, Check later For Future Updates and Events</h5>
         <?php } ?>

      </div>
      <!-- end: Blog -->
    </div>

    <div class="heading heading-center">
    	<h3>OPEN EVENTS</h3>
          <div class="hr-title hr-long center"><abbr>Upcoming ICMDS Open Events</abbr> </div>
      <!-- Blog -->
      <div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item">

        <?php
        $sql = $mysqli->query("SELECT * FROM event WHERE status='0'");
        $change = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
          $eventid = $row['event_id'];
          $result = explode(" ", $row['start_time'], 6);
          $date = $result[1];$month = $result[2];$year = $result[3];$day = $result[0]; $display = $date.' '.$month.' '.$year.' '.$day; $time = $result[5];
          $nmonth = date('m',strtotime($month));
          $check = strtotime($year.'-'.$nmonth.'-'.$date.' '.$time);
          if ($check>$current_time) {
            $change = 1;
            $_SESSION[$row['event_id']]=1;
        ?>

          <!-- Post item-->
          <div class="post-item border">
              <div class="post-item-wrap">
                  <div class="post-image">
                        <img alt="No Image" height="350px" src="icmds/db/images/<?php echo $row['cover'];?>">
                    <!-- </a> -->

                  </div>
                  <div class="post-item-description">
                      <span class="post-meta-date"><i class="fa fa-calendar-o"></i><?php echo $row['start_time']?></span>

                      <h2><?php echo $row['event_name']?></h2>
                      <p><?php echo $row['event_description']?></p>

                  </div>
              </div>
          </div>
          <!-- end: Post item-->
          <?php
            }
          }
          if ($change==0) {
           ?>
           <h5 class="text-center">Currently No Upcoming Open Events are There, Check later For Future Updates and Events</h5>
         <?php } ?>

      </div>
      <!-- end: Blog -->
    </div>

    </div>
</section>
<!-- end: Section -->

<!-- Footer -->
<footer id="footer" class="footer-light">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Footer widget area 1 -->
                            <div class="widget clearfix widget-contact-us" style="background-image: url('images/world-map-dark.png'); background-position: 50% 20px; background-repeat: no-repeat">
<!--                                <h4>About</h4>-->
                                <ul class="list-icon">
                                    <li><i class="fa fa-map-marker"></i> PO Box 5527<br>Cary, NC 27511<br>USA
                                    <li><i class="fa fa-envelope"></i> <a href="mailto:first.last@example.com">questions@icmds.org</a>
                                    </li>

                                </ul>
                                <!-- Social icons -->
                                <div class="social-icons social-icons-border float-left m-t-20">
                                    <ul>

                                        <li class="social-facebook"><a href="https://www.facebook.com/ICMDS-1569280673289457/"><i class="fa fa-facebook"></i></a></li>

                                    </ul>
                                </div>
                                <!-- end: Social icons -->
                            </div>
                            <!-- end: Footer widget area 1 -->
                        </div>
                        <div class="col-md-2">
                            <!-- Footer widget area 2 -->
                            <div class="widget">
                                <h4>Quick LInks</h4>
                                <ul class="list-icon list-icon-arrow">
                                    <li><a href="index">Home</a></li>
                                    <li><a href="about">About</a></li>
                                    <li><a href="membership">Membership</a></li>
                                    <li><a href="ticket">Tickets</a></li>
                                    <li><a href="ticket">Events</a></li>
                                    <li><a href="links">Important Links</a></li>
                                    <li><a href="contact">Contact Us</a></li>

                                </ul>
                            </div>
                            <!-- end: Footer widget area 2 -->
                        </div>
                        <div class="col-md-3">
                            <!-- Footer widget area 3 -->
                            <div class="widget">
<!--
                                <h4>Latest From Our Blog</h4>
                                <div class="post-thumbnail-list">
                                    <div class="post-thumbnail-entry">

                                        <div class="post-thumbnail-content">
                                            <a href="#">Suspendisse consectetur fringilla luctus</a>
                                            <span class="post-date"><i class="fa fa-clock-o"></i> 6m ago</span>
                                            <span class="post-category"><i class="fa fa-tag"></i> Technology</span>
                                        </div>
                                    </div>
                                    <div class="post-thumbnail-entry">

                                        <div class="post-thumbnail-content">
                                            <a href="#">Consectetur adipiscing elit</a>
                                            <span class="post-date"><i class="fa fa-clock-o"></i> 24h ago</span>
                                            <span class="post-category"><i class="fa fa-tag"></i> Lifestyle</span>
                                        </div>
                                    </div>
                                    <div class="post-thumbnail-entry">

                                        <div class="post-thumbnail-content">
                                            <a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a>
                                            <span class="post-date"><i class="fa fa-clock-o"></i> 11h ago</span>
                                            <span class="post-category"><i class="fa fa-tag"></i> Lifestyle</span>
                                        </div>
                                    </div>
                                </div>
-->
                            </div>
                            <!-- end: Footer widget area 3 -->
                        </div>
                        <div class="col-md-3">
                            <!-- Footer widget area 4 -->
<!--
                            <div class="widget widget-tweeter" data-username="ardianmusliu" data-limit="2">
                                <h4>Recent Tweets</h4>
                            </div>
-->
                            <!-- end: Footer widget area 4 -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-content">
                <div class="container">
                    <div class="copyright-text text-center">&copy; 2018. All Rights Reserved. Designed by<a href="http://www.onclavesystems.com" target="_blank">&nbsp;Onclave Systems</a>
                    </div>
                </div>
            </div>
        </footer>
  <!-- end: Footer -->

</div>    <!-- end: Wrapper -->

    <!-- Go to top button -->
    <a id="goToTop"><i class="fa fa-angle-up top-icon"></i><i class="fa fa-angle-up"></i></a>

<!--Plugins-->
 <script src="js/jquery.js"></script>
 <script src="js/plugins.js"></script>

<!--Template functions-->
 <script src="js/functions.js"></script>

 <script type="text/javascript">
   function check(f){
     var dataString = 'eventid='+ f;
     jQuery.ajax({
     url: "mail/check.php",
     data: dataString,
     type: "POST",
     success:function(data){
       if (data == "success") {
         window.location.href="checkout?eventid="+f;
       } else {
          alert(data);
       }
     }
     });
   }
 </script>

</body>
</html>
