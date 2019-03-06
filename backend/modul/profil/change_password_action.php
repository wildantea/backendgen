<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
	case "up":
	$check_pass_old = $db->checkExist('sys_users',array('id' => $_SESSION['id_user'],'password' => md5($_POST['password'])));
if ($check_pass_old==false) {
	action_response('Your current password is wrong');
}
$data = array("password"=>md5($_POST["password_baru"]));
$up = $db->update("sys_users",$data,"id",$_POST["id"]);
session_destroy();
action_response($db->getErrorMessage());
		break;
	default:
		# code...
		break;
}

?>