
<div>
    <?php if(empty($cart_id)):?>      
    <?php else:
    $cartQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
    $results = mysqli_fetch_assoc($cartQ);
    $items = json_decode($results['items'],true);
    $sub_total =0;    
    ?>
    <!-- Card -->

<!-- Card -->
<div class="card card-cascade" style="margin-top:45px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Shopping Cart</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Fashion Factory</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

  <!-- Text -->
  <table class="table table-condensed" id="cart_widget">
            <tbody>
                <?php foreach($items as $item):
                    $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
                    $product = mysqli_fetch_assoc($productQ);
                ?>
                    <tr>
                        <td><?=$item['quantity'];?></td>
                        <td><?=substr($product['title'],0,20);?></td>
                        <td><?=money($item['quantity'] * $product['price']);?></td>
                    </tr>
                <?php 
                    $sub_total +=($item['quantity'] * $product['price']);
            endforeach;?>
            <tr>
                <td></td>
                <td>Sub Total</td>
                <td><?=money($sub_total);?></td>
            </tr>
            </tbody>
        </table>

    <?php endif;?>
  <hr>

<a href="cart.php" class="btn btn-rounded blue-gradient btn-block"><i class="fas fa-2x fa-shopping-cart"> </i></a>


</div>

</div>

       
    </div>
