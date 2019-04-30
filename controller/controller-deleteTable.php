<?php
include_once '../model/DataTableBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idTable = $json_obj->idTable;
$tableLogic = new DataTableBO();
$deleteTable = $tableLogic->DeleteTable($idTable);

if($deleteTable){
  header('Content-Type: application/json');
  print json_encode($deleteTable);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar una mesa')));
} 
?>