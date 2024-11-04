<?php require_once('_header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: index.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: index.php');
        exit;
    }
}

foreach ($result as $row) {
    $p_name = $row['p_name'];
    $p_old_price = $row['p_old_price'];
    $p_current_price = $row['p_current_price'];
    $p_qty = $row['p_qty'];
    $p_featured_photo = $row['p_featured_photo'];
    $p_description = $row['p_description'];
    $p_short_description = $row['p_short_description'];
    $p_feature = $row['p_feature'];
    $p_condition = $row['p_condition'];
    $p_return_policy = $row['p_return_policy'];
    $p_total_view = $row['p_total_view'];
    $p_is_featured = $row['p_is_featured'];
    $p_is_active = $row['p_is_active'];
    $ecat_id = $row['ecat_id'];
}

// Getting all categories name for breadcrumb
$statement = $pdo->prepare("SELECT
                        t1.ecat_id,
                        t1.ecat_name,
                        t1.mcat_id,

                        t2.mcat_id,
                        t2.mcat_name,
                        t2.tcat_id,

                        t3.tcat_id,
                        t3.tcat_name

                        FROM tbl_end_category t1
                        JOIN tbl_mid_category t2
                        ON t1.mcat_id = t2.mcat_id
                        JOIN tbl_top_category t3
                        ON t2.tcat_id = t3.tcat_id
                        WHERE t1.ecat_id=?");
$statement->execute(array($ecat_id));
$total = $statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $ecat_name = $row['ecat_name'];
    $mcat_id = $row['mcat_id'];
    $mcat_name = $row['mcat_name'];
    $tcat_id = $row['tcat_id'];
    $tcat_name = $row['tcat_name'];
}


$p_total_view = $p_total_view + 1;

$statement = $pdo->prepare("UPDATE tbl_product SET p_total_view=? WHERE p_id=?");
$statement->execute(array($p_total_view, $_REQUEST['id']));


$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $size[] = $row['size_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $color[] = $row['color_id'];
}


if (isset($_POST['form_review'])) {

    $statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=? AND cust_id=?");
    $statement->execute(array($_REQUEST['id'], $_SESSION['customer']['cust_id']));
    $total = $statement->rowCount();

    if ($total) {
        $error_message = LANG_VALUE_68;
    } else {
        $statement = $pdo->prepare("INSERT INTO tbl_rating (p_id,cust_id,comment,rating) VALUES (?,?,?,?)");
        $statement->execute(array($_REQUEST['id'], $_SESSION['customer']['cust_id'], $_POST['comment'], $_POST['rating']));
        $success_message = LANG_VALUE_163;
    }

}

// Getting the average rating for this product
$t_rating = 0;
$statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$tot_rating = $statement->rowCount();
if ($tot_rating == 0) {
    $avg_rating = 0;
} else {
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $t_rating = $t_rating + $row['rating'];
    }
    $avg_rating = $t_rating / $tot_rating;
}

if (isset($_POST['form_add_to_cart'])) {

    // getting the currect stock of this product
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $current_p_qty = $row['p_qty'];
    }
    if ($_POST['p_qty'] > $current_p_qty):
        $temp_msg = 'Sorry! There are only ' . $current_p_qty . ' item(s) in stock';
        ?>
        <script type="text/javascript">alert('<?php echo $temp_msg; ?>');</script>
        <?php
    else:
        if (isset($_SESSION['cart_p_id'])) {
            $arr_cart_p_id = array();
            $arr_cart_size_id = array();
            $arr_cart_color_id = array();
            $arr_cart_p_qty = array();
            $arr_cart_p_current_price = array();

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
            foreach ($_SESSION['cart_color_id'] as $key => $value) {
                $i++;
                $arr_cart_color_id[$i] = $value;
            }


            $added = 0;
            if (!isset($_POST['size_id'])) {
                $size_id = 0;
            } else {
                $size_id = $_POST['size_id'];
            }
            if (!isset($_POST['color_id'])) {
                $color_id = 0;
            } else {
                $color_id = $_POST['color_id'];
            }
            for ($i = 1; $i <= count($arr_cart_p_id); $i++) {
                if (($arr_cart_p_id[$i] == $_REQUEST['id']) && ($arr_cart_size_id[$i] == $size_id) && ($arr_cart_color_id[$i] == $color_id)) {
                    $added = 1;
                    break;
                }
            }
            if ($added == 1) {
                $error_message1 = 'This product is already added to the shopping cart.';
            } else {

                $i = 0;
                foreach ($_SESSION['cart_p_id'] as $key => $res) {
                    $i++;
                }
                $new_key = $i + 1;

                if (isset($_POST['size_id'])) {

                    $size_id = $_POST['size_id'];

                    $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
                    $statement->execute(array($size_id));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $size_name = $row['size_name'];
                    }
                } else {
                    $size_id = 0;
                    $size_name = '';
                }

                if (isset($_POST['color_id'])) {
                    $color_id = $_POST['color_id'];
                    $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
                    $statement->execute(array($color_id));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $color_name = $row['color_name'];
                    }
                } else {
                    $color_id = 0;
                    $color_name = '';
                }


                $_SESSION['cart_p_id'][$new_key] = $_REQUEST['id'];
                $_SESSION['cart_size_id'][$new_key] = $size_id;
                $_SESSION['cart_size_name'][$new_key] = $size_name;
                $_SESSION['cart_color_id'][$new_key] = $color_id;
                $_SESSION['cart_color_name'][$new_key] = $color_name;
                $_SESSION['cart_p_qty'][$new_key] = $_POST['p_qty'];
                $_SESSION['cart_p_current_price'][$new_key] = $_POST['p_current_price'];
                $_SESSION['cart_p_name'][$new_key] = $_POST['p_name'];
                $_SESSION['cart_p_featured_photo'][$new_key] = $_POST['p_featured_photo'];

                $success_message1 = 'Product is added to the cart successfully!';
            }

        } else {

            if (isset($_POST['size_id'])) {

                $size_id = $_POST['size_id'];

                $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
                $statement->execute(array($size_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $size_name = $row['size_name'];
                }
            } else {
                $size_id = 0;
                $size_name = '';
            }

            if (isset($_POST['color_id'])) {
                $color_id = $_POST['color_id'];
                $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
                $statement->execute(array($color_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $color_name = $row['color_name'];
                }
            } else {
                $color_id = 0;
                $color_name = '';
            }


            $_SESSION['cart_p_id'][1] = $_REQUEST['id'];
            $_SESSION['cart_size_id'][1] = $size_id;
            $_SESSION['cart_size_name'][1] = $size_name;
            $_SESSION['cart_color_id'][1] = $color_id;
            $_SESSION['cart_color_name'][1] = $color_name;
            $_SESSION['cart_p_qty'][1] = $_POST['p_qty'];
            $_SESSION['cart_p_current_price'][1] = $_POST['p_current_price'];
            $_SESSION['cart_p_name'][1] = $_POST['p_name'];
            $_SESSION['cart_p_featured_photo'][1] = $_POST['p_featured_photo'];

            $success_message1 = 'Product is added to the cart successfully!';
        }
    endif;
}
?>

<?php
if ($error_message1 != '') {
    echo "<script>alert('" . $error_message1 . "')</script>";
}
if ($success_message1 != '') {
    echo "<script>alert('" . $success_message1 . "')</script>";
    header('location: product.php?id=' . $_REQUEST['id']);
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
                                <a class="breadcrumb-link" href="<?php echo BASE_URL; ?>">Home</a>
                            </li>
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link"
                                    href="<?php echo BASE_URL . 'product-category.php?id=' . $tcat_id . '&type=top-category' ?>"><?php echo $tcat_name; ?></a>
                            </li>
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link"
                                    href="<?php echo BASE_URL . 'product-category.php?id=' . $mcat_id . '&type=mid-category' ?>"><?php echo $mcat_name; ?></a>
                            </li>
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link"
                                    href="<?php echo BASE_URL . 'product-category.php?id=' . $ecat_id . '&type=end-category' ?>"><?php echo $ecat_name; ?></a>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text"><?php echo $p_name; ?></span>
                            </li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- pro-detail-page start -->
    <section class="product-details-page pro-style2 bg-color section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="pro-details-pos pro-details-left-pos">
                        <!-- Product slider start -->
                        <div class="product-detail-slider product-details-lr product-details product-details-sticky">

                            <!-- Product slider start -->
                            <div class="product-detail-img product-detail-img-right">
                                <div class="product-img-top">
                                    <button class="full-view"><i class="bi bi-arrows-fullscreen"></i></button>
                                    <div class="style2-slider-big slick-slider">
                                        <div class="slick-slide ">
                                            <a href="assets/uploads/<?php echo $p_featured_photo; ?>"
                                                class="product-single">
                                                <figure class="zoom" onmousemove="zoom(event)"
                                                    style="background-image: url('assets/uploads/<?php echo $p_featured_photo; ?>');">
                                                    <img src="assets/uploads/<?php echo $p_featured_photo; ?>"
                                                        class="img-fluid" alt="pro-1">
                                                </figure>
                                            </a>
                                        </div>

                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <div class="slick-slide ">
                                                <a href="assets/uploads/product_photos/<?php echo $row['photo']; ?>"
                                                    class="product-single">
                                                    <figure class="zoom" onmousemove="zoom(event)"
                                                        style="background-image: url('assets/uploads/product_photos/<?php echo $row['photo']; ?>');">
                                                        <img src="assets/uploads/product_photos/<?php echo $row['photo']; ?>"
                                                            class="img-fluid" alt="pro-2">
                                                    </figure>
                                                </a>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <!-- small slick-slider start -->
                                <div class="pro-slider">
                                    <div class="style2-slider-small pro-detail-slider">

                                        <div class="slick-slide">
                                            <a href="javascript:void(0)" class="product-single--thumbnail">
                                                <img src="assets/uploads/<?php echo $p_featured_photo; ?>"
                                                    class="img-fluid" alt="pro-1">
                                            </a>
                                        </div>

                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <div class="slick-slide ">
                                                <a href="javascript:void(0)" class="product-single--thumbnail">
                                                    <img src="assets/uploads/product_photos/<?php echo $row['photo']; ?>"
                                                        class="img-fluid" alt="pro-2">
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- small slick-slider end -->
                            </div>
                            <!-- Product slider end -->
                        </div>
                        <!-- peoduct detail start -->
                        <div class="product-details-wrap product-details-lr product-details">
                            <div class="product-details-info">
                                <div class="pro-nprist">
                                    <div class="product-info">
                                        <!-- product-ratting start -->
                                        <div class="product-ratting">
                                            <?php
                                            if ($avg_rating == 0) {
                                                echo '';
                                            } elseif ($avg_rating == 1.5) {
                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                            } elseif ($avg_rating == 2.5) {
                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                            } elseif ($avg_rating == 3.5) {
                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                            } elseif ($avg_rating == 4.5) {
                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        ';
                                            } else {
                                                for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                    <?php if ($i > $avg_rating): ?>
                                                        <i class="fa fa-star-o"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php endif; ?>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <!-- product-ratting end -->
                                    </div>
                                    <div class="product-info">
                                        <!-- product-title start -->
                                        <div class="product-title">
                                            <h2><?php echo $p_name; ?></h2>
                                        </div>
                                        <!-- product-title end -->
                                    </div>

                                    <form action="" method="post">
                                        < <div class="product-info">
                                            <div class="pro-prlb pro-sale">
                                                <div class="price-box">
                                                    <span class="new-price"> $<?php echo $p_current_price; ?></span>
                                                    <?php if ($p_old_price != ''): ?>
                                                        <span class="old-price">$<?php echo $p_old_price; ?></span>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <input type="hidden" name="p_current_price"
                                                value="<?php echo $p_current_price; ?>">
                                            <input type="hidden" name="p_name" value="<?php echo $p_name; ?>">
                                            <input type="hidden" name="p_featured_photo"
                                                value="<?php echo $p_featured_photo; ?>">
                                </div>
                                <!-- <div class="product-info">
                                            <div class="product-inventory">
                                                <div class="stock-inventory stock-more">
                                                    <p class="text-success">Hurry up! only
                                                        <span class="available-stock bg-success">77</span>
                                                        <span>products left in stock!</span>
                                                    </p>
                                                </div>
                                                <div class="product-variant">
                                                    <h6>Availability:</h6>
                                                    <span class="stock-qty in-stock text-success">
                                                        <span>In stock<i class="bi bi-check2"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> -->
                                <?php if (isset($size)): ?>
                                    <div class="product-info">
                                        <div class="pro-detail-action">

                                            <div class="product-variant-option">
                                                <div class="swatch-variant">
                                                    <div class="swatch clearfix Color">
                                                        <div class="header">
                                                            <h6><span>Size</span></h6>
                                                        </div>
                                                        <div class="variant-wrap">
                                                            <div class="variant-property">

                                                                <select name="size_id" class="form-control select2"
                                                                    style="width:auto;">
                                                                    <?php
                                                                    $statement = $pdo->prepare("SELECT * FROM tbl_size");
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result as $row) {
                                                                        if (in_array($row['size_id'], $size)) {
                                                                            ?>
                                                                            <option value="<?php echo $row['size_id']; ?>">
                                                                                <?php echo $row['size_name']; ?>
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($color)): ?>
                                    <div class="product-info">
                                        <div class="pro-detail-action">

                                            <div class="product-variant-option">
                                                <div class="swatch-variant">
                                                    <div class="swatch clearfix Color">
                                                        <div class="header">
                                                            <h6><span>Color</span></h6>
                                                        </div>
                                                        <div class="variant-wrap">
                                                            <div class="variant-property">

                                                                <select name="color_id" class="form-control select2"
                                                                    style="width:auto;">
                                                                    <?php
                                                                    $statement = $pdo->prepare("SELECT * FROM tbl_color");
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result as $row) {
                                                                        if (in_array($row['color_id'], $color)) {
                                                                            ?>
                                                                            <option value="<?php echo $row['color_id']; ?>">
                                                                                <?php echo $row['color_name']; ?>
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="product-info">

                                    <div class="product-quantity-action">
                                        <h6>Quantity:</h6>
                                        <div class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <button class="dec qtybutton minus"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input type="text" name="p_qty" value="1">
                                                <button class="inc qtybutton plus"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-info">
                                    <div class="product-actions">
                                        <!-- pro-deatail button start -->
                                        <div class="pro-detail-button">
                                            <button type="submit" name="form_add_to_cart"
                                                class="btn add-to-cart ajax-spin-cart">
                                                <span class="cart-title">Add to cart</span>
                                            </button>
                                            </form>
                                            <!-- <a href="cart-empty.html" class="btn btn-cart btn-theme">
                                                        <span>Buy now</span>
                                                    </a> -->
                                        </div>
                                        <!-- pro-deatail button start -->
                                        <!-- pro-deatail wishlist start -->

                                        <!-- pro-deatail wishlist end -->
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <!-- peoduct detail end -->
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="product-details-page pro-style2 bg-color ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pro-details-pos pro-details-left-pos">

                        <div class="product-description-tab">
                            <div class="product-tab horizontal-tab">
                                <div class="tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation">
                                            <a href="#description" class="active" data-bs-toggle="tab">
                                                <h6><?php echo LANG_VALUE_59; ?></h6>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#feature" data-bs-toggle="tab">
                                                <h6><?php echo LANG_VALUE_60; ?></h6>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#condition" data-bs-toggle="tab">
                                                <h6><?php echo LANG_VALUE_61; ?></h6>
                                            </a>
                                        </li>
                                        <li role="presentation"><a href="#return_policy" aria-controls="return_policy"
                                                role="tab" data-bs-toggle="tab">
                                                <h6> <?php echo LANG_VALUE_62; ?></h6>
                                            </a></li>

                                    </ul>
                                </div>
                                <div class="description-review-text tab-content">
                                    <div class="tab-pane active" id="description">
                                        <div class="product-description">
                                            <p> <?php
                                            if ($p_description == '') {
                                                echo LANG_VALUE_70;
                                            } else {
                                                echo $p_description;
                                            }
                                            ?></p>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="feature">
                                        <div class="product-description">
                                            <?php
                                            if ($p_feature == '') {
                                                echo LANG_VALUE_71;
                                            } else {
                                                echo $p_feature;
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="condition">
                                        <div class="product-description">
                                            <?php
                                            if ($p_condition == '') {
                                                echo LANG_VALUE_72;
                                            } else {
                                                echo $p_condition;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="return_policy">
                                        <div class="product-description">
                                            <?php
                                            if ($p_return_policy == '') {
                                                echo LANG_VALUE_73;
                                            } else {
                                                echo $p_return_policy;
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- pro-detail-page end -->
    <!-- product video-review start -->
    <section class="product-reviews section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="video">
                        <div class="video-wrapper">
                            <iframe src="https://www.youtube.com/embed/0Aja_yP93PY" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <div class="section-cont-title">
                                <?php
                                $statement = $pdo->prepare("SELECT * 
                                                            FROM tbl_rating t1 
                                                            JOIN tbl_customer t2 
                                                            ON t1.cust_id = t2.cust_id 
                                                            WHERE t1.p_id=?");
                                $statement->execute(array($_REQUEST['id']));
                                $total = $statement->rowCount();
                                ?>
                                <h2><span>Customer Reviews(<?php echo $total; ?>)</span></h2>
                            </div>
                        </div>
                    </div>
                    <div id="pro-reviews">
                        <div class="spr-container">
                            <div class="spr-header">
                                <?php
                                if ($total) {
                                    $j = 0;
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $j++;
                                        ?>
                                        <h2 class="spr-header-title"><?php echo $row['cust_name']; ?></h2>
                                        <p>
                                            <?php echo $row['comment']; ?>
                                        </p>


                                        <div class="product-ratting">
                                            <span class="pro-ratting">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                    <?php if ($i > $row['rating']): ?>
                                                        <i class="fa fa-star-o"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php endif; ?>
                                                    <?php
                                                }
                                                ?>
                                            </span>


                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo LANG_VALUE_74;
                                }
                                ?>
                                  <div class="product-ratting">
                                  <span class="spr-summary-actions">
                                    <a href="#add-review" data-bs-toggle="collapse"
                                        class="spr-summary-actions-newreview">Write a review</a>
                                </span>
                                  </div>
                               
                                <!-- product-ratting end -->
                            </div>
                            <div class="spr-content">
                                <!-- spar-from start -->
                                <div class="spr-form collapse" id="add-review">
                               
                                        <?php
                                        if($error_message != '') {
                                            echo "<script>alert('".$error_message."')</script>";
                                        }
                                        if($success_message != '') {
                                            echo "<script>alert('".$success_message."')</script>";
                                        }
                                        ?>
                                        <?php 
                                        if(isset($_SESSION['customer'])):
                                         ?>

                                            <?php
                                            $statement = $pdo->prepare("SELECT * 
                                                                FROM tbl_rating
                                                                WHERE p_id=? AND cust_id=?");
                                            $statement->execute(array($_REQUEST['id'],$_SESSION['customer']['cust_id']));
                                            $total = $statement->rowCount();
                                            ?>
                                            <?php if($total==0): ?>
                                    <form action="" method="post">
                                        <h3 class="spr-form-title">Write a review</h3>
                                      <style>
                                       
    /* Hide the default checkbox */
    input[type="checkbox"] {
        display: none;
    }

    /* Style for the star label */
    .star-label {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
    }

    /* Change color on hover */
    .star-label:hover,
    .star-label:focus {
        color: gold;
    }

    /* When the checkbox is checked, change the color of the star */
    input[type="checkbox"]:checked + .star-label {
        color: gold;
    }
                                      </style>
                                        <fieldset class="spr-form-review">
                                            <div class="spr-form-review-rating">
                                                <label class="spr-form-label">Rating</label>
                                                <div class="rating-section">
                                                <div class="swatch-element White first-variant">
    <input type="checkbox" name="rating[]" id="size1" value="1">
    <label class="star-label" for="size1">★</label>
</div>

<div class="swatch-element White first-variant">
    <input type="checkbox" name="rating[]" id="size2" value="2">
    <label class="star-label" for="size2">★</label>
</div>

<div class="swatch-element White first-variant">
    <input type="checkbox" name="rating[]" id="size3" value="3">
    <label class="star-label" for="size3">★</label>
</div>
<div class="swatch-element White first-variant">
    <input type="checkbox" name="rating[]" id="size4" value="4">
    <label class="star-label" for="size4">★</label>
</div>
<div class="swatch-element White first-variant">
    <input type="checkbox" name="rating[]" id="size5" value="5">
    <label class="star-label" for="size5">★</label>
</div>
                                            </div> 
                                            </div>
                                         
                                            <div class="spr-form-review-body">
                                                
                                                <div class="spr-form-input">
                                                    <textarea class="spr-form-input spr-form-input-textarea" name="comment"
                                                        placeholder="Write your comments here" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="spr-form-actions">
                                            <input type="submit" name="form_review"
                                                class="spr-button spr-button-primary button button-primary btn btn-primary"
                                                value="Submit Review">
                                        </fieldset>
                                    </form>
                                    <?php else: ?>
                                                <span style="color:red;"><?php echo LANG_VALUE_68; ?></span>
                                            <?php endif; ?>


                                        <?php
                                     else:
                                      ?>
                                            <p class="error">
												<?php echo LANG_VALUE_69; ?> <br>
												<a href="login.php" style="color:red;text-decoration: underline;"><?php echo LANG_VALUE_9; ?></a>
											</p>
                                        <?php 
                                    endif;
                                     ?>           
                                </div>
                                <!-- spar-from end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product video-review end -->
    <!-- product-tranding start -->
    <section class="Trending-product bg-color section-ptb">
        <div class="collection-category">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <span class="sub-title" data-animate="animate__fadeInUp">Browse collection</span>
                                <h2><span data-animate="animate__fadeInUp">Related Products</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                    <div class="collection-wrap">
                                <div class="collection-slider swiper" id="Trending-product">
                                    <div class="swiper-wrapper">
                                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_id!=?");
                    $statement->execute(array($ecat_id,$_REQUEST['id']));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        ?>
                                            <div class="swiper-slide" data-animate="animate__fadeInUp">
                                                <div class="single-product-wrap">
                                                    <div class="product-image">
                                                        <a href="product.php?id=<?php echo $row['p_id']; ?>" class="pro-img">
                                                            <img src="assets/uploads/<?php echo htmlspecialchars($row['p_featured_photo']); ?>" class="img-fluid img1 mobile-img1" alt="<?php echo $row['p_name']; ?>">
                                                        </a>

                                                    </div>
                                                    <div class="product-content">

                                                        <div class="product-title">
                                                            <h6><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h6>
                                                        </div>
                                                        <div class="product-price">
                                                            <div class="pro-price-box">
                                                                <span class="new-price">$<?php echo number_format($row['p_current_price'], 2); ?></span>
                                                                <?php if ($row['p_old_price']): ?>
                                                                    <span class="old-price">$<?php echo number_format($row['p_old_price'], 2); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pro-label-retting">
                                                        <div class="product-ratting">
                                                            <?php
                                                            $t_rating = 0;
                                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                            $statement1->execute(array($row['p_id']));
                                                            $tot_rating = $statement1->rowCount();
                                                            if ($tot_rating == 0) {
                                                                $avg_rating = 0;
                                                            } else {
                                                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($result1 as $row1) {
                                                                    $t_rating = $t_rating + $row1['rating'];
                                                                }
                                                                $avg_rating = $t_rating / $tot_rating;
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($avg_rating == 0) {
                                                                echo '';
                                                            } elseif ($avg_rating == 1.5) {
                                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                                            } elseif ($avg_rating == 2.5) {
                                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                                            } elseif ($avg_rating == 3.5) {
                                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                                            } elseif ($avg_rating == 4.5) {
                                                                echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        ';
                                                            } else {
                                                                for ($i = 1; $i <= 5; $i++) {
                                                            ?>
                                                                    <?php if ($i > $avg_rating): ?>
                                                                        <i class="fa fa-star-o"></i>
                                                                    <?php else: ?>
                                                                        <i class="fa fa-star"></i>
                                                                    <?php endif; ?>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php if ($row['p_qty'] == 0): ?>
                                                            <div class="out-of-stock">
                                                                <div class="inner">Out Of Stock</div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="product-label pro-new-sale">
                                                                <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                                                    <span class="">Read More</span></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>



                                    <div class="collection-button" data-animate="animate__fadeInUp">
                                        <a href="collection.html" class="btn btn-style2" data-animate="animate__fadeInUp">View all item</a>
                                    </div>
                                </div>
                                <div class="swiper-buttons" data-animate="animate__fadeInUp">
                                    <div class="swiper-buttons-wrap">
                                        <button class="swiper-prev swiper-prev-Trending"><span><i class="feather-arrow-left"></i></span></button>
                                        <button class="swiper-next swiper-next-Trending"><span><i class="feather-arrow-right"></i></span></button>
                                    </div>
                                </div>
                                <div class="swiper-dots" data-animate="animate__fadeInUp">
                                    <div class="swiper-pagination swiper-pagination-Trending"></div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tranding end -->
</main>
<!-- main section end-->
<?php

require_once('_footer.php'); ?>
