<?php
	//doc route
	$app->get('/ruangan/doc',function() use ($db) {
		include "doc.php";
	});


	//login action
	$app->post('/ruangan/login', function() use ($app,$db) {
		auth_data($app,$db,"json");
	});

	//auth status
	$read_auth = ($db->fetch_single_row('sys_services','nav_act','ruangan')->read_auth=="Y")?$authenticate('json'):"noauth";
	//url route
	$app->get('/ruangan',$read_auth, function() use ($app,$apiClass,$pg) {
		$data = $pg->query("select data_ruangan.nama_ruangan,data_ruangan.kapasitas from data_ruangan");
		if ($data==true) {
		$response['status'] = array();
		//meta data
		$response['meta']['total-records'] = $pg->total_record;
		$response['meta']['current-records'] = $pg->total_current_record;
		$response['meta']['total-pages'] = $pg->total_pages;
		$response['meta']['current-page'] = $pg->page;

		$response['results'] = array();
		foreach ($data as $dt) {
		//status code
		$response['status']['code'] = 200;
		$response['status']['message'] = "Ok";
			
		$row = array(
				'nama_ruangan' => $dt->nama_ruangan,
				'kapasitas' => $dt->kapasitas,
				);
		//result data
		array_push($response['results'],$row);

		}
		//paginations link
		$response['paginations'] = array();
		$response['paginations']['self'] = $pg->api_current_uri($apiClass->uri_segment(0));
		$response['paginations']['first'] = $pg->api_first($apiClass->uri_segment(0));
		$response['paginations']['prev'] = $pg->api_prev($apiClass->uri_segment(0));
		$response['paginations']['next'] = $pg->api_next($apiClass->uri_segment(0));
		$response['paginations']['last'] = $pg->api_last($apiClass->uri_segment(0));
		
        echoResponse(200, $response,"json");
		} else {
			$response['status']['code'] = 422;
			$response['status']['message'] = $pg->getErrorMessage();
			echoResponse(422, $response,"json");
		}
	});

	$app->get('/ruangan/:id',$read_auth, function($id) use ($app,$apiClass,$pg) {
	$data = $pg->query("select data_ruangan.nama_ruangan,data_ruangan.kapasitas from data_ruangan where id=?",array('id'=>$id));
	if ($data==true) {
		$response['status'] = array();

		if ($data->rowCount()>0) {
			$response['results'] = array();
			foreach ($data as $dt) {
			//status code
			$response['status']['code'] = 200;
			$response['status']['message'] = "Ok";
				
		$row = array(
				'nama_ruangan' => $dt->nama_ruangan,
				'kapasitas' => $dt->kapasitas,
				);
			//result data
			array_push($response['results'],$row);
			}
	        echoResponse(200, $response,"json");
		} else {
			$response['status']['code'] = 404;
            $response['status']["message"] = "The requested resource doesn't exists";
            echoResponse(404, $response,"json");
		}

	} else {
		$response['status']['code'] = 422;
		$response['status']['message'] = $pg->getErrorMessage();
		echoResponse(422, $response,"json");
	}
	});

	//auth status
	$create_auth = ($db->fetch_single_row('sys_services','nav_act','ruangan')->create_auth=="Y")?$authenticate('xml'):"noauth";
	//post ruangan
	$app->post('/ruangan',$create_auth, function() use ($app,$db,$apiClass) {
	 		$app = \Slim\Slim::getInstance();
	 		$request = $app->request();

	 		
	 		
		$validation = array(
		"nama_ruangan" => array(
              "type" => "alphaspace",
              "alias" => "nama_ruangan",
              "value" => $request->post("nama_ruangan"),
              "allownull" => "no",
		),
		"kapasitas" => array(
              "type" => "alphaspace",
              "alias" => "kapasitas",
              "value" => $request->post("kapasitas"),
              "allownull" => "no",
		),
		);
	 		
		$data = array(
            "nama_ruangan" => $request->post("nama_ruangan"),
            "kapasitas" => $request->post("kapasitas"),
		);

	 		$val = $apiClass->assert($validation);

	 		if (empty($apiClass->errors())) {
	 			
	 			$in = $db->insert('data_ruangan',$data);

	 			if ($in==true) {
	 			$id = $db->last_insert_id();
	 			$response['status']['code'] = 201;
                $response['status']["message"] = "ruangan created successfully";
                $response['status']["id"] = $id;
                echoResponse(201, $response,"json");
		 		} else {
					$response['status']['code'] = 422;
					$response['status']['message'] = $db->getErrorMessage();
					echoResponse(422, $response,"json");
		 		}
	 		} else {
					$response['status']['code'] = 422;
					foreach ($apiClass->errors() as $error) {
						$response['status']['message'] = $error;	
					}
					echoResponse(422, $response,"json");
	 		}

	});

	//auth status
	$update_auth = ($db->fetch_single_row('sys_services','nav_act','ruangan')->update_auth=="Y")?$authenticate('xml'):"noauth";

	//update ruangan
	$app->put('/ruangan/:id',$update_auth, function($id) use ($app,$db,$apiClass) {
	 		$app = \Slim\Slim::getInstance();
	 		$request = $app->request();
	 		
	 		$validation = array();
	 		$data = array();

	 		$data_stream = array();
			new lib\stream($data_stream);

	 		$_PUT = $data_stream['post'];
			$_FILES = $data_stream['file'];

	 		
        if (isset($_PUT["nama_ruangan"])) {
          $nama_ruangan_validation = array(
            "nama_ruangan" => array(
              "type" => "alphaspace",
              "alias" => "nama_ruangan",
              "value" => $_PUT["nama_ruangan"],
              "allownull" => "no",
        ));
        $nama_ruangan_data =  array(
            "nama_ruangan" => $_PUT["nama_ruangan"]
        );
        $validation = array_merge($validation,$nama_ruangan_validation);
        $data = array_merge($data,$nama_ruangan_data);
        }
        if (isset($_PUT["kapasitas"])) {
          $kapasitas_validation = array(
            "kapasitas" => array(
              "type" => "alphaspace",
              "alias" => "kapasitas",
              "value" => $_PUT["kapasitas"],
              "allownull" => "no",
        ));
        $kapasitas_data =  array(
            "kapasitas" => $_PUT["kapasitas"]
        );
        $validation = array_merge($validation,$kapasitas_validation);
        $data = array_merge($data,$kapasitas_data);
        }

	 	      if (!empty($data)) {

	        if (!empty($validation)) {
	          $val = $apiClass->assert($validation);

	          if (empty($apiClass->errors())) {
	          	
	            $up = $db->update("data_ruangan",$data,"id",$id);

	            if ($up==true) {
	              $response["status"]["code"] = 200;
	                      $response["status"]["message"] = ucwords("ruangan")." Updated successfully";
	                      echoResponse(200, $response,"json");
	            } else {
	              $response["status"]["code"] = 422;
	              $response["status"]["message"] = $apiClass->pdo->getErrorMessage();
	              echoResponse(422, $response,"json");
	            }
	          } else {
	              $response["status"]["code"] = 422;
	              foreach ($apiClass->errors() as $error) {
	                $response["status"]["message"] = $error;  
	              }
	              echoResponse(422, $response,"json");
	          }
	        } else {
	            $up = $db->update("data_ruangan",$data,"$primary_key",$id);

	            if ($up==true) {
	              $response["status"]["code"] = 200;
	                      $response["status"]["message"] = ucwords("ruangan")." Updated successfully";
	                      echoResponse(200, $response,"json");
	            } else {
	              $response["status"]["code"] = 422;
	              $response["status"]["message"] = $db->getErrorMessage();
	              echoResponse(422, $response,"json");
	            }
	        }

	      } else {
	          $response["status"]["code"] = 422;
	                  $response["status"]["message"] = "Unprocessable Entity";
	                  echoResponse(422, $response,"json");
	      }
	});


//auth status
$delete_auth = ($db->fetch_single_row('sys_services','nav_act','ruangan')->delete_auth=="Y")?$authenticate('xml'):"noauth";

	//delete ruangan
	$app->delete('/ruangan/delete/:id',$delete_auth, function($id) use ($app,$db,$apiClass) {
			$single_data = $db->fetch_single_row("data_ruangan","id",$id);
			
	 		$up = $db->delete('data_ruangan','id',$id);

	 		if ($up==true) {
	 			$response['status']['code'] = 200;
                $response['status']["message"] = "ruangan Deleted successfully";
                echoResponse(200, $response,"json");
	 		} else {
				$response['status']['code'] = 422;
				$response['status']['message'] = $db->getErrorMessage();
				echoResponse(422, $response,"json");
	 		}

	});

	//search ruangan
	$app->get('/ruangan/search/:search',$read_auth, function($search) use ($app,$db,$pg,$apiClass) {
          $search_condition = $db->getRawWhereFilterForColumns($search, array('data_ruangan.nama_ruangan','data_ruangan.kapasitas',));
          $search_condition = "where $search_condition";
	 	$data = $pg->query("select data_ruangan.nama_ruangan,data_ruangan.kapasitas from data_ruangan $search_condition");
	 	if ($data==true) {
	 		$response['status'] = array();
	 		$response['results'] = array();
	 		foreach ($data as $dt) {
				//status code
				$response['status']['code'] = 200;
				$response['status']['message'] = "Ok";
				
		$row = array(
				'nama_ruangan' => $dt->nama_ruangan,
				'kapasitas' => $dt->kapasitas,
				);
				//result data
				array_push($response['results'],$row);	 			
	 		}
	 				//paginations link
		$response['paginations'] = array();
		$response['paginations']['self'] = $pg->api_current_uri($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['first'] = $pg->api_first($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['prev'] = $pg->api_prev($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['next'] = $pg->api_next($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['last'] = $pg->api_last($apiClass->uri_segment(0),$apiClass->uri_segment(2));
			echoResponse(200, $response,"json");
	 	} else {
			$response['status']['code'] = 422;
			$response['status']['message'] = $db->getErrorMessage();
			echoResponse(422, $response,"json");
	 	}
	});

	