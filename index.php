<?php
        require_once 'core/init.php';
        include 'inc/head.php';
        include 'inc/nav.php';
        include 'inc/paral.php';
        include 'inc/leftbar.php';

        $sql = "SELECT * FROM products WHERE featured = 1";
        $featured = $db->query($sql);
?>

    <!-- Main content-->
        <div class="col-md-8">
        <div class="container">
            
    
            <div class="card card-cascade" style="margin-top:37px; margin-bottom:30px;">

    <!-- Card image -->
    <div class="view view-cascade gradient-card-header blue-gradient">

    <!-- Title -->
    <h2 class="card-header-title mb-3">BEST SELLERS</h2>
    <!-- Subtitle -->
    <p class="card-header-subtitle mb-0">NEW COLLECTION</p>

    </div>
    </div>
    </div>
        
            <div class="row">
                
                <?php while($product = mysqli_fetch_assoc($featured)) : ?>
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
                            <div class="card-footer text-muted text-center mt-2">
                              
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
