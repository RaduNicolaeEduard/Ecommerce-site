<?php
require_once '../core/init.php';
if (!is_logged_in()) {
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/nav.php';
//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);
$errors = array();

//Edit Brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $edit_result = $db->query($sql2);
    $eBrand = mysqli_fetch_assoc($edit_result);

}

//delete brand
if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = '$delete_id'";
    $db->query($sql);
    header('Location: brands.php');
    
}


// if add form subbmited
if(isset($_POST['add_submit'])){
    $brand = sanitize($_POST['brand']);
    //check if brand is blank
    if($_POST['brand'] == ''){
        $errors[] .= 'You must enter a brand!';
    }
    //check if brand exists
    $sql = "SELECT * FROM brand WHERE brand = '$brand'";
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result);
    if($count > 0){
        $errors[] .= $brand. ' already exists. Please choose another brand...';
    }
    //display errors @nicolae
    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        //Add brand to database
        $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
        if(isset($_GET['edit'])){
            $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
        }
        $db->query($sql);
        header('Location: brands.php');
    }
}
?>
<div class="container">
<div class="card card-cascade" style="margin-top:30px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Brands</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Edit or add brands</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

  <!-- Text -->



<!-- Brand Form -->
<div class="d-flex justify-content-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
        <div class="form-group">
            <?php 
                $brand_value = '';
            if(isset($_GET['edit'])){
                $brand_value = $eBrand['brand'];
            }else{
                if(isset($_POST['brand'])){
                    $brand_value = sanitize($_POST["brand"]);
                }
            } ?>
            <label for="brand" "><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand: </label>
            <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>">
            <?php if(isset($_GET['edit'])):?>
                <a href="brands.php" class="btn btn-outline-danger btn-rounded waves-effect">Cancel</a>
            <?php endif; ?>
            <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Brand" class="btn btn-success">
        </div>
    </form>
</div>
<hr>
<table class="table table-bordered table-striped table-condested" style="width:700px;margin:0 auto;">
    <thead>
        <th></th>
        <th class="text-center" style="font-size:20px;">Brand</th>
        <th></th>
    </thead>
    <tbody>
        <?php while($brand = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><a href="brands.php?edit=<?=$brand['id'];?>" class="btn btn-sm "><i class="fas fa-edit fa-2x"></i></a></td>
                <td class="text-center"><?=$brand['brand']; ?></td>
                <td><a href="brands.php?delete=<?=$brand['id'];?>" class="btn btn-sm "><i class="fas fa-times fa-2x"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>

</div>
</div>
<?php include 'includes/footer.php'; ?>