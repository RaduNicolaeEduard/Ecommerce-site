<?php
require_once '../core/init.php';
if (!is_logged_in()) {
   header('Location: login.php');
}
include 'includes/head.php';
include 'includes/nav.php';

?>

<?php
    $txnQuery ="SELECT t.id, t.cart_id, t.full_name,t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
    FROM transactions t
    LEFT JOIN cart c ON t.cart_id = c.id
    WHERE c.paid = 1 AND c.shipped = 0
    ORDER BY t.txn_date";
    $txnResults = $db->query($txnQuery);
?>
<div class="row">
<!-- orders to fill -->
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="card card-cascade" style="margin-top:30px;">

<!-- Card image -->
<div class="view view-cascade gradient-card-header blue-gradient">

  <!-- Title -->
  <h2 class="card-header-title mb-3">Orders To Ship</h2>
  <!-- Subtitle -->


</div>

<!-- Card content -->
<div class="card-body card-body-cascade text-center">



</div>
    <table class="table table-condesed table-bordered table-striped">
        <thead>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Total</th>
            <th>Date</th>
        </thead>
        <tbody>
        <?php while($order = mysqli_fetch_assoc($txnResults)):?>
            <tr>
                <td><a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-sm btn-info">Details</a></td>
                <td><?=$order['full_name'];?></td>
                <td><?=$order['description'];?></td>
                <td><?=money($order['grand_total']);?></td>
                <td><?=pretty_date($order['txn_date']);?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
</div>
<div class="col-md-2"></div>
<?php include 'includes/footer.php'; ?>