 <!-- This is main configuration File -->
 <?php
    ob_start();
    session_start();
    include("admin/inc/config.php");
    include("admin/inc/functions.php");
    include("admin/inc/CSRF_Protect.php");
    $csrf = new CSRF_Protect();
    $error_message = '';
    $success_message = '';
    $error_message1 = '';
    $success_message1 = '';

    // Getting all language variables into array as global variable
    $i = 1;
    $statement = $pdo->prepare("SELECT * FROM tbl_language");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        define('LANG_VALUE_' . $i, $row['lang_value']);
        $i++;
    }

    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $logo = $row['logo'];
        $favicon = $row['favicon'];
        $contact_email = $row['contact_email'];
        $contact_phone = $row['contact_phone'];
        $meta_title_home = $row['meta_title_home'];
        $meta_keyword_home = $row['meta_keyword_home'];
        $meta_description_home = $row['meta_description_home'];
        $before_head = $row['before_head'];
        $after_body = $row['after_body'];
    }

    // Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
    $current_date_time = date('Y-m-d H:i:s');
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
    $statement->execute(array('Pending'));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $ts1 = strtotime($row['payment_date']);
        $ts2 = strtotime($current_date_time);
        $diff = $ts2 - $ts1;
        $time = $diff / (3600);
        if ($time > 24) {

            // Return back the stock amount
            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
            $statement1->execute(array($row['payment_id']));
            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result1 as $row1) {
                $statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
                $statement2->execute(array($row1['product_id']));
                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $row2) {
                    $p_qty = $row2['p_qty'];
                }
                $final = $p_qty + $row1['quantity'];

                $statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
                $statement->execute(array($final, $row1['product_id']));
            }

            // Deleting data from table
            $statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
            $statement1->execute(array($row['payment_id']));

            $statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
            $statement1->execute(array($row['id']));
        }
    }
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">

     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- title -->

     <!-- favicon -->
     <link rel="icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">
     <!-- bootstrap css -->
     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="css/bootstrap-icons.css">
     <!-- magnific-popup css -->
     <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
     <!-- fontawesome css -->
     <link rel="stylesheet" type="text/css" href="css/all.min.css">
     <!--fether css -->
     <link rel="stylesheet" type="text/css" href="css/feather.css">
     <!-- animate css -->
     <link rel="stylesheet" type="text/css" href="css/animate.min.css">
     <!-- owl-carousel css -->
     <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
     <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
     <!-- swiper css -->
     <link rel="stylesheet" type="text/css" href="css/swiper-bundle.min.css">
     <!-- slick slider css -->
     <link rel="stylesheet" type="text/css" href="css/slick.css">
     <!-- plugin css -->
     <link rel="stylesheet" type="text/css" href="css/plugin.css">
     <!-- collection css -->
     <link rel="stylesheet" type="text/css" href="css/collection.css">
     <!-- blog css -->
     <link rel="stylesheet" type="text/css" href="css/blog.css">
     <!-- other-pages css -->
     <link rel="stylesheet" type="text/css" href="css/other-pages.css">
     <!-- product-page css -->
     <link rel="stylesheet" type="text/css" href="css/product-page.css">
     <!-- style css -->
     <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" type="text/css" href="css/style2.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
     <?php

        $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $about_meta_title = $row['about_meta_title'];
            $about_meta_keyword = $row['about_meta_keyword'];
            $about_meta_description = $row['about_meta_description'];
            $faq_meta_title = $row['faq_meta_title'];
            $faq_meta_keyword = $row['faq_meta_keyword'];
            $faq_meta_description = $row['faq_meta_description'];
            $blog_meta_title = $row['blog_meta_title'];
            $blog_meta_keyword = $row['blog_meta_keyword'];
            $blog_meta_description = $row['blog_meta_description'];
            $contact_meta_title = $row['contact_meta_title'];
            $contact_meta_keyword = $row['contact_meta_keyword'];
            $contact_meta_description = $row['contact_meta_description'];
            $pgallery_meta_title = $row['pgallery_meta_title'];
            $pgallery_meta_keyword = $row['pgallery_meta_keyword'];
            $pgallery_meta_description = $row['pgallery_meta_description'];
            $vgallery_meta_title = $row['vgallery_meta_title'];
            $vgallery_meta_keyword = $row['vgallery_meta_keyword'];
            $vgallery_meta_description = $row['vgallery_meta_description'];
        }

        $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

        if ($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
        ?>
         <title><?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }

        if ($cur_page == 'about.php') {
        ?>
         <title><?php echo $about_meta_title; ?></title>
         <meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
         <meta name="description" content="<?php echo $about_meta_description; ?>">
     <?php
        }
        if ($cur_page == 'faq.php') {
        ?>
         <title><?php echo $faq_meta_title; ?></title>
         <meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
         <meta name="description" content="<?php echo $faq_meta_description; ?>">
     <?php
        }
        if ($cur_page == 'contact.php') {
        ?>
         <title><?php echo $contact_meta_title; ?></title>
         <meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
         <meta name="description" content="<?php echo $contact_meta_description; ?>">
     <?php
        }
        if ($cur_page == 'product.php') {
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $og_photo = $row['p_featured_photo'];
                $og_title = $row['p_name'];
                $og_slug = 'product.php?id=' . $_REQUEST['id'];
                $og_description = substr(strip_tags($row['p_description']), 0, 200) . '...';
            }
        }

        if ($cur_page == 'dashboard.php') {
        ?>
         <title>Dashboard - <?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }
        if ($cur_page == 'customer-profile-update.php') {
        ?>
         <title>Update Profile - <?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }
        if ($cur_page == 'customer-billing-shipping-update.php') {
        ?>
         <title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }
        if ($cur_page == 'customer-password-update.php') {
        ?>
         <title>Update Password - <?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }
        if ($cur_page == 'customer-order.php') {
        ?>
         <title>Orders - <?php echo $meta_title_home; ?></title>
         <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
         <meta name="description" content="<?php echo $meta_description_home; ?>">
     <?php
        }
        ?>

     <?php if ($cur_page == 'blog-single.php'): ?>
         <meta property="og:title" content="<?php echo $og_title; ?>">
         <meta property="og:type" content="website">
         <meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
         <meta property="og:description" content="<?php echo $og_description; ?>">
         <meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
     <?php endif; ?>

     <?php if ($cur_page == 'product.php'): ?>
         <meta property="og:title" content="<?php echo $og_title; ?>">
         <meta property="og:type" content="website">
         <meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
         <meta property="og:description" content="<?php echo $og_description; ?>">
         <meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
     <?php endif; ?>


     <?php echo $before_head; ?>
 </head>

 <body>

     <!-- header start -->
     <header class="main-header" id="stickyheader">
         <div class="header-top-area">
             <div class="container-fluid">
                 <div class="row">
                     <div class="col">
                         <div class="header-area">
                             <div class="header-element header-toggle">
                                 <div class="header-icon-block">
                                     <ul class="shop-element">
                                         <li class="side-wrap toggler-wrap">
                                             <div class="toggler-wrapper">
                                                 <button class="toggler-btn">
                                                     <span class="toggler-icon"><svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                             <line x1="3" y1="12" x2="21" y2="12"></line>
                                                             <line x1="3" y1="6" x2="21" y2="6"></line>
                                                             <line x1="3" y1="18" x2="21" y2="18"></line>
                                                         </svg></span>
                                                 </button>
                                             </div>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                             <div class="header-element header-logo">
                                 <div class="header-theme-logo">
                                     <a href="index.html" class="theme-logo">
                                         <img src="assets/uploads/<?php echo $logo; ?>" class="img-fluid" alt="logo">
                                     </a>
                                 </div>
                             </div>
                             <div class="header-element header-search">
                                 <div class="search-crap">
                                     <div class="search-content">
                                         <div class="search-box">
                                             <form action="search-result.php" method="get" class="search-bar">
                                                 <?php $csrf->echoInputField(); ?>
                                                 <div class="form-search">
                                                     <input type="search" name="search_text" placeholder="<?php echo LANG_VALUE_2; ?>" class="search-input">
                                                     <button type="submit" class="search-btn"><i class="feather-search"></i></button>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="header-element header-icon">
                                 <div class="header-icon-block">
                                     <ul class="shop-element">
                                         <li class="side-wrap search-wrap">
                                             <div class="search-wrapper">
                                                 <a href="#searchmodal" data-bs-toggle="modal">
                                                     <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 24 24">
                                                             <path fill="currentColor" d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9s-9-4.032-9-9s4.032-9 9-9m0 16c3.867 0 7-3.133 7-7s-3.133-7-7-7s-7 3.133-7 7s3.133 7 7 7m8.485.071l2.829 2.828l-1.415 1.415l-2.828-2.829z"></path>
                                                         </svg></span>
                                                 </a>
                                             </div>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                             <div class="header-element header-details">
                                 <div class="header-icon-details">
                                     <ul class="details-ul">
                                         <li class="info-wrap info-headphones">
                                             <div class="info-wrapper">
                                                 <a href="index.html" class="icon"><i class="feather-headphones"></i></a>
                                                 <div class="info-text">
                                                     <span class="label">Hotline Mail</span>
                                                     <a href="tel:+260005002600" class="info-link"><?php echo $contact_email; ?></a>
                                                 </div>
                                             </div>
                                         </li>
                                         <?php
                                            $isLoggedIn = isset($_SESSION['customer']);
                                            $custName = $isLoggedIn ? $_SESSION['customer']['cust_name'] : '';
                                            $accountLink = $isLoggedIn ? 'dashboard.php' : 'login.php';
                                            ?>

                                         <li class="info-wrap info-Login">
                                             <div class="info-wrapper">
                                                 <a href="index.html" class="icon"><i class="feather-user"></i></a>
                                                 <div class="info-text">
                                                     <span class="label">My account</span>
                                                     <a href="<?php echo $accountLink; ?>" class="info-link">
                                                         <?php echo $isLoggedIn ? $custName : 'Login Or Register'; ?>
                                                     </a>
                                                 </div>
                                             </div>
                                         </li>


                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- header-bottam start -->
         <div class="header-bottom-area">
             <div class="container-fluid">
                 <div class="row">
                     <div class="col">
                         <div class="main-block">

                             <div class="side-wrap header-menu">
                                 <div class="mainmenu-content">
                                     <div class="main-wrap">
                                         <ul class="main-menu">
                                             <li class="menu-link">
                                                 <a href="index.html" class="link-title">
                                                     <span class="sp-link-title">Home</span>
                                                 </a>

                                             </li>
                                             <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                 <li class="menu-link">
                                                     <a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category" class="link-title">
                                                         <span class="sp-link-title"><?php echo $row['tcat_name']; ?><span class="header-sale-lable">Sale</span></span>
                                                         <span class="menu-arrow"><i class="fa fa-angle-down"></i></span>
                                                     </a>

                                                     <div class="menu-dropdown menu-mega collapse" id="colection">

                                                         <ul class="ul container p-0">
                                                             <?php
                                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                                                                $statement1->execute(array($row['tcat_id']));
                                                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($result1 as $row1) {
                                                                ?>
                                                                 <li class="menumega-li">
                                                                     <a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category" class="menumega-title">
                                                                         <span class="sp-link-title"><?php echo $row1['mcat_name']; ?></span>
                                                                         <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                                     </a>
                                                                     <div class="menumegasup-dropdown collapse">
                                                                         <ul class="menumegasup-ul">
                                                                             <?php
                                                                                $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                                                                $statement2->execute(array($row1['mcat_id']));
                                                                                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach ($result2 as $row2) {
                                                                                ?>
                                                                                 <li class="menumegasup-li">
                                                                                     <a href="collection-without.html" class="menumegasup-title">
                                                                                         <span class="sp-link-title"><?php echo $row2['ecat_name']; ?></span>
                                                                                     </a>
                                                                                 </li>
                                                                             <?php
                                                                                }
                                                                                ?>

                                                                         </ul>
                                                                     </div>
                                                                 </li>
                                                             <?php
                                                                }
                                                                ?>
                                                         </ul>

                                                     </div>

                                                 </li>
                                             <?php
                                                }
                                                ?>
                                             <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    $about_title = $row['about_title'];
                                                    $faq_title = $row['faq_title'];
                                                    $blog_title = $row['blog_title'];
                                                    $contact_title = $row['contact_title'];
                                                    $pgallery_title = $row['pgallery_title'];
                                                    $vgallery_title = $row['vgallery_title'];
                                                }
                                                ?>


                                             <li class="menu-link"><a class="link-title" href="about.php"> <span class="sp-link-title"><?php echo $about_title; ?></span></a></li>
                                             <li class="menu-link"><a class="link-title" href="faq.php"> <span class="sp-link-title"><?php echo $faq_title; ?></span></a></li>

                                             <li class="menu-link"><a class="link-title" href="contact.php"> <span class="sp-link-title"><?php echo $contact_title; ?></sppan></a></li>

                                         </ul>
                                     </div>
                                 </div>
                             </div>
                             <div class="side-wrap header-icon">
                                 <div class="header-icon-block">
                                     <ul class="shop-element">




                                         <li class="side-wrap cart-wrap">
                                             <div class="cart-wrapper">
                                                 <div class="shopping-cart">
                                                     <a class="add-to-cart" href="cart.php">
                                                         <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 24 24">
                                                                 <path fill="currentColor" d="M6.505 2h11a1 1 0 0 1 .8.4l2.7 3.6v15a1 1 0 0 1-1 1h-16a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4m12.5 6h-14v12h14zm-.5-2l-1.5-2h-10l-1.5 2zm-9.5 4v2a3 3 0 1 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2z"></path>
                                                             </svg></span>
                                                         <?php
                                                            $table_total_price = 0;
                                                            $total_items = 0;

                                                            if (isset($_SESSION['cart_p_id'])) {
                                                                foreach ($_SESSION['cart_p_qty'] as $key => $quantity) {
                                                                    $price = $_SESSION['cart_p_current_price'][$key] ?? 0; // Ensure price exists
                                                                    $table_total_price += $price * $quantity;
                                                                    $total_items += $quantity; // Count total items
                                                                }
                                                            ?>


                                                             <span class="bigcounter"><?php echo $total_items; ?> Items</span>

                                                         <?php   } else { ?>

                                                         <?php
                                                                echo '<span class="bigcounter">0 Items</span>';
                                                            }
                                                            ?>
                                                     </a>
                                                 </div>
                                             </div>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </header>
     <!-- header end -->