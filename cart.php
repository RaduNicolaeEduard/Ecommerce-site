<?php
require_once 'core/init.php';
include 'inc/head.php';
include 'inc/nav.php';

if($cart_id != ''){
    $cartQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'],true);
    $i =1;
    $sub_total = 0;
    $item_count = 0;
}
?>

    
        <div class="text-center">
        <h2 class="text-center" style="margin-top:30px">My Shopping Cart</h2>
        <hr>
        <?php if($cart_id == ''):?>
        <div class="alert alert-danger">
            <p class="text-center"> Shopping Cart empty</p>
        </div>
        </div>
<?php else:?>
    <div class="container">
    <table class="table table-bordered table-condesed table-striped">
        <thead>
            <th>#</th>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Sub Total</th>
        </thead>
        <tbody>
            <?php
                foreach ($items as $item) {
                    $product_id = $item['id'];
                    $productQ = $db->query("SELECT * FROM products WHERE id ='{$product_id}'");
                    $product = mysqli_fetch_assoc($productQ);
                    $sArray = explode(',',$product['sizes']);
                    foreach($sArray as $sizeString){
                        $s = explode(':',$sizeString);
                        if ($s[0] == $item['size']) {
                            $available = $s[1];
                        }
                    }
                    ?>

                    <tr>
                        <td><?=$i;?></td>
                        <td><?=$product['title'];?></td>
                        <td><?=money($product['price']);?></td>
                        <td>
                            <button class="btn btn-sm" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>');"><i class="fas fa-minus"></i></button>
                            <?=$item['quantity'];?>
                            <?php if($item['quantity'] < $available): ?>
                           <button class="btn btn-sm" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>');"><i class="fas fa-plus"></i></button>
                            <?php else:?>
                                <span class="text-danger">Max Products</span>
                            <?php endif;?>
                        </td>
                        <td><?=$item['size'];?></td>
                        <td><?=money($item['quantity'] * $product['price']);?></td>
                    </tr>

                    <?php 
                    $i++;
                    $item_count += $item['quantity'];
                    $sub_total += ($product['price'] * $item['quantity']);
                } 
                    $tax = TAXRATE * $sub_total;
                    $tax = number_format($tax,2);
                    $grand_total = $tax + $sub_total;
                ?>
        </tbody>
    </table>
    <table class="table table-bordered table-condensed text-right">
    <legend>
            Totals
        </legend>
                <thead class="totals-table-header">
                    <th>Total Items</th>
                    <th>Sub Total</th>
                    <th>Tax</th>
                    <th>Grand Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$item_count;?></td>
                        <td><?=money($sub_total );?></td>
                        <td><?=money($tax);?></td>
                        <td class="alert-success"><?=money($grand_total);?></td>
                    </tr>
                </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#checkoutModal">
                Check Out <i class="fas fa-shopping-cart"></i>
</button>
    <!-- Central Modal Medium Success -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutmyModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead" id="checkoutModalLabel">Shipping Adress</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>


      <style>
      .contai {
  display: flex;
  flex-wrap: wrap;
}

.contai>div {
  flex: 0 50%;
  padding-right:5px;
}
      </style>
      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="far fa-4x fa-address-card animated rotateIn"></i>
         <form action="ThankYou.php" method="post" id="payment-form">
             <span class="" id="payment_errors"></span>
             <input type="hidden" name="tax" value="<?=$tax;?>">
             <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
             <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
             <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
             <input type="hidden" name="tax" value="<?=$tax;?>">
             <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count > 1)?'s':'').' From Fashion Factory';?>">
                <div id="step1" style="display:block;">
                <div class="contai">
                         <div class="form-group md-form mb-5">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="street">Street Address</label>
                        <input type="text" class="form-control" id="street" name="street">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="street2">Street Address 2</label>
                        <input type="text" class="form-control" id="street2" name="street2">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="county">County</label>
                        <input type="text" class="form-control" id="county" name="county">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" name="country">
                    </div>
                    </div>

                </div>
                <div id="step2" style="display:none;">
                <div class="contai">
                    <div class="form-group md-form mb-5">
                        <label for="name">Name on Card</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="number">Card Number</label>
                        <input type="text" id="number" class="form-control">
                    </div>
                    <div class="form-group md-form mb-5">
                        <label for="cvc">CVV Number</label>
                        <input type="text" id="cvc" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="exp-month">Expire Month</label>
                        <select id="exp-month" class="browser-default custom-select">
                            <option value=""></option>
                            <?php for($i=1;$i < 13; $i++):?>
                            <option value="<?=$i;?>"><?=$i;?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="exp-year" class="m">Expire Year:</label>
                        <select id="exp-year" class="browser-default custom-select">
                                <option value=""></option>
                                <?php $yr = date("Y");?>
                                <?php for($i=0;$i<11;$i++):?>
                                    <option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
                                <?php endfor;?>
                        </select>
                    </div>
                            </div>
            </div>
         
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
          
    
        <button type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" onclick="check_address();" id="next_button">Next</button>
        <button type="button" class="btn btn-outline-info waves-effect" onclick="back_address()" id="back_button" style="display:none">Back</button>
        <button type="submit" class="btn btn-info" id="check_out_button" style="display:none">Check Out</button>
        </form>
    </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Success-->
    </div>
<?php endif;?>

<script>
    function back_address(){
        jQuery('#payment_errors').html("");
                        jQuery('#step1').css("display","block");
                        jQuery('#step2').css("display","none");
                        jQuery('#next_button').css("display","block");
                        jQuery('#back_button').css("display","none");
                        jQuery('#check_out_button').css("display","none");
                        jQuery('#checkoutModalLabel').html("Shipping Address")
    }
    function check_address(){
        let data = {
            'full_name' : jQuery('#full_name').val(),
            'email' : jQuery('#email').val(),
            'street' : jQuery('#street').val(),
            'street2' : jQuery('#street2').val(),
            'city' : jQuery('#city').val(),
            'county' : jQuery('#county').val(),
            'zip_code' : jQuery('#zip_code').val(),
            'country' : jQuery('#country').val(),
            };

            jQuery.ajax({
                url : '/tutorial/admin/parsers/check_address.php',
                method : 'POST',
                data : data,
                success : function(data){
                    if(data != 'passed'){
                        jQuery('#payment_errors').html(data);
                        
                    }
                    if(data == 'passed'){
                        jQuery('#payment_errors').html("");
                        jQuery('#step1').css("display","none");
                        jQuery('#step2').css("display","block");
                        jQuery('#next_button').css("display","none");
                        jQuery('#back_button').css("display","block");
                        jQuery('#check_out_button').css("display","block");
                        jQuery('#checkoutModalLabel').html("Enter Your Card Details")
                    }
                },
                error : function(){aler("something Went Wrong");},
            });
    }
</script>
<?php
    include 'inc/footer.php'
?>