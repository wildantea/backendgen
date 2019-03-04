<?php
session_start();
include "../../inc/config.php";
$columns = array(
    'sys_group_users.level_name',
    'sys_group_users.deskripsi',
    'sys_group_users.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('deskripsi','sys_group_users.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("sys_group_users.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by sys_group_users.id";

  $query = $datatable->get_custom("select sys_group_users.level_name,sys_group_users.deskripsi,sys_group_users.id from sys_group_users",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->level_name;
    $ResultData[] = $value->deskripsi;
    if ($value->id!=1) {
      $ResultData[] = '<a data-id="'.$value->id.'" class="btn btn-primary btn-sm edit_data " data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <button data-id="'.$value->id.'" data-uri="'.base_admin().'modul/user_group/user_group_action.php" class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Delete" data-variable="dtb_user_group"><i class="fa fa-trash"></i></button>';
    } else {
      $ResultData[] = '#';
    }
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>