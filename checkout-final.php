<?php
if (isset($_POST['proceed']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])  && isset($_POST['productid'])) {

  $username = $_POST['name'];
  $useremail = $_POST['email'];
  $userphone = $_POST['phone'];


  if ($_POST['productid']==1) {
      $name = "Patron Family Members"; $price = "250.00"; $validity = "1 Day";
  } elseif ($_POST['productid']==2) {
      $name = "Extended Family membership"; $price = "180.00"; $validity = "1 Year";
  } elseif ($_POST['productid']==3) {
      $name = "Full-Society Family Members"; $price = "150.00"; $validity = "1 Year";
  }elseif ($_POST['productid']==4) {
      $name = "Senior Family Members"; $price = "100.00"; $validity = "1 Year";
  }elseif ($_POST['productid']==5) {
      $name = "Patron Individual Members"; $price = "125.00"; $validity = "1 Year";
  }elseif ($_POST['productid']==6) {
      $name = "Individual Members"; $price = "75.00"; $validity = "1 Year";
  }elseif ($_POST['productid']==7) {
      $name = "Student / Senior Citizen"; $price = "50.00"; $validity = "1 Year";
  }elseif ($_POST['productid']==8) {
      $name = "Premier Membership"; $price = "1000.00"; $validity = "1 Year";
  }
?>
<!DOCTYPE html>
<html lang="en">

 <head> <meta name="viewport" content="width=device-width, initial-scale=1" /> <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <!-- Document title -->
     <title>Checkout | ICMDS</title> <!-- Stylesheets & Fonts --> <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" /> <link href="css/plugins.css" rel="stylesheet"> <link href="css/style.css" rel="stylesheet"> <link href="css/responsive.css" rel="stylesheet"> </head>

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
        <section id="page-title" data-parallax-image="images/parallax/checkout.jpg">
	<div class="container">
		<div class="page-title">
			<h1>Checkout</h1>

		</div>

	</div>
</section>
<!-- end: Page title -->

<!-- SHOP CHECKOUT -->
<section id="shop-checkout">
	<div class="container">
		<div class="shop-cart">
			<form method="post" class="sep-top-md" action="#">
				<div class="row">
					<div class="col-md-12 no-padding">
						<div class="col-md-12">
							<h4 class="upper">Basic Information</h4>
						</div>
						<div class="col-md-12 form-group">
							<label >Full Name</label>
							<input type="text" class="form-control input-lg" readonly value="<?php echo $_POST['name'];?>">
						</div>
            <div class="col-md-6 form-group">
							<label >Email</label>
							<input type="text" class="form-control input-lg" readonly value="<?php echo $_POST['email'];?>">
						</div>
						<div class="col-md-6 form-group">
							<label>Phone</label>
							<input type="text" class="form-control input-lg" readonly value="<?php echo $_POST['phone'];?>">
						</div>
					</div>
				</div>
      </form>
			<div class="seperator"><i class="fa fa-credit-card"></i>
			</div>


			<div class="row">

				<div class="col-md-6">
					<div class="table-responsive">
						<h4>Order Total</h4>

            <table class="table">
							<tbody>
								<tr>
									<td class="cart-product-name">
										<strong><?php echo $name;?></strong>
									</td>

									<td class="cart-product-name text-right">
										<span class="amount">$<?php echo $price;?></span>
									</td>
								</tr>

								<tr>
									<td class="cart-product-name">
										<strong>Total</strong>
									</td>

									<td class="cart-product-name text-right">
										<span class="amount color lead"><strong>$<?php echo $price;?></strong></span>
									</td>
								</tr>
							</tbody>

						</table>

					</div>
				</div>
				<div class="col-md-6">
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="business" value="XMP3UCFKRCQ52">
          <input type="hidden" name="lc" value="US">
          <input type="hidden" name="item_name" value="<?php echo $name;?>">
          <input type="hidden" name="item_number" value="<?php echo $_POST['productid'];?>">
          <input type="hidden" name="amount" value="<?php echo $price;?>">
          <input type="hidden" name="custom" value="<?php echo $username.",".$userphone.",".$useremail;?>">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="button_subtype" value="services">
          <input type="hidden" name="no_note" value="1">
          <input type="hidden" name="no_shipping" value="1">
          <input type="hidden" name="rm" value="1">
          <input type="hidden" name="return" value="http://icmds.org/order-confirm">
          <input type="hidden" name="cancel_return" value="http://icmds.org/membership">
          <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
          <input type="hidden" name="notify_url" value="http://icmds.org/mail/listener.php">
          <center>
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </center>
          </form>

				</div>

			</div>



		</div>
	</div>
</section>
<!-- end: SHOP CHECKOUT -->



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


</body>
</html>
<?php
} else {
  header('location: membership');
}
?>
