<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>User Managements</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>user-managements">User Managements</a></li>
                        <li class="active">Detail User Managements</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail User Managements</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="Full Name" class="control-label col-lg-2">Full Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->full_name;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Username" class="control-label col-lg-2">Username <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->username;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
                            
              <div class="form-group">
                <label for="Email" class="control-label col-lg-2">Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->email;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Photo" class="control-label col-lg-2">Photo <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                    <img src="<?=base_url();?>upload/back_profil_foto/thumb_<?=$data_edit->foto_user?>" class="myImage"></div>
                  </div>
                  </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Group user" class="control-label col-lg-2">Group user <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <?php foreach ($db->fetch_all("sys_group_users") as $isi) {
                  if ($data_edit->group_level==$isi->level) {

                    echo "<input disabled class='form-control' type='text' value='$isi->level_name'>";
                  }
               } ?>
              </div>
                      </div><!-- /.form-group -->

            <div class="form-group">
                <label for="Active" class="control-label col-lg-2">Active </label>
                <div class="col-lg-10">
                <?php if ($data_edit->aktif=="Y") {
                  ?>
                  <input name="aktif" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox" checked>
                  <?php
                } else {
                  ?>
                  <input name="aktif" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox">
                  <?php
                }?>
                </div>
            </div><!-- /.form-group -->
            
                        
                      </form>
                      <a href="<?=base_index();?>user-managements" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
