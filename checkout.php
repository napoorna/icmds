<?php
require 'connection.php';
if (isset($_GET['eventid'])) {
  session_start();
  $_SESSION['time']=1;
  $eventid = $mysqli->real_escape_string($_GET['eventid']);

  // if (isset($_SESSION[$eventid])) {
  //   unset($_SESSION[$eventid]);
    $sql1 = $mysqli->query("SELECT event_name FROM event WHERE event_id='$eventid' AND status='1'");
    $res=$sql1->fetch_assoc();
    if ($sql1->num_rows == 0) {
      echo '<script language="javascript">';
      echo 'alert("Event Not Found");';
      echo 'window.location.href = "ticket"';
      echo '</script>';
    }
    $name = $res['event_name'];
?>
<!DOCTYPE html>
<html lang="en">

 <head> <meta name="viewport" content="width=device-width, initial-scale=1" /> <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <!-- Document title -->
     <title>Checkout | ICMDS</title> <!-- Stylesheets & Fonts --> <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" /> <link href="css/plugins.css" rel="stylesheet"> <link href="css/style.css" rel="stylesheet"> <link href="css/responsive.css" rel="stylesheet">
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
			<form id="formdata" method="POST" class="sep-top-md" action="confirm_proceed">
				<div class="row">
					<div class="col-md-12 no-padding">
						<div class="col-md-12">
							<h4 class="upper">Basic Information</h4>
						</div>
						<div class="col-md-12 form-group">
							<label>Event Name</label>
							<input type="text" class="form-control input-lg" readonly value="<?php echo $name; ?>" name="ename">
						</div>
						<div class="col-md-12 form-group">
							<label class="sr-only">Full Name</label>
							<input type="text" class="form-control input-lg" required placeholder="Full Name" name="name">
						</div>
            <input type="hidden" name="eventid" value="<?php echo $_GET['eventid'];?>">
						<div class="col-md-6 form-group">
							<label class="sr-only">Email</label>
							<input type="email" class="form-control input-lg" onchange="changeemail();" id="email" required placeholder="Email" name="email">
						</div>
						<div class="col-md-6 form-group">
							<label class="sr-only">Phone</label>
							<input type="number" class="form-control input-lg" required placeholder="Phone" name="phone">
						</div>
            <input type="hidden" id="eventid" name="eventid" value="<?php echo $eventid;?>">
					</div>
				</div>

        <div class="table table-condensed table-striped table-responsive">
  				<table class="table">
  					<thead>
  						<tr>
  							<th class="cart-product-thumbnail">Product</th>
  							<th class="cart-product-price">Unit Price</th>
  							<th class="cart-product-quantity">Quantity</th>
  						</tr>
  					</thead>
  					<tbody>
              <?php
                $sql = $mysqli->query("SELECT * FROM event_ticket_category_map WHERE event_id='$eventid'");
               while ($row = mysqli_fetch_assoc($sql)){ ?>
  						<tr>
  							<td class="cart-product-thumbnail">
  								<div class="cart-product-thumbnail-name"><?php echo $row['category'];?></div>
  							</td>
                <input type="hidden" name="category_input[]" class="category_input" value="<?php echo $row['category'];?>">
                <input type="hidden" name="price_input[]" class="price_input" value="<?php echo $row['price'];?>">
  							<td class="cart-product-price" name="price[]">
  								<span class="amount"><?php echo $row['price'];?></span>
  							</td>

  							<td class="cart-product-quantity">
  								<div class="quantity">
                    <select class="qnt_input" onchange="trigger();" name="quantities[]">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                    </select>
  								</div>
  							</td>
  						</tr>
              <?php } ?>
  					</tbody>

  				</table>
  			</div>

        <div class="row">
          <div class="col-sm-6 text-center">
          <h5>Do You Have Any Membership ? Enter Membership ID Connected With Provided Email</h5>
          </div>
          <div class="col-sm-3">
          <input type="text" class="form-control input-lg" onchange="valid();" id="mid" placeholder="Membership ID" name="mid">
          </div>
          <input type="button" class="btn btn-success col-sm-3" onclick="check();" id="checkbtn" value="Check" name="mid">
        </div>

          <br>
          <center><h3><span id="msg"></span></h3></center>
          <br>
          <center><h3><span id="disc"></span></h3></center>
          <br>
          <center><h3><span id="final"></span></h3></center>
          <br>
          <center><button type="submit" name="proceedbutton" class="btn btn-primary">Proceed</button></center>
    </form>


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


 <script type="text/javascript">
   function trigger(){
     var inputs = document.getElementsByClassName( 'price_input' ),
     names  = [].map.call(inputs, function( input ) {
         return input.value;
     });
     var qnt_inputs = document.getElementsByClassName( 'qnt_input' ),
     qnt_names  = [].map.call(qnt_inputs, function( input ) {
         return input.value;
     });
     var price_array = names.toString().split(",");
     var qnt_array = qnt_names.toString().split(",");

     // alert(price_array.length);
     var total_value = 0;
     for (var i = 0; i < price_array.length; i++) {
       total_value = (parseFloat(price_array[i],10)*parseFloat(qnt_array[i],10))+parseFloat(total_value,10);
     }
     // alert(total_value.toFixed(2));
     document.getElementById("msg").innerHTML="Total Fare $"+total_value.toFixed(2);
     document.getElementById('disc').innerHTML = "";
     document.getElementById('final').innerHTML = "";

     // parseFloat(f.value.value,10)


   }

  function valueput(){
      document.getElementById("msg").innerHTML="Total Fare $0.00";
      document.getElementById('checkbtn').disabled= true;
   }
 </script>

 <script type="text/javascript">
 $('#formdata').submit(function(e) {
   e.preventDefault();
   var self = this;
   var data = document.getElementById("msg").innerHTML;
   if (data == "Total Fare $0.00") {
     alert('Total Fare Can Not Be Zero');
     return false;
   } else {

     var inputs = document.getElementsByClassName( 'price_input' ),
     names  = [].map.call(inputs, function( input ) {
         return input.value;
     });
     var qnt_inputs = document.getElementsByClassName( 'qnt_input' ),
     qnt_names  = [].map.call(qnt_inputs, function( input ) {
         return input.value;
     });
     var category = document.getElementsByClassName( 'category_input' ),
     cats  = [].map.call(category, function( input ) {
         return input.value;
     });

       var mid = document.getElementById('mid').value;
       var eventid = document.getElementById('eventid').value;
       if (mid != "") {

          var email = document.getElementById('email').value;
          var dataString = 'email='+ email + '&mid=' + mid + '&price=' + names + '&qnt=' + qnt_names + '&eventid=' + eventid + '&cats=' + cats;
          jQuery.ajax({
          url: "mail/verify_mid.php",
          data: dataString,
          type: "POST",
          success:function(data){
            if (data == "success") {
              self.submit();
            } else {
              alert(data);
              return false;
            }
          }
          });
       } else if (mid == "") {

         var email = document.getElementById('email').value;
         var mid = 99;
         var dataString = 'email='+ email + '&mid=' + mid + '&price=' + names + '&qnt=' + qnt_names + '&eventid=' + eventid + '&cats=' + cats;
         jQuery.ajax({
         url: "mail/verify_mid.php",
         data: dataString,
         type: "POST",
         success:function(data){
           if (data == "success") {
             self.submit();
           } else {
             alert(data);
             return false;
           }
         }
         });
       }
   }
});
 </script>

 <script type="text/javascript">
   function valid(){
     var val = document.getElementById('mid').value;
     document.getElementById('disc').innerHTML = "";
     document.getElementById('final').innerHTML = "";

     if (val == "") {
       document.getElementById('checkbtn').disabled= true;
     } else {
       document.getElementById('checkbtn').disabled= false;
     }
   }

   function check(){
     var mid = document.getElementById('mid').value;
     var total = document.getElementById("msg").innerHTML;
     var eventid = document.getElementById("eventid").value;
     if (mid != "") {
        var email = document.getElementById('email').value;
        var dataString = 'email='+ email + '&mid=' + mid + '&total=' + total + '&eventid=' + eventid;
        jQuery.ajax({
        url: "mail/verify.php",
        data: dataString,
        type: "POST",
        success:function(data){
          var n = data.length;
          if (n==2) {
              var totalval = total.substring(12);
              final = (parseFloat(totalval,10) - (parseFloat(totalval,10)*parseFloat(data,10)/100)).toFixed(2);
              document.getElementById('disc').innerHTML = "Membership discount: "+data+"%";
              document.getElementById('final').innerHTML = "Final Fare $"+final;
          } else {
            alert(data);
          }
        }
        });
     }
   }
 </script>
 <script type="text/javascript">
   function changeemail(){
     document.getElementById('disc').innerHTML = "";
     document.getElementById('final').innerHTML = "";
   }
 </script>


</body>
</html>
<?php
// } else {
//   header('location: ticket');
// }
} else {
  header('location: ticket');
}
?>
