<?php require_once('_header.php'); ?>

<?php
if(!isset($_REQUEST['search_text'])) {
    header('location: index.php');
    exit;
} else {
	if($_REQUEST['search_text']=='') {
		header('location: index.php');
    	exit;
	}
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_search = $row['banner_search'];
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
                                        <span class="breadcrumb-text">   Search By: 
            <?php 
                $search_text = strip_tags($_REQUEST['search_text']); 
                echo $search_text; 
            ?>       </span>
                                    </li>
                                </ul>
                                <!-- breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb end -->
            <!-- collection start -->
            <section class="main-content-wrap bg-color shop-page section-ptb">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="pro-grli-wrapper left-side-wrap">
                                <div class="pro-grli-wrap product-grid">
                                   
                                    <!-- shop-top-bar start -->
                             
                                    <!-- shop-top-bar end -->
                                    <!-- Latest-product start -->  
                                    <div class="special-product grid-3">
                                        <div class="collection-category">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="collection-wrap">
                                                        <ul class="product-view-ul">


                                                        <?php
                            $search_text = '%'.$search_text.'%';
                        ?>

			<?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? AND p_name LIKE ?");
            $statement->execute(array(1,$search_text));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'search-result.php?search_text='.$_REQUEST['search_text'];   //your file name  (the name of this file)
            $limit = 12;                                 //how many items to show per page
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;          //first item to display on this page
            else
                $start = 0;
            

            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? AND p_name LIKE ? LIMIT $start, $limit");
            $statement->execute(array(1,$search_text));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
            $prev = $page - 1;                          //previous page is page - 1
            $next = $page + 1;                          //next page is page + 1
            $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
            {   
                $pagination .= "<div class=\"pagination\">";
                if ($page > 1) 
                    $pagination.= "<a href=\"$targetpage&page=$prev\">&#171; previous</a>";
                else
                    $pagination.= "<span class=\"disabled\">&#171; previous</span>";    
                if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
                {   
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
                {
                    if($page < 1 + ($adjacents * 2))        
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";       
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";       
                    }
                    else
                    {
                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                    }
                }
                if ($page < $counter - 1) 
                    $pagination.= "<a href=\"$targetpage&page=$next\">next &#187;</a>";
                else
                    $pagination.= "<span class=\"disabled\">next &#187;</span>";
                $pagination.= "</div>\n";       
            }
            /* ===================== Pagination Code Ends ================== */
            ?>

                        <?php
                            
                            if(!$total_pages):
                                echo '<span style="color:red;font-size:18px;">No result found</span>';
                            else:
                            foreach ($result as $row) {
                                ?>      
                                                            <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                                <div class="single-product-wrap">
                                                                    <div class="product-image banner-hover">
                                                                        <a href="product.php?id=<?php echo $row['p_id']; ?>" class="pro-img">
                                                                            <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-fluid img1 mobile-img1" alt="p1">
                                                                            <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-fluid img2 mobile-img2" alt="p2">
                                                                        </a>
                                                                       
                                                                    </div>
                                                                    <div class="product-caption">
                                                                        <div class="product-content">
                                                                           
                                                                            <div class="product-title">
                                                                                <h6><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h6>
                                                                            </div>
                                                                            <div class="product-price">
                                                                                <div class="pro-price-box">
                                                                                    <span class="new-price">$<?php echo $row['p_current_price']; ?></span>
                                                                                    <?php if($row['p_old_price'] != ''): ?>
                                                                                    <span class="old-price">$<?php echo $row['p_old_price']; ?></span>
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
                                                    if($tot_rating == 0) {
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
                                                    if($avg_rating == 0) {
                                                        echo '';
                                                    }
                                                    elseif($avg_rating == 1.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    } 
                                                    elseif($avg_rating == 2.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    }
                                                    elseif($avg_rating == 3.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        ';
                                                    }
                                                    elseif($avg_rating == 4.5) {
                                                        echo '
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                        ';
                                                    }
                                                    else {
                                                        for($i=1;$i<=5;$i++) {
                                                            ?>
                                                            <?php if($i>$avg_rating): ?>
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
                                                            </li>
                                                            <?php
                                }
                        
                        ?>
                                                        </ul>
                                                    </div>
                                                    <div class="clear"></div>
							<div class="pagination">
                            <?php 
                                echo $pagination; 
                            ?>
                            </div>
                            <?php
                            endif;
                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Latest-product end -->
                                </div>
                                <div class="pro-grli-wrap product-sidebar">
                                    <div class="pro-grid-block">
                                        <?php require_once('_sidebar-category.php'); ?>
                                        <!-- sidebar img start -->
                                    
                                        <!-- sidebar img start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- collection end -->
        </main>
        <!-- main section end-->
       <?php require_once('_footer.php'); ?>