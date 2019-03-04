<?php
include "../../inc/config.php";

$data_sorting = $_POST['sorting'];

print_r($_POST);

foreach ($data_sorting as $key => $data) {
	if ($key>0) {
			$array_menu[$data['depth']][] = array(
				'id' => $data['id'],
				'parent' => $data['parent_id']
			);
		$depth[] = $data['depth'];
	}
}

print_r($array_menu);

foreach ($array_menu as $depth => $depth_array) {
	foreach ($depth_array as $key => $id) {
		$array_update_menu = array('urutan_menu' => $key+1);
		if ($id['parent']!="") {
			$array_update_menu['parent'] = $id['parent'];
		} else {
			$array_update_menu['parent'] = 0;
		}
		$db->update('sys_menu',$array_update_menu,'id',$id['id']);
		print_r($array_update_menu);		
	}
}

exit();


$count_array_depth = array_count_values($depth);

for ($i=0; $i < count($count_array_depth); $i++) { 
	for ($child_dept=0; $child_dept < $count_array_depth[$i]; $child_dept++) { 
		$array_menu[] = array(
			'id' => $data['id'],
			'urutan_menu' => $data['depth']+$key
		);
	}
}
exit();

$all_menu_parent = $db->query("select * from sys_menu where type_menu=?",array('type_menu' => 'main'));
foreach ($all_menu_parent as $parent) {
	$id_parent_aray[] = $parent->id;
}

print_r($data_sorting);

foreach ($data_sorting as $key => $data) {
	if ($key>0) {
		if ($data['parent_id']=="") {
			$data_parent[] = $data['id'];
		} else {
			$data_child[$data['id']] = $data['parent_id'];
		}
	}
}

print_r($data_parent);

exit();

$order_parent=1;
foreach ($data_parent as $id_parent) {
	$db->update('sys_menu',array('urutan_menu' => $order_parent),'id',$id_parent);
	$order_child = 1;
	foreach ($data_child as $child_id => $parent_id) {
		if ($parent_id==$id_parent) {
			$db->update('sys_menu',array('urutan_menu' => $order_child,'parent' => $parent_id),'id',$child_id);
			$order_child++;
		}
	}
$order_parent++;
}

exit();

$replace_parent_original = str_replace(array('item-'), "", $_POST['parent_original_drag_id']);
$drag_item = str_replace(array('item-'), "", $_POST['drag_item']);
$parent_drag_id = $_POST['parent_drag_id'];

$replace_data = array("item[]=");
$data_order = str_replace($replace_data, "", $_POST['order']);
$explode_order = explode("&", $data_order);

//let's reorder drag item 
$menu_items = $db->query("select * from sys_menu where type_menu=? and parent=?", array('type_menu' => 'page','parent' =>  $replace_parent_original));
$flip_array_order = array_flip($explode_order);


foreach ($menu_items as $item) {
	if (in_array($item->id, array_keys($flip_array_order))) {
		$reorder_item[$flip_array_order[$item->id]] = $item->id;
	}
}

ksort($reorder_item);
$reorder_item = array_values($reorder_item);

if ($replace_parent_original==$parent_drag_id) {
	for ($i=0; $i <count($reorder_item) ; $i++) { 
		$db->update('sys_menu',array('parent' => $replace_parent_original,'urutan_menu' => $i+1),'id',$reorder_item[$i]);
	}
	exit();
} else {
	for ($i=0; $i <count($reorder_item) ; $i++) { 
	if ($reorder_item[$i]!=$drag_item) {
		$db->update('sys_menu',array('parent' => $replace_parent_original,'urutan_menu' => $i+1),'id',$reorder_item[$i]);
		}
	}
}





//update dragable to new parent
$db->update('sys_menu',array('parent' => $parent_drag_id),'id',$drag_item);

//let's reorder drag item to new one
$menu_items = $db->query("select * from sys_menu where type_menu=? and parent=?", array('type_menu' => 'page','parent' =>  $parent_drag_id));
$flip_array_order = array_flip($explode_order);


foreach ($menu_items as $item) {
	if (in_array($item->id, array_keys($flip_array_order))) {
		$reorder_items[$flip_array_order[$item->id]] = $item->id;
	}
}

ksort($reorder_items);
$reorder_items = array_values($reorder_items);


for ($i=0; $i <count($reorder_items) ; $i++) { 
	$update = array('parent' => $parent_drag_id,'urutan_menu' => $i+1);
	$db->update('sys_menu',$update,'id',$reorder_items[$i]);
}


/*if ($_POST['parent_drag_id']==0) {
	array_unshift($explode_parent,$drag_item);
}
*/

$data_urutan = str_replace($replace_data, "", $_POST['urutan']);
$explode_parent = explode("&", $data_urutan);


$flip_array_urutan = array_flip($explode_parent);
//reorder parent 0
$parent_zero = $db->query("select * from sys_menu where parent=?",array('parent' => 0));
foreach ($parent_zero as $zero) {
	if (in_array($zero->id, array_keys($flip_array_urutan))) {
		$reorder_item_parent[$flip_array_urutan[$zero->id]] = $zero->id;
	}

}
//print_r($reorder_item_parent);
ksort($reorder_item_parent);
$reorder_item_parent = array_values($reorder_item_parent);

for ($i=0; $i <count($reorder_item_parent) ; $i++) { 
	$update = array('urutan_menu' => $i+1);
	$db->update('sys_menu',$update,'id',$reorder_item_parent[$i]);
}
?>