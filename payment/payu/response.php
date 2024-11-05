<?php
session_start();
$file_path = 'customer_session_data.json';

if (file_exists($file_path)) {
    $json_data = file_get_contents($file_path);
    $session_data = json_decode($json_data, true);
    $_SESSION['customer'] = $session_data ?: []; // Fallback to empty array if decode fails
    unlink($file_path);
}


$postdata = $_POST;
$msg = '';
$salt = "UkojH5TS"; //Salt already saved in session during initial request.

if (isset($postdata ['key'])) {
	$key				=   $postdata['key'];
	$txnid 				= 	$postdata['txnid'];
    $amount      		= 	$postdata['amount'];
	$productInfo  		= 	$postdata['productinfo'];
	$firstname    		= 	$postdata['firstname'];
	$email        		=	$postdata['email'];
	$udf5				=   $postdata['udf5'];	
	$status				= 	$postdata['status'];
	$resphash			= 	$postdata['hash'];
	//Calculate response hash to verify	
	$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
	$keyArray 	  		= 	explode("|",$keyString);
	$reverseKeyArray 	= 	array_reverse($keyArray);
	$reverseKeyString	=	implode("|",$reverseKeyArray);
	$CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString)); //hash without additionalcharges
	
	//check for presence of additionalcharges parameter in response.
	$additionalCharges  = 	"";
	
	If (isset($postdata["additionalCharges"])) {
       $additionalCharges=$postdata["additionalCharges"];
	   //hash with additionalcharges
	   $CalcHashString 	= 	strtolower(hash('sha512', $additionalCharges.'|'.$salt.'|'.$status.'|'.$reverseKeyString));
	}
	//Comapre status and hash. Hash verification is mandatory.
	if ($status == 'success'  && $resphash == $CalcHashString) {
		$msg = "Transaction Successful, Hash Verified...<br />";
		//Do success order processing here...
		//Additional step - Use verify payment api to double check payment.
		if(verifyPayment($key,$salt,$txnid,$status))
        echo renderMessage("Transaction Successful", "Thank You for Your Order!", true);
		else
		echo renderMessage("Verification Failed", "Your transaction could not be verified.", false);
	}
	else {
		//tampered or failed
        echo renderMessage("Verification Failed", "Your transaction could not be verified.", false);
	} 
}
else exit(0);


//This function is used to double check payment
function verifyPayment($key,$salt,$txnid,$status)
{
	$command = "verify_payment"; //mandatory parameter
	
	$hash_str = $key  . '|' . $command . '|' . $txnid . '|' . $salt ;
	$hash = strtolower(hash('sha512', $hash_str)); //generate hash for verify payment request

    $r = array('key' => $key , 'hash' =>$hash , 'var1' => $txnid, 'command' => $command);
	    
    $qs= http_build_query($r);
	//for production
    //$wsUrl = "https://info.payu.in/merchant/postservice.php?form=2";
   
	//for test
	$wsUrl = "https://test.payu.in/merchant/postservice.php?form=2";
	
	try 
	{		
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $wsUrl);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_SSLVERSION, 6); //TLS 1.2 mandatory
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		$o = curl_exec($c);
		if (curl_errno($c)) {
			$sad = curl_error($c);
			throw new Exception($sad);
		}
		curl_close($c);
		
		
		$response = json_decode($o,true);
		
		if(isset($response['status']))
		{
			// response is in Json format. Use the transaction_detailspart for status
			$response = $response['transaction_details'];
			$response = $response[$txnid];
			
			if($response['status'] == $status) //payment response status and verify status matched
				return true;
			else
				return false;
		}
		else {
			return false;
		}
	}
	catch (Exception $e){
		return false;	
	}
}

function renderMessage($title, $message, $success)
{
    $bgColor = $success ? "#53bf8b" : "#DE524C";
    $icon = $success ? "✓" : "✗";
    return "
    <html>
        <body style='display: flex; align-items: center; justify-content: center; height: 95vh;'>
            <div class='box' style='text-align: center; padding: 30px; border: 1px solid #bfbfbf; width: 50%;'>
                <div style='background: $bgColor; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 50px;'>$icon</div>
                <h1>$title</h1>
                <p>$message</p>
                <p><a href='/customer-order.php'>Click Here to Check Order Status</a></p>
            </div>
        </body>
    </html>";
}
