<?php
session_start();
include "../../inc/config.php";

$columns = array(
    'sys_services.page_name',
    'sys_services.url',
    'sys_services.nav_act',
    'sys_token.enable_token_read',
    'sys_token.enable_token_create',
    'sys_token.enable_token_update',
    'sys_token.enable_token_delete',
    'sys_token.format_data',
    'sys_token.id',
  );

  //if you want to exclude column for searching, put columns name in quote and separate with comma if multi
  //$datatable->setDisableSearchColumn("sys_token.format_data","sys_token.id");
  
  //set numbering is true
  $datatable->setNumberingStatus(0);

  //set order by column
  $datatable->setOrderBy("sys_token.id desc");


  //set group by column
  //$datatable->setGroupBy("sys_token.id");

  $query = $datatable->execQuery("select sys_services.page_name,sys_services.url,sys_services.nav_act,sys_token.enable_token_read,sys_token.enable_token_create,sys_token.enable_token_update,sys_token.enable_token_delete,sys_token.format_data,sys_token.id from sys_token inner join sys_services on sys_token.id_service=sys_services.id",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
  
    $ResultData[] = $value->page_name;
    $ResultData[] = "<a target='_blank' href='".base_url()."api/".$value->url."'>".base_url()."api/".$value->url."</a>";
    $ResultData[] = "<a target='_blank' href='".base_url()."api/".$value->url."/doc'>".base_url()."api/".$value->url."/doc</a>";
    if ($value->enable_token_read=='Y') {
       $ResultData[] =  "<span class='btn btn-xs btn-success'>Yes</span>";
    } else {
       $ResultData[] =  "<span class='btn btn-xs btn-danger'>No</span>";
    }
    if ($value->enable_token_create=='Y') {
       $ResultData[] =  "<span class='btn btn-xs btn-success'>Yes</span>";
    } else {
       $ResultData[] =  "<span class='btn btn-xs btn-danger'>No</span>";
    }
    if ($value->enable_token_update=='Y') {
       $ResultData[] =  "<span class='btn btn-xs btn-success'>Yes</span>";
    } else {
       $ResultData[] =  "<span class='btn btn-xs btn-danger'>No</span>";
    }
    if ($value->enable_token_delete=='Y') {
       $ResultData[] =  "<span class='btn btn-xs btn-success'>Yes</span>";
    } else {
       $ResultData[] =  "<span class='btn btn-xs btn-danger'>No</span>";
    }
    $ResultData[] = $value->format_data;
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->setData($data);
//create our json
$datatable->createData();

?>