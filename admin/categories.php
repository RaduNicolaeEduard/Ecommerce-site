<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
if (!is_logged_in()) {
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/nav.php';

$sql="SELECT * FROM categories WHERE parent=0";
$result = $db->query($sql);
$errors = array();
$category = '';
$post_parent= '';
//Edit Category
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);
}
//Delete Category
if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "SELECT * FROM categories WHERE id = '$delete_id'";
    $result = $db->query($sql);
    $category = mysqli_fetch_assoc($result);
    if($category['parent'] == 0){
        $sqll = "DELETE FROM categories WHERE parent = '$delete_id'";
        $db->query($sqll);
    }
    $dsql = "DELETE FROM categories WHERE id = '$delete_id'";
    $db->query($dsql);
    header('Location; categories.php');
}

//Process Form

if(isset($_POST) && !empty($_POST)){
    //if category is blank
    $post_parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
    if(isset($_GET['edit'])){
    $id = $edit_category['id'];
    $sqlform = "SELECT * FROM categories WHERE category ='$category' AND paret = '$post_parent' AND id !='$id'";
    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
    if($category == ''){
        $errors[] .= 'The category cannot be left blank';
    }
    //daca exista in db
    if($count > 0){
        $errors[] .= $category. ' already exists, please choose a new category';
    }
    //display errors or update database
    if(!empty($errors)){
        //display errors
        $display = display_errors($errors); ?>

        <script>
            jQuery('document').ready(function(){
                jQuery('#errors').html('<?=$display;?>');
            });
        </script>
<?php   }else{
        //update database
        $updatesql = "INSERT INTO categories (category, parent) VALUES ('$category','$post_parent')";
        if(isset($_GET['edit'])){
            $updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
        }
        $db->query($updatesql);
        header('Location: categories.php');

    }
}
    $category_value ='';
    $parent_value =0;
    if(isset($_GET['edit'])){
        $category_value = $edit_category['category'];
        $parent_value = $edit_category['parent'];
    }else{
        if(isset($_POST)){
            $category_value = $category;
            $parent_value = $post_parent;
        }
    }
?>
<div class="container">
<div class="card card-cascade" style="margin-top:30px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Categories</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Add or edit categories</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">


</div>

<div class="row">
<!-- FORM -->

    <div class="col-md-6">
    <div class="container">
        <form action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" class="form">
        <legend style="font-size:30px"><?=((isset($_GET['edit']))?'Edit':'Add A');?> category</legend>
        <div id="errors"></div>
            <div class="form-group">
                <label for="parent">Parent</label>
                <select name="parent" class="browser-default custom-select" id="parent">
                    <option value="0"<?=(($parent_value == 0)?' selected="selected"':'');?>>Parent</option>
                    <?php while($parent = mysqli_fetch_assoc($result)):?>
                        <option value="<?=$parent['id']?>"<?=(($parent_value == $parent['id'])?' selected ="selected"':'');?>><?=$parent['category'];?></option>
                    <?php endwhile;?>
                </select>
                
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?=$category_value?>">
            </div>
            <div class="form-group"></div>
            <input type="submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Category" >
        </form>
        </div>
    </div>
    <div class="col-md-6">
 <!-- category table -->
 <div class="container">
    <table class="table ">
        <thead class="black white-text">
            <th style="font-size:20px">Category</th>
            <th style="font-size:20px">Parent</th>
            <th></th>
        </thead>
        <tbody>
        <?php 
            $sql="SELECT * FROM categories WHERE parent=0";
            $result = $db->query($sql);
            while($parent = mysqli_fetch_assoc($result)):
                $parent_id = (int)$parent['id'];
                $sql2 = "SELECT * FROM categories WHERE parent ='$parent_id'";
                $cresult = $db->query($sql2);
            ?>
            <tr class="grey lighten-2">
                <td style="font-size:23px"><?=$parent['category'];?></td>
                <td style="font-size:23px" >Parent</td>
                <td>
                    <a href="categories.php?edit=<?=$parent['id']?>" class="btn btn-sm btn-default"><i class="fas fa-edit fa-2x"></i></a>
                    <a href="categories.php?delete=<?=$parent['id']?>" class="btn btn-sm btn-default"><i class="fas fa-times fa-2x"></i></a>

                </td>
            </tr>
            <?php while($child = mysqli_fetch_assoc($cresult)):?>
            <tr>
                <td style="font-size:23px"><?=$child['category'];?></td>
                <td style="font-size:23px"><?=$parent['category'];?></td>
                <td>
                    <a href="categories.php?edit=<?=$child['id']?>" class="btn btn-sm btn-default"><i class="fas fa-edit fa-2x"></i></a>
                    <a href="categories.php?delete=<?=$child['id']?>" class="btn btn-sm btn-default"><i class="fas fa-times fa-2x"></i></a>

                </td>
            </tr>
        <?php endwhile;?>
        <?php endwhile;?>
        </tbody>
    </table></div>    

    </div></div>
</div>

            </div>
<?php include 'includes/footer.php';?>