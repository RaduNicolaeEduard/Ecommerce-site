<?php   
        require_once 'core/init.php';
        include 'inc/head.php';
        include 'inc/nav.php';
        include 'inc/leftbar.php';
       

        $sql = "SELECT * FROM products";
        $cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
        if($cat_id == ''){
            $sql .= " WHERE deleted = 0";
        }else{
            $sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
        }
        $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
        $min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
        $max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
        $brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
        if($min_price != ''){
            $sql .= " AND price >= '{$min_price}'";
        }
        if($max_price != ''){
            $sql .= " AND price <= '{$max_price}'";
        }
        if ($brand != '') {
            $sql .= " AND brand = '{$brand}'";
        }
        if ($price_sort == 'low') {
          $sql .= " ORDER BY price";
        }
        if ($price_sort == 'high') {
            $sql .= " ORDER BY price DESC";
        }
        $productQ = $db->query($sql);
        $category = get_category($cat_id);

        
?>

    <!-- Main content-->
    <div class="col-md-8">
    <div class="card card-cascade" style="margin-top:37px; margin-bottom:30px;">
    <div class="view view-cascade gradient-card-header blue-gradient">
    <?php if($cat_id != ''):?>
    <h2 class="card-header-title mb-3"><?=$category['parent']. ' '. $category['child'];?></h2>
    <?php else:?>
    <h2 class="card-header-title mb-3">Fashion Factory</h2>
    <?php endif;?>
    <div class="container">
            
    
        



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
