<?php
require "backend/inc/config.php";
require('backend/inc/lib/simplexlsx.class.php');
$time_start = microtime(true); 
echo "<pre>";

//insert using query 
/*$db->begin_transaction();
$db->query("delete from jurusan");
$db->rollBack();*/

/*$db->begin_transaction();
$db->query("insert into jurusan(id_fakultas,nama_jurusan) values(1,'Biologis')");
$db->query("insert into jurusan(id_fakultas,nama_jurusan) values(1,'Biologi')");
$db->commit();*/

//query 
/*$rows = $db->query("select * from provinsi limit 2");
foreach ($rows as $row) {
	print_r($row);
}*/

//single row
/*$row = $db->fetchSingleRow("provinsi","id_prov",11);
echo $row->nama_prov;*/

//fetchCustomSingle
/*$data = $db->fetchCustomSingle("select * from provinsi order by id_prov desc");
echo $data->nama_prov;*/

//fetchAll
/*$data = $db->fetchAll('provinsi');
foreach ($data as $dt) {
	print_r($dt);
}*/

//checkExist
/*$check_data = array('nama_prov' => 'Papua');
$checkExist = $db->checkExist('provinsi',$check_data);
//var_dump($checkExist);
if ($checkExist) {
	$get_data = $checkExist->getData();
	print_r($get_data);
}*/

/*$jurusan = array('Fisika',"Inf'ormatika");
foreach ($jurusan as $jur) {
	$array_data[] = array(
		'id_fakultas' => 2,
		'nama_jurusan' => $jur
	);
}
print_r($array_data);


$db->insertMulti('jurusan',$array_data);

exit();*/

 function trimmer($value) {
 	return preg_replace( '/[^[:print:]]/', '',filter_var($value, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH));
 }

$Reader = new SimpleXLSX("krs.xlsx");
  foreach( $Reader->rows() as $key => $val ) {
    if ($key>0) {
      	if ($val[0]!='') {
      		$data_array[] = array(
      			'nim' => trimmer($val[0]),
      			'nama' => trimmer($val[1]),
      			'semester' => trimmer($val[2]),
      			'kode_mk' => trimmer($val[3]),
      			'nama_mk' => trimmer($val[4]),
      			'nama_kelas' => trimmer($val[5]),
      			'kode_jurusan' => trimmer($val[6])
      		);
      	}

  	}
 }


$db->insertMulti('krs',$data_array);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo waktu_import($execution_time);
function waktu_import($waktu) {

  $hours = floor($waktu / 3600);
  $minutes = floor(($waktu / 60) % 60);
  $seconds = $waktu % 60;

  return ($hours < 1?'':$hours.' Jam') . ($minutes < 1 ? '':$minutes.' Menit') . $seconds.' Detik';
}