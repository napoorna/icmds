<?php
require 'connection.php';
session_start();
if (!isset($_SESSION['time'])) {
  header('location: ticket');
}
unset($_SESSION['time']);
if (isset($_POST['name'])) {

  $name = $mysqli->real_escape_string($_POST['name']);
  $ename = $mysqli->real_escape_string($_POST['ename']);
  $eventid = $mysqli->real_escape_string($_POST['eventid']);
  $email = $mysqli->real_escape_string($_POST['email']);
  $phone = $mysqli->real_escape_string($_POST['phone']);
  $mid = $mysqli->real_escape_string($_POST['mid']);
  if ($mid != "") {
    $sql = $mysqli->query("SELECT discount FROM event WHERE event_id='$eventid'");
    $res = $sql->fetch_assoc();
    $discount = $res['discount'];
  } else {
    $discount = 0;
  }



?>
<!DOCTYPE html>
<html lang="en">

 <head>
   <meta name="viewport" content="width=device-width, initial-scale=1" /> <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!-- <meta http-equiv="refresh" content="15; URL=http://www.icmds.org/confirm_proceed"> -->
     <!-- Document title -->
     <title>Confirm Proceed | ICMDS</title> <!-- Stylesheets & Fonts --> <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" /> <link href="css/plugins.css" rel="stylesheet"> <link href="css/style.css" rel="stylesheet"> <link href="css/responsive.css" rel="stylesheet">
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
</head>

<body onload="valueput();">	<!-- Wrapper -->
	<div id="wrapper">

		 <!-- Topbar -->
        <div id="topbar" class="topbar-coloured">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="top-menu">
                            <li><a href="#">Phone: +1 (234) 567-890</a></li>
                            <li><a href="#">Email: contact@icmds.com</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 hidden-xs">
                        <div class="social-icons social-icons-colored-hover">
                            <ul>
                                <li class="social-facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="social-twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
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
			<form id="formdata" method="post" class="sep-top-md" action="#">
				<div class="row">
					<div class="col-md-12 no-padding">
						<div class="col-md-12">
							<h4 class="upper">Basic Information</h4>
						</div>
            <div class="col-md-12 form-group">
              <label>Event Name</label>
              <input type="text" class="form-control input-lg" readonly value="<?php echo $ename; ?>" name="ename">
            </div>
						<div class="col-md-12 form-group">
							<label class="sr-only">Full Name</label>
							<input type="text" class="form-control input-lg" readonly value="<?php echo $name;?>" name="name">
						</div>
            <input type="hidden" name="eventid" value="<?php echo $_POST['eventid'];?>">
						<div class="col-md-6 form-group">
							<label class="sr-only">Email</label>
							<input type="email" class="form-control input-lg" readonly value="<?php echo $email;?>" name="email">
						</div>
						<div class="col-md-6 form-group">
							<label class="sr-only">Phone</label>
							<input type="number" class="form-control input-lg" readonly value="<?php echo $phone;?>" name="phone">
						</div>
    			</div>
				</div>

        <div class="table table-condensed table-striped table-responsive">
  				<table class="table">
  					<thead>
  						<tr>
  							<th class="cart-product-thumbnail">Product</th>
  							<th class="cart-product-price">Unit Price</th>
  							<th class="cart-product-quantity">Quantity</th>
  							<th class="cart-product-quantity">Total</th>
  						</tr>
  					</thead>
  					<tbody>
              <?php

                 $total = 0;
                 $category_input = $_POST['category_input'];
                 $price = $_POST['price_input'];
                 $qnt = $_POST['quantities'];
                 $count = 0;
                 $product_count = "";
                 foreach ($category_input as $key => $category) {
                   $count = $count + $qnt[$key];
                   if ($qnt[$key] !=0) {
                     if ($product_count == "") {
                        $product_count = $category.$qnt[$key];
                        $price_count = $price[$key]*$qnt[$key];
                     } else {
                        $product_count = $product_count.",".$category.$qnt[$key];
                        $price_count = $price_count.",".$price[$key]*$qnt[$key];
                     }
                   }

                ?>
  						<tr>
  							<td class="cart-product-thumbnail">
  								<div class="cart-product-thumbnail-name"><?php echo $category;?></div>
  							</td>
  							<td class="cart-product-price">
  								<div class="cart-product-thumbnail-name"><?php echo $price[$key];?></div>
  							</td>
                <td class="cart-product-price">
  								<div class="cart-product-thumbnail-name"><?php echo $qnt[$key];?></div>
  							</td>
                <?php $total = $total + ($price[$key]*$qnt[$key]); ?>
                <td class="cart-product-price">
  								<div class="cart-product-thumbnail-name"><?php echo $price[$key]*$qnt[$key];?></div>
  							</td>
  						</tr>
              <?php } ?>
  					</tbody>

  				</table>
  			</div>

        <div class="row" style="text-align: right;padding-right:12%;">
            <h5>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $<?php echo $total;?></h5>
          <?php
          if ($discount != "" || $discount != 0):
            $final = round($total - ($total*($discount/100)),2);
            ?>
            <h5>Membership Discount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $discount;?>%</h5>
          <?php else:
            $final = round($total,2);
            ?>
          <?php endif; ?>

        </div>
        <hr>
        <div class="row" style="text-align: right;padding-right:12%;">
          <h5>Amount Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $<?php echo $final;?></h5>
        </div>

          <br>
          <center><h3><span id="msg"></span></h3></center>
          <br>
          <center><h3><span id="disc"></span></h3></center>
          <br>
          <center><h3><span id="final"></span></h3></center>
        </form>
          <br>
          <center>

            <!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="JAMS8JB5MZ7DE">
            <input type="hidden" name="lc" value="IN">
            <input type="hidden" name="item_name" value="ItemName">
            <input type="hidden" name="item_number" value="ItemID">
            <input type="hidden" name="amount" value="0.01">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="http://icmds.org/order-confirm">
            <input type="hidden" name="cancel_return" value="http://icmds.org/ticket">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
            <input type="hidden" name="notify_url" value="https://www.mywebsite.com/example_usage_advanced.php">
            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
            </form> -->

            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="XMP3UCFKRCQ52">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="<?php echo $product_count; ?>">
            <input type="hidden" name="item_number" value="<?php echo $eventid; ?>">
            <input type="hidden" name="amount" value="<?php echo $final; ?>">
            <input type="hidden" name="custom" value="<?php echo $count.",".$name.",".$phone.",".$email.",".$price_count;?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="http://icmds.org/order-confirm">
            <input type="hidden" name="cancel_return" value="http://icmds.org/ticket">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
            <input type="hidden" name="notify_url" value="http://icmds.org/mail/listener_ticket.php">
            <!-- <input type="hidden" name="notify_url" value="http://onclavesystems.com/demo/paypalipn/example_usage_advanced.php"> -->
            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
            </form>

          </center>


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
                                    <li><i class="fa fa-map-marker"></i> 795 Folsom Ave, Suite 600
                                        <br>San Francisco, CA 94107</li>
                                    <li><i class="fa fa-phone"></i> (123) 456-7890 </li>
                                    <li><i class="fa fa-envelope"></i> <a href="mailto:first.last@example.com">first.last@example.com</a>
                                    </li>
                                    <li>
                                        <br><i class="fa fa-clock-o"></i>Monday - Friday: <strong>08:00 - 22:00</strong>
                                        <br>Saturday, Sunday: <strong>Closed</strong>
                                    </li>
                                </ul>
                                <!-- Social icons -->
                                <div class="social-icons social-icons-border float-left m-t-20">
                                    <ul>

                                        <li class="social-facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="social-twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
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
  header('location: ticket');
}
?>
