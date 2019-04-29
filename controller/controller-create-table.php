<?php
include_once '../model/DataTable.php';
include_once '../model/DataTableBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$tableLogic = new DataTableBO();
$tableData = DataTable::constructNewTableJson($json_obj);
try{
  $tableLogic->CreateTable($tableData);
  print true;
}
catch(Exception $e){
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al registrar una mesa')));
}

?>