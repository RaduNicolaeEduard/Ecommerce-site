<style>
    
</style>
<footer class="page-footer font-small unique-color-dark pt-4" id="footer">
    <div class="container">
        <ul class="list-unstyled list-inline text-center py-2">
            <li class="list-inline-item">
                <h5 class="mb-1"> DB Project <br>Radu Nicolae-Eduard</h5>        
        </li>
        </ul>
    </div>
<div class="footer-copyright text-center py-3"><a href="index.php">Fashion Factory</a>
<p>FILS 1221F</p>
</div>
</div>



</footer>
   
<script type="text/javascript" src="../js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script>
<script>
    function UpdateSizes(){
        let sizeString = '';
        for(let i=1 ; i<=12 ; i++){
            if(jQuery('#size'+i).val()!=''){
                sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
            }
        
        }
        jQuery('#sizes').val(sizeString);
    }

    function get_child_options(selected){
        if (typeof selected == 'undefined') {
            let selected ='';
        }
        let parentID = jQuery('#parent').val();
        jQuery.ajax({
            url:'/tutorial/admin/parsers/child_categories.php',
            type:'POST',
            data: {parentID : parentID, selected: selected},
            success: function(data){
                jQuery("#child").html(data);
            },
            error: function(){alert("Something went wrong with the child options.")},
        });
    }
    jQuery('select[name="parent"]').change(function(){
        get_child_options();
    });
</script>
</body>
</html>