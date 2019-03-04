<?php
session_start();
include "config.php";


$json_response = array();

//i only receive ajax request :D
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $data = array(
        'username'=>$_POST['username'],
        'password'=>md5($_POST['password'])
        );
    $check = $db->check_exist('sys_users', $data);
    if ($check==true) {
        $dt=$db->fetch_single_row('sys_users', 'username', $_POST['username']);
        $group_dt=$db->fetch_single_row('sys_group_users', 'level', $dt->group_level);
        $_SESSION['group_level']=$group_dt->level;
        $_SESSION['id_user']=$dt->id;
        $_SESSION['login']=1;
        $status['status'] = "good";
    } else {
        $status['status'] = "bad";
    }
} else {
    //hei , don't ever try if you're not ajax request, because you gonna die
    $status['status'] = "go out dude";
}


array_push($json_response, $status);
echo json_encode($json_response);
