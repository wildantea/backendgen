<?php
session_check_adm();
switch (uri_segment(2)) {
	default:
		include "service_permission_view.php";
		break;
}

?>
