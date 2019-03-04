<?php
session_start();
//import page
include "../../inc/config.php";
?>
        <div class="alert isi_informasi" style="display:none;margin-bottom: 0px;">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          
        </div>
                     <form id="input_import" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/mahasiswa/mahasiswa_action.php?act=import">
                     <div class="form-group">
                        <label for="nim" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10"> <a href="<?=base_url();?>upload/sample/mahasiswa.xlsx" class="btn btn-success btn-flat"><i class="fa fa-cloud-download"></i> Download Contoh Template XLS</a></div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Upload Data Akm" class="control-label col-lg-2">Upload Data</label>
                        <div class="col-lg-10">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="semester" required>
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.form-group -->

                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                         <a data-dismiss="modal" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Tutup</a>
                          <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cloud-upload"></i> Upload Data</button>
                        </div>
                      </div><!-- /.form-group -->
                    </form>
<script type="text/javascript">
  $(document).ready(function(){
   $("#input_import").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },

            submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#input_import").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                          $('.fileinput').fileinput('clear');
                          $(".isi_informasi").show();
                          $(".isi_informasi").html('');
                          $(".isi_informasi").html(data);
                          dtb_mahasiswa.draw( false );
                          $('#loadnya').hide();
                     
                      }
                    });
            }

        });  

});
</script>
<?php
//include on top
$time_start = microtime(true); 
require('../../inc/lib/SpreadsheetReader.php');

		//action
 case 'import':
      if (!is_dir("../../../upload/upload_excel")) {
              mkdir("../../../upload/upload_excel");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/upload_excel/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }

      $error_count = 0;
      $error = array();
      $sukses = 0;
      $values = "";

  $Reader = new SpreadsheetReader("../../../upload/upload_excel/".$_FILES['semester']['name']);

  foreach ($Reader as $key => $val)
  {

 
    if ($key>0) {

      if ($val[0]!='') {
          $check = $db->check_exist('fakultas',array('kode_mk' => filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'kur_id'=>$_POST['id_kur']));
          if ($check==true) {
            $error_count++;
            $error[] = $val[0]." Sudah Ada";
          } else {
            $sukses++;
      $values .= '("'.
      preg_replace( '/[^[:print:]]/', '',filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
preg_replace( '/[^[:print:]]/', '',filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH).'"),';
        }

      }

    }

      }

if ($values!="") {
  $values = rtrim($values,",");

  $query = "insert into matkul (id,nama_fakultas) values ".$values;
  //echo $query;
  $db->query($query);
}

          unlink("../../../upload/upload_excel/".$_FILES['semester']['name']);
          $msg = '';
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);

      if (($sukses>0) || ($error_count>0)) {
        $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" style=\"margin-bottom: 0;\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <font color=\"#3c763d\">".$sukses." data Matakuliah baru berhasil di import</font><br />
            <font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
            if (!$error_count==0) {
              $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
            }
            //echo "<br />Total: ".$i." baris data";
            $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
                $i=1;
                foreach ($error as $pesan) {
                    $msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
                  $i++;
                  }
            $msg .= "</div>";
            $msg .= "<p>Total Waktu Import : ". waktu_import($execution_time);
           $msg .= "</div>";

      }
     echo $msg;
    break;
