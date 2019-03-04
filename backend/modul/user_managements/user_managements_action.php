<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
    case 'reset':
  $data = array(
      'password'=>md5($_POST['password_baru'])
    );
      $up = $db->update("sys_users",$data,"id",$_POST["id"]);
    if ($up=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "in":
$check_username = $db->check_exist('sys_users',array('username' => $_POST['username']));
if ($check_username) {
    action_response('Username Already Exist');
  }  
$check_email = $db->check_exist('sys_users',array('email' => $_POST['email']));
if ($check_email) {
    action_response('Email Already Exist');
  }  

  if (!is_dir("../../../../upload/back_profil_foto")) {
              mkdir("../../../../upload/back_profil_foto");
            }
  
  $data = array(
      "full_name" => $_POST["full_name"],
      "username" => $_POST["username"],
      "password" => MD5($_POST["password"]),
      "email" => $_POST["email"],
      "group_level" => $_POST["group_level"],
  );
  
  
                    if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["foto_user"]["name"]) ) {

              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
$filename = $_FILES["foto_user"]["name"];
$filename = preg_replace("#[^a-z.0-9]#i", "", $filename); 
$ex = explode(".", $filename); // split filename
$fileExt = end($ex); // ekstensi akhir
$filename = time().rand().".".$fileExt;//rename nama file';
$filename_thumb = 'thumb_'.$filename;//rename nama file';
$db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../../upload/back_profil_foto/",$filename,200);
$size = getimagesize ($_FILES["foto_user"]["tmp_name"]);
if ($size[0]>512) {
  $db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../../upload/back_profil_foto/",$filename_thumb,512);
} else {
  copy($_FILES["foto_user"]["tmp_name"], "../../../../upload/back_profil_foto/".$filename_thumb);
}
              $foto_user = array("foto_user"=>$filename);
              $data = array_merge($data,$foto_user);
            }
  
   
          if(isset($_POST["aktif"])=="on")
          {
            $aktif = array("aktif"=>"Y");
            $data=array_merge($data,$aktif);
          } else {
            $aktif = array("aktif"=>"N");
            $data=array_merge($data,$aktif);
          }
    $in = $db->insert("sys_users",$data);
   
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    $db->deleteDirectory("../../../../upload/back_profil_foto/".$db->fetch_single_row("sys_users","id",$_GET["id"])->foto_user);
$db->deleteDirectory("../../../../upload/back_profil_foto/thumb_".$db->fetch_single_row("sys_users","id",$_GET["id"])->foto_user);

      $db->delete("sys_users","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("sys_users","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":

    
   $data = array(
      "full_name" => $_POST["full_name"],  
      "email" => $_POST["email"],
      "group_level" => $_POST["group_level"],
   );
   
   
                         if(isset($_FILES["foto_user"]["name"])) {
                        if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["foto_user"]["name"]) ) {

              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
$filename = $_FILES["foto_user"]["name"];
$filename = preg_replace("#[^a-z.0-9]#i", "", $filename); 
$ex = explode(".", $filename); // split filename
$fileExt = end($ex); // ekstensi akhir
$filename = time().rand().".".$fileExt;//rename nama file';
$filename_thumb = 'thumb_'.$filename;//rename nama file';
$db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../../upload/back_profil_foto/",$filename,200);
$size = getimagesize ($_FILES["foto_user"]["tmp_name"]);
if ($size[0]>512) {
  $db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../../upload/back_profil_foto/",$filename_thumb,512);
} else {
  copy($_FILES["foto_user"]["tmp_name"], "../../../../upload/back_profil_foto/".$filename_thumb);
}
$db->deleteDirectory("../../../../upload/back_profil_foto/".$db->fetch_single_row("sys_users","id",$_POST["id"])->foto_user);
$db->deleteDirectory("../../../../upload/back_profil_foto/thumb_".$db->fetch_single_row("sys_users","id",$_POST["id"])->foto_user);
              $foto_user = array("foto_user"=>$filename);
              $data = array_merge($data,$foto_user);
            }

                         }
   

    
          if(isset($_POST["aktif"])=="on")
          {
            $aktif = array("aktif"=>"Y");
            $data=array_merge($data,$aktif);
          } else {
            $aktif = array("aktif"=>"N");
            $data=array_merge($data,$aktif);
          }
    
    $up = $db->update("sys_users",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>