                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Group User Permission
            </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>menu-management">Menu Management</a></li>
                        <li class="active">Group User Permission</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title">&nbsp;</h3>
                                </div><!-- /.box-header -->

<form method="get" class="form-horizontal" action="">
                      <div class="form-group">
                        <label for="Menu" class="control-label col-lg-2">Group Users</label>
                        <div class="col-lg-4">
                            <select name="user" id="id_po_select" data-placeholder="Pilih User" class="form-control chzn-select" tabindex="2">
                        <option value="">Choose Group User</option>
                          <?php 

foreach ($db->query("select sys_group_users.id, sys_group_users.level_name from sys_group_users ") as $isi) {

                  if (intval($_GET['user'])==$isi->id) {
                     echo "<option value='$isi->id' selected>$isi->level_name</option>";
                  } else {
                     echo "<option value='$isi->id'>$isi->level_name</option>";
                  }
                 
               } ?>

                  
                  </select>
                        </div>
                      </div><!-- /.form-group -->

 <label for="Menu" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
<button style="margin-top:10px;margin-bottom:10px" class="btn btn-primary">Show Menu</button>
</div>
</form>

                                <div class="box-body table-responsive">
          
<?php if (isset($_GET['user'])) {
  
?>       
<h3>Check The Checkbox To Give Permission</h3>
<table id="dtb" class="table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                        <th style="width:20px">No</th>
                          <th>Menu </th>
                       
                          <th>View</th>
                           <th>Add</th>
                            <th>Edit</th>
                             <th>Delete</th>
                             <th>Import</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
$group_level = $db->fetchSingleRow("sys_group_users","id",$_GET['user']);
if ($group_level) {

$level = $group_level->level;
      $dtb=$db->query("SELECT sys_menu.id,sys_menu.page_name,type_menu,
(select sys_menu_role.read_act from sys_menu_role where sys_menu_role.id_menu=sys_menu.id and sys_menu_role.group_level='$level') as read_act,
(select sys_menu_role.insert_act from sys_menu_role where sys_menu_role.id_menu=sys_menu.id and sys_menu_role.group_level='$level') as insert_act,
(select sys_menu_role.update_act from sys_menu_role where sys_menu_role.id_menu=sys_menu.id and sys_menu_role.group_level='$level') as update_act,
(select sys_menu_role.delete_act from sys_menu_role where sys_menu_role.id_menu=sys_menu.id and sys_menu_role.group_level='$level') as delete_act,
(select sys_menu_role.import_act from sys_menu_role where sys_menu_role.id_menu=sys_menu.id and sys_menu_role.group_level='$level') as import_act 
FROM sys_menu order by parent,urutan_menu asc");
      $i=1;
      foreach ($dtb as $isi) {
        ?><tr id="line_<?=$isi->id;?>">
        <td>
        <?=$i;?></td>
        <td><?=$isi->page_name;?></td>
       
        <?php
        if($isi->type_menu=='main')
        {
            ?>
            <td>
              <div class="checkbox">
              <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'read_act')" <?=($isi->read_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
            </td>
            <td colspan="3">Main Menu</td>
<?php
        } elseif ($isi->type_menu=='separator') {
          ?>
          <td>
              <div class="checkbox">
              <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'read_act')" <?=($isi->read_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
            </td>
            <td colspan="3">Separator</td>
          <?php
        } else {



        ?>
        <td>
        <div class="checkbox">
          <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'read_act')" <?=($isi->read_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
        </td>
          <td>
          <div class="checkbox">
           <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'insert_act')" <?=($isi->insert_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
      </td>
            <td>   <div class="checkbox">
            <div class="checkbox checkbox-primary">
                          <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'update_act')" <?=($isi->update_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div></td>
              <td>   <div class="checkbox">
              <div class="checkbox checkbox-primary">
                         <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'delete_act')" <?=($isi->delete_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div></td>
              <td>   <div class="checkbox">
              <div class="checkbox checkbox-primary">
                         <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_role(<?=$isi->id;?>,this,'import_act')" <?=($isi->import_act=='Y')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div></td>
                          <?php 
                          }
                          ?>
        </tr>
        <?php
        $i++;
      }
      ?>
                   </tbody>
                    </table>
<?php 

}  

?>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
  



<script type="text/javascript">
function update_role(id,cb,act) {
  check_act = '';
  if (cb.checked) {
     check_act = 'Y';
  } else {
    check_act = 'N';
  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/menu_management/menu_management_action.php",
        data : {
          id_menu : id,
          data_act : check_act,
          level : "<?=$level;?>",
          action : act
        },
      success: function(data){
        console.log(data);
    }

  });
}

  </script>

<?php
  
}
?>