<?php
switch (uri_segment(1)) {
    case "detail":
    $data_edit = $db->fetch_single_row("sys_group_users","id",uri_segment(2));
    include "user_group_detail.php";
    break;
    default:
    include "user_group_view.php";
    break;
}
?>