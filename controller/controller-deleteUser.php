<?php
include_once '../model/UserBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idUser = $json_obj->idUser;
$userLogic = new UserBO();
$userResult = $userLogic->DeleteUser($idUser);

if($userResult){
  header('Content-Type: application/json');
  print json_encode($userResult);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar un usuario')));
} 
?>