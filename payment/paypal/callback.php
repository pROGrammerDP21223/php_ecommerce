<?php
// Define PhonePe gateway information
$gateway = (object) [
    'token' => 'PGTESTPAYUAT',
    'secret_key' => '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399',
];

// Extract transaction ID from POST data
$orderId = $_POST['transactionId'];

// Construct X-VERIFY header for status check
$encodeIn265 = hash('sha256', '/pg/v1/status/' . $gateway->token . '/' . $orderId . $gateway->secret_key) . '###1';

// Set headers for the status check request
$headers = [
    'Content-Type: application/json',
    'X-MERCHANT-ID: ' . $gateway->token,
    'X-VERIFY: ' . $encodeIn265,
    'Accept: application/json',
];

// Define PhonePe status check URL
$phonePeStatusUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Development
// $phonePeStatusUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Production

// Initialize cURL for status check
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $phonePeStatusUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode the status check response
$api_response = json_decode($response);

// Check if the payment was successful
if ($api_response->code == "PAYMENT_SUCCESS") {
    // Insert payment details into your database
   
    echo "Thank you for your payment. We will contact you shortly!";
} else {
    // Handle failed transactions
    echo "Transaction Failed";
}
?>