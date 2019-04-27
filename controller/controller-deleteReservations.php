<?php
include_once '../model/ReservationsBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idReservation = $json_obj->idReservation;
$showLogic = new ReservationsBO();
$deleteReservations = $showLogic->DeleteReservation($idReservation);

if($deleteReservations){
  header('Content-Type: application/json');
  print json_encode($deleteReservations);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar una reservación')));
} 
?>