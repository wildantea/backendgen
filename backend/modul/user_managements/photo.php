<?php
session_start();
include "../../inc/config.php";
 $data_edit = $db->fetchSingleRow("sys_users","id",$_POST['id']);
?>
<img src="<?=base_url();?>upload/back_profil_foto/thumb_<?=$data_edit->foto_user;?>">