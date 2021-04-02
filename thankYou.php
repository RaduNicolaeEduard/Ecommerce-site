<?php
require_once 'core/init.php';
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$county = sanitize($_POST['county']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);

$metadata = array(
    "cart_id" => $cart_id,
    "tax" => $tax,
    "sub_total" => $sub_total,
);

//adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
$iresult = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresult['items'],true);
foreach ($items as $item) {
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT sizes FROM products WHERE id ='{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']);
  foreach($sizes as $size){
    if($size['size'] == $item['size']){
      $q = $size['quantity'] - $item['quantity'];
      $newSizes[] = array('size' => $size['size'],'quantity' => $q);
    }else{
      $newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity']);
    }
  }
  $sizeString = sizesToString($newSizes);
  $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}


//update cart
$db->query("UPDATE cart set paid = 1 WHERE id ='{$cart_id}'");
$db->query("INSERT INTO transactions
    (cart_id,full_name,email,street,street2,city,county,zip_code,country,sub_total,tax,grand_total,description) VALUES
    ('$cart_id','$full_name','$email','$street','$street2','$city','$county','$zip_code','$country','$sub_total','$tax','$grand_total','$description')");

    $domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
    include 'inc/head.php';
    include 'inc/nav.php';
    ?>
    <div class="container">
    <!-- Card -->
<div class="card card-cascade wider reverse" style="margin-top:100px;">

<!-- Card image -->
<div class="view view-cascade overlay">
  <!-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Card image cap">
  <a href="#!"> -->
    <div class="mask rgba-white-slight"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

  <!-- Title -->
  <h4 class="card-title"><strong>Thank You!</strong></h4>
  <!-- Subtitle -->
  <h6 class="font-weight-bold indigo-text py-2">Order Total: <?=money($grand_total);?></h6>
  <!-- Text -->
  <p class="card-text"><p>Your Order has been sucesfully placed. Your recipt number is: <strong><?=$cart_id;?></strong></p>
<p>The items will be shipped to the address below</p>
<address>
    <?=$full_name;?><br>
    <?=$street;?><br>
    <?=(($street2 != '')?$street2.'<br>':'');?>
    <?=$city. ', '. $county. ', '.$zip_code;?><br>
    <?=$country;?><br>
</address>
  </p>

  

</div>
</div>
</div>
<!-- Card -->
<?php
    include 'inc/footer.php'

?>
