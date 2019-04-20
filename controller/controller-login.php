<?php
include_once '../model/User.php';
include_once '../model/UserBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$userLogic = new UserBO();
$userData = User::constructPost($json_obj);

$usrResponse = $userLogic->Login($userData);

if($usrResponse){
  header('Content-Type: application/json');
  $arrayReponse = array('name'=>$usrResponse->name, 'type'=>$usrResponse->type);
  print json_encode($usrResponse);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Usuario o contraseña incorrecto')));
}


?>