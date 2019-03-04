<?php
$modul_name = str_replace(" ", "_", strtolower($_POST['filter_name']));
?>

<style type="text/css">

	/* Hemisu Light */
/* Original theme - http://noahfrederick.com/vim-color-scheme-hemisu/ */
textarea {
 background: #05631a;
    color: #fff;
  font-family: Menlo, 'Bitstream Vera Sans Mono', 'DejaVu Sans Mono', Monaco, Consolas, monospace;
  font-size: 12px;
  line-height: 1.5;
  border: 1px solid #dedede!important;
  padding: 10px;
  max-height: 300px;
  width: auto;
  overflow: auto!important;
}
pre.prettyprint > code {
  width: auto;
  overflow: auto!important;
}
</style>
<h3>Filter</h3>
<div class="prettyprint">
	<textarea cols="185" rows="50">

  <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Filter  </h3>
              </div>
              <div class="box-body">
             <form class="form-horizontal" method="post" action="<?=' <?=base_admin();?>';?>/modul/<?=$modul_name;?>/<?=$modul_name;?>_data.php">
<?php

foreach ($_POST['label'] as $dt) {


$id= str_replace(" ", "_", $dt);
$id = strtolower($id);
  ?>
  <div class="form-group">
                          <label for="Semester" class="control-label col-lg-2"><?=$dt;?>  </label>
                          <div class="col-lg-3">
                          <select id="<?=$id;?>_filter" name="<?=$id;?>_filter" data-placeholder="Pilih <?=$dt;?> ..." class="form-control chzn-select" tabindex="2">
                          <option value="all">Semua  </option>
             </select>

          </div>
                        </div><!-- /.form-group -->
  <?php
}
?>
                     
                        <div class="form-group">
                          <label for="tags" class="control-label col-lg-2">&nbsp;  </label>
                          <div class="col-lg-10">
                            <span id="filter" class="btn btn-primary"><i class="fa fa-refresh">  </i> Filter  </span>
                            <button type="submit" class="btn btn-success"><i class="fa fa-cloud-download">  </i> Download  </button>
                          </div>
                        </div><!-- /.form-group -->
                      </form>
              </div>
            <!-- /.box-body -->
            </div>

<?php

echo '</textarea></div>';
echo "<pre>";
print_r($_POST);