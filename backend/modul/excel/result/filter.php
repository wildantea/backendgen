
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal" id="filter_form" method="post" action="<?=base_admin();?>modul/mahasiswa/download_data.php" target="_blank">
                   
              <div class="form-group">
                    <label for="Program studi" class="control-label col-lg-2">Program studi</label>
                    <div class="col-lg-5">
                    <select id="jur_filter" name="jur_filter" data-placeholder="Pilih Program studi ..." class="form-control chzn-select" tabindex="2" required="">
                    <?php
                    looping_prodi();
                    ?>
                    </select>
                    </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                    <label for="Angkatan" class="control-label col-lg-2">Angkatan</label>
                    <div class="col-lg-5">
                    <select id="angkatan_filter" name="angkatan_filter" data-placeholder="Pilih Angkatan ..." class="form-control chzn-select" tabindex="2" required="">
                    <?php
                    looping_prodi();
                    ?>
                    </select>
                    </div>
              </div><!-- /.form-group -->

                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <span id="filter" class="btn btn-primary"><i class="fa fa-refresh"></i> Filter</span>
                        <button type="submit" class="btn btn-success"><i class="fa fa-cloud-download"></i> Download</button>
                      </div><!-- /.form-group -->
                    </div>
                    </form>
            </div>
            <!-- /.box-body -->
          </div>

$(document).ready(function(){

  $("#fakultas_filter").change(function(){

            $.ajax({
            type : "post",
            url : "<?=base_admin();?>modul/mahasiswa/get_jurusan_filter.php",
            data : {fakultas:this.value},
            success : function(data) {
                $("#jurusan_filter").html(data);
                $("#jurusan_filter").trigger("chosen:updated");

            }
        });
            });

          //chosen select
          $(".chzn-select").chosen();
          $(".chzn-select-deselect").chosen({
              allow_single_deselect: true
          });
    
      //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
       $.validator.addMethod("myFunc", function(val) {
        if(val=='all'){
          return false;
        } else {
          return true;
        }
      }, "Untuk Cetak Data Silakan Pilih Prodi");
    $("#filter_form").validate({
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
            } else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          jur_filter: {
            myFunc:true
          //minlength: 2
          },
        
          sem_filter: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
        
          sem_filter: {
          required: "Untuk Cetak Data Silakan Pilih Semester",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
        }
    });
});
