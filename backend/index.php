<?php
session_start();
include "inc/config.php";

require_once "inc/url.php";

if (isset($_SESSION['login'])) {

//call header file
include  "header.php";
//switch for static menu
switch (uri_segment(0)) {
	case 'filter':
		include "system/page/filter/filter.php";
		break;
	case 'profil':
		include "modul/profil/profil.php";
		break;
	case '':
		include "modul/home/home.php";
		break;
}

     //dynamic menu from database
	//jika url yang di dipanggil ada di role user, include page
	foreach ($db->fetch_all('sys_menu') as $isi) {
		if (in_array($isi->url, $role_user)) {
			if (uri_segment(0)==$isi->url && uri_segment(0)!='') {
				include "modul/".$isi->nav_act."/".$isi->nav_act.".php";
			}

        }
	}


include "footer.php";

} else {
	redirect(base_admin()."login.php");
}
?>
