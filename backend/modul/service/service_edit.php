<?php
session_start();
include "../../inc/config.php";
$data_edit = $db->fetchCustomSingle("SELECT sys_token.*,page_name FROM sys_services INNER JOIN sys_token ON sys_services.id=sys_token.id_service where sys_token.id=?",array("id" => $_POST['id_data']));
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_data_service" method="post" class="form-horizontal" action="<?=base_admin();?>modul/service/service_action.php?act=up">
                        <div class="form-group">
                <label for="Enable Token" class="control-label col-lg-3">Service Name </label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" readonly="" value="<?=$data_edit->page_name;?>">
                </div>
              </div>
            <div class="form-group">
                <label for="Enable Token" class="control-label col-lg-3">Enable Token Read </label>
                <div class="col-lg-9">
                <?php if ($data_edit->enable_token_read=="Y") {
                ?>
                  <input name="enable_token_read" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="enable_token_read" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->
            <div class="form-group">
                <label for="Enable Token" class="control-label col-lg-3">Enable Token Create</label>
                <div class="col-lg-9">
                <?php if ($data_edit->enable_token_create=="Y") {
                ?>
                  <input name="enable_token_create" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="enable_token_create" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->

            <div class="form-group">
                <label for="Enable Token" class="control-label col-lg-3">Enable Token Update</label>
                <div class="col-lg-9">
                <?php if ($data_edit->enable_token_update=="Y") {
                ?>
                  <input name="enable_token_update" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="enable_token_update" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->
            <div class="form-group">
                <label for="Enable Token" class="control-label col-lg-3">Enable Token Delete</label>
                <div class="col-lg-9">
                <?php if ($data_edit->enable_token_delete=="Y") {
                ?>
                  <input name="enable_token_delete" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="enable_token_delete" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->
            
            <div class="form-group">
                <label for="Format Output" class="control-label col-lg-3">Format Output <span style="color:#FF0000">*</span></label>
                <div class="col-lg-9">
                    <select id="format_data" name="format_data" data-placeholder="Pilih Format Output..." class="form-control chzn-select" tabindex="2" required>
                      <option value=""></option>
                     <?php
                     $option = array(
'json' => 'Json',

'xml' => 'XML',
);
                     foreach ($option as $isi => $val) {

                        if ($data_edit->format_data==$isi) {
                          echo "<option value='$data_edit->format_data' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
                    </select>
                  </div>
            </div><!-- /.form-group -->
            
              <input type="hidden" name="id" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang["cancel_button"];?></button>
                  <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                  </div>
                </div>
              </div><!-- /.form-group -->

            </form>

<script type="text/javascript">
    
    $(document).ready(function() {
    
    
      $.each($(".make-switch"), function () {
            $(this).bootstrapSwitch({
            onText: $(this).data("onText"),
            offText: $(this).data("offText"),
            onColor: $(this).data("onColor"),
            offColor: $(this).data("offColor"),
            size: $(this).data("size"),
            labelText: $(this).data("labelText")
            });
          });
        
    
      //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
      //chosen select
      $(".chzn-select").chosen();
      $(".chzn-select-deselect").chosen({
          allow_single_deselect: true
      });
        
    
    $("#edit_data_service").validate({
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
            }
            else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            }
            else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            }
            else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          format_data: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          format_data: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
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
                            $('#modal_data_service').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 dtb_data_service.draw();
                            });
                          }
                    });
                }

            });
        }
    });
});
</script>
