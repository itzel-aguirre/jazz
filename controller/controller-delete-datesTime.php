<?php
include_once '../model/ShowBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$dateLogic = new ShowBO();
$deleteDate = $dateLogic->delete_reservationDatesTime($json_obj);

if($deleteDate){
  header('Content-Type: application/json');
  print json_encode($deleteDate);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar la fecha')));
} 
?>