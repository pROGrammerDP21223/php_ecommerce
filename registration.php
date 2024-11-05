<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129."<br>";
    }

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

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_cname,
                                        cust_email,
                                        cust_phone,
                                        cust_country,
                                        cust_address,
                                        cust_city,
                                        cust_state,
                                        cust_zip,
                                        cust_b_name,
                                        cust_b_cname,
                                        cust_b_phone,
                                        cust_b_country,
                                        cust_b_address,
                                        cust_b_city,
                                        cust_b_state,
                                        cust_b_zip,
                                        cust_s_name,
                                        cust_s_cname,
                                        cust_s_phone,
                                        cust_s_country,
                                        cust_s_address,
                                        cust_s_city,
                                        cust_s_state,
                                        cust_s_zip,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
                                        strip_tags($_POST['cust_name']),
                                        strip_tags($_POST['cust_cname']),
                                        strip_tags($_POST['cust_email']),
                                        strip_tags($_POST['cust_phone']),
                                        strip_tags($_POST['cust_country']),
                                        strip_tags($_POST['cust_address']),
                                        strip_tags($_POST['cust_city']),
                                        strip_tags($_POST['cust_state']),
                                        strip_tags($_POST['cust_zip']),
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        md5($_POST['cust_password']),
                                        $token,
                                        $cust_datetime,
                                        $cust_timestamp,
                                        0
                                    ));

        // Send email for confirmation of the account
        $to = $_POST['cust_email'];
        
        $subject = LANG_VALUE_150;
        $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
        $message = '
'.LANG_VALUE_151.'<br><br>

<a href="'.$verify_link.'">'.$verify_link.'</a>';

        $headers = "From: noreply@" . BASE_URL . "\r\n" .
                   "Reply-To: noreply@" . BASE_URL . "\r\n" .
                   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        // Sending Email
        mail($to, $subject, $message, $headers);

        unset($_POST['cust_name']);
        unset($_POST['cust_cname']);
        unset($_POST['cust_email']);
        unset($_POST['cust_phone']);
        unset($_POST['cust_address']);
        unset($_POST['cust_city']);
        unset($_POST['cust_state']);
        unset($_POST['cust_zip']);

        $success_message = LANG_VALUE_152;
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
                                        <h2 data-animate="animate__fadeInUp"><span>Register account</span></h2>
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
                                            <li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_102; ?> *</label>
    <input type="text" name="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>" placeholder="<?php echo LANG_VALUE_102; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_103; ?></label>
    <input type="text" name="cust_cname" value="<?php if(isset($_POST['cust_cname'])){echo $_POST['cust_cname'];} ?>" placeholder="<?php echo LANG_VALUE_103; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_94; ?> *</label>
    <input type="email" name="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>" placeholder="Email address" autocomplete="email">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_104; ?> *</label>
    <input type="text" name="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>" placeholder="<?php echo LANG_VALUE_104; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_105; ?> *</label>
    <textarea name="cust_address" cols="30" rows="10" style="height:70px;" placeholder="<?php echo LANG_VALUE_105; ?>"><?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?></textarea>
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_106; ?> *</label>
    <select name="cust_country" class="form-control select2">
        <option value="">Select country</option>
        <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            ?>
            <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
            <?php
        }
        ?>
    </select>
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_107; ?> *</label>
    <input type="text" name="cust_city" value="<?php if(isset($_POST['cust_city'])){echo $_POST['cust_city'];} ?>" placeholder="<?php echo LANG_VALUE_107; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_108; ?> *</label>
    <input type="text" name="cust_state" value="<?php if(isset($_POST['cust_state'])){echo $_POST['cust_state'];} ?>" placeholder="<?php echo LANG_VALUE_108; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_109; ?> *</label>
    <input type="text" name="cust_zip" value="<?php if(isset($_POST['cust_zip'])){echo $_POST['cust_zip'];} ?>" placeholder="<?php echo LANG_VALUE_109; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_96; ?> *</label>
    <input type="password" name="cust_password" placeholder="<?php echo LANG_VALUE_96; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label><?php echo LANG_VALUE_98; ?> *</label>
    <input type="password" name="cust_re_password" placeholder="<?php echo LANG_VALUE_98; ?>">
</li>

<li class="form-fill-li" data-animate="animate__fadeInUp">
    <label></label>
    <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_15; ?>" name="form1">
</li>

                                            </ul>
                                           
                                        </form>
                                    </div>
                                    <div class="acc-wrapper" data-animate="animate__fadeInUp">
                                        <h6>Already have account?</h6>
                                        <div class="account-optional">
                                            <a href="login.php">Login account</a>
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