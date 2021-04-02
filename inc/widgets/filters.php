<?php
    $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
    $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
    $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
    $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
    $b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
    $brandQ =$db->query("SELECT * FROM brand ORDER BY brand");
?>
<div class="card card-cascade" style="margin-top:45px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-1">Search By:</h2>
 
 <style>
 
 .containerae {
  display: flex;
  flex-wrap: wrap;
}

.containerae>div {
  flex: 0 50%;
  /*demo*/
  border: red solid;
  box-sizing:border-box
}
 </style>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

<h4 class="text-center">Price</h4>
<form action="search.php" method="post">
<input type="hidden" name="cat" value="<?=$cat_id;?>">
<input type="hidden" name="price_sort" value="0">
<div style="display:flex;">
<div class="form-check">
  <input type="radio" class="form-check-input" id="materialUnchecked" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>
  <label class="form-check-label" for="materialUnchecked">low>high</label>
</div>

<div class="form-check">
  <input type="radio" class="form-check-input" id="materialUncheckeda" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>
  <label class="form-check-label" for="materialUncheckeda">high>low</label>
</div>
</div>
<div class="form-row">
                <div class="col">
                    <div class="md-form">
                        <input type="text" name="min_price" id="materialRegisterFormFirstName" class="form-control" value="<?=$min_price;?>">
                        <label for="materialRegisterFormFirstName">Min Price</label>
                    </div>
                    </div>
                    <div class="col">
                    <div class="md-form">
                        <input type="text" name="max_price" id="materialRegisterFormFirstNamea" class="form-control" value="<?=$max_price;?>">
                        <label for="materialRegisterFormFirstNamea">Max Price</label>
                    </div>
                    </div>
                    </div>
<br>
     <h4 class="text-center">Brand</h4>  
     <div class="form-check containerae">
  <input type="radio" class="form-check-input" id="a" name="brand" value=""<?=(($b == '')?' checked':'');?>>
  <label for="a">All</label>  


  </div>
  <?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
    
    <div class="form-check containerae">
  <input type="radio" class="form-check-input" id="<?=$brand['brand'];?>" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?' checked':'');?>>
  <label for="<?=$brand['brand'];?>"><?=$brand['brand'];?></label>  
</div>
  <?php endwhile;?>
  <hr>

  <input type="submit" class="btn blue-gradient btn-rounded waves-effect" value="search">
  

</form>




    <!-- Text -->



  

  </div>

</div>