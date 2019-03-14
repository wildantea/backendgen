<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Web Service
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-service">Data Service</a></li>
                        <li class="active">Data Service List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                  <a href="<?=base_index();?>service/create" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> <?=$lang['add_button'];?></a>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12" style="margin-bottom: 10px">
                                   <button id="bulk_delete" style="display: none;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <?php echo $lang["delete_selected"];?></button> <span class="selected-data"></span>
                            </div>
                            </div>
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_data_service" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th rowspan="2">Name</th>
                                  <th rowspan="2">URL</th>
                                  <th rowspan="2">URL Doc</th>
                                  <th colspan="4" class="dt-center">Enable Token</th>
                                  <th rowspan="2">Format</th>
                                  <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                  <th>Read</th>
                                  <th>Create</th>
                                  <th>Update</th>
                                  <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
              </div>
 <?php
  $edit ="";
  $del="";
 if ($db->userCan("update")) {
    $edit = "<a data-id='+data+'  class=\"btn btn-primary btn-sm edit_data \" data-toggle=\"tooltip\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
      
 }
  if ($db->userCan("delete")) {
    
    $del = "<button data-id='+data+' data-uri=".base_admin()."modul/service/service_action.php".' class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Delete" data-variable="dtb_data_service"><i class="fa fa-trash"></i></button>';
    
 }
        ?>

    <div class="modal" id="modal_data_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> Data Service</h4> </div> <div class="modal-body" id="isi_data_service"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
      
      $("#add_data_service").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/data_service/data_service_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_data_service").html(data);
              }
          });

      $('#modal_data_service').modal({ keyboard: false,backdrop:'static',show:true });

    });
    
      
    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);
        $(".modal-title").html("Edit Data Service");
        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/service/service_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_data_service").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_data_service').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_data_service = $("#dtb_data_service").DataTable({
              
           'bProcessing': true,
            'bServerSide': true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [8],
              "orderable": false,
              "searchable": false,
              "className": "all",
              "render": function(data, type, full, meta){
                return '<?=$edit;?> <?=$del;?>';
               }
            },
            ],
      
            'ajax':{
              url :'<?=base_admin();?>modul/service/service_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
</script>
            