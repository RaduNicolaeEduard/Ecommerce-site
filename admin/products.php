<?php 
require_once $_SERVER['DOCUMENT_ROOT']. '/tutorial/core/init.php';
if (!is_logged_in()) {
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/nav.php';

//Delete Product
if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
    header('LOCATION: products.php');
}

$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand ");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title'])&& $_POST['title'] != '')?sanitize($_POST['title']):'');
$sizes = ((isset($_POST['sizes'])&& $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
$price = ((isset($_POST['price'])&& $_POST['price'] != '')?sanitize($_POST['price']):'');
$list_price = ((isset($_POST['list_price'])&& $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description'])&& $_POST['description'] != '')?sanitize($_POST['description']):'');
$sizes = rtrim($sizes,',');
$saved_image = '';
    if (isset($_GET['edit'])) {
        $edit_id = (int)$_GET['edit'];
        $productResult = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
        $product = mysqli_fetch_assoc($productResult);
        if (isset($_GET['delete_image'])) {
            $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
          unlink($image_url);
          $db->query("UPDATE products SET image = '' WHERE id ='$edit_id'");
          header('Location: products.php?edit='.$edit_id);
        }
        $category =((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
        $title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['title']);
        $sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes']))?sanitize($_POST['sizes']):$product['sizes']);
        $price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$product['price']);
        $list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
        $description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$product['description']);
        $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['brand']);
        $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
        $parentResult = mysqli_fetch_assoc($parentQ);
        $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parentResult['parent']);
        $sizes = rtrim($sizes,',');
        $saved_image = (($product['image'] != '')?$product['image']:'');
        $dbpath = $saved_image;
    }
    if (!empty($sizes)) {
        $sizeString = sanitize($sizes);
        $sizeString = rtrim($sizeString,',');
        $sizesArray = explode(',',$sizeString);
        $sArray = array();
        $qArray = array();
        foreach ($sizesArray as $ss) {
            $s = explode(':', $ss);
            $sArray[] = $s[0];
            $qArray[] = $s[1];
        }

    }else{$sizesArray = array();}
if ($_POST) {
    $dbpath ='';
    $errors = array();
    $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
    foreach ($required as $field ) {
        if ($_POST[$field] == '') {
            $errors[] = 'All Fields With an Astrisk are required.';
        break;
        }
    }
    if (!empty($_FILES)) {
  
        $photo = $_FILES['photo'];
        $name = $photo['name'];
        $nameArray = explode('.',$name);
        $fileName = $nameArray[0];
        $fileExt = $nameArray[1];
        $mime = explode('/',$photo['type']);
        $mimeType = $mime[0];
        $mimeExt = $mime[1];
        $tmpLoc = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $allowed = array('png','jpg','jpeg','gif');
        $uploadName = md5(microtime()).'.'.$fileExt;
        $uploadPath = BASEURL.'images/products/'.$uploadName;
        $dbpath = '/tutorial/images/products/'.$uploadName;
        if ($mimeType != 'image') {
            $errors[] = 'The file must be a image';
        }
        if (!in_array($fileExt, $allowed)) {
            $errors[] = 'The photo must be  png ,jpg ,jpeg or gif';
        }
        if ($fileSize > 25000000) {
            $errors[] ='The file size must be under 25mb';
        }
        if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
            $errors[] = 'File extention does not match the file.';
        }
    }
    if (!empty($errors)) {
        echo display_errors($errors);
    }else {
        //upload file and insert into database
        move_uploaded_file($tmpLoc,$uploadPath);
        $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`) 
        VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description')";
        if(isset($_GET['edit'])){
            $insertSQL = "UPDATE products SET `title` = '$title', `price` = '$price', `list_price` = '$list_price', 
            `brand` ='$brand', `categories` ='$category', `sizes` = '$sizes', `image` = '$dbpath', `description` = 'description'
            WHERE id = '$edit_id'";
        }
        $db->query($insertSql);
        header('Location: products.php');

    }
}

?>
<div class="container">
<div class="card card-cascade" style="margin-top:30px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2>


</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
<div class="containe">
    <div class="form-group col-md-3">
        <label for="title">Title*:</label>
        <input type="text" class="form-control" name="title" id="title" value="<?=$title;?>">
    </div>
    <div class="form-group col-md-3">
        <label for="brand">Brand*:</label>
        <select class=" browser-default custom-select" name="brand" id="brand">
            <option value=""<?=(($brand == '')?' selected':'');?>></option>
            <?php while($b = mysqli_fetch_assoc($brandQuery)):?>
            <option value="<?=$b['id']?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand'];?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class = "form-group col-md-3">
        <label for="parent">Parent Category*:</label>
        <select name="parent" class="browser-default custom-select"id="parent">
            <option value=""<?=(($parent == '')?' selected':'');?>></option>
            <?php while($p = mysqli_fetch_assoc($parentQuery)):?>
            <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?'selected':'');?>><?=$p['category'];?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="form-group col-md-3">
                <label for="child">Child Category*: </label>
                <select name="child" class="browser-default custom-select"id="child">
                   
                </select>
    </div>
    <div class="form-group col-md-3">
                <label for="price">Price*: </label>
                <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
    </div>
    <div class="form-group col-md-3">
                <label for="list_price">List Price: </label>
                <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
    </div>
    <div class="form-group col-md-3">
        <label for="">Quantity & Sizes*: </label>
        <button class=" btn btn-xs btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
    </div>
    <div class="form-group col-md-3">
        <label for="sizes">Sizes & Qty Preview</label>
        <input type="text" name="sizes" class="form-control"id="sizes" value="<?=$sizes;?>" readonly>
    </div>
    <div class="form-group col-md-6">
    <?php if($saved_image != ''):?>
        <div class="saved-image "><img src="<?=$saved_image;?>" alt="saved image" style="width: 200px;height: auto;"></div><br>
        <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete image</a>
    <?php else:?>
        <label for="photo">Product Photo*: </label>
        <input type="file" name="photo" id="photo" class="form-control">
        <?php endif ;?>
    </div>
    <div class="form-group col-md-6">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"cols="30" rows="6"><?=$description;?></textarea>
    </div>
    <div class="form-group pull-right">
        <a href="products.php" class="btn btn-outline-danger btn-rounded waves-effect">Cancel</a>
        <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class=" btn btn-success btn-rounded waves-effect">
    </div><div class="clearfix"></div>
    </div>
</form>



<style>
    /* .modal-backdrop {
    z-index: 1040 !important;
}
.modal-dialog {
    margin: 2px auto;
    z-index: 1100 !important;
} */
.containe{
    display:flex;
    flex-wrap:wrap;
}
</style>

<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
      <div class="containe">
        <?php for($i=1; $i <= 12; $i++):?>
            <div class="form-group col-md-4">
                <label for="size<?=$i;?>">Size:</label>
                <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="qty<?=$i;?>">Quantity:</label>
                <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
            </div>
        <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="UpdateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php } else {
    


$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);

if (isset($_GET['featured'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $db->query($featuredSql);
    header('Location: products.php');
}
?>
<div class="container">
<div class="card card-cascade" style="margin-top:30px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Products</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Add or edit products</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

  <!-- Text -->




    <a href="products.php?add=1" class="btn btn-success" id="add-product-btn" style="" >Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
    <thead>
        <th></th>
        <th>Product</th>
        <th>Price</th>
        <th>Categories</th>
        <th>Featured</th>
        <th>Sold</th>
    </thead>
    <tbody>
        <?php while($product = mysqli_fetch_assoc($presults)):
                $childID = $product['categories'];
                $catSql = "SELECT * FROM categories WHERE id = '$childID'";
                $result = $db->query($catSql);
                $child = mysqli_fetch_assoc($result);
                $parentID = $child['parent'];
                $pSql = "SELECT * FROM categories WHERE id ='$parentID'";
                $presult = $db->query($pSql);
                $parent = mysqli_fetch_assoc($presult);
                $category = $parent['category'].'~'.$child['category'];
            ?>
            <tr>
                <td>
                    <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-sm btn-default"><i class="fas fa-edit fa-2x"></i></a>
                    <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-sm btn-default"><i class="fas fa-times fa-2x"></i></a>
                </td>
                <td><?=$product['title'];?></td>
                <td><?=money($product['price']);?></td>
                <td><?=$category;?></td>
                    <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-sm btn-default">
                    <span class="fas fa-<?=(($product['featured'] ==1)?'minus':'plus');?>"></span>
                    </a>&nbsp <?=(($product['featured'] == 1)?'Featured Product':'');?></td>
                <td>0</td>
            </tr>
        <?php endwhile;?>
    </tbody>
    
</table>
        </div>
</div>

</div>

<?php }
include 'includes/footer.php';
?>
<script>
    jQuery('document').ready(function(){
        get_child_options('<?=$category;?>');

    });
</script>