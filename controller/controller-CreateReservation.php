<?php
include_once '../model/Reservations.php';
include_once '../model/ReservationsBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$reservationData =  Reservations::constructPost($json_obj);
$reservationLogic = new ReservationsBO();
//se envian los datos a registrar, almacenados en $json_obj
$ResponseDataReservation = $reservationLogic->CreateReservation($reservationData);

if($ResponseDataReservation){
  header('Content-Type: application/json');
  print json_encode($ResponseDataReservation);

}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Incorrecto')));
} 

?>