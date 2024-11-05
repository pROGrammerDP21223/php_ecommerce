<?php require_once('_header.php'); ?>

<?php
// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: ' . BASE_URL . 'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123 . "<br>";
    }

    if (empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124 . "<br>";
    }

    if (empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125 . "<br>";
    }

    if (empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126 . "<br>";
    }

    if (empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127 . "<br>";
    }

    if (empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128 . "<br>";
    }

    if (empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129 . "<br>";
    }

    if ($valid == 1) {

        // update data into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_cname=?, cust_phone=?, cust_country=?, cust_address=?, cust_city=?, cust_state=?, cust_zip=? WHERE cust_id=?");
        $statement->execute(array(
            strip_tags($_POST['cust_name']),
            strip_tags($_POST['cust_cname']),
            strip_tags($_POST['cust_phone']),
            strip_tags($_POST['cust_country']),
            strip_tags($_POST['cust_address']),
            strip_tags($_POST['cust_city']),
            strip_tags($_POST['cust_state']),
            strip_tags($_POST['cust_zip']),
            $_SESSION['customer']['cust_id']
        ));

        $success_message = LANG_VALUE_130;

        $_SESSION['customer']['cust_name'] = $_POST['cust_name'];
        $_SESSION['customer']['cust_cname'] = $_POST['cust_cname'];
        $_SESSION['customer']['cust_phone'] = $_POST['cust_phone'];
        $_SESSION['customer']['cust_country'] = $_POST['cust_country'];
        $_SESSION['customer']['cust_address'] = $_POST['cust_address'];
        $_SESSION['customer']['cust_city'] = $_POST['cust_city'];
        $_SESSION['customer']['cust_state'] = $_POST['cust_state'];
        $_SESSION['customer']['cust_zip'] = $_POST['cust_zip'];
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
                                    <h6 data-animate="animate__fadeInUp">Profile</h6>
                                </div>
                                <?php
                                if ($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                                }
                                if ($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                }
                                ?>
                                <form action="" method="post">
                                    <?php $csrf->echoInputField(); ?>

                                    <div class="billing-form">

                                        <ul class="input-2">
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_102; ?> *</label>
                                                <input type="text" name="cust_name"
                                                    value="<?php echo $_SESSION['customer']['cust_name']; ?>"
                                                    placeholder="First name">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_103; ?></label>
                                                <input type="text" name="cust_cname"
                                                    value="<?php echo $_SESSION['customer']['cust_cname']; ?>"
                                                    placeholder="Company name">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_94; ?> *</label>
                                                <input type="text" name=""
                                                    value="<?php echo $_SESSION['customer']['cust_email']; ?>" disabled
                                                    placeholder="Email" style="background-color: #f9f9f9;">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_104; ?> *</label>
                                                <input type="text" name="cust_phone"
                                                    value="<?php echo $_SESSION['customer']['cust_phone']; ?>"
                                                    placeholder="Phone">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_105; ?> *</label>
                                                <textarea name="cust_address" class="form-control" cols="30" rows="10"
                                                    style="height:70px;"
                                                    placeholder="Address"><?php echo $_SESSION['customer']['cust_address']; ?></textarea>
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_106; ?> *</label>
                                                <select name="cust_country" class="form-control">
                                                    <?php
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $_SESSION['customer']['cust_country']) {
                                                               echo 'selected';
                                                           } ?>><?php echo $row['country_name']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_107; ?> *</label>
                                                <input type="text" name="cust_city"
                                                    value="<?php echo $_SESSION['customer']['cust_city']; ?>"
                                                    placeholder="City">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_108; ?> *</label>
                                                <input type="text" name="cust_state"
                                                    value="<?php echo $_SESSION['customer']['cust_state']; ?>"
                                                    placeholder="State">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_109; ?> *</label>
                                                <input type="text" name="cust_zip"
                                                    value="<?php echo $_SESSION['customer']['cust_zip']; ?>"
                                                    placeholder="Zip Code">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <input type="submit" class="btn btn-primary text-white"
                                                    value="<?php echo LANG_VALUE_5; ?>" name="form1">
                                            </li>
                                        </ul>

                                    </div>
                                </form>
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