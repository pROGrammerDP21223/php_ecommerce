
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

<html>
<head>
    <style>
        .path {
            fill: transparent;
            stroke: #fff;
            stroke-width: 2;
            stroke-dasharray: 25;
            stroke-dashoffset: 0;
            stroke-linecap: round;
            stroke-linejoin: round;
            animation: animate 1s cubic-bezier(0, 0, 0.32, -0.13) infinite
        }
        @keyframes animate {
            from {
                stroke-dashoffset: 26
            }
            to {
                stroke-dashoffset: 0
            }
        }
        .box {
            margin-right: auto;
            margin-left: auto;
            border: 1px solid #bfbfbf;
            width: 50%;
            box-shadow: 0 0 10px #bfbfbf;
        }
        @media (max-width:768px) {
            .box {
                width: 100%;
            }
        }
    </style>
</head>

<?php
                        if ($status == 'success' && $resphash == $CalcHashString) {
                            $msg = "Transaction Successful, Hash Verified...<br />";
                            // Do success order processing here...
                            // Additional step - Use verify payment API to double-check payment.
                            if (verifyPayment($key, $salt, $txnid, $status)) {
                        ?>
<body style="display: flex; align-items: center; justify-content: center; height: 95vh;">
    <div class="row justify-content-center box">
        <div
            style="background-color: #fffefa; color: #183d3d; font-family: \'Poppins\', sans-serif; margin: 20px; text-align: center;">
            <div style="text-align: center; padding: 25px 0;">
                <div
                    style="background: #53bf8b; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                    <svg class="svg" width="85px" version="1.1" id="tick" viewBox="6 5 26 26">
                        <polyline class="path" points="11.6,20 15.9,24.2 26.4,13.8 " />
                    </svg>
                </div>
            </div>
            <div class="thank-you-message">
                <h1>Thank You for Your Order!</h1>
                <p class="thank-you-subtext">Your order status will be updated in a few hours...</p>
                <p> <a href="/customer-order.php" style="color: #503f12;
            text-decoration: underline;" class="thank-you-link">Click Here </a> To Check Order Status...</p>
            </div>
        </div>
    </div>
</body>
<?php
                            } else {
                        ?>

<body style="display: flex; align-items: center; justify-content: center; height: 95vh;">
    <div class="row justify-content-center box">
        <div
            style="background-color: #fffefa; color: #183d3d; font-family: \'Poppins\', sans-serif; margin: 20px; text-align: center;">
            <div style="text-align: center; padding: 25px 0;">
                <div
                    style="background: #DE524C; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                    <svg class="svg22" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 72 72"
                        style="enable-background:new 0 0 72 72;" xml:space="preserve">
                       
                        <g>
                            <circle class="circle-stroke" cx="36" cy="36" r="32" />
                            <circle class="circle-fill" cx="36" cy="36" r="32" />
                        </g>
                        <g>
                            <line class="cross" x1="27.4" y1="44.6" x2="44.6" y2="27.4" />
                            <line class="cross" x1="27.4" y1="27.4" x2="44.6" y2="44.6" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="thank-you-message">
                <h1>Transaction Failed...</h1>
                <p class="thank-you-subtext">Your order status will be updated in a few hours...</p>
                <p> <a href="/customer-order.php" style="color: #503f12;
            text-decoration: underline;" class="thank-you-link">Click Here </a> To Check Order Status...</p>
            </div>
        </div>
    </div>
</body>
<?php
                            }
                        } else {
                        ?>
                        <body style="display: flex; align-items: center; justify-content: center; height: 95vh;">
    <div class="row justify-content-center box">
        <div
            style="background-color: #fffefa; color: #183d3d; font-family: \'Poppins\', sans-serif; margin: 20px; text-align: center;">
            <div style="text-align: center; padding: 25px 0;">
                <div
                    style="background: #DE524C; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                    <svg class="svg22" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 72 72"
                        style="enable-background:new 0 0 72 72;" xml:space="preserve">
                       
                        <g>
                            <circle class="circle-stroke" cx="36" cy="36" r="32" />
                            <circle class="circle-fill" cx="36" cy="36" r="32" />
                        </g>
                        <g>
                            <line class="cross" x1="27.4" y1="44.6" x2="44.6" y2="27.4" />
                            <line class="cross" x1="27.4" y1="27.4" x2="44.6" y2="44.6" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="thank-you-message">
                <h1>Transaction Failed...</h1>
                <p class="thank-you-subtext">Your order status will be updated in a few hours...</p>
                <p> <a href="/customer-order.php" style="color: #503f12;
            text-decoration: underline;" class="thank-you-link">Click Here </a> To Check Order Status...</p>
            </div>
        </div>
    </div>
</body>
<?php
                        }
                        ?>



<style>
     .circle-fill {
                                fill: #DE524C;
                            }
                            .circle-stroke {
                                fill: none;
                                stroke: #DE524C;
                                stroke-width: 5;
                                stroke-miterlimit: 10;
                            }
                            .cross {
                                fill: none;
                                stroke: #FFFFFF;
                                stroke-width: 5;
                                stroke-linecap: round;
                                stroke-miterlimit: 10;
                            }
   
    .bg-logo {
        opacity: 1;
        animation: 1s bg-animation forwards infinite;
        animation-delay: 0.5s;
    }
    @keyframes bg-animation {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
    .logo {
        opacity: 1;
        stroke-dasharray: 180;
        stroke-dashoffset: 180;
        animation: 1s logo-animation forwards;
    }
    @keyframes logo-animation {
        0% {
            opacity: 1;
            stroke-dashoffset: 180;
        }
        100% {
            opacity: 0;
            stroke-dashoffset: 0;
        }
    }
    .circle-stroke {
        opacity: 0;
        stroke-dasharray: 210;
        stroke-dashoffset: 0;
        animation: 1.5s stroke-animation forwards;
        animation-delay: 0.8s;
    }
    @keyframes stroke-animation {
        0% {
            opacity: 0;
            stroke-dashoffset: 210;
        }
        100% {
            opacity: 1;
            stroke-dashoffset: 0;
        }
    }
    .circle-fill {
        opacity: 0;
        animation: 3s fill-animation forwards;
        animation-delay: 1s;
    }
    @keyframes fill-animation {
        0% {
            opacity: 0;
        }
        80% {
            opacity: 1;
        }
        100% {
            opacity: 1;
        }
    }
    .cross {
        opacity: 1;
        stroke-dasharray: 180;
        stroke-dashoffset: 180;
        animation: 2s cross-animation forwards infinite;
        animation-delay: 2s;
    }
    @keyframes cross-animation {
        0% {
            stroke-dashoffset: 180;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }
</style>
</html>t