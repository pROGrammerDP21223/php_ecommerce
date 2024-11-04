<section class="slider-content">
        <div class="home-slider owl-carousel owl-theme" id="home-slider">

            <?php
            $i = 0;
            $statement = $pdo->prepare("SELECT * FROM tbl_slider");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
                <div class="item">
                    <div class="slider-image-info">
                        <!-- slider-text start -->
                        <div class="slider-image">
                            <img src="assets/uploads/<?php echo $row['photo']; ?>" class="img-fluid desk-img" alt="slider1">

                        </div>
                        <!-- slider-img end -->
                        <div class="container slider-info-content">
                            <div class="row">
                                <div class="col">
                                    <div class="slider-info-wrap <?php if ($row['position'] == 'Left') {
                                                                        echo 'slider-content-left slider-text-left';
                                                                    } elseif ($row['position'] == 'Center') {
                                                                        echo 'slider-content-center slider-text-center';
                                                                    } elseif ($row['position'] == 'Right') {
                                                                        echo 'slider-content-right slider-text-right';
                                                                    } ?> ">
                                        <!-- slider-text start -->
                                        <div class="slider-info-text">
                                            <div class="slider-text-info">

                                                <h2><span><?php echo $row['heading']; ?></span></h2>
                                                <div class="slider-text">

                                                    <span> <?php echo nl2br($row['content']); ?></span>
                                                </div>
                                                <a href="<?php echo $row['button_url']; ?>" class="btn btn-style"><?php echo $row['button_text']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- slider-text end -->
                    </div>
                </div>
            <?php
                $i++;
            }
            ?>
        </div>
    </section>