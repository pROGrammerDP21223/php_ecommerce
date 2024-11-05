<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_reset_password = $row['banner_reset_password'];
}
?>

<?php
if( !isset($_GET['email']) || !isset($_GET['token']) )
{
    header('location: login.php');
    exit;
}

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=? AND cust_token=?");
$statement->execute(array($_GET['email'],$_GET['token']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$tot = $statement->rowCount();
if($tot == 0)
{
    header('location: login.php');
    exit;
}
foreach ($result as $row) {
    $saved_time = $row['cust_timestamp'];
}

$error_message2 = '';
if(time() - $saved_time > 86400)
{
    $error_message2 = LANG_VALUE_144;
}

if(isset($_POST['form1'])) {

    $valid = 1;
    
    if( empty($_POST['cust_new_password']) || empty($_POST['cust_re_password']) )
    {
        $valid = 0;
        $error_message .= LANG_VALUE_140.'\\n';
    }
    else
    {
        if($_POST['cust_new_password'] != $_POST['cust_re_password'])
        {
            $valid = 0;
            $error_message .= LANG_VALUE_139.'\\n';
        }
    }   

    if($valid == 1) {

        $cust_new_password = strip_tags($_POST['cust_new_password']);
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=?, cust_token=?, cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array(md5($cust_new_password),'','',$_GET['email']));
        
        header('location: reset-password-success.php');
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
                                            <h2><span>Reset Password</span></h2>
                                        </div>
                                    </div>
                                </div>
                                <?php
                    if($error_message != '') {
                        echo "<script>alert('".$error_message."')</script>";
                    }
                    ?>
                    <?php if($error_message2 != ''): ?>
                        <div class="error"><?php echo $error_message2; ?></div>
                    <?php else: ?>
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
                                        <?php endif; ?>
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