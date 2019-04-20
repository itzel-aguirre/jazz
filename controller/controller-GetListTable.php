<?php
include_once '../model/DataTable.php';
include_once '../model/DataTableBO.php';


# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$newDataTable = new DataTableBO();
//se envian los datos a registrar, almacenados en $json_obj
$ResponseDataTable = $newDataTable->GetListTable($json_obj);

if($ResponseDataTable){
  header('Content-Type: application/json');
  print json_encode($ResponseDataTable);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Incorrecto')));
} 
?>