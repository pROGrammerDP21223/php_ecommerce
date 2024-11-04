<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}
?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
        $table_quantity[$i] = $row['p_qty'];
    }

    $i=0;
    foreach($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = $val;
    }
    $i=0;
    foreach($_POST['quantity'] as $val) {
        $i++;
        $arr2[$i] = $val;
    }
    $i=0;
    foreach($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = $val;
    }
    
    $allow_update = 1;
    for($i=1;$i<=count($arr1);$i++) {
        for($j=1;$j<=count($table_product_id);$j++) {
            if($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        if($table_quantity[$temp_index] < $arr2[$i]) {
        	$allow_update = 0;
            $error_message .= '"'.$arr2[$i].'" items are not available for "'.$arr3[$i].'"\n';
        } else {
            $_SESSION['cart_p_qty'][$i] = $arr2[$i];
        }
    }
    $error_message .= '\nOther items quantity are updated successfully!';
    ?>
    
    <?php if($allow_update == 0): ?>
    	<script>alert('<?php echo $error_message; ?>');</script>
	<?php else: ?>
		<script>alert('All Items Quantity Update is Successful!');</script>
	<?php endif; ?>
    <?php

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
                                        <span class="breadcrumb-text"><?php echo LANG_VALUE_18; ?></span>
                                    </li>
                                </ul>
                                <!-- breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb end -->
            <!-- cart-page start -->
            <section class="cart-page section-ptb">
       
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="cart-page-wrap">
                                    <div class="cart-wrap-info">
                                        <div class="cart-item-wrap">
                                         
                                            <div class="item-wrap">
                                                <?php if(!isset($_SESSION['cart_p_id'])): ?>
                                                <?php echo 'Cart is empty'; ?>
                                            <?php else: ?>
                                            <form action="" method="post">
                                                <?php $csrf->echoInputField(); ?>
                            
                                                <?php
                                                $table_total_price = 0;
                            
                                                $i=0;
                                                foreach($_SESSION['cart_p_id'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_p_id[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_size_id'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_size_id[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_size_name'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_size_name[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_color_id'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_color_id[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_color_name'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_color_name[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_p_qty'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_p_qty[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_p_current_price[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_p_name'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_p_name[$i] = $value;
                                                }
                            
                                                $i=0;
                                                foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                                                {
                                                    $i++;
                                                    $arr_cart_p_featured_photo[$i] = $value;
                                                }
                                                ?>
                                                <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>

                                                <ul class="cart-wrap">
                                                    <!-- cart-info start -->
                                                    <li class="item-info">
                                                        <!-- cart-img start -->
                                                        <div class="item-img">
                                                            <a href="product-template.html" data-animate="animate__fadeInUp">
                                                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" class="img-fluid" alt="p-1">
                                                            </a>
                                                        </div>
                                                        <!-- cart-img end -->
                                                        <!-- cart-title start -->
                                                        <div class="item-text">
                                                            <a href="product-template.html" data-animate="animate__fadeInUp"><?php echo $arr_cart_p_name[$i]; ?></a>
                                                            <span class="item-option" data-animate="animate__fadeInUp">
                                                                <span class="item-title">Size:</span>
                                                                <span class="item-type"><?php echo $arr_cart_size_name[$i]; ?></span>
                                                            </span>
                                                            <span class="item-option" data-animate="animate__fadeInUp">
                                                                <span class="item-title">Color:</span>
                                                                <span class="item-type"><?php echo $arr_cart_color_name[$i]; ?></span>
                                                            </span>
                                                            <span class="item-option" data-animate="animate__fadeInUp">
                                                                <span class="item-price">$<?php echo $arr_cart_p_current_price[$i]; ?></span>
                                                            </span>
                                                            
                                                        </div>
                                                        <!-- cart-title send -->
                                                    </li>
                                                    <!-- cart-info end -->
                                                    <!-- cart-qty start -->
                                                    <li class="item-qty">
                                                        <div class="product-quantity-action">
                                                            <div class="product-quantity" data-animate="animate__fadeInUp">
                                                                <input type="hidden" name="product_id[]" value="<?php echo $arr_cart_p_id[$i]; ?>">
                                                                <input type="hidden" name="product_name[]" value="<?php echo $arr_cart_p_name[$i]; ?>">
                                                                <div class="cart-plus-minus">
                                                                    <button class="dec qtybutton minus"><i class="fa-solid fa-minus"></i></button>
                                                                    <input type="text" name="quantity[]" value="<?php echo $arr_cart_p_qty[$i]; ?>">
                                                                    <button class="inc qtybutton plus"><i class="fa-solid fa-plus"></i></button>
                                                                </div>
                                                                <span class="dec qtybtn"></span>
                                                                <span class="inc qtybtn"></span>
                                                            </div>
                                                        </div>
                                                        <div class="item-remove">
                                                            <span class="remove-wrap">
                                                                <a onclick="return confirmDelete();" href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>" class="text-danger" data-animate="animate__fadeInUp">Remove</a>
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <!-- cart-qty end -->
                                                    <!-- cart-price start -->
                                                    <li class="item-price">
                                                        <span class="amount full-price" data-animate="animate__fadeInUp"><?php
                                                            $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                                            $table_total_price = $table_total_price + $row_total_price;
                                                            ?>
                                                            <?php echo LANG_VALUE_1; ?><?php echo $row_total_price; ?></span>
                                                    </li>
                                                    <?php endfor; ?>
                                                  
                                                    <div class="cart-total-wrap cart-info">
                                            <div class="cart-total">
                                                <div class="total-amount animate__fadeInUp animate__animated" data-animate="animate__fadeInUp">
                                                    <h6 class="total-title">Total : </h6>
                                                    <span class="amount total-price">$<?php echo $table_total_price; ?></span>
                                                </div>
                                           
                                               
                                            </div>
                                        </div>
                                                    <!-- cart-price end -->
                                                </ul>
                                              
                                            </div>
                                            <div class="cart-buttons" data-animate="animate__fadeInUp">
                                                <input type="submit" value="<?php echo LANG_VALUE_20; ?>" name="form1" class="btn-style2">
                                                <a href="index.php" class="btn-style2">Continue shopping</a>
                                                <a href="checkout.php" class="btn-style2">Proceed To Checkout</a>
                                            </div>
                                        </form>
                                            <?php endif; ?>
                                        </div>
                                                    
                                    </div>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <!-- cart-page end -->
            <!-- product-tranding start -->
          
            <!-- product-tranding end -->
        </main>
        <!-- main section end-->
     
        <?php require_once('_footer.php'); ?>