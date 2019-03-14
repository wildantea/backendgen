<?php
include "../backend/inc/config.php";
require 'vendor/autoload.php';
include   "lib/class.stream.php";

use \Slim\Slim;
use \Slim\Route;
use \lib\apiClass;
use \lib\stream;

$app = new Slim;

$req = $app->request;

$apiClass = new apiClass($db);



// function defination to convert array to xml
function array_to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
     }
}


function echoResponse($status_code, $response,$type) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    if ($type=='json') {
       // setting response content type to json
      $app->contentType('application/json');
       echo json_encode($response);
    } elseif ($type=='xml') {
      $app->contentType('application/xml');
    // creating object of SimpleXMLElement
    $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

    // function call to convert array to xml
    array_to_xml($response,$xml_data);
      
      echo $xml_data->asXML();

    }

}

  
 /**
     * Adding Middle Layer to authenticate every request
     * Checking if the request has valid api key in the 'Authorization' header
     */
  $authenticate = function ($type,$id_service,$access ) {
    return function () use ($type,$id_service,$access ) {

       // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    global $db;
 
      

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        
 
        // get the api key
        $api_key = $headers['Authorization'];

         //get access 
        $array_access = array();
        $data_access = $db->fetchSingleRow("sys_token","id_service",$id_service);
        $access = json_decode($data_access->read_access);
        foreach ($access as $acc) {
          if ($acc->access==1) {  
            $array_access[] = $acc->token;
          }
        }
        
        // validating api key
        if (in_array($api_key, $array_access)) {
            return true;  
        } else {
           
            // api key is not present in users table
            $response['status']['code'] = 401;
            $response['status']["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response,"$type");
            $app->stop();
        }
    } else {
        // api key is missing in header
        $response['status']['code'] = 400;
        $response['status']["message"] = "Api key is misssing";
        echoResponse(400, $response,"$type");
        $app->stop();
        }

      };
  };

$resourceUri = $req->getResourceUri();

$first_uri = explode("/", $resourceUri);


$include_file = "services/".$first_uri[1].'/'.$first_uri[1].".php";
$filename = $first_uri[1];

if (file_exists($include_file)) {
  include "$include_file";

} else {
  $app->notFound(function () {
    $response['status']['code'] = 422;
        $response['status']["description"] = "The requested resource doesn't exists";
    echoResponse(404, $response,"json");
  });
  //echo "not exist";
}

  function noauth() {
    return true;
  }

function auth_data($app,$db,$type) {
    $app = $app::getInstance();
    $request = $app->request();
    $username = $request->post('username');
    $password = $request->post('password');


    $data = array(
      'username' => $username,
      'password' => md5($password)
      );

    if ($db->checkExist('sys_users',$data)) {
      $dt = $db->fetchSingleRow('sys_users','username',$username);
      $response = array();
      $response['user'] = $dt->full_name;
      $user_token = "";
      $token = $db->fetchCustomSingle('select read_access from sys_token limit 1');
      $read_token = json_decode($token->read_access);
          foreach ($read_token as $dt_read) {
          if ($dt_read->user_id==$dt->id) {
            $user_token = $dt_read->token;
          }
        }
        if ($user_token=="") {
          $user_token = bin2hex(openssl_random_pseudo_bytes(16));
                $services = $db->fetchAll("sys_token");
        foreach ($services as $serv) {
          foreach (json_decode($serv->read_access) as $read) {
            $object_read[] = '{"user_id":'.$read->user_id.',"access":"'.$read->access.'","token":"'.$read->token.'"}';  
          }
          foreach (json_decode($serv->create_access) as $create) {
            $object_create[] = '{"user_id":'.$create->user_id.',"access":"'.$create->access.'","token":"'.$create->token.'"}';  
          }
          foreach (json_decode($serv->update_access) as $update) {
            $object_update[] = '{"user_id":'.$update->user_id.',"access":"'.$update->access.'","token":"'.$update->token.'"}';  
          }
          foreach (json_decode($serv->delete_access) as $delete) {
            $object_delete[] = '{"user_id":'.$delete->user_id.',"access":"'.$delete->access.'","token":"'.$delete->token.'"}';  
            }
          }
          $object_read[] = '{"user_id":'.$_GET['user'].',"access":"0","token":"'.$user_token.'"}';
          $object_create[] = '{"user_id":'.$_GET['user'].',"access":"0","token":"'.$user_token.'"}';
          $object_update[] = '{"user_id":'.$_GET['user'].',"access":"0","token":"'.$user_token.'"}';
          $object_delete[] = '{"user_id":'.$_GET['user'].',"access":"0","token":"'.$user_token.'"}';

          //read access
          $obj_read = implode(",", $object_read);
          $string_obj_read = "[$obj_read]";

          //create access
          $obj_create = implode(",", $object_create);
          $string_obj_create = "[$obj_create]";

          //update access
          $obj_update = implode(",", $object_update);
          $string_obj_update = "[$obj_update]";

          //delete access
          $obj_delete = implode(",", $object_delete);
          $string_obj_delete = "[$obj_delete]";


          $db->query("update sys_token set read_access='$string_obj_read',create_access='$string_obj_create',update_access='$string_obj_update',delete_access='$string_obj_delete'");
            $response['token'] = $user_token;
        } else {
           $response['token'] = $user_token;
        }

      echoResponse(200, $response,"$type");
    } else {
            $response['status']['code'] = 401;
            $response['status']["message"] = "Invalid Username or Password";
            echoResponse(401, $response,"$type");
            $app->stop();
    }
}

$app->run();



?>
