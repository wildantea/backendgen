                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Edit Page
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>modul">Page</a></li>
                        <li class="active">Edit Page</li>
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
                          <form id="update" class="form-horizontal" action="<?=base_admin();?>modul/page/page_action.php?act=up">
      <div class="form-group">
                        <label for="text1" class="control-label col-lg-2"><?=$lang['menu_name'];?></label>
                        <div class="col-lg-10">
                          <input type="text" id="text1" name="page_name" value="<?=$data_edit->page_name;?>" required placeholder="Page name" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
                           <div class="form-group">
                        <label for="text1" class="control-label col-lg-2">Icon</label>
                        <div class="col-lg-7">
                          <input type="text" id="text1" value="<?=$data_edit->icon;?>" name="icon" placeholder="fa-camera-retro" class="form-control">
                        <a target="_blank" href="<?=base_index();?>page/icon">Reference Icon (new window)</a>
                        </div>
                      </div><!-- /.form-group -->
                         <div class="form-group">
                        <label class="control-label col-lg-2"><?=$lang['parent_menu'];?></label>
                        <div class="col-lg-10">
                          <select data-placeholder="Pilih Modul" name="parent" class="form-control chzn-select" tabindex="2">
              <?php
               if ($data_edit->parent==0) {
                    echo "<option value='0' selected>None</option>";
                  } else {
                    echo "<option value='0'>None</option>";
                    $get_parent = $db->fetchSingleRow('sys_menu','id',$data_edit->parent);
                     echo "<option value='$get_parent->id' selected>$get_parent->page_name</option>";
                  }


$data = $db->query("select * from sys_menu where type_menu='main' and id!=? and id!='$data_edit->parent'",array('id'=>$data_edit->id));
foreach ($data as $isi) {
                     echo "<option value='$isi->id'>$isi->page_name</option>";
                  }

                ?>
                          </select>
                        </div>
                      </div>
                         <div class="form-group">
                        <label for="Update" class="control-label col-lg-2"><?=$lang['menu_show'];?></label>
                        <div class="col-lg-10">
                       <?php if ($data_edit->tampil=="Y") {
      ?>
      <input name="tampil" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
      <?php
    } else {
      ?>
      <input name="tampil" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
      <?php
    }?>  </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
             <a href="<?=base_index();?>page" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                        </div>
                      </div><!-- /.form-group -->
                    </form>

                  </div>
                  </div>
              </div>
</div>

                </section><!-- /.content -->




