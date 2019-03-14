<?php
session_check_adm();
switch (uri_segment(1)) {
	case 'import':
		include "import.php";
		break;
	case 'create':
		include "service_add.php";
		break;
	case 'edit':
		$data_edit = $db->fetchSingleRow('sys_menu','id',uri_segment(2));
		include "page_edit.php";
		break;
	case 'icon':
		include "icon.php";
		break;
	default:
		include "service_view.php";
		break;
}

?>
