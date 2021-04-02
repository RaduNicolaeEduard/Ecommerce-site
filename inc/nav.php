<?php
    $sql = "SELECT * FROM categories WHERE parent = 0";
    $pquerry = $db->query($sql);
?>

<nav class="navbar navbar-expand-lg navbar-fixed-top navbar-dark unique-color-dark">
        <div class="container">
        <a href="index.php" class="navbar-brand">Fashion Factory</a>
            <ul class="navbar-nav mr-auto">

            <?php while($parent = mysqli_fetch_assoc($pquerry)) :?>
                <?php 
                    $parent_id = $parent['id'];
                    $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
                    $cquerry = $db->query($sql2);
                ?>
                <li class="nav-item dropdown" style="margin-left:20px;">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    <?php while($child = mysqli_fetch_assoc($cquerry)) : ?>
                    <li><a href="category.php?cat=<?=$child['id']?>"><?php echo $child['category'];?></a></li>
                    <?php endwhile; ?>
                    </ul>
                </li>
                <?php endwhile; ?>
                <li class="nav-item">
                    <a href="cart.php" class="nav-link" ><i class="fas fa-shopping-cart"></i>My Cart</a>
                </li>
                    </ul>
        </div>
    </nav>