<style type="text/css">
  th {
    vertical-align: middle;
    text-align: center;
  }
  td {
    vertical-align: middle;
  }
  .btn span.glyphicon {         
  opacity: 0;       
}
.btn.active span.glyphicon {        
  opacity: 1;       
}
</style>                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Service User Permission
            </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>menu-management">Menu Management</a></li>
                        <li class="active">Service User Permission</li>
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
                        <label for="Menu" class="control-label col-lg-2">Select Users</label>
                        <div class="col-lg-4">
                            <select name="user" id="id_po_select" data-placeholder="Pilih User" class="form-control chzn-select" tabindex="2">
                        <option value="">Choose Service User</option>
                          <?php 

foreach ($db->query("select id,username from sys_users") as $isi) {

                  if (intval($_GET['user'])==$isi->id) {
                     echo "<option value='$isi->id' selected>$isi->username</option>";
                  } else {
                     echo "<option value='$isi->id'>$isi->username</option>";
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
  
  $token = $db->fetchCustomSingle('select read_access from sys_token limit 1');
  $read_token = json_decode($token->read_access);
          foreach ($read_token as $dt_read) {
          if ($dt_read->user_id==$_GET['user']) {
            $read_access_token = $dt_read->token;
          }
        }
?>       
<h3>Check The Checkbox To Give Permission</h3>
<h4>Token : <?=$read_access_token;?></h4>
<table id="dtb" class="table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                        <th rowspan="2" style="width:20px;vertical-align:middle">No</th>
                          <th rowspan="2" style="vertical-align:middle">Service Name </th>
                          <th >Read</th>
                          <th >Create</th>
                          <th >Update</th>
                          <th >Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
      $dtb=$db->query("select sys_token.id,sys_services.page_name,read_access,create_access,update_access,delete_access from sys_services inner join sys_token on sys_services.id=sys_token.id_service");
      $i=1;

      foreach ($dtb as $isi) {



        $read_access = $isi->read_access;


        $read = json_decode($read_access);
        foreach ($read as $dt_read) {
          if ($dt_read->user_id==$_GET['user']) {
            $read_access = $dt_read->access;
          } 
        }
      
        $create_access = $isi->create_access;
        $create = json_decode($create_access);
        foreach ($create as $dt_create) {
          if ($dt_create->user_id==$_GET['user']) {
            $create_access = $dt_create->access;
          }
        }
        $update_access = $isi->update_access;
        $update = json_decode($update_access);
                foreach ($update as $dt_update) {
          if ($dt_update->user_id==$_GET['user']) {
            $update_access = $dt_update->access;
          }
        }
        $delete_access = $isi->delete_access;
        $delete = json_decode($delete_access);
                foreach ($delete as $dt_delete) {
          if ($dt_delete->user_id==$_GET['user']) {
            $delete_access = $dt_delete->access;
          }
        }
        ?><tr id="line_<?=$isi->id;?>">
        <td>
        <?=$i;?></td>
        <td><?=$isi->page_name;?></td>
        <td valign="middle">
        <div class="checkbox" align="center">

          <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="read_act(<?=$isi->id;?>,<?=$_GET['user'];?>,this)" <?=($read_access=='1')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
        </td>
                <td align="center">
        <div class="checkbox">
          <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="create_act(<?=$isi->id;?>,<?=$_GET['user'];?>,this)" <?=($create_access=='1')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
        </td>
          <td align="center">
        <div class="checkbox">
          <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="update_act(<?=$isi->id;?>,<?=$_GET['user'];?>,this)" <?=($update_access=='1')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
        </td>
                <td align="center">
        <div class="checkbox">
          <div class="checkbox checkbox-primary">
                        <input class="styled styled-primary" type="checkbox" value="option1" onclick="delete_act(<?=$isi->id;?>,<?=$_GET['user'];?>,this)" <?=($delete_access=='1')?'checked=""':'';?>>
                        <label for="checkbox2">
                            &nbsp;
                        </label>
                    </div>
                          </div>
        </td>
               
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
  
function read_act(id,user,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_read",
        data: "token_id="+id+"&user="+user+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}
  
/*function read_act_token(id,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_read_token",
         data: "token_id="+id+"&user="+user+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}*/
function update_act(id,user,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_update",
        data: "token_id="+id+"&user="+user+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}
/*function update_act_token(id,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_update_token",
        data: "token_id="+id+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}*/

function create_act(id,user,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_create",
        data: "token_id="+id+"&user="+user+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}

/*function create_act_token(id,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_create_token",
        data: "token_id="+id+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}*/
function delete_act(id,user,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_delete",
        data: "token_id="+id+"&user="+user+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}
/*function delete_act_token(id,cb) {
  check_act = '';
  if (cb.checked) {
     check_act = '1';
  } else {
    check_act = '0';

  }
  $.ajax({

        type: "post",
        url: "<?=base_admin();?>modul/root_module/service_permission/service_permission_action.php?act=change_delete_token",
        data: "token_id="+id+"&data_act="+check_act,
     //  enctype:  'multipart/form-data'
      success: function(data){

        console.log(data);
    }

  });
}
*/

</script>



