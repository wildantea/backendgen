<?php
include "inc/config.php";
require 'vendor/autoload.php';
//include "lib/validatorClass.php";

use \Slim\Slim;
use \Slim\Route;

use Respect\Validation\Validator as v;

use Respect\Validation\Exceptions\NestedValidationException;

use Respect\Validation\Exceptions\ValidationException;


use lib\apiClass;

$app = new Slim;

$req = $app->request;


//get all user
$app->get('/','form');
$app->post('/send','send');

function send()
{
	echo "<pre>";
	print_r($_POST);

	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	global $db;


	$valid = new apiClass($db);


	$validation = array(
		'username' => array (
			'type' => 'alnum',
			'value' => $_POST['username']
			),
		'angka' => array(
			'type' => 'notEmpty',
			'value' => $_POST['angka']
			),
		'gambar' => array(
			'type' => 'image',
			'value' => 	$_FILES['gambar']['tmp_name']
			),
		'checkfile' => array(
			'type' => 'file',
			'value' => $_FILES['checkfile']['name'],
			'extention' => 'pdf|doc|xls|docx'
			),
		'nextfile' => array(
			'type' => 'file',
			'value' => $_FILES['nextfile']['name'],
			'extention' => 'pdf|xls|docx'
			)


		);



	print_r($validation);
	
	$val = $valid->assert($validation);

	print_r($valid->errors());
		
/*
	$usernameValidator = v::alnum()->noWhitespace()->length(1, 15)->setName('Username');
	//$angka = v::numeric()->validate($number); // true




	$usernameValidator->validate($_POST['username']);    


	
	try {
	    $usernameValidator->assert('really messed up screen#name');
	} catch(NestedValidationException $exception) {
			$errors = $exception->findMessages([
    'alnum' => '{{name}} must contain hanya letters and digits',
    'length' => '{{name}} must not have more than 15 chars',
    'noWhitespace' => '{{name}} cannot contain spaces'
	]);
	   echo $exception->getFullMessage();
	}
*/


}

function form()
{
	$ar1 = array(
		'nama' => 'wildan',
		'alamat' => 'sumedang',
		'muka' => 'ganteng'
		);
	$ar2 = array('nama','muka');

	$end = array_intersect($ar2, $ar1);
	print_r($end);
/*
	global $db;
	$data = $db->fetch_all('ext');
	foreach ($data as $dt) {
		echo "'".$dt->extentionn."' => '".$dt->mime."',<br>";
	}*/
	?>
	<form enctype="multipart/form-data" action="http://localhost/match_app/api/coba.php/send" method="POST">
    <legend>Profile</legend>

    <input class="form-control" placeholder="username" name="username" type="text" autofocus="">
    <input class="form-control" name="angka" type="text" >
    <input type="file" name="gambar">
     <input type="file" name="checkfile">
    <input type="file" name="nextfile">
    
    <button class="btn btn-primary">Join</button>
	</form>
	<?php
}





$app->run();



?>