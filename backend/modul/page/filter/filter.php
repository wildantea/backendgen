<style type="text/css">
  table tr:hover {
  cursor:move;
}
</style>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Filter Maker
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>modul">Maker</a></li>
                        <li class="active">Add Maker</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
                                <div class="box-header">
                                </div><!-- /.box-header -->

                  <div class="box-body">
                        <form class="form-horizontal" id="inputss" action="<?=base_admin();?>modul/page/filter/create_filter.php" method="post">
                      <div class="form-group">
                        <label for="text1" class="control-label col-lg-2"><?=$lang['menu_name'];?></label>
                        <div class="col-lg-10">
                          <input type="text" autofocus="" name="filter_name" required placeholder="Page name" class="form-control">
                        </div>
                      </div><!-- /.form-group -->

   <div class="col-lg-12">
    
    <h3>Form Page</h3>
   
                <div class="box">
                  <div id="defaultTable" class="body collapse in">
                    <table class="table responsive-table" >
                      <thead>

                        <tr style="background: rgb(60, 141, 188);color: #fff;">
                         <th>LABLE</th>
                          <th>TYPE</th>
                          <th>Chain</th>
                        
                        </tr>
                      </thead>
                       <tbody id="input_sort">

<tr class="row_new">


                       
                          <td>
                       <input type="text" class="form-control" id="label" name="label[]">
                     </td>
                          <td>
                            <select  name="type" class="form-control tipe">
                            
                              <option value="select_custom">Select Custom Value</option>
                              <option value="select">Select From Database</option>
                              <option value="select_chaining">Select Chainining</option>
                             </select>
                             <div class="type_content">

                             </div>

                          </td>
                          <td >
<input type="text" name="chain[]" class="form-control" style="float: left;width: 50px;margin-right: 10px;" >
<span  class="btn btn-primary btn-flat add_chain" ><i class='fa fa-plus'></i></span>
   
    <span  class="btn btn-danger btn-flat btn-remove" ><i class='fa fa-trash-o'></i></span>
   

</td>

                        </tr>



    </tbody>
 </table>
 <span style="margin-left: 10px;" class='btn btn-primary btn-flat' id='btn-clone'><i class='fa fa-plus'></i> Add Row</span> 


                  </div>
                </div>



              </div><!-- /.col-lg-6 -->


                      <div class="form-group">
                        <div class="col-lg-10" style="margin-left: 25px;">
                          <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Submit</button>
                        </div>
                      </div><!-- /.form-group -->
                    </form>
  
                  </div>
                  </div>
              </div>
</div>

                </section><!-- /.content -->


 <script type="text/javascript">
$(document).ready(function(){

$("#btn-clone-chain").click(function(){

  $("tr.row_new:last").clone().insertAfter("tr.row_new:last");
  $("tr.row_new:last").find('.type_content').html('');


   $(".btn-remove").click(function(){
    var obj = $(this);
    var count = $('tr.row_new').length;

    console.log(count);
    if(count>1){
      $(obj).parent().parent().remove();

    }
    return false;
  });




     $(".tipe").change(function(){
         var obj = $(this);
         val = obj.val();
        
        if (val=='select') {
        $.ajax({
          url: "<?=base_admin();?>modul/page/filter/from_db.php",
          success:function(data){
            obj.parent().find('.type_content').html(data);
            }
          });

        }
        else if (val=='select_chaining') {
           var maintb = $('#main_table').find(":selected").text();
                   $.ajax({
                  url: "<?=base_admin();?>modul/page/isi_chaining.php?main_table="+maintb+"&col="+col,
                  success:function(data){
                   obj.parent().find('.type_content').html(data);
                    }
                  });
        }

    });

     $(".type_content").on('change','.from',function(){
         var obj = $(this);
         tb = obj.val();
            if (tb!='') {
            $.ajax({
          url: "<?=base_admin();?>modul/page/filter/isi_on.php?tb="+tb,
          success:function(data){
            obj.parent().find('.isi_on').html(data);
            }
          });
        }
         else {
           obj.parent().find('.isi_on').html('');
         }


    });

});

$("#btn-clone").click(function(){
  //alert($("tr.row_new:last").html());
//console.log( $(this);
 // $("tr.row_new:last").find("select").select2("destroy");
  $("tr.row_new:last").clone().insertAfter("tr.row_new:last");
  $("tr.row_new:last").find('.type_content').html('');
  

 // $("tr.row_new:last").find("input").val("");

 // $("tr.row_new select").select2();



   $(".btn-remove").click(function(){
    var obj = $(this);
    var count = $('tr.row_new').length;

    console.log(count);
    if(count>1){
      $(obj).parent().parent().remove();

    }
    return false;
  });




     $(".tipe").change(function(){
         var obj = $(this);
         val = obj.val();
        
        if (val=='select') {
        $.ajax({
          url: "<?=base_admin();?>modul/page/filter/from_db.php",
          success:function(data){
            obj.parent().find('.type_content').html(data);
            }
          });

        }
        else if (val=='select_chaining') {
           var maintb = $('#main_table').find(":selected").text();
                   $.ajax({
                  url: "<?=base_admin();?>modul/page/isi_chaining.php?main_table="+maintb+"&col="+col,
                  success:function(data){
                   obj.parent().find('.type_content').html(data);
                    }
                  });
        }

    });

     $(".type_content").on('change','.from',function(){
         var obj = $(this);
         tb = obj.val();
            if (tb!='') {
            $.ajax({
          url: "<?=base_admin();?>modul/page/filter/isi_on.php?tb="+tb,
          success:function(data){
            obj.parent().find('.isi_on').html(data);
            }
          });
        }
         else {
           obj.parent().find('.isi_on').html('');
         }


    });

});


     $(".type_content").on('change','.from',function(){
         var obj = $(this);
         tb = obj.val();
            if (tb!='') {
            $.ajax({
          url: "<?=base_admin();?>modul/page/filter/isi_on.php?tb="+tb,
          success:function(data){
            obj.parent().find('.isi_on').html(data);
            }
          });
        }
         else {
           obj.parent().find('.isi_on').html('');
         }


    });




     $(".tipe").change(function(){
         var obj = $(this);
         val = obj.val();
             if (val=='select') {
        $.ajax({
          url: "<?=base_admin();?>modul/page/filter/from_db.php",
          success:function(data){
            obj.parent().find('.type_content').html(data);
            }
          });

        }
        else if (val=='select_chaining') {
           var maintb = $('#main_table').find(":selected").text();
                   $.ajax({
                  url: "<?=base_admin();?>modul/page/isi_chaining.php?main_table="+maintb+"&col="+col,
                  success:function(data){
                   obj.parent().find('.type_content').html(data);
                    }
                  });
        }
    });

});



  //onchange type
  function tipe(val,col)
  {

     var obj = $(this);
    console.log(obj);

    if (val=='select') {
        $.ajax({
      url: "<?=base_admin();?>modul/page/filter/from_db.php?col="+col,
      success:function(data){
        $("#type_content_"+col).html(data);
        }
      });

    }
    else if (val=='select_chaining') {
       var maintb = $('#main_table').find(":selected").text();
               $.ajax({
              url: "<?=base_admin();?>modul/page/isi_chaining.php?main_table="+maintb+"&col="+col,
              success:function(data){
                $("#type_content_"+col).html(data);
                }
              });
    }

  }


</script>
