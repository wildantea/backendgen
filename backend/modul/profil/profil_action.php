<?php
session_start();
include "../../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
	case "delete":
		$db->delete("sys_users","id",$_GET["id"]);
		break;
	case "up":

	 $data = array(
	 	"full_name"=>$_POST["full_name"],
	 	"email"=>$_POST["email"]
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
$db->deleteDirectory("../../../../upload/back_profil_foto/".$db->fetchSingleRow("sys_users","id",$_POST["id"])->foto_user);
$db->deleteDirectory("../../../../upload/back_profil_foto/thumb_".$db->fetchSingleRow("sys_users","id",$_POST["id"])->foto_user);
              $foto_user = array("foto_user"=>$filename);
              $data = array_merge($data,$foto_user);
						}

                         }
		$up = $db->update("sys_users",$data,"id",$_POST["id"]);
		action_response($db->getErrorMessage());
		break;
	default:
		# code...
		break;
}

?>