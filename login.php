<?php 
require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>

<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = LANG_VALUE_132.'<br>';
    } else {
        
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total==0) {
            $error_message .= LANG_VALUE_133.'<br>';
        } else {
            //using MD5 form
            if( $row_password != md5($cust_password) ) {
                $error_message .= LANG_VALUE_139.'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;

            // Encode session data to JSON and save it to a file
            $json_data = json_encode($_SESSION['customer']);
            file_put_contents('customer_session_data.json', $json_data);
                    header("location: dashboard.php");
                }
            }
            
        }
    }
}
?>



<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
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
                                        <a class="breadcrumb-link" href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-li">
                                        <span class="breadcrumb-text">Account</span>
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
                            <div class="log-acc" id="CustomerLoginForm">
                                <div class="section-capture">
                                    <div class="section-title">
                                        <h2 data-animate="animate__fadeInUp"><span>Login account</span></h2>
                                    </div>
                                </div>
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
                                        <form method="post" action="">
                                        <?php $csrf->echoInputField(); ?>      
                                            <ul class="form-fill">
                                                <li class="form-fill-li Email" data-animate="animate__fadeInUp">
                                                    <label>Email address</label>
                                                    <input type="email" name="cust_email" autocomplete="email" placeholder="Email address">
                                                </li>
                                                <li class="form-fill-li Password" data-animate="animate__fadeInUp">
                                                    <label>Password</label>
                                                    <input type="password" name="cust_password" placeholder="Password">
                                                </li>
                                            </ul>
                                            <div class="form-action-button" data-animate="animate__fadeInUp">
                                                <div class="button-forget">
                                                    <button type="submit" name="form1" class="btn btn-style2">Sign in</button>
                                                    <a href="forgot-password.php" >Forgot your password?</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="acc-wrapper" data-animate="animate__fadeInUp">
                                        <h6>Not yet register?</h6>
                                        <div class="account-optional">
                                            <a href="registration.php">Create a account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="log-acc" id="RecoverPasswordForm" style="display: none;">
                                <!-- account title start -->
                                <div class="content-main-title">
                                    <div class="section-capture">
                                        <div class="section-title">
                                            <h2><span>Login account</span></h2>
                                        </div>
                                    </div>
                                </div>
                                <!-- account title end -->
                                <!-- account login start -->
                                <div class="log-acc-page">
                                    <div class="contact-form-list">
                                        <form method="post">
                                            <ul class="form-fill">
                                                <li class="form-fill-li Email">
                                                    <label>Email address</label>
                                                    <input type="email" name="cust_email" autocomplete="email" placeholder="Email address">
                                                </li>
                                            </ul>
                                            <div class="form-action-button">
                                                <div class="button-forget">
                                                    <button type="submit" name="form11" class="btn btn-style2">Cancel</button>
                                                    <a href="javascript:void(0)" onclick="myFunction()">Cancel</a>
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
                <script>
                function myFunction() {
                var x = document.getElementById("RecoverPasswordForm");
                var y= document.getElementById("CustomerLoginForm");
                if (x.style.display === "none") {
                x.style.display = "block";
                }
                else {
                x.style.display = "none";
                }
                if (y.style.display === "none") {
                y.style.display = "block";
                }
                else {
                y.style.display = "none";
                }
                }
                </script>
            </section>
            <!-- customer-page end  -->
        </main>
        <!-- main section end-->
        <?php require_once('_footer.php'); ?>