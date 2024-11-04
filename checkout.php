<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if (!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>
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
                                <span class="breadcrumb-text"><?php echo LANG_VALUE_22; ?></span>
                            </li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- checkout-area start -->
    <section class="section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php if (!isset($_SESSION['customer'])): ?>
                        <p>
                            <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                        </p>
                    <?php else: ?>
                        <div class="checkout-area">

                            <div class="order-area">
                                <div class="check-pro">
                                    <h2 data-animate="animate__fadeInUp">In your cart (2)</h2>
                                    <ul class="check-ul">
                                        <?php
                                        $table_total_price = 0;

                                        $i = 0;
                                        foreach ($_SESSION['cart_p_id'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_id[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_size_id'] as $key => $value) {
                                            $i++;
                                            $arr_cart_size_id[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_size_name'] as $key => $value) {
                                            $i++;
                                            $arr_cart_size_name[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_color_id'] as $key => $value) {
                                            $i++;
                                            $arr_cart_color_id[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_color_name'] as $key => $value) {
                                            $i++;
                                            $arr_cart_color_name[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_qty[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_current_price[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_p_name'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_name[$i] = $value;
                                        }

                                        $i = 0;
                                        foreach ($_SESSION['cart_p_featured_photo'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_featured_photo[$i] = $value;
                                        }
                                        ?>
                                        <?php for ($i = 1; $i <= count($arr_cart_p_id); $i++): ?>
                                            <li>
                                                <div class="check-pro-img">
                                                    <a href="#" data-animate="animate__fadeInUp">
                                                        <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>"
                                                            class="img-fluid" alt="p-1">
                                                    </a>
                                                </div>
                                                <div class="check-content">
                                                    <a href="#"
                                                        data-animate="animate__fadeInUp"><?php echo $arr_cart_p_name[$i]; ?></a>
                                                    <span class="check-code" data-animate="animate__fadeInUp">
                                                        <span>Size :</span>
                                                        <span><?php echo $arr_cart_size_name[$i]; ?></span>
                                                    </span>
                                                    <span class="check-code" data-animate="animate__fadeInUp">
                                                        <span>Color :</span>
                                                        <span><?php echo $arr_cart_color_name[$i]; ?></span>
                                                    </span>
                                                    <div class="check-qty-pric" data-animate="animate__fadeInUp">
                                                        <span class="check-qty"><?php echo $arr_cart_p_qty[$i]; ?> X</span>
                                                        <span class="check-price">$<?php
                                                        $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                                                        $table_total_price = $table_total_price + $row_total_price;
                                                        ?>
                                                            <?php echo LANG_VALUE_1; ?>         <?php echo $row_total_price; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endfor; ?>

                                    </ul>
                                </div>
                                <h2 data-animate="animate__fadeInUp">Your order</h2>
                                <ul class="order-history">

                                    <li class="order-details" data-animate="animate__fadeInUp">
                                        <span>Subtotal</span>
                                        <span>$<?php echo $table_total_price; ?></span>
                                    </li>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                                    $statement->execute(array($_SESSION['customer']['cust_country']));
                                    $total = $statement->rowCount();
                                    if ($total) {
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $shipping_cost = $row['amount'];
                                        }
                                    } else {
                                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $shipping_cost = $row['amount'];
                                        }
                                    }
                                    ?>
                                    <li class="order-details" data-animate="animate__fadeInUp">
                                        <span>Shipping Charge</span>
                                        <span><?php echo $shipping_cost; ?></span>
                                    </li>
                                    <li class="order-details" data-animate="animate__fadeInUp">
                                        <span>Total</span>
                                        <span><?php
                                        $final_total = $table_total_price + $shipping_cost;
                                        ?>
                                            <?php echo LANG_VALUE_1; ?>     <?php echo $final_total; ?></span>
                                    </li>
                                </ul>

                                <div class="checkout-btn">
                                    <a href="order-complete.html" class="btn-style2 checkout disabled"
                                        data-animate="animate__fadeInUp">Back to Cart</a>

                                </div>

                            </div>
                            <div class="billing-area">
                                <form>
                                    <h2 data-animate="animate__fadeInUp"><?php echo LANG_VALUE_161; ?></h2>
                                    <div class="billing-form">
                                        <ul class="input-2" data-animate="animate__fadeInUp">
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_102; ?></label>
                                                <input readonly type="text" name="f-name"
                                                    value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                            </li>
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_103; ?></label>
                                                <input readonly type="text" name="l-name"
                                                    value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>">
                                            </li>
                                        </ul>
                                        <ul class="billing-ul">
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                <input readonly type="text" name="company details"
                                                    value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Address</label>
                                                <input readonly type="text" name="address"
                                                    value=" <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>">
                                            </li>
                                        </ul>
                                        <ul class="input-2" data-animate="animate__fadeInUp" style="margin-top: 15px">
                                        <li style="margin-top:0" class="billing-li">
                                                <label><?php echo LANG_VALUE_107; ?></label>
                                                <input readonly type="text" name="l-name"
                                                    value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                            </li> 
                                        <li style="margin-top:0" class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Country</label>
                                                <select readonly>
                                                    <option selected> <?php
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                                    $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        echo $row['country_name'];
                                                    }
                                                    ?></option>

                                                </select>
                                            </li>
                                            
                                        </ul>
                                        <ul class="billing-ul">
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                <input readonly type="text" name="company details"
                                                    value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Address</label>
                                                <input readonly type="text" name="address"
                                                    value=" <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>">
                                            </li>


                                        </ul>
                                        <ul class="input-2" data-animate="animate__fadeInUp">
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_108; ?></label>
                                                <input readonly type="text" name="mail" value="<?php echo $_SESSION['customer']['cust_b_state']; ?>">
                                            </li>
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_109; ?></label>
                                                <input readonly type="text" name="phone" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                                <form>
                                    <h2 data-animate="animate__fadeInUp"><?php echo LANG_VALUE_162; ?></h2>
                                    <div class="billing-form">
                                        <ul class="input-2" data-animate="animate__fadeInUp">
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_102; ?></label>
                                                <input readonly type="text" name="f-name"
                                                    value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                            </li>
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_103; ?></label>
                                                <input readonly type="text" name="l-name"
                                                    value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>">
                                            </li>
                                        </ul>
                                        <ul class="billing-ul">
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                <input readonly type="text" name="company details"
                                                    value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Address</label>
                                                <input readonly type="text" name="address"
                                                    value=" <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>">
                                            </li>
                                        </ul>
                                        <ul class="input-2" data-animate="animate__fadeInUp" style="margin-top: 15px">
                                        <li style="margin-top:0" class="billing-li">
                                                <label><?php echo LANG_VALUE_107; ?></label>
                                                <input readonly type="text" name="l-name"
                                                    value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                            </li> 
                                        <li style="margin-top:0" class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Country</label>
                                                <select readonly>
                                                    <option selected> <?php
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                                    $statement->execute(array($_SESSION['customer']['cust_s_country']));
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        echo $row['country_name'];
                                                    }
                                                    ?></option>

                                                </select>
                                            </li>
                                            
                                        </ul>
                                        <ul class="billing-ul">
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label><?php echo LANG_VALUE_104; ?></label>
                                                <input readonly type="text" name="company details"
                                                    value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                            </li>
                                            <li class="billing-li" data-animate="animate__fadeInUp">
                                                <label>Address</label>
                                                <input readonly type="text" name="address"
                                                    value=" <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>">
                                            </li>


                                        </ul>
                                        <ul class="input-2" data-animate="animate__fadeInUp">
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_108; ?></label>
                                                <input readonly type="text" name="mail" value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                                            </li>
                                            <li class="billing-li">
                                                <label><?php echo LANG_VALUE_109; ?></label>
                                                <input readonly type="text" name="phone" value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                               
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section style="margin: 0 0 70px">

            <div class="container">
                <h3 class="special"><?php echo LANG_VALUE_33; ?></h3>
                <div class="row">
                    <?php
                    $checkout_access = 1;
                    if (
                        ($_SESSION['customer']['cust_b_name'] == '') ||
                        ($_SESSION['customer']['cust_b_cname'] == '') ||
                        ($_SESSION['customer']['cust_b_phone'] == '') ||
                        ($_SESSION['customer']['cust_b_country'] == '') ||
                        ($_SESSION['customer']['cust_b_address'] == '') ||
                        ($_SESSION['customer']['cust_b_city'] == '') ||
                        ($_SESSION['customer']['cust_b_state'] == '') ||
                        ($_SESSION['customer']['cust_b_zip'] == '') ||
                        ($_SESSION['customer']['cust_s_name'] == '') ||
                        ($_SESSION['customer']['cust_s_cname'] == '') ||
                        ($_SESSION['customer']['cust_s_phone'] == '') ||
                        ($_SESSION['customer']['cust_s_country'] == '') ||
                        ($_SESSION['customer']['cust_s_address'] == '') ||
                        ($_SESSION['customer']['cust_s_city'] == '') ||
                        ($_SESSION['customer']['cust_s_state'] == '') ||
                        ($_SESSION['customer']['cust_s_zip'] == '')
                    ) {
                        $checkout_access = 0;
                    }
                    ?>
                    <?php if ($checkout_access == 0): ?>
                        <div class="col-12">
                            <div class="alert alert-custom">
                                You must fill out all billing and shipping information in your dashboard before checking out.
                                Please update your information <a href="customer-billing-shipping-update.php"
                                    class="text-danger text-decoration-underline">here</a>.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="row g-3">
                                <!-- Payment Method Selection -->
                                <div class="col-12 form-group py-3">
                                    <label for="paymentMethod"><?php echo LANG_VALUE_34; ?> *</label>
                                    <select name="payment_method" class="form-control select2" id="paymentMethod"
                                        style="margin-top: 15px">
                                        <option value=""><?php echo LANG_VALUE_35; ?></option>
                                        <option value="paypal"><?php echo LANG_VALUE_36; ?></option>
                                        <option value="bank"><?php echo LANG_VALUE_38; ?></option>
                                    </select>
                                </div>

                                <!-- PayPal Form -->
                                <form class="paypal" action="payment/paypal/payment_process.php"
                                    method="post" id="paypalForm" target="_blank" style="display: none;">
                                    <input type="hidden" id="udf5" name="udf5" value="PayUBiz_PHP7_Kit" />				
                                    <input type="text" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,99999999)?>" /></span>
                                    <input type="text" id="firstname" name="firstname" placeholder="First Name" value="" /></span>
                                    <input type="text" id="email" name="email" placeholder="Email ID" value="" /></span>
                                    <input type="hidden" name="amount" value="6.00" >
                                    <input type="text" id="productinfo" name="productinfo" placeholder="Product Info" value="P01,P02" /></span>
                                    <input type="text" id="Pg" name="Pg" placeholder="PG" value="CC" /></span>
                                    <div class="col-12 form-group">
                                        <input type="submit" class="btn btn-primary w-100" value="<?php echo LANG_VALUE_46; ?>"
                                         >
                                    </div>
                                </form>

                                <!-- Bank Form -->
                                <form action="payment/bank/init.php" method="post" id="bankForm" style="display: none;">
                                    <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                    <div class="col-12 form-group">
                                        <label><?php echo LANG_VALUE_43; ?></label><br>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo nl2br($row['bank_detail']);
                                        }
                                        ?>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label><?php echo LANG_VALUE_44; ?> <br><span class="text-muted"
                                                style="font-size:0.9rem;"><?php echo LANG_VALUE_45; ?></span></label>
                                        <textarea name="transaction_info" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="submit" class="btn btn-primary w-100" value="<?php echo LANG_VALUE_46; ?>"
                                            name="form3">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            document.getElementById('paymentMethod').addEventListener('change', function () {
                                var paypalForm = document.getElementById('paypalForm');
                                var bankForm = document.getElementById('bankForm');

                                if (this.value === 'paypal') {
                                    paypalForm.style.display = 'block';
                                    bankForm.style.display = 'none';
                                } else if (this.value === 'bank') {
                                    paypalForm.style.display = 'none';
                                    bankForm.style.display = 'block';
                                } else {
                                    paypalForm.style.display = 'none';
                                    bankForm.style.display = 'none';
                                }
                            });
                        </script>

                    <?php endif; ?>

                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- checkout-area end -->
</main>
<!-- main section end-->
<?php require_once('_footer.php'); ?>