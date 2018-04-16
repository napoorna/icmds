<?php
 require 'connection.php';
 $date = date("Y-m-d H:i");
 $current_time = strtotime(date("Y-m-d H:i", strtotime($date . "-5 hours -30 minutes")));
?>
<!DOCTYPE html>
<html lang="en">

 <head> <meta name="viewport" content="width=device-width, initial-scale=1" /> <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <!-- Document title -->
     <title>Past Events | ICMDS</title> <!-- Stylesheets & Fonts --> <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" /> <link href="css/plugins.css" rel="stylesheet"> <link href="css/style.css" rel="stylesheet"> <link href="css/responsive.css" rel="stylesheet"> </head>

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

        <!-- Content -->
        <section id="page-content">
            <div class="container">
                <!-- post content -->

                <!-- Page title -->
                <div class="page-title">
                    <h1>Past Events</h1>

                </div>
                <br>
                <!-- end: Page title -->

                <!-- Blog -->
                <div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item">

                    <?php
                    $sql = $mysqli->query("SELECT * FROM event");

                    $change1 = 0;
                    while ($row = mysqli_fetch_assoc($sql)) {
                      $eventid = $row['event_id'];
                      $result1 = explode(" ", $row['start_time'], 6);
                      $date1 = $result1[1];$month1 = $result1[2];$year1 = $result1[3];$day1 = $result1[0]; $display1 = $date1.' '.$month1.' '.$year1.' '.$day1; $time1 = $result1[5];
                      $nmonth1 = date('m',strtotime($month1));
                      $check1 = strtotime($year1.'-'.$nmonth1.'-'.$date1.' '.$time1);
                      if ($check1<=$current_time) {
                        $qry = $mysqli->query("SELECT docs FROM eventdocs WHERE event_id='$eventid'");
                        $change1 = 1;
                    ?>

                    <!-- Post item-->
                    <div class="post-item border">
                        <div class="post-item-wrap">
                            <div class="post-image">
                              <!-- <a href="community-events-gallery?event_id=<?php echo $eventid;?>"> -->
                                  <img alt="No Image" height="350px" src="icmds/db/images/<?php echo $row['cover'];?>">
                              <!-- </a> -->

                            </div>
                            <div class="post-item-description">
                                <span class="post-meta-date"><i class="fa fa-calendar-o"></i><?php echo $row['start_time']?></span>

                                <h2><?php echo $row['event_name']?></h2>
                                <p><?php echo $row['event_description']?></p>
                                <?php if ($qry->num_rows != 0): ?>
                                  <a href="past-events-gallery?event_id=<?php echo $eventid;?>" class="item-link">View Images <i class="fa fa-arrow-right"></i></a>
                                <?php else: ?>
                                  <p class="item-link">That's all</p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <!-- end: Post item-->
                    <?php
                      }
                    }
                    if ($change1==0) {
                     ?>
                     <h5 class="text-center">Currently No Past Events are There, Check later For Future Updates and Events</h5>
                   <?php } ?>

                </div>
                <!-- end: Blog -->

                <!-- Pagination -->
                <!-- <div class="pagination pagination-simple">
                    <ul>
                        <li>
                            <a href="#" aria-label="Previous"> <span aria-hidden="true"><i class="fa fa-angle-left"></i></span> </a>
                        </li>
                        <li class="active"><a href="#">1</a> </li>
                        <li><a href="#">2</a> </li>
                        <li ><a href="#">3</a> </li>
                        <li><a href="#">4</a> </li>
                        <li><a href="#">5</a> </li>
                        <li>
                            <a href="#" aria-label="Next"> <span aria-hidden="true"><i class="fa fa-angle-right"></i></span> </a>
                        </li>
                    </ul>
                </div> -->
                <!-- end: Pagination -->

            </div>
            <!-- end: post content -->

        </section>

        <!-- Content -->
        <section id="page-content">
            <div class="container">

                <div class="page-title">
                    <h1>Past Events Gallery</h1>

                </div>
                <br><br>

                        <!-- Gallery -->
                        <div class="grid-layout grid-3-columns" data-margin="20" data-item="grid-item" data-lightbox="gallery">
                            <div class="grid-item">
                                    <a class="image-hover-zoom" href="icmds_images/aishwarya-1024x683.jpg" data-lightbox="gallery-item"><img src="icmds_images/aishwarya-1024x683.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/AjoyChakrabarty_SwatiSangeethotsavam.jpg" data-lightbox="gallery-item"><img src="icmds_images/AjoyChakrabarty_SwatiSangeethotsavam.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Amjad_Ali_Khan_and_Sons.jpg" data-lightbox="gallery-item"><img src="icmds_images/Amjad_Ali_Khan_and_Sons.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/anoushka_face_3.jpg" data-lightbox="gallery-item"><img src="icmds_images/anoushka_face_3.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Ashwini_Bhide.jpg" data-lightbox="gallery-item"><img src="icmds_images/Ashwini_Bhide.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/August_27th.jpg" data-lightbox="gallery-item"><img src="icmds_images/August_27th.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Birju_Maharaj.jpg" data-lightbox="gallery-item"><img src="icmds_images/Birju_Maharaj.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Carnatic_Hindustani_Jugalbandi1.jpg" data-lightbox="gallery-item"><img src="icmds_images/Carnatic_Hindustani_Jugalbandi1.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/carnatic-brothers.jpg" data-lightbox="gallery-item"><img src="icmds_images/carnatic-brothers.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Hema_Malini_Durga.jpg" data-lightbox="gallery-item"><img src="icmds_images/Hema_Malini_Durga.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Hindol-1024x576.jpg" data-lightbox="gallery-item"><img src="icmds_images/Hindol-1024x576.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/June17th-pdf-791x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/June17th-pdf-791x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/LocalTalentEntryForm20162-page-001-791x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/LocalTalentEntryForm20162-page-001-791x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/LocalTalentFlyer032517-791x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/LocalTalentFlyer032517-791x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/May13flyer-pdf-663x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/May13flyer-pdf-663x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/M-Balachandra-Prabhu.jpg" data-lightbox="gallery-item"><img src="icmds_images/M-Balachandra-Prabhu.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/MilindRaikar-1.jpg" data-lightbox="gallery-item"><img src="icmds_images/MilindRaikar-1.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/PARTHAS-CONCERT-791x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/PARTHAS-CONCERT-791x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/PtAjay.jpg" data-lightbox="gallery-item"><img src="icmds_images/PtAjay.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Rakesh-Chourasia.jpg" data-lightbox="gallery-item"><img src="icmds_images/Rakesh-Chourasia.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Sangeet-Symphony.jpg" data-lightbox="gallery-item"><img src="icmds_images/Sangeet-Symphony.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/sangeetsymphony2017-pdf-791x1024.jpg" data-lightbox="gallery-item"><img src="icmds_images/sangeetsymphony2017-pdf-791x1024.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Sanhita-768x576.jpg" data-lightbox="gallery-item"><img src="icmds_images/Sanhita-768x576.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Sitar--768x576.jpg" data-lightbox="gallery-item"><img src="icmds_images/Sitar--768x576.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Slide1-1-768x576.jpg" data-lightbox="gallery-item"><img src="icmds_images/Slide1-1-768x576.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Slide1-768x576.jpg" data-lightbox="gallery-item"><img src="icmds_images/Slide1-768x576.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Subbulakshmi.jpg" data-lightbox="gallery-item"><img src="icmds_images/Subbulakshmi.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Sumitra-Guha-1.jpg" data-lightbox="gallery-item"><img src="icmds_images/Sumitra-Guha-1.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Sumitra-Guha3.jpg" data-lightbox="gallery-item"><img src="icmds_images/Sumitra-Guha3.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/thLIY4EVA6.jpg" data-lightbox="gallery-item"><img src="icmds_images/thLIY4EVA6.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/zakir_hussain_icmds_2014.jpg" data-lightbox="gallery-item"><img src="icmds_images/zakir_hussain_icmds_2014.jpg"></a>
                            </div>
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="icmds_images/Zakir_Rakesh_duke.jpg" data-lightbox="gallery-item"><img src="icmds_images/Zakir_Rakesh_duke.jpg"></a>
                            </div>
                        </div>
                        <!-- end: Gallery -->



            </div>
        </section>


        <!-- end: Content -->
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

    </div>
    <!-- end: Wrapper -->

    <!-- Go to top button -->
    <a id="goToTop"><i class="fa fa-angle-up top-icon"></i><i class="fa fa-angle-up"></i></a>

 <!--Plugins-->
 <script src="js/jquery.js"></script>
 <script src="js/plugins.js"></script>

<!--Template functions-->
 <script src="js/functions.js"></script>

</body>

</html>
