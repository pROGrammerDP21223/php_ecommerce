<?php
ob_start();
session_start();
require_once('../../admin/inc/config.php');

$key11 = "oZ7oo9";
$salt11 = "UkojH5TS";
$item_amount = $_POST['amount'];
$item_number = time();

$payment_date = date('Y-m-d H:i:s');
$action = 'https://test.payu.in/_payment';

$html = '';

$statement = $pdo->prepare("INSERT INTO tbl_payment (
	customer_id,
	customer_name,
	customer_email,
	payment_date,
	txnid, 
	paid_amount,
	card_number,
	card_cvv,
	card_month,
	card_year,
	bank_transaction_info,
	payment_method,
	payment_status,
	shipping_status,
	payment_id
	) 
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql = $statement->execute(array(
	$_SESSION['customer']['cust_id'],
	$_SESSION['customer']['cust_name'],
	$_SESSION['customer']['cust_email'],
	$payment_date,
	$_POST['txnid'],
	$item_amount,
	'',
	'',
	'',
	'',
	'',
	'PayU',
	'Pending',
	'Pending',
	$item_number
));



$i = 0;
foreach ($_SESSION['cart_p_id'] as $key => $value) {
	$i++;
	$arr_cart_p_id[$i] = $value;
}

$i = 0;
foreach ($_SESSION['cart_p_name'] as $key => $value) {
	$i++;
	$arr_cart_p_name[$i] = $value;
}

$i = 0;
foreach ($_SESSION['cart_size_name'] as $key => $value) {
	$i++;
	$arr_cart_size_name[$i] = $value;
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
$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$i++;
	$arr_p_id[$i] = $row['p_id'];
	$arr_p_qty[$i] = $row['p_qty'];
}


for ($i = 1; $i <= count($arr_cart_p_name); $i++) {
	$statement = $pdo->prepare("INSERT INTO tbl_order (
	product_id,
	product_name,
	size, 
	color,
	quantity, 
	unit_price, 
	payment_id
	) 
	VALUES (?,?,?,?,?,?,?)");
	$sql = $statement->execute(array(
		$arr_cart_p_id[$i],
		$arr_cart_p_name[$i],
		$arr_cart_size_name[$i],
		$arr_cart_color_name[$i],
		$arr_cart_p_qty[$i],
		$arr_cart_p_current_price[$i],
		$item_number
	));

	// Update the stock
	for ($j = 1; $j <= count($arr_p_id); $j++) {
		if ($arr_p_id[$j] == $arr_cart_p_id[$i]) {
			$current_qty = $arr_p_qty[$j];
			break;
		}
	}
	$final_quantity = $current_qty - $arr_cart_p_qty[$i];
	$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
	$statement->execute(array($final_quantity, $arr_cart_p_id[$i]));

}
$product_info = implode(", ", $arr_cart_p_name);
if ($sql) {
	$json_data = json_encode($_SESSION['customer']);
	file_put_contents('customer_session_data.json', $json_data);
	if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {

		$hash = hash('sha512', $key11 . '|' . $_POST['txnid'] . '|' . $_POST['amount'] . '|' . $product_info . '|' . $_SESSION['customer']['cust_name'] . '|' . $_SESSION['customer']['cust_email'] . '|||||' . $_POST['udf5'] . '||||||' . $salt11);

		$_SESSION['salt'] = $salt11; //save salt in session to use during Hash validation in response

		$html = '<form action="' . $action . '" id="payment_form_submit" method="post">
			<input type="hidden" id="udf5" name="udf5" value="' . $_POST['udf5'] . '" />
			<input type="hidden" id="firstname" name="firstname" value="' . $_SESSION['customer']['cust_name'] . '" />
			<input type="hidden" id="email" name="email" value="' .$_SESSION['customer']['cust_email'] . '" />
			<input type="hidden" id="phone" name="phone" value="' . $_SESSION['customer']['cust_phone'] . '" />
			<input type="hidden" id="surl" name="surl" value="' . getCallbackUrl() . '" />
			<input type="hidden" id="furl" name="furl" value="' . getCallbackUrl() . '" />
			<input type="hidden" id="curl" name="curl" value="' . getCallbackUrl() . '" />
			<input type="hidden" id="key" name="key" value="' . $key11 . '" />
			<input type="hidden" id="txnid" name="txnid" value="' . $_POST['txnid'] . '" />
			<input type="hidden" id="amount" name="amount" value="' . $_POST['amount'] . '" />
			   <input type="hidden" id="productinfo" name="productinfo" value="' . htmlspecialchars($product_info, ENT_QUOTES, 'UTF-8') . '" />
			
			<input type="hidden" id="Pg" name="Pg" value="CC" />
			<input type="hidden" id="hash" name="hash" value="' . $hash . '" />
			</form>
			<script type="text/javascript"><!--
				document.getElementById("payment_form_submit").submit();	
			//-->
			</script>';

	}
	echo $html;
} else {
	echo 'Payment failed. Please try again.';

}


//This function is for dynamically generating callback url to be postd to payment gateway. Payment response will be
//posted back to this url. 



function getCallbackUrl()
{
	$specificUrl = "http://localhost/github/php_ecommerce/response.php";
    
		return $specificUrl;
}

