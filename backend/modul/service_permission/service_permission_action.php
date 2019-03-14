<?php
session_start();
include "../../inc/config.php";
session_check_adm();
switch ($_GET["act"]) {
	
	case 'gen_token':
		$services = $db->query("select * from sys_token");
		$new_token = bin2hex(openssl_random_pseudo_bytes(16));
		foreach ($services as $service) {
			$read = json_decode($service->read_access);
	        foreach ($read as $dt_read) {
	          if ($dt_read->user_id==$_POST['user_id']) {
	             $array_json = array(
	                'user_id' => $_POST['user_id'],
	                'access' => $dt_read->access,
	                'token' => $new_token
	            );
	          } else {
	            $array_json = array(
	              'user_id' => $dt_read->user_id,
	              'access' => $dt_read->access,
	              'token' => $dt_read->token
	            );
	          }
	          $json_read[] = $array_json;
	        }

			$get_read = json_encode($json_read);

			//create
			$create = json_decode($service->create_access);
	        foreach ($create as $dt_create) {
	          if ($dt_create->user_id==$_POST['user_id']) {
	             $array_json = array(
	                'user_id' => $_POST['user_id'],
	                'access' => $dt_create->access,
	                'token' => $new_token
	            );
	          } else {
	            $array_json = array(
	              'user_id' => $dt_create->user_id,
	              'access' => $dt_create->access,
	              'token' => $dt_create->token
	            );
	          }
	          $json_create[] = $array_json;
	        }

			$get_create = json_encode($json_create);


			//update
			$update = json_decode($service->update_access);
	        foreach ($update as $dt_update) {
	          if ($dt_update->user_id==$_POST['user_id']) {
	             $array_json = array(
	                'user_id' => $_POST['user_id'],
	                'access' => $dt_update->access,
	                'token' => $new_token
	            );
	          } else {
	            $array_json = array(
	              'user_id' => $dt_update->user_id,
	              'access' => $dt_update->access,
	              'token' => $dt_update->token
	            );
	          }
	          $json_update[] = $array_json;
	        }

			$get_update = json_encode($json_update);

			//delete
			$delete = json_decode($service->delete_access);
	        foreach ($delete as $dt_delete) {
	          if ($dt_delete->user_id==$_POST['user_id']) {
	             $array_json = array(
	                'user_id' => $_POST['user_id'],
	                'access' => $dt_delete->access,
	                'token' => $new_token
	            );
	          } else {
	            $array_json = array(
	              'user_id' => $dt_delete->user_id,
	              'access' => $dt_delete->access,
	              'token' => $dt_delete->token
	            );
	          }
	          $json_delete[] = $array_json;
	        }

			$get_delete = json_encode($json_delete);

			$data_update = array(
				'read_access' => $get_read,
				'create_access' => $get_create,
				'update_access' => $get_update,
				'delete_access' => $get_delete
			);
			$update_data = $db->update('sys_token',$data_update,'id',$service->id);

			$json_read = array();
			$json_create = array();
			$json_update = array();
			$json_delete = array();
		}
		echo $new_token;

		break;
	case 'change_read':
		print_r($_POST);
		$get_read = $db->fetchCustomSingle("select read_access from sys_token where id=?",array('id' => $_POST['token_id']));

        $read = json_decode($get_read->read_access);
        foreach ($read as $dt_read) {
          if ($dt_read->user_id==$_POST['user']) {
             $array_json = array(
                'user_id' => $_POST['user'],
                'enable_token' => $dt_read->enable_token,
                'access' => $_POST['data_act'],
                'token' => $dt_read->token
            );
          } else {
            $array_json = array(
              'user_id' => $dt_read->user_id,
              'enable_token' => $dt_read->enable_token,
              'access' => $dt_read->access,
              'token' => $dt_read->token
            );
          }
          $json_read[] = $array_json;
        }

		$get_read = json_encode($json_read);
		
/*		$read_access = $_POST['data_act'];
		$token_enable = $get_read->{'token'};
		$json_data = '{"access":'.$read_access.',"token":'.$token_enable.'}';*/
		$data = array('read_access' => $get_read);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_enable_token':
		print_r($_POST);
		$act_token = $_POST['act_token']."_access";
		$get_read = $db->fetchCustomSingle('select '.$act_token.' from sys_token where id=?',array('id' => $_POST['token_id']));
		$get_read = json_decode($get_read->{$act_token});
	        foreach ($get_read as $dt_read) {
	          if ($dt_read->user_id==$_POST['user'] or $_POST['']) {
	             $array_json = array(
	                'user_id' => $_POST['user'],
	                'enable_token' => $_POST['data_act'],
	                'access' => $dt_read->access,
	                'token' => $dt_read->token
	            );
	          } else {
	            $array_json = array(
	              'user_id' => $dt_read->user_id,
	              'enable_token' => $dt_read->enable_token,
	              'access' => $dt_read->access,
	              'token' => $dt_read->token
	            );
	          }
	          $json_read[] = $array_json;
	        }

		$json_data = json_encode($json_read);
		$data = array("$act_token" => $json_data);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_create':
		$get_create = $db->fetchCustomSingle("select create_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_created = json_decode($get_create->create_access);

		foreach ($get_created as $dt_read) {
          if ($dt_read->user_id==$_POST['user']) {
             $array_json = array(
                'user_id' => $_POST['user'],
                'enable_token' => $dt_read->enable_token,
                'access' => $_POST['data_act'],
                'token' => $dt_read->token
            );
          } else {
            $array_json = array(
              'user_id' => $dt_read->user_id,
              'enable_token' => $dt_read->enable_token,
              'access' => $dt_read->access,
              'token' => $dt_read->token
            );
          }
          $json_read[] = $array_json;
        }

		$get_create = json_encode($json_read);

		/*
		$create_access = $_POST['data_act'];
		$token_enable = $get_create->{'token'};
		$json_data = '{"access":'.$create_access.',"token":'.$token_enable.'}';*/
		$data = array('create_access' => $get_create);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_create_token':
		print_r($_POST);
		$get_create = $db->fetchCustomSingle("select create_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_create = json_decode($get_create->create_access);
		$create_access =  $get_create->{'access'};
		$token_enable = $_POST['data_act'];
		$json_data = '{"access":'.$create_access.',"token":'.$token_enable.'}';
		$data = array('create_access' => $json_data);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_update':
		print_r($_POST);
		$get_update = $db->fetchCustomSingle("select update_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_update = json_decode($get_update->update_access);

		foreach ($get_update as $dt_read) {
          if ($dt_read->user_id==$_POST['user']) {
             $array_json = array(
                'user_id' => $_POST['user'],
                'enable_token' => $dt_read->enable_token,
                'access' => $_POST['data_act'],
                'token' => $dt_read->token
            );
          } else {
            $array_json = array(
              'user_id' => $dt_read->user_id,
              'enable_token' => $dt_read->enable_token,
              'access' => $dt_read->access,
              'token' => $dt_read->token
            );
          }
          $json_read[] = $array_json;
        }

		$get_update = json_encode($json_read);

/*		$update_access = $_POST['data_act'];
		$token_enable = $get_update->{'token'};
		$json_data = '{"access":'.$update_access.',"token":'.$token_enable.'}';*/
		$data = array('update_access' => $get_update);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_update_token':
		print_r($_POST);
		$get_update = $db->fetchCustomSingle("select update_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_update_token = json_decode($get_update->update_access);
		$update_access_token = $get_update_token->{'access'};
		$token_enable = $_POST['data_act'];
		$json_data = '{"access":'.$update_access_token.',"token":'.$token_enable.'}';
		$data = array('update_access' => $json_data);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_delete':
		print_r($_POST);
		$get_delete = $db->fetchCustomSingle("select delete_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_delete = json_decode($get_delete->delete_access);
		foreach ($get_delete as $dt_read) {
          if ($dt_read->user_id==$_POST['user']) {
             $array_json = array(
                'user_id' => $_POST['user'],
                'enable_token' => $dt_read->enable_token,
                'access' => $_POST['data_act'],
                'token' => $dt_read->token
            );
          } else {
            $array_json = array(
              'user_id' => $dt_read->user_id,
              'enable_token' => $dt_read->enable_token,
              'access' => $dt_read->access,
              'token' => $dt_read->token
            );
          }
          $json_read[] = $array_json;
        }

		$get_delete = json_encode($json_read);

		/*$delete_access = $_POST['data_act'];
		$token_enable = $get_delete->{'token'};
		$json_data = '{"access":'.$delete_access.',"token":'.$token_enable.'}';*/
		$data = array('delete_access' => $get_delete);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
	case 'change_delete_token':
		print_r($_POST);
		$get_delete = $db->fetchCustomSingle("select delete_access from sys_token where id=?",array('id' => $_POST['token_id']));
		$get_delete = json_decode($get_delete->delete_access);
		$delete_access_token = $get_delete->{'access'};
		$token_enable = $_POST['data_act'];
		$json_data = '{"access":'.$delete_access_token.',"token":'.$token_enable.'}';
		$data = array('delete_access' => $json_data);
		$update = $db->update('sys_token',$data,'id',$_POST['token_id']);
		break;
		
	default:
		# code...
		break;
}

?>