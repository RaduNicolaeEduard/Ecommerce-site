<?php
require_once '../core/init.php'; 
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql ="SELECT brand FROM brand WHERE id='$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$sizestring = rtrim($sizestring,',');
$size_array = explode(',',$sizestring);

?>

<script>
// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});</script>
            <?php ob_start(); ?>
            
            <div class="modal fade right " id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-full-height modal-right">
                    <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title text-center"><?=$product['title'];?></h4>
                        <span id="modal_errors" class="bg-info"></span>
                       
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="center-block"><img src="<?=$product['image'];?>" style="width:450px;"class="details images-responsive" alt="<?=$product['title'];?>"></div>
                                </div>
                                <div class="col-sm-6">
                                    <h4>Details</h4>
                                    <p><?=nl2br($product['description']);?></p>
                                    <hr>
                                    <p>Price: <?=$product['price'];?></p>
                                    <p>Brand: <?=$brand['brand'];?></p>
                                    <form action="add_cart.php" method="post" id="add_product_form">
                                        <input type="hidden" name="product_id" value="<?=$id;?>">
                                        <input type="hidden" name="available" id="available" value="">
                                        <div class="form-group">
                                            <div class="col-xs-3 md-form">
                                                <label for="quantity">Quantity:</label>
                                                <input type="text" class="form-control" name="quantity" id="quantity">
                                            </div> <div class="col-xs-9"></div>
                                            <br>
                                        </div>
                                        <div class="form-group">
                                            <label for="size">Size:</label>
                                            <select name="size" id="size" class="mdb-select md-form">
                                            
                                                <option value=""></option>
                                                <?php foreach($size_array as $string){
                                                    $string_array = explode(':', $string);
                                                    $size = $string_array[0];
                                                    $available = $string_array[1];
                                                    if($available > 0){
                                                    echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.'('.$available.' Available)</option>';
                                                }}?>
                                                
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                   
                        <button class="btn btn-outline-danger btn-rounded waves-effect" onclick="closeModal()">CLOSE</button>
                        <button class="btn btn-primary btn-rounded" onclick="add_to_cart();return false;"><span class="fas fa-shopping-cart"></span> Add To Cart</button>
                    </div>
                    </div>
                </div>
            </div>
            <script>
                jQuery('#size').change(function(){
                    let available = jQuery('#size option:selected').data("available");
                    jQuery('#available').val(available);
                });

                function closeModal(){
                    jQuery('#details-modal').modal('hide');
                    setTimeout(function(){
                        jQuery('#details-modal').remove();
                        jQuery('.modal-backdrop').remove();
                    },300);
                }
            </script>
      <?php echo ob_get_clean(); ?>