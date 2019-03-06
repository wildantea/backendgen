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
  $authenticate = function ($type ) {
    return function () use ($type ) {

       // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        global $db;
 
        // get the api key
        $api_key = $headers['Authorization'];

        //check token db
        $check_key = $db->checkExist('sys_users',array('token' => $api_key));

        // validating api key
        if ($check_key==true) {
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
      $response['user'] = $dt->first_name." ".$dt->last_name; //Just return the user name for reference
            $response['token'] = bin2hex(openssl_random_pseudo_bytes(16)); //generate a random token

            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));//the expiration date will be in one hour from the current moment
          $data_token = array('token' => $response['token'],'token_expiration' => $tokenExpiration);
          $db->update('sys_users',$data_token,'username',$username);

            //update the token on the database and set the expiration date-time, implement your own
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
