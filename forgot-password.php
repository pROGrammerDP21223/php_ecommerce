<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
}
?>

<?php
if(isset($_POST['form1'])) {

    $valid = 1;
        
    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."\\n";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."\\n";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                        
            if(!$total) {
                $valid = 0;
                $error_message .= LANG_VALUE_135."\\n";
            }
        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $forget_password_message = $row['forget_password_message'];
        }

        $token = md5(rand());
        $now = time();

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?,cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array($token,$now,strip_tags($_POST['cust_email'])));
        
        $message = '<p>'.LANG_VALUE_142.'<br> <a href="'.BASE_URL.'reset-password.php?email='.$_POST['cust_email'].'&token='.$token.'">Click here</a>';
        
        $to      = $_POST['cust_email'];
        $subject = LANG_VALUE_143;
        $headers = "From: noreply@" . BASE_URL . "\r\n" .
                   "Reply-To: noreply@" . BASE_URL . "\r\n" .
                   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($to, $subject, $message, $headers);

        $success_message = $forget_password_message;
    }
}
?>


        <main>
            <!-- breadcrumb start -->
            <section class="breadcrumb-area">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="breadcrumb-index">
                                <!-- breadcrumb-list start -->
                                <ul class="breadcrumb-ul">
                                    <li class="breadcrumb-li">
                                        <a class="breadcrumb-link" href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-li">
                                        <span class="breadcrumb-text">Reset Password</span>
                                    </li>
                                </ul>
                                <!-- breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb end -->
            <!-- customer-page start -->
            <section class="customer-page section-ptb">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <!-- account login title start -->
                       
                            <div class="log-acc" id="RecoverPasswordForm" style="display: block;">
                                <!-- account title start -->
                                <div class="content-main-title">
                                    <div class="section-capture">
                                        <div class="section-title">
                                            <h2><span>Forgot Password</span></h2>
                                        </div>
                                    </div>
                                </div>
                                <!-- account title end -->
                                <!-- account login start -->
                                <div class="log-acc-page">
                                    <div class="contact-form-list">
                                        <form method="post" action="">
                                        <?php $csrf->echoInputField(); ?>
                                            <ul class="form-fill">
                                                <li class="form-fill-li Email">
                                                    <label>Email address</label>
                                                    <input type="email" name="cust_email" autocomplete="email" placeholder="Email address">
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
                            <!-- account login start -->
                        </div>
                    </div>
                </div>
               
            </section>
            <!-- customer-page end  -->
        </main>
        <!-- main section end-->
        <?php require_once('_footer.php'); ?>