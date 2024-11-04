<div class="shop-sidebar-inner">
                                            <div class="shop-sidebar-wrap filter-sidebar">
                                                <!-- button start -->
                                                <button class="close-sidebar" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                </button>
                                                <!-- button end -->
                                                <!-- filter-form start -->
                                                <div class="facets">
                                                    <form class="facets-form">
                                                        <div class="facets-wrapper">
                                                            <!-- Product-Categories start -->
                                                           


                                                            <div class="shop-sidebar sidebar-product">
                                                                <h6 class="shop-title" data-animate="animate__fadeInUp">Product Categories</h6>


                                                                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $i++;
                    ?>
                                                                <a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category"  class="shop-title shop-title-lg" data-animate="animate__fadeInUp"><?php echo $row['tcat_name']; ?></a>
                                                               
                                                                <div class="collapse filter-element" id="collapse-2" data-animate="animate__fadeInUp">
                                                                    <ul class="brand-ul scrollbar">
                                                                    <?php
                            $j=0;
                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                            $statement1->execute(array($row['tcat_id']));
                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $row1) {
                                $j++;
                                ?>
                                                                        <li class="brand-li">
                                                                            <label class="cust-checkbox-label">
                                                                                <a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category" name="cust-checkbox" class="cust-checkbox">
                                                                                <span class="filter-name"><?php echo $row1['mcat_name']; ?></span>
                                                                                </a>
                                                                              
                                                                            </label>
                                                                        </li>
                                                                        <?php
                                            }
                                        ?>
                                                                    </ul>
                                                                </div>
                                                                <?php
                                            }
                                        ?>
                                                            </div>

                                                        
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- filter-form end -->
                                            </div>
                                        </div>