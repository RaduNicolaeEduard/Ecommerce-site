<?php
require_once '../core/init.php';
if (!is_logged_in()) {
    login_error_redirect();
}
if(!has_permission('admin')){
    permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/nav.php';
if(isset($_GET['delete'])){
    $delete_id = sanitize($_GET['delete']);
    $db->query("DELETE FROM users WHERE id = '$delete_id'");
    $_SESSION['success_flash'] = 'User has been deleted';
    header('Location: users.php');
}
if(isset($_GET['add'])){

    $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
    $email = ((isset($_POST['name']))?sanitize($_POST['email']):'');
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
    $errors = array();
    if($_POST){
        $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
        $emailCount = mysqli_num_rows($emailQuery);

        if ($emailCount != 0) {
            $errors[] = 'That email already exits in our database';
        }
        $required = array('name', 'email', 'password', 'confirm', 'permissions');
        foreach($required as $f){
            if (empty($_POST[$f])) {
                $errors[] = 'You must fill out all fields';
            break;
            }
        }
        if (strlen($password) < 6) {
            $errors[] = 'Your password must be at least 6 characters';
        }
        if ($password != $confirm) {
            $errors[] = 'Your password does not match';
        }
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'You must enter a valid emaild';
        }
        if (!empty($errors)) {
            echo display_errors($errors);
        }else{
            $hashed = password_hash($password,PASSWORD_DEFAULT);
            $db->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
            $_SESSION['success_flash'] = 'User has been added!';
            header('Location: users.php');
        }
    }
?>
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
<div class="container">
<div class="card card-cascade" style="margin-top:30px;margin-bottom:224px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Add A New User</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Deserve for her own card</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">

    <form action="users.php?add=1" method="post">
    <div class="containe">
        <div class="form-group col-md-6">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
        </div>
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group col-md-6">
            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
        </div>
        <div class="form-group col-md-6">
            <label for="name">Permissions: </label>
            <select class="browser-default custom-select" name="permissions">
                <option value=""<?=(($permissions == '')?' selected':'');?>></option>
                <option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>editor</option>
                <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
            </select>
            
        </div>
        <div class="form-group text-right" style="margin-top:25px;">
            <a href="users.php" class="btn btn-default">Cancel</a>
            <input type="submit" value="Add User" class="btn btn-success">
            
        </div>
        </div>
    </form>
    
</div>
</div>
</div>
<?php
}else{


$userQuery = $db->query("SELECT * FROM users ORDER by full_name");
?>
<div class="container">
<div class="card card-cascade" style="margin-top:30px">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Users</h2>
  <!-- Subtitle -->
  <p class="card-header-subtitle mb-0">Add Or Edit Users</p>

</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">



<a href="users.php?add=1" class="btn btn-success" >Add New User</a>
<hr>
<table class="table table-bordered table-striped table-condesed">
    <thead>
        <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>Join Date</th>
        <th>Last Login</th>
        <th>Permissions</th>
    </thead>
    <tbody>
        <?php while($user = mysqli_fetch_assoc($userQuery)): ?>
            <tr>
                <td>
                    <?php if($user['id'] != $user_data['id']):?>
                        <a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-sm"><i class="fas fa-times fa-2x"></i></a>
                    <?php endif;?>
                </td>
                <td><?=$user['full_name'];?></td>
                <td><?=$user['email'];?></td>
                <td><?=pretty_date($user['join_date']);?></td>
                <td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'never':pretty_date($user['last_login']));?></td>
                <td><?=$user['permissions'];?></td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>
</div>
</div>

</div>
<?php }include 'includes/footer.php'; ?>