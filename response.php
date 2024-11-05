<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}



$file_path = 'payment/payu/customer_session_data.json';

if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);

    // Decode the JSON data into an associative array
    $session_data = json_decode($json_data, true);
    $_SESSION['customer'] = [];

    foreach ($session_data as $key => $value) {
        $_SESSION['customer'][$key] = $value; // Store in the 'customer' sub-array
    }

    // Delete the file after storing data in the session
    unlink($file_path);
}

$postdata = $_POST;
$msg = '';
$salt = "UkojH5TS"; // Salt already saved in session during initial request.

if (isset($postdata['key'])) {
    $key = $postdata['key'];
    $txnid = $postdata['txnid'];
    $amount = $postdata['amount'];
    $productInfo = $postdata['productinfo'];
    $firstname = $postdata['firstname'];
    $email = $postdata['email'];
    $udf5 = $postdata['udf5'];
    $status = $postdata['status'];
    $resphash = $postdata['hash'];

    // Calculate response hash to verify
    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||' . $udf5 . '|||||';
    $keyArray = explode("|", $keyString);
    $reverseKeyArray = array_reverse($keyArray);
    $reverseKeyString = implode("|", $reverseKeyArray);
    $CalcHashString = strtolower(hash('sha512', $salt . '|' . $status . '|' . $reverseKeyString)); // Hash without additional charges

    // Check for presence of additionalcharges parameter in response
    $additionalCharges = "";
    if (isset($postdata["additionalCharges"])) {
        $additionalCharges = $postdata["additionalCharges"];
        // Hash with additional charges
        $CalcHashString = strtolower(hash('sha512', $additionalCharges . '|' . $salt . '|' . $status . '|' . $reverseKeyString));
    }

    // Compare status and hash. Hash verification is mandatory
    if ($status == 'success' && $resphash == $CalcHashString) {
        $msg = "Transaction Successful, Hash Verified...<br />";
        // Do success order processing here...
        // Additional step - Use verify payment API to double-check payment
        if (verifyPayment($key, $salt, $txnid, $status)) {
            $msg = "Transaction Successful, Hash Verified...Payment Verified...";
        } else {
            $msg = "Transaction Successful, Hash Verified...Payment Verification failed...";
        }
    } else {
        // Tampered or failed
        $msg = "Payment failed for Hash not verified...";
    }
} else {
    header("Location: index.php"); // Change 'index.php' to your actual homepage URL
    exit(); // Always exit after a header redirect
}

// This function is used to double-check payment
function verifyPayment($key, $salt, $txnid, $status)
{
    $command = "verify_payment"; // Mandatory parameter
    $hash_str = $key . '|' . $command . '|' . $txnid . '|' . $salt;
    $hash = strtolower(hash('sha512', $hash_str)); // Generate hash for verify payment request

    $r = array('key' => $key, 'hash' => $hash, 'var1' => $txnid, 'command' => $command);
    $qs = http_build_query($r);
    // For production
    //$wsUrl = "https://info.payu.in/merchant/postservice.php?form=2";
    
    // For test
    $wsUrl = "https://test.payu.in/merchant/postservice.php?form=2";

    try {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSLVERSION, 6); // TLS 1.2 mandatory
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new Exception($sad);
        }
        curl_close($c);

        $response = json_decode($o, true);

        if (isset($response['status'])) {
            // Response is in Json format. Use the transaction details part for status
            $response = $response['transaction_details'];
            $response = $response[$txnid];

            if ($response['status'] == $status) { // Payment response status and verify status matched
                return true;
            }
        }
        return false;
    } catch (Exception $e) {
        return false;
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
                                <span class="breadcrumb-text">Order Status</span>
                            </li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- order-complete start -->
    <section class="order-complete section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="order-area">
                        <?php
                        if ($status == 'success' && $resphash == $CalcHashString) {
                            $msg = "Transaction Successful, Hash Verified...<br />";
                            // Do success order processing here...
                            // Additional step - Use verify payment API to double-check payment.
                            if (verifyPayment($key, $salt, $txnid, $status)) {
                        ?>
                                <div class="order-details">
                                    <span class="text-success order-i" data-animate="animate__fadeInUp"><i class="fa fa-check-circle"></i></span>
                                    <h6 data-animate="animate__fadeInUp">Thank you for your order</h6>
                                    <span class="order-s" data-animate="animate__fadeInUp">Your order status will be updated in a few hours</span>
                                    <a href="track-page.html" class="tracking-link btn btn-style2" data-animate="animate__fadeInUp">Click Here To Check Order Status...</a>
                                </div>
                        <?php
                            } else {
                        ?>
                                <div class="order-details">
                                    <span class="text-danger order-i" data-animate="animate__fadeInUp"><i class="fa fa-times-circle"></i></span>
                                    <h6 data-animate="animate__fadeInUp">Transaction Failed...</h6>
                                    <span class="order-s" data-animate="animate__fadeInUp">Your order status will be updated in a few hours</span>
                                    <a href="track-page.html" class="tracking-link btn btn-style2" data-animate="animate__fadeInUp">Click Here To Check Order Status...</a>
                                </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="order-details">
                                <span class="text-danger order-i" data-animate="animate__fadeInUp"><i class="fa fa-times-circle"></i></span>
                                <h6 data-animate="animate__fadeInUp">Transaction Failed...</h6>
                                <span class="order-s" data-animate="animate__fadeInUp">Your order status will be updated in a few hours</span>
                                <a href="track-page.html" class="tracking-link btn btn-style2" data-animate="animate__fadeInUp">Click Here To Check Order Status...</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order-complete end -->
</main>
<!-- main section end-->
<!-- footer start -->
<?php require_once('_footer.php'); ?>
