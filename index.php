<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('_header.php'); 


$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $cta_title = $row['cta_title'];
    $cta_content = $row['cta_content'];
    $cta_read_more_text = $row['cta_read_more_text'];
    $cta_read_more_url = $row['cta_read_more_url'];
    $cta_photo = $row['cta_photo'];
    $featured_product_title = $row['featured_product_title'];
    $featured_product_subtitle = $row['featured_product_subtitle'];
    $latest_product_title = $row['latest_product_title'];
    $latest_product_subtitle = $row['latest_product_subtitle'];
    $popular_product_title = $row['popular_product_title'];
    $popular_product_subtitle = $row['popular_product_subtitle'];
    $total_featured_product_home = $row['total_featured_product_home'];
    $total_latest_product_home = $row['total_latest_product_home'];
    $total_popular_product_home = $row['total_popular_product_home'];
    $home_service_on_off = $row['home_service_on_off'];
    $home_welcome_on_off = $row['home_welcome_on_off'];
    $home_featured_product_on_off = $row['home_featured_product_on_off'];
    $home_latest_product_on_off = $row['home_latest_product_on_off'];
    $home_popular_product_on_off = $row['home_popular_product_on_off'];
}


?>

<!-- main start -->
<main id="main-content">
    <!-- slider-area start-->
    <?php
    $statement = $pdo->prepare("SELECT * FROM tbl_slider");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php for ($j = 0; $j < count($result); $j++): ?>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $j; ?>" class="<?php echo $j === 0 ? 'active' : ''; ?>" aria-current="<?php echo $j === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $j + 1; ?>"></button>
            <?php endfor; ?>
        </div>

        <div class="carousel-inner">
            <?php
            foreach ($result as $i => $row): ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <img src="assets/uploads/<?php echo $row['photo']; ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="text-white"><?php echo $row['heading']; ?></h1>
                        <p><?php echo nl2br($row['content']); ?></p>
                        <a href="<?php echo $row['button_url']; ?>" class="btn btn-style"><?php echo $row['button_text']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- slider-area end -->

    <!-- our-service start -->
    <?php if ($home_service_on_off == 1): ?>
        <section class="our-service-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="grid-wrap">
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_service");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                            ?>
                                <li class="grid-wrapper" data-animate="animate__fadeInUp">
                                    <div class="ser-block">
                                        <a href="javascript:void(0)">
                                            <span class="ser-icon">
                                                <img src="assets/uploads/<?php echo $row['photo']; ?>" class="img-fluid" alt="service-1">
                                                <span></span>
                                            </span>
                                            <div class="service-text">
                                                <h6><?php echo $row['title']; ?></h6>
                                                <p><?php echo nl2br($row['content']); ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- our-service end -->
    <!-- product-tranding start -->
    <?php if ($home_featured_product_on_off == 1): ?>
        <section class="Trending-product bg-color section-ptb">
            <div class="collection-category">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section-capture">
                                <div class="section-title">
                                    <span class="sub-title" data-animate="animate__fadeInUp"><?php echo $featured_product_subtitle; ?></span>
                                    <h2><span data-animate="animate__fadeInUp"><?php echo $featured_product_title; ?></span></h2>
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
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured=? AND p_is_active=? LIMIT " . $total_featured_product_home);
                                        $statement->execute(array(1, 1));
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
    <?php endif; ?>

    <!-- product-tranding end -->

    <!-- test-area start -->
    <section class="testimonial section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="testimonial-block">
                        <div class="section-capture">
                            <div class="section-title">
                                <span class="sub-title" data-animate="animate__fadeInUp">1300+ Customer reviews</span>
                                <h2 data-animate="animate__fadeInUp"><span>Our customer love</span></h2>
                            </div>
                        </div>
                        <div class="testi-wrap">
                            <div class="test-slider swiper" id="test-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="testi-info">
                                            <span class="auth-img">
                                                <img src="img/testi/test-1.jpg" class="img-fluid" alt="test-1">
                                            </span>
                                            <div class="testi-review-block" data-animate="animate__fadeInUp">
                                                <span class="testi-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </span>
                                                <span class="testi-comment">01 Comment</span>
                                            </div>
                                            <p data-animate="animate__fadeInUp">If you are going to use a passage of you need to be sure there isn't anything embarrassing hidden in the middle of text generator on the internet dictionary of over .</p>
                                            <div class="bottom-text">
                                                <span class="icon" data-animate="animate__fadeInUp"><i class="fa-solid fa-quote-left"></i></span>
                                                <div class="title">
                                                    <h6 data-animate="animate__fadeInUp">Karen onnabit</h6>
                                                    <span data-animate="animate__fadeInUp">Store customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="testi-info">
                                            <span class="auth-img">
                                                <img src="img/testi/test-2.jpg" class="img-fluid" alt="test-2">
                                            </span>
                                            <div class="testi-review-block" data-animate="animate__fadeInUp">
                                                <span class="testi-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </span>
                                                <span class="testi-comment">01 Comment</span>
                                            </div>
                                            <p data-animate="animate__fadeInUp">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchange wasin the 1960s with the release of containing passages.</p>
                                            <div class="bottom-text">
                                                <span class="icon" data-animate="animate__fadeInUp"><i class="fa-solid fa-quote-left"></i></span>
                                                <div class="title">
                                                    <h6 data-animate="animate__fadeInUp">Lynne gwistic</h6>
                                                    <span data-animate="animate__fadeInUp">Store customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="testi-info">
                                            <span class="auth-img">
                                                <img src="img/testi/test-3.jpg" class="img-fluid" alt="test-3">
                                            </span>
                                            <div class="testi-review-block" data-animate="animate__fadeInUp">
                                                <span class="testi-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </span>
                                                <span class="testi-comment">01 Comment</span>
                                            </div>
                                            <p data-animate="animate__fadeInUp">If you are going to use a passage of you need to be sure there isn't anything embarrassing hidden in the middle of text generator on the internet dictionary of over .</p>
                                            <div class="bottom-text">
                                                <span class="icon" data-animate="animate__fadeInUp"><i class="fa-solid fa-quote-left"></i></span>
                                                <div class="title">
                                                    <h6 data-animate="animate__fadeInUp">Karen onnabit</h6>
                                                    <span data-animate="animate__fadeInUp">Store customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="testi-info">
                                            <span class="auth-img">
                                                <img src="img/testi/test-4.jpg" class="img-fluid" alt="test-4">
                                            </span>
                                            <div class="testi-review-block" data-animate="animate__fadeInUp">
                                                <span class="testi-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </span>
                                                <span class="testi-comment">01 Comment</span>
                                            </div>
                                            <p data-animate="animate__fadeInUp">It was popularised in the 1960s with the release of letraset sheets containing lorem Ipsum passages,and more recently with desktop software.</p>
                                            <div class="bottom-text">
                                                <span class="icon" data-animate="animate__fadeInUp"><i class="fa-solid fa-quote-left"></i></span>
                                                <div class="title">
                                                    <h6 data-animate="animate__fadeInUp">David williams</h6>
                                                    <span data-animate="animate__fadeInUp">Store customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="testi-info">
                                            <span class="auth-img">
                                                <img src="img/testi/test-5.jpg" class="img-fluid" alt="test-5">
                                            </span>
                                            <div class="testi-review-block" data-animate="animate__fadeInUp">
                                                <span class="testi-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </span>
                                                <span class="testi-comment">01 Comment</span>
                                            </div>
                                            <p data-animate="animate__fadeInUp">If you are going to use a passage of you need to be sure there isn't anything embarrassing hidden in the middle of text generator on the internet dictionary of over .</p>
                                            <div class="bottom-text">
                                                <span class="icon" data-animate="animate__fadeInUp"><i class="fa-solid fa-quote-left"></i></span>
                                                <div class="title">
                                                    <h6 data-animate="animate__fadeInUp">Lynne gwistic</h6>
                                                    <span data-animate="animate__fadeInUp">Store customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-buttons-wrap">
                                <div class="swiper-buttons">
                                    <div class="swiper-buttons-wrap">
                                        <button class="swiper-prev swiper-prev-test"><span><i class="fa-solid fa-arrow-left"></i></span></button>
                                        <button class="swiper-next swiper-next-test"><span><i class="fa-solid fa-arrow-right"></i></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- test-area end -->


    <!-- brand-logo start -->
    <div class="brand-logo">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="brand-logo-wrap">
                        <div class="brand-logo-slider owl-carousel owl-theme" id="brand-logo">
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo1.png" class="img-fluid" alt="brand-logo1">
                                    </span>
                                </a>
                            </div>
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo2.png" class="img-fluid" alt="brand-logo2">
                                    </span>
                                </a>
                            </div>
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo3.png" class="img-fluid" alt="brand-logo3">
                                    </span>
                                </a>
                            </div>
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo4.png" class="img-fluid" alt="brand-logo4">
                                    </span>
                                </a>
                            </div>
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo5.png" class="img-fluid" alt="brand-logo5">
                                    </span>
                                </a>
                            </div>
                            <div class="item">
                                <a href="index.php">
                                    <span class="brand-img" data-animate="animate__fadeInUp">
                                        <img src="img/brand-logo/home1-brand-logo6.png" class="img-fluid" alt="brand-logo6">
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand-logo end -->
</main>
<!-- main end -->
 <?php
require_once('_footer.php'); ?>