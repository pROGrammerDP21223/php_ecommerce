<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$footer_about = $row['footer_about'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$contact_address = $row['contact_address'];
	$footer_copyright = $row['footer_copyright'];
	$total_recent_post_footer = $row['total_recent_post_footer'];
    $total_popular_post_footer = $row['total_popular_post_footer'];
    $newsletter_on_off = $row['newsletter_on_off'];
    $before_body = $row['before_body'];
}
?>


<!-- footer start -->
<section class="footer-area section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="footer-list">
                    <ul class="footer-ul">
                        <li class="footer-li footer-logo" data-animate="animate__fadeInUp">
                            <div class="footer-content">
                                <a href="index.php" class="theme-logo">
                                    <img src="img/logo/logo.png" class="img-fluid" alt="footer-logo">
                                </a>
                                <ul class="ftcontact-ul">
                                    <li class="ftcontact-li">
                                        <div class="footer-desc">
                                            <p class="desc">There are many variations of passages of lorem Ipsum available, but the majority .. </p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="app-code">
                                    <h6 class="ftlist-title">Download for app</h6>
                                    <div class="code-1">
                                        <a href="index.php" class="image">
                                            <img src="img/footer/home-footer1.jpg" class="img-fluid desk-img" alt="gp-icon-01">
                                        </a>
                                        <a href="index.php" class="image">
                                            <img src="img/footer/home-footer2.jpg" class="img-fluid desk-img" alt="as-icon-02">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="footer-li" data-animate="animate__fadeInUp">
                            <ul class="ftlist-ul">
                                <li class="ftlist-li">
                                    <h6 class="ftlist-title">Help with</h6>
                                    <a href="#footer-help" class="ftlist-title" data-bs-toggle="collapse" aria-expanded="false">
                                        <span>Help with</span>
                                        <span><i class="fa-solid fa-plus"></i></span>
                                    </a>
                                    <ul class="ftlink-ul collapse" id="footer-help">
                                        <li class="ftlink-li">
                                            <a href="contact-us.html">Contact us</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="terms-condition.html">Terms & conditions</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="track-page.html">Track your order</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="shipping-policy.html">Our guarantee </a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="pro-tickets.html">Guide des tailles</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="footer-li" data-animate="animate__fadeInUp">
                            <ul class="ftlist-ul">
                                <li class="ftlist-li">
                                    <h6 class="ftlist-title">Information</h6>
                                    <a href="#footer-information" class="ftlist-title" data-bs-toggle="collapse" aria-expanded="false">
                                        <span>Information</span>
                                        <span><i class="fa-solid fa-plus"></i></span>
                                    </a>
                                    <ul class="ftlink-ul collapse" id="footer-information">
                                        <li class="ftlink-li">
                                            <a href="about-us.html">About story</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="privacy-policy.html">Privacy policy</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="return-policy.html">Return policy</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="payment-policy.html">Payment policy</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="collection.html">We our brand</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="footer-li" data-animate="animate__fadeInUp">
                            <ul class="ftlist-ul">
                                <li class="ftlist-li">
                                    <h6 class="ftlist-title">Top category</h6>
                                    <a href="#footer-category" class="ftlist-title" data-bs-toggle="collapse" aria-expanded="false">
                                        <span>Top category</span>
                                        <span><i class="fa-solid fa-plus"></i></span>
                                    </a>
                                    <ul class="ftlink-ul collapse" id="footer-category">
                                        <li class="ftlink-li">
                                            <a href="product-template.html">Wireless headphone</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="product-template2.html">Bluetooth speakers</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="product-template3.html">Portable devices</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="product-template4.html">Monio live camera</a>
                                        </li>
                                        <li class="ftlink-li">
                                            <a href="product-template5.html">Movie projector T6</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="footer-li footer-contact" data-animate="animate__fadeInUp">
                            <ul class="ftlist-ul">
                                <li class="ftlist-li">
                                    <h6 class="ftlist-title">Contact info</h6>
                                    <a href="#footer-Contact" class="ftlist-title" data-bs-toggle="collapse" aria-expanded="false">
                                        <span>Contact info</span>
                                        <span><i class="fa-solid fa-plus"></i></span>
                                    </a>
                                    <ul class="ftcontact-ul collapse" id="footer-Contact">
                                        <li class="ftcontact-li">
                                            <div class="ft-contact-add">
                                                <a href="#" class="ft-contact-address">Phone: +1 234 567 890 </a>
                                            </div>
                                        </li>
                                        <li class="ftcontact-li">
                                            <div class="ft-contact-add">
                                                <a href="Email:info@domain.com" class="ft-contact-address">Email: info@domain.com</a>
                                            </div>
                                        </li>
                                        <li class="ftcontact-li">
                                            <div class="ft-contact-add">
                                                <p class="ft-contact-text">401 Broadway, 24th floor,</p>
                                            </div>
                                        </li>
                                        <li class="ftcontact-li">
                                            <div class="ft-contact-add">
                                                <p class="ft-contact-text">orchard view, london, UK</p>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer end -->
<!-- footer-copyright start -->
<footer class="ft-copyright-area bt">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="ft-copyright">
                    <ul class="ft-copryright-ul">
                        <li class="ft-copryright-li ft-payment">
                            <ul class="payment-icon">
                                <li>
                                    <a href="index.php">
                                        <img src="img/payment/pay-1.jpg" class="img-fluid" alt="pay-1">
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <img src="img/payment/pay-2.jpg" class="img-fluid" alt="pay-2">
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <img src="img/payment/pay-3.jpg" class="img-fluid" alt="pay-3">
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <img src="img/payment/pay-4.jpg" class="img-fluid" alt="pay-4">
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="ft-copryright-li news-letter">
                            <div class="news-block">
                                <div class="section-title">
                                    <h2>Subscribe newsletter</h2>
                                </div>
                                <?php
			if(isset($_POST['form_subscribe']))
			{

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= LANG_VALUE_131;
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= LANG_VALUE_134;
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= LANG_VALUE_147;
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
				    		$to = $_POST['email_subscribe'];
							$subject = 'Subscriber Email Confirmation';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;

							$message = '
Thanks for your interest to subscribe our newsletter!<br><br>
Please click this link to confirm your subscription:
					'.$verification_url.'<br><br>
This link will be active only for 24 hours.
					';

							$headers = 'From: ' . $contact_email . "\r\n" .
								   'Reply-To: ' . $contact_email . "\r\n" .
								   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
								   "MIME-Version: 1.0\r\n" . 
								   "Content-Type: text/html; charset=ISO-8859-1\r\n";

							// Sending the email
							mail($to, $subject, $message, $headers);

							$success_message1 = LANG_VALUE_136;
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>
                                <form action="" method="post" id="contact_form" accept-charset="UTF-8" class="contact-form">
                                <?php $csrf->echoInputField(); ?>  
                                <input type="hidden" name="form_type" value="customer">
                                 
                                    <div class="subscribe-block">
                                        <input type="email" name="email_subscribe" class="email mail" id="E-mail" value="" placeholder="Enter your email" autocapitalize="off">
                                        <div class="email-submit">
                                            <button type="submit" name="form_subscribe" class="btn btn-style2">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="ft-copryright-li ft-copyright-text">
                            <p>
                                <span>© 2024 Designed By Dhananjay</span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-copyright end -->
<!-- vega-mobile start -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $stripe_public_key = $row['stripe_public_key'];
    $stripe_secret_key = $row['stripe_secret_key'];
}
?>
<!-- vega-mobile end -->
<!-- mobile-menu start -->
<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-contents">
        <div class="menu-close">
            <button class="menu-close-btn">
                <span class="menu-close-icon"><svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></span>
            </button>
        </div>
        <div class="mobilemenu-content">
            <div class="main-wrap">
                <ul class="main-menu">
                    <li class="menu-link">
                        <a href="index.php" class="link-title" >
                            <span class="sp-link-title">Home</span>
                           
                        </a>
                      
                    </li>
                 
                    <li class="menu-link">
                        <a href="#menu-mega" class="link-title" data-bs-toggle="collapse" aria-expanded="false">
                            <span class="sp-link-title">Product</span>
                            <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                        </a>

                        <?php
$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $uniqueId = "menumega-sup" . $row['tcat_id']; // Make unique ID
    ?>
    <div class="menu-dropdown menu-mega collapse" id="menu-mega">
        <ul class="ul container p-0">
            <li class="menumega-li">
                <a href="#<?php echo $uniqueId; ?>" class="menumega-title" data-bs-toggle="collapse" aria-expanded="false">
                    <span class="sp-link-title"><?php echo $row['tcat_name']; ?></span>
                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                </a>
                <div class="menumegasup-dropdown collapse" id="<?php echo $uniqueId; ?>">
                <?php
                $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                $statement1->execute(array($row['tcat_id']));
                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result1 as $row1) {
                    ?>
                    <ul class="menumegasup-ul">
    
                    <?php
                    $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                    $statement2->execute(array($row1['mcat_id']));
                    $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result2 as $row2) {
                        ?>
                        <li class="menumegasup-li">
                            <a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category" class="menumegasup-title">
                                <span class="sp-link-title"><?php echo $row2['ecat_name']; ?></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    </ul>
                    <?php
                }
                ?>
                </div>
            </li>
        </ul>
    </div>
    <?php
}
?>

                    </li>
                    
                    <li class="menu-link">
                        <a href="about.php" class="link-title">
                            <span class="sp-link-title">About us</span>
                        </a>
                    </li>
                    <li class="menu-link">
                        <a href="faq.php" class="link-title">
                            <span class="sp-link-title">FAQ's</span>
                        </a>
                    </li>
                    <li class="menu-link">
                        <a href="contact.php" class="link-title">
                            <span class="sp-link-title">Contact us</span>
                        </a>
                    </li>
                
                </ul>
            </div>
         
        </div>
    </div>
</div>
<!-- mobile-menu end -->
<!-- search-modal start -->
<div class="modal fade" id="searchmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="crap-search">
                                <button type="button" class="pop-close" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button>
                                <form action="search-result.php" method="get" class="search-bar" role="search">
                                <?php $csrf->echoInputField(); ?> 
                                <div class="form-search">
                                        <input name="search_text" placeholder="Find our serch" class="input-text" required="">
                                        <button class="search-btn" type="submit"><i class="feather-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-drawer start -->

<!-- cart-drawer end -->
<!-- newsletter start -->
<!-- <div id="newsletter" class="popup-wrapper">
    <div class="popup-wrapper">
        <div class="modal fade show" id="news-letter-modal" aria-modal="true" role="dialog">
            <div class="newsletter-popup-inner modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" class="contact-form">
                            <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="feather-x"></i></button>
                            <div class="newsletter-info">
                                <div class="subscribe-area">
                                    <div class="subscribe-content">
                                        <h2>Newsletter</h2>
                                        <p>Subscribe with us to get special offers and other discount information</p>
                                    </div>
                                    <div class="popup-newsletter">
                                        <div class="subscribe-con">
                                            <div class="subscribe-block">
                                                <input type="email" name="q" class="email mail" placeholder="Enter your mail">
                                                <div class="email-submit">
                                                    <button type="submit" class="news-btn btn btn-style">Subscribe</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- newsletter end -->
<!-- quickview modal start -->

<!-- quickview modal end -->
<!-- bg-scren start -->
<div class="bg-screen"></div>
<!-- bg-scren end -->
<!-- bottom-menu start -->
<div class="bottom-menu">
    <ul class="bottom-menu-element">
        <li class="bottom-menu-wrap">
            <div class="bottom-menu-wrapper">
                <a href="index.php" class="bottom-menu-home">
                    <span class="bottom-menu-icon"><svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg></span>
                    <span class="bottom-menu-title">Home</span>
                </a>
            </div>
        </li>
        <li class="bottom-menu-wrap">
            <div class="bottom-menu-wrapper">
                <a href="login.php" class="bottom-menu-user">
                    <span class="bottom-menu-icon"><svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg></span>
                    <span class="bottom-menu-title">Account</span>
                </a>
            </div>
        </li>
      
        
        <li class="bottom-menu-wrap">
            <div class="bottom-menu-wrapper">
                <a href="cart.php" class="bottom-menu-cart">
                    <span class="bottom-menu-icon-wrap">
                        <span class="bottom-menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 24 24">
                                <path fill="currentColor" d="M6.505 2h11a1 1 0 0 1 .8.4l2.7 3.6v15a1 1 0 0 1-1 1h-16a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4m12.5 6h-14v12h14zm-.5-2l-1.5-2h-10l-1.5 2zm-9.5 4v2a3 3 0 1 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2z"></path>
                            </svg></span>
                        <span class="bottom-menu-counter cart-counter">3</span>
                    </span>
                    <span class="bottom-menu-title">Cart</span>
                </a>
            </div>
        </li>
    </ul>
</div>
<!-- bottom-menu end -->
<!-- jquery js -->
<script src="js/jquery-3.6.3.min.js"></script>
<!-- bootstrap js -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- magnific-popup js -->
<script src="js/jquery.magnific-popup.min.js"></script>
<!-- owl-carousel js -->
<script src="js/owl.carousel.min.js"></script>
<!-- swiper-slider js -->
<script src="js/swiper-bundle.min.js"></script>
<!-- slick js -->
<script src="js/slick.min.js"></script>
<!-- waypoints js -->
<script src="js/waypoints.min.js"></script>
<!-- counter js -->
<script src="js/counter.js"></script>
<!-- main js -->
<script src="js/main.js"></script>
<script>

</script>
<script>
	function confirmDelete()
	{
	    return confirm("Do you sure want to delete this data?");
	}
	$(document).ready(function () {
		advFieldsStatus = $('#advFieldsStatus').val();

		$('#paypal_form').hide();
		$('#stripe_form').hide();
		$('#bank_form').hide();

        $('#advFieldsStatus').on('change',function() {
            advFieldsStatus = $('#advFieldsStatus').val();
            if ( advFieldsStatus == '' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'PayPal' ) {
               	$('#paypal_form').show();
				$('#stripe_form').hide();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Stripe' ) {
               	$('#paypal_form').hide();
				$('#stripe_form').show();
				$('#bank_form').hide();
            } else if ( advFieldsStatus == 'Bank Deposit' ) {
            	$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').show();
            }
        });
	});


	$(document).on('submit', '#stripe_form', function () {
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        $('#submit-button').prop("disabled", true);
        $("#msg-container").hide();
        Stripe.card.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
            name: $('.card-holder-name').val()
        }, stripeResponseHandler);
        return false;
    });
    Stripe.setPublishableKey('<?php echo $stripe_public_key; ?>');
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('#submit-button').prop("disabled", false);
            $("#msg-container").html('<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' + response.error.message + '</div>');
            $("#msg-container").show();
        } else {
            var form$ = $("#stripe_form");
            var token = response['id'];
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            form$.get(0).submit();
        }
    }
</script>

</body>

</html>