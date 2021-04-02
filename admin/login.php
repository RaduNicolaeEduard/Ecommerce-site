<?php 
require_once $_SERVER['DOCUMENT_ROOT']. '/tutorial/core/init.php';
include 'includes/head.php';
// $password = 'password';
// $hashed = password_hash($password,PASSWORD_DEFAULT);
// echo $hashed
$email =((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password =((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>
<script src="js/particles.js"></script>
<script src="js/app.js"></script>

<style>
    html,body{ 
	width:100%;
	height:100%;
    background:#111;
}
#particles-js {
  position: fixed;
  z-index: 50;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}
  
</style>    

<div id="login-form" >
    <div>
        <?php
        if($_POST){
            //form validation
            if(empty($_POST['email']) || empty($_POST['password'])){
            $errors[] = 'You must prodvide email and password';
        }
        //validate email
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $errors[] ='You must enter a valid email';
        }
        // password is more than 6 characters
        if(strlen($password)<6){
            $errors[] = 'Password must be at least 6 characters';
        }
        //user exists
        $query = $db->query("SELECT * FROM users WHERE email = '$email'");
        $user = mysqli_fetch_assoc($query);
        $userCount = mysqli_num_rows($query);
        if($userCount<1){
            $errors[] = 'That email does not exit in the database';
        }
        
        if (!password_verify($password,$user['password'])) {
            $errors[] = 'The password is inccorect';
        }

        //check for errorrs
        if(!empty($errors)){
            echo display_errors($errors);
        }else{
            //log user in
            $user_id = $user['id'];
            login($user_id);
        }
    }
        ;?>
    </div>
    <h2 class="text-center">Login</h2><hr>
    <form action="login.php" method ="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group">
            <input type="submit" value="login" class="btn btn-primary">
        </div>
    </form>
    <p class= "text-right"><a href="/tutorial/index.php" alt="home">Visit Site</a></p>
    </div>
</div>
</div>
