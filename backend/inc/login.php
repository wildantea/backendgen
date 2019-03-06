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
    $check = $db->checkExist('sys_users', $data);
    if ($check==true) {
        $_SESSION['group_level']= $check->getData()->group_level;
        $_SESSION['id_user']= $check->getData()->id;
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
