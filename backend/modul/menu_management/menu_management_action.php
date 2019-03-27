<?php
session_start();
include "../../inc/config.php";
session_check_adm();

		//check exist
		$action = $_POST['action'];
		$array_exist = array(
				"id_menu" => $_POST['id_menu'],
				"group_level" => $_POST['level']
				);
		
		$check = $db->checkExist("sys_menu_role",$array_exist);
		if ($check)
		{
			$db->query("update sys_menu_role set $action=? where id_menu=? and group_level=?",
				array(
					"$action" => $_POST['data_act'],
					'id_menu' => $_POST['id_menu'],
					'group_level' => $_POST['level']
				));
		} else {
			$array_act = array(
				'read_act' => 'N',
				'insert_act' => 'N',
				'update_act' => 'N',
				'delete_act' => 'N',
				'import_act' => 'N',
				'id_menu' => $_POST['id_menu'],
				'group_level' => $_POST['level']
			);
			$array_act[$action] = $_POST['data_act'];
			$db->insert("sys_menu_role",$array_act);
		}

?>