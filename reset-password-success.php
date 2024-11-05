<?php require_once('_header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
}
?>


        <main>
            <!-- breadcrumb start -->
            <section class="breadcrumb-area">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="breadcrumb-index">
                                <!-- breadcrumb-list start -->
                                <ul class="breadcrumb-ul">
                                    <li class="breadcrumb-li">
                                        <a class="breadcrumb-link" href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-li">
                                        <span class="breadcrumb-text">Reset Password</span>
                                    </li>
                                </ul>
                                <!-- breadcrumb-list end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb end -->
            <!-- customer-page start -->
            <section class="customer-page section-ptb">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <!-- account login title start -->
                       
                            <div class="user-content">
                    <?php echo LANG_VALUE_146; ?><br><br>
                    <a href="<?php echo BASE_URL; ?>login.php" style="color:#e4144d;font-weight:bold;"><?php echo LANG_VALUE_11; ?></a>
                </div>   
                            <!-- account login start -->
                        </div>
                    </div>
                </div>
               
            </section>
            <!-- customer-page end  -->
        </main>
        <!-- main section end-->
        <?php require_once('_footer.php'); ?>