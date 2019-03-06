<?php $data_edit=$db->fetchSingleRow('sys_users','id',$_SESSION['id_user']);?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Change Password
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>profil">Profil</a></li>
                        <li class="active">Change Password</li>
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
                    <form id="input_change_password" method="post" class="form-horizontal" action="<?=base_admin();?>modul/root_module/profil/change_password_action.php?act=up">
                        <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-2"><?=$lang["current_password"];?></label>
                        <div class="col-lg-10">
                          <input type="password" id="password" name="password" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-2"><?=$lang["new_password"];?></label>
                        <div class="col-lg-10">
                          <input type="password" id="password_baru" name="password_baru"  class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
                       <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-2"><?=$lang["confirm_password"];?></label>
                        <div class="col-lg-10">
                          <input type="password" id="password_confirm" name="password_confirm" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$_SESSION['id_user'];?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <a href="<?=base_index();?>profil" class="btn btn-default"><i class="fa fa-step-backward"></i> Back</a>
                          <button type="submit" class="btn btn-primary"><i class="fa  fa-unlock"></i> <?=$lang["change_password_button"];?></button>
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
     $("#input_change_password").validate({
 errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
       rules : {
                password : {
                    required:true,
               //     remote : "http://localhost/gen_back/admina/modul/change_password/check_pass.php",
 /*                   remote: {
           url: "http://localhost/gen_back/admina/modul/change_password/check_pass.php" ,
           type: "post" ,
           data: {
              password: function() {
                 return $("#password").val();
           }
         }
     }*/
                },
                 password_baru : {
                    minlength : 3,
                    required:true
                },
                password_confirm : {
                    minlength : 3,
                    required:true,
                    equalTo : "#password_baru"
                }
               },
                  messages:
             {
                 password:
                 {
                    required: "Enter your old password",
                    //remote: jQuery.validator.format("{0} tidak sama"),
                 },
                 password_baru: {
                  required:"Enter your new password",
                   minlength:"Use 3 characters or more for your password",
                 },
                 password_confirm: {
                  required:"confirm your password",
                  minlength:"Use 3 characters or more for your password",
                  equalTo:"Those passwords didn't match. Try Again"
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
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                    window.history.back();
                            });
                          } else {
                             console.log(responseText);
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                          }
                    });
                }

            });
            }

        });
});
</script>
 