<?php
include_once '../model/ReservationsBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idReservation = $json_obj->idReservation;
$deposito = $json_obj->deposito;
$showLogic = new ReservationsBO();
$updateReservations = $showLogic->updateDeposit($idReservation, $deposito);

if($updateReservations){
  header('Content-Type: application/json');
  print json_encode($updateReservations);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al registrar el deposito')));
} 
?>