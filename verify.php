<?php require_once('_header.php'); ?>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['cust_token']) {
            header('location: '.BASE_URL);
            exit;
        }
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
        $statement->execute(array('',1,$_GET['email']));

        $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';     
    }
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
                                        <a class="breadcrumb-link" href="index.php">Home</a>
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
                       
                            <?php 
                        echo $error_message;
                        echo $success_message;
                    ?>
                            <!-- account login start -->
                        </div>
                    </div>
                </div>
               
            </section>
            <!-- customer-page end  -->
        </main>
        <!-- main section end-->
        <?php require_once('_footer.php'); ?>