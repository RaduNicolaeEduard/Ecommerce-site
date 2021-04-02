<?php   
        require_once 'core/init.php';
        include 'inc/head.php';
        include 'inc/nav.php';
        include 'inc/leftbar.php';
        if(isset($_GET['cat'])){
            $cat_id = sanitize($_GET['cat']);
        }else{
            $cat_id = '';
        }
        $sql = "SELECT * FROM products WHERE categories = '$cat_id'";
        $productQ = $db->query($sql);
        $category = get_category($cat_id);

        
?>

    <!-- Main content-->
    <div class="col-md-8">
 
    <div class="container">
            
            <div class="card card-cascade" style="margin-top:39px; margin-bottom:30px;">

    <!-- Card image -->
    <div class="view view-cascade gradient-card-header blue-gradient">

    <!-- Title -->
    <h2 class="card-header-title mb-10"><?=$category['parent']. ' '. $category['child'];?></h2>
    <!-- Subtitle -->


    </div>
    </div>
    </div>
    <div class="row">
                
                <?php while($product = mysqli_fetch_assoc($productQ)) : ?>
                <div class="col-md-3" style="ma">
                    <!-- Card Wider -->
                            <div class="card card-cascade wider" style="height:90%;">

                            <!-- Card image -->
                            <div class="view view-cascade overlay">
                            <img  class="card-img-top" src="<?= $product['image']; ?>" alt="Card image cap">
                            <a href="#!">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                            </div>

                            <!-- Card content -->
                            <div class="card-body card-body-cascade text-center pb-0">

                            <!-- Title -->
                            <h4 class="card-title"><strong><?= $product['title']; ?></strong></h4>
                            <!-- Subtitle -->
                            <h5 class="blue-text pb-2"><strong><?= $product['price']; ?> RON</strong></h5>
                            <!-- Text -->
                            <p class="card-text">List Price: <s><?= $product['list_price']; ?></s></p>

                            

                            <!-- Card footer -->
                            <div class="card-footer text-muted text-center mt-4">
                              
                    <button type="button" class="btn blue-gradient btn-rounded waves-effect btn-block" style="font-size:15px" onclick="detailsmodal(<?=$product['id']; ?>)">Details</button>
                            </div>

                            </div>

                            </div>
                            <!-- Card Wider -->
                                            </div>
                                            <?php endwhile; ?>

            </div>
        </div>
        
<?php
    
    include 'inc/rightbar.php';
    include 'inc/footer.php';
?>
