<?php $data_edit=$db->fetchSingleRow('sys_users','id',$_SESSION['id_user']);

?>
 
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      View Profil
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>profil">Profil</a></li>
                        <li class="active">Profil</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
<div class="col-md-5">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
<img src="<?=base_url();?>upload/back_profil_foto/thumb_<?=$data_edit->foto_user;?>" class="img-responsive" style="margin: 0 auto;">
              <h3 class="profile-username text-center"><?=ucwords(strtolower($data_edit->full_name));?></h3>

              <p class="text-muted text-center"><?=$data_edit->group_level;?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Email</b> <span class="pull-right"><?=$data_edit->email;?></span>
                </li>
              </ul>
            
               <a href="<?=base_index();?>profil/edit" class="btn btn-primary btn-block"><i class="fa fa-pencil-square-o"></i> <?=$lang["edit_profile_button"];?></a> <a href="<?=base_index();?>profil/change-password" class="btn btn-primary btn-block"><i class="fa  fa-unlock"></i> <?=$lang["change_password_button"];?></a>
              
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
                    </div>
                  
                </section><!-- /.content -->
        
 