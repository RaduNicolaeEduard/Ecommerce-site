<nav class="navbar navbar-expand-lg navbar-fixed-top navbar-dark unique-color-dark">
        <div class="container">
        <a href="index.php" class="navbar-brand">Fashion Factory ADMIN</a>
        
            <ul class="navbar-nav mr-auto" style="margin-top:10px;">


            <li ><a href="brands.php"class="nav-link">Brands</a></li>
            <li><a href="categories.php" class="nav-link">Categories</a></li>
            <li><a href="products.php" class="nav-link">Products</a></li>
           
            <?php if(has_permission('admin')): ?>
            <li><a href="users.php" class="nav-link">Users</a></li>
            <?php endif;?>
           
           
            <li class="dropdown">
                <a href="#" class="dropdown-toggle nav-link active" style="margin-left:500px" data-toggle="dropdown">Hello <?=$user_data['first'];?> !</a>
            <ul class="dropdown-menu" style="margin-left:500px" role="menu">
                <li><a href="change_password.php">Change Password</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            </li>
               
        </div>
    </nav>
   