
<?php
switch (uri_segment(1)) {
  case 'change-password':
    include "change_pass.php";
    break;
	case "edit":
    include "profil_edit.php";
		break;
	default:
		include "profil_view.php";
		break;
}

?>
