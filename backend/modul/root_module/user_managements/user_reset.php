                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Reset Password
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>profil">Profil</a></li>
                        <li class="active">Reset Password</li>
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
                  
                    <form id="input_change_password" method="post" class="form-horizontal" action="<?=base_admin();?>modul/root_module/user_managements/user_managements_action.php?act=reset">
                      <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-2">New Password</label>
                        <div class="col-lg-10">
                          <input type="password" id="password_baru" name="password_baru"  class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
                       <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-2">Confirm new password</label>
                        <div class="col-lg-10">
                          <input type="password" id="password_confirm" name="password_confirm" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id?>">
                      <input type="hidden" id="redirect" value="<?=base_index();?>user-management">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                        <a href="<?=base_index();?>user-managements" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
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
               //     remote : "http://localhost/gen_back/admina/modul/root_module/change_password/check_pass.php",
 /*                   remote: {
           url: "http://localhost/gen_back/admina/modul/root_module/change_password/check_pass.php" ,
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
                    remote: jQuery.validator.format("{0} tidak sama"),
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
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#pass_up").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                          console.log(data);
                          $('#loadnya').hide();
                              if (data=='false') {
                         $('.pass_salah').fadeIn();
                                //$('.sukses').html(data);
                              } else {
                                $('.notif_top_up').fadeIn(1000);
                                 setTimeout(function () {
                                 window.location.href = "<?=base_index();?>user-managements"; //will redirect to your blog page (an ex: blog.html)
                              }, 2000); //will call the function after 2 secs.
                                //redirect jika berhasil login
                              }
                      }
                    });
            }

        });
});
</script>
 