<?php require_once('_header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }
    
    if($valid == 1) {

        // update data into the database

        $password = strip_tags($_POST['cust_password']);
        
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(md5($password),$_SESSION['customer']['cust_id']));
        
        $_SESSION['customer']['cust_password'] = md5($password);        

        $success_message = LANG_VALUE_141;
    }
}
?>
<!-- main section start-->
<main>
    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="breadcrumb-index">
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="index.php">Home</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">profile</span>
                            </li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!--profile start -->
    <section class="pro-address-area section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="password-block">
                        <!-- order profile start -->
                        <div class="profile-info">
                            <div class="account-profile">

                                <div class="profile-text">
                                    <h6 data-animate="animate__fadeInUp">
                                        <?php echo $_SESSION['customer']['cust_name']; ?></h6>
                                    <span
                                        data-animate="animate__fadeInUp"><?php echo $_SESSION['customer']['cust_email']; ?></span>
                                </div>
                            </div>
                            <div class="account-detail">
                                <?php require_once('customer-sidebar.php'); ?>
                            </div>
                        </div>
                        <!-- order profile end -->
                        <!-- order info start -->
                        <div class="profile-form profile-address">
                            <div class="billing-area">

                                <div class="pro-add-title">
                                    <h6 data-animate="animate__fadeInUp">Update Password</h6>
                                </div>
                                <div class="log-acc" id="RecoverPasswordForm" style="display: block;">
                                <!-- account title start -->
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="log-acc-page">
                                    <div class="contact-form-list">
                                    <form action="" method="post">
                                    <?php $csrf->echoInputField(); ?>
                                            <ul class="form-fill">
                                                <li class="form-fill-li Email">
                                                    <label><?php echo LANG_VALUE_100; ?></label>
                                                    <input type="password" name="cust_new_password" autocomplete="email" placeholder="<?php echo LANG_VALUE_100; ?>">
                                                </li>
                                                <li class="form-fill-li Email">
                                                    <label><?php echo LANG_VALUE_101; ?></label>
                                                    <input type="password" name="cust_re_password" autocomplete="email" placeholder="<?php echo LANG_VALUE_101; ?>">
                                                </li>
                                            </ul>
                                            <div class="form-action-button">
                                                <div class="button-forget">
                                                    <button type="submit" name="form1" class="btn btn-style2">Submit</button>
                                                    <a href="login.php" >Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                <!-- account login end -->
                            </div>
                            </div>
                        </div>
                        <!-- order info end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- profile end -->
</main>
<!-- main section end-->
<?php require_once('_footer.php'); ?>