<?php $data_edit=$db->fetchSingleRow('sys_users','id',$_SESSION['id_user']);?>
 
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     <?=$lang["edit_profile_button"];?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>profil"><?=$lang["profile_label"];?></a></li>
                        <li class="active"><?=$lang["edit_profile_button"];?></li>
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
                       <div class="alert alert-danger error_data" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="isi_warning"></span>
                      </div>
                     <form id="edit_profile" method="post" class="form-horizontal" action="<?=base_admin();?>modul/profil/profil_action.php?act=up">
                      <div class="form-group">
                        <label for="First Name" class="control-label col-lg-2">Username</label>
                        <div class="col-lg-10">
                          <input type="text" value="<?=$data_edit->username;?>" class="form-control" readonly> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="First Name" class="control-label col-lg-2"><?=$lang["full_name"];?></label>
                        <div class="col-lg-10">
                          <input type="text" id="full_name" name="full_name" value="<?=$data_edit->full_name;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text" id="email" name="email" value="<?=$data_edit->email;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                     


      <div class="form-group">
                        <label for="nama_foto" class="control-label col-lg-2"><?=$lang["photo"];?></label>
                        <div class="col-lg-10">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px;">
                             <img src="../../../upload/back_profil_foto/<?=$data_edit->foto_user?>">
                            </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new"><?=$lang["select_image"];?></span> <span class="fileinput-exists"><?=$lang["select_image"];?></span>
                                <input type="file" name="foto_user" accept="image/*">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?=$lang["remove_photo"];?></a>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.form-group -->
                     

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                           <a href="<?=base_index();?>profil" class="btn btn-default"><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
                           <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                    
                   
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 <script type="text/javascript">
    $(document).ready(function() {
    
    
    
    $("#edit_profile").validate({
        errorClass: "help-block",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-error").addClass("has-success");
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("chzn-select")) {
                var id = element.attr("id");
                error.insertAfter("#" + id + "_chosen");
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
            } else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            } else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            } else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          full_name: {
          required: true,
          //minlength: 2
          },
        
          email: {
          required: true,
          //minlength: 2
          }
        
        },
         messages: {
            
          full_name: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          email: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          }
        
        },
    

        submitHandler: function(form) {
            $("#loadnya").show();
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $("#loadnya").hide();
                  console.log(data); 
                  $(".isi_warning").html(data.responseText);
                  $(".error_data").focus()
                  $(".error_data").fadeIn();
                },
                success: function(responseText) {
                  $("#loadnya").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                          console.log(responseText[index].status);
                          if (responseText[index].status=="die") {
                            $("#informasi").modal("show");
                          } else if(responseText[index].status=="error") {
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                          } else if(responseText[index].status=="good") {
                            $(".save-data").attr("disabled", "disabled");
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                    window.history.back();
                            });
                          }
                    });
                }

            });
        }
    });
});
</script>
