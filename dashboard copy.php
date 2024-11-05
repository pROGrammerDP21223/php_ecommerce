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


    // update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET 
                            cust_b_name=?, 
                            cust_b_cname=?, 
                            cust_b_phone=?, 
                            cust_b_country=?, 
                            cust_b_address=?, 
                            cust_b_city=?, 
                            cust_b_state=?, 
                            cust_b_zip=?,
                            cust_s_name=?, 
                            cust_s_cname=?, 
                            cust_s_phone=?, 
                            cust_s_country=?, 
                            cust_s_address=?, 
                            cust_s_city=?, 
                            cust_s_state=?, 
                            cust_s_zip=? 

                            WHERE cust_id=?");
    $statement->execute(array(
        strip_tags($_POST['cust_b_name']),
        strip_tags($_POST['cust_b_cname']),
        strip_tags($_POST['cust_b_phone']),
        strip_tags($_POST['cust_b_country']),
        strip_tags($_POST['cust_b_address']),
        strip_tags($_POST['cust_b_city']),
        strip_tags($_POST['cust_b_state']),
        strip_tags($_POST['cust_b_zip']),
        strip_tags($_POST['cust_s_name']),
        strip_tags($_POST['cust_s_cname']),
        strip_tags($_POST['cust_s_phone']),
        strip_tags($_POST['cust_s_country']),
        strip_tags($_POST['cust_s_address']),
        strip_tags($_POST['cust_s_city']),
        strip_tags($_POST['cust_s_state']),
        strip_tags($_POST['cust_s_zip']),
        $_SESSION['customer']['cust_id']
    ));

    $success_message = LANG_VALUE_122;

    $_SESSION['customer']['cust_b_name'] = strip_tags($_POST['cust_b_name']);
    $_SESSION['customer']['cust_b_cname'] = strip_tags($_POST['cust_b_cname']);
    $_SESSION['customer']['cust_b_phone'] = strip_tags($_POST['cust_b_phone']);
    $_SESSION['customer']['cust_b_country'] = strip_tags($_POST['cust_b_country']);
    $_SESSION['customer']['cust_b_address'] = strip_tags($_POST['cust_b_address']);
    $_SESSION['customer']['cust_b_city'] = strip_tags($_POST['cust_b_city']);
    $_SESSION['customer']['cust_b_state'] = strip_tags($_POST['cust_b_state']);
    $_SESSION['customer']['cust_b_zip'] = strip_tags($_POST['cust_b_zip']);
    $_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
    $_SESSION['customer']['cust_s_cname'] = strip_tags($_POST['cust_s_cname']);
    $_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
    $_SESSION['customer']['cust_s_country'] = strip_tags($_POST['cust_s_country']);
    $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
    $_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);
    $_SESSION['customer']['cust_s_state'] = strip_tags($_POST['cust_s_state']);
    $_SESSION['customer']['cust_s_zip'] = strip_tags($_POST['cust_s_zip']);

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
                                        <?php echo $_SESSION['customer']['cust_name']; ?>
                                    </h6>
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

                                <div class="row">
                                    <div class="billing-area">

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
                                            <div class="row">


                                                <div class="billing-title col-md-6">
                                                    <h6 data-animate="animate__fadeInUp">Billing address</h6>
                                                    <div class="billing-address-1">
                                                        <ul class="add-name">
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_102; ?></label>
                                                                <input type="text" name="cust_b_name"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_name']; ?>"
                                                                    placeholder="Business Name">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_103; ?></label>
                                                                <input type="text" name="cust_b_cname"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>"
                                                                    placeholder="Business Contact Name">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                                <input type="text" name="cust_b_phone"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>"
                                                                    placeholder="Business Phone">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_106; ?></label>
                                                                <select name="cust_b_country" class="form-control">
                                                                    <?php
                                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result as $row) {
                                                                        ?>
                                                                        <option value="<?php echo $row['country_id']; ?>"
                                                                            <?php if ($row['country_id'] == $_SESSION['customer']['cust_b_country']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $row['country_name']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_105; ?></label>
                                                                <textarea name="cust_b_address" class="form-control"
                                                                    cols="30" rows="10" style="height:100px;"
                                                                    placeholder="Business Address"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_107; ?></label>
                                                                <input type="text" name="cust_b_city"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_city']; ?>"
                                                                    placeholder="City">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_108; ?></label>
                                                                <input type="text" name="cust_b_state"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_state']; ?>"
                                                                    placeholder="State">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_109; ?></label>
                                                                <input type="text" name="cust_b_zip"
                                                                    value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>"
                                                                    placeholder="Zip Code">
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="billing-title col-md-6">
                                                    <h6 data-animate="animate__fadeInUp">Shipping address</h6>
                                                    <div class="billing-address-1">
                                                        <ul class="add-name">
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_102; ?></label>
                                                                <input type="text" name="cust_s_name"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_name']; ?>"
                                                                    placeholder="Shipping Name">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_103; ?></label>
                                                                <input type="text" name="cust_s_cname"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>"
                                                                    placeholder="Shipping Contact Name">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                                <input type="text" name="cust_s_phone"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>"
                                                                    placeholder="Shipping Phone">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_106; ?></label>
                                                                <select name="cust_s_country" class="form-control">
                                                                    <?php
                                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result as $row) {
                                                                        ?>
                                                                        <option value="<?php echo $row['country_id']; ?>"
                                                                            <?php if ($row['country_id'] == $_SESSION['customer']['cust_s_country']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $row['country_name']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_105; ?></label>
                                                                <textarea name="cust_s_address" class="form-control"
                                                                    cols="30" rows="10" style="height:100px;"
                                                                    placeholder="Shipping Address"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_107; ?></label>
                                                                <input type="text" name="cust_s_city"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_city']; ?>"
                                                                    placeholder="City">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_108; ?></label>
                                                                <input type="text" name="cust_s_state"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_state']; ?>"
                                                                    placeholder="State">
                                                            </li>
                                                            <li class="billing-name" data-animate="animate__fadeInUp">
                                                                <label><?php echo LANG_VALUE_109; ?></label>
                                                                <input type="text" name="cust_s_zip"
                                                                    value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>"
                                                                    placeholder="Zip Code">
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>

                                            </div>
                                            <!-- button start -->
                                            <div class="billing-button justify-content-center"
                                                data-animate="animate__fadeInUp">
                                                <button type="submit" name="form1"
                                                    class="btn btn-style2">Update</button>

                                            </div>
                                            <!-- button end -->
                                    </div>
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