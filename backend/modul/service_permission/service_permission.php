<?php
session_check_adm();
switch (uri_segment(1)) {
	default:
		include "service_permission_view.php";
		break;
}

?>
