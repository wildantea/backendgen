<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        User Group
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>user-group">User Group</a></li>
                        <li class="active">User Group List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <a id="add_user_group" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo $lang["add_button"];?></a>
                            </div><!-- /.box-header -->
                            <div class="box-body">
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_user_group" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Level</th>
                                  <th>Description</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
              </div>

    <div class="modal" id="modal_user_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> User Group</h4> </div> <div class="modal-body" id="isi_user_group"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
      
      $("#add_user_group").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/user_group/user_group_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_user_group").html(data);
              }
          });

      $('#modal_user_group').modal({ keyboard: false,backdrop:'static',show:true });

    });
    
      
    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/user_group/user_group_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_user_group").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_user_group').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_user_group = $("#dtb_user_group").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [3],
              "orderable": false,
              "searchable": false,
              "className": "all"
            },
      
            {
             "targets": [0],
             "width" : "5%",
              "orderable": false,
              "searchable": false,
              "className": "dt-center"
            } ],
      
            'ajax':{
              url :'<?=base_index();?>modul/user_group/user_group_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });

</script>
            