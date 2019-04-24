<?php
include_once '../model/ShowBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idShow = $json_obj->idShow;
$showLogic = new ShowBO();
$deleteShow = $showLogic->DeleteShow($idShow);

if($deleteShow){
  header('Content-Type: application/json');
  print json_encode($deleteShow);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar un espectáculo')));
} 
?>