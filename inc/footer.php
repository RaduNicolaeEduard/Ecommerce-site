<style>
    body{
        position: relative;
  min-height: 100vh;
    }
#footer{
    position: absolute;
  bottom: 0;
  width: 100%;
  height: 13rem;
}
</style>
<footer class="page-footer font-small unique-color-dark pt-4" id="footer">
    <div class="container">
        <ul class="list-unstyled list-inline text-center py-2">
            <li class="list-inline-item">
                <h5 class="mb-1"> DB Project <br>Radu Nicolae-Eduard</h5>        
        </li>
        </ul>
    </div>
<div class="footer-copyright text-center py-3">&copy I don't have Copyright 2018-2019 <a href="index.php">Fashion Factory</a>
<p>FILS 1221F</p>
</div>
</div>



</footer>
   


  <script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- jQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
    <script>
        function detailsmodal(id){
            let data = {"id" : id};
            jQuery.ajax({
                url:'/tutorial/inc/modal+footer.php',
                method : "post",
                data : data,
                success : function(data){
                    jQuery('body').append(data);
                    jQuery('#details-modal').modal('toggle');
                },
                error : function(){
                    alert("Something Went Wrong!")
                }
            });
        }

        function update_cart(mode,edit_id,edit_size){
            let data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
            jQuery.ajax({
                url : '/tutorial/admin/parsers/update_cart.php',
                method : "post",
                data : data,
                success : function(){location.reload();},
                error : function(){alert("Something went wrong");},
            });
        }

        function add_to_cart(){
            jQuery('#modal_errors').html("");
            let size = jQuery('#size').val();
            let quantity = jQuery('#quantity').val();
            let available =jQuery('#available').val();
            let error = '';
            let data = jQuery('#add_product_form').serialize();
            if (size == '' || quantity == '' || quantity == 0) {
                error += '<p class="text-white"> You must choose a size and quantity</p>';
                jQuery('#modal_errors').html(error);
                return;
            }else if(quantity > available){
                error += '<p class="text-white">There are only '+available+' available</p>';
                jQuery('#modal_errors').html(error);
            }else{
                jQuery.ajax({
                    url : '/tutorial/admin/parsers/add_cart.php',
                    method : 'post',
                    data : data,
                    success : function(){
                     location.reload();
                    },
                    error : function(){alert("something went wrong");}
                });
            }
        }
    </script>
</body>
</html>