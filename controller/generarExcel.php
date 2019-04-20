<?php
include_once '../model/Reservations.php';
include_once '../model/ReservationsBO.php';
/* include '../lib/PHPExcel.php';
include '../lib/PHPExcel/Writer/Excel2007.php'; */

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$reservationLogic = new ReservationsBO();
$usrResponse = $reservationLogic->generateExcel();

if($usrResponse){
  header('Content-Type: application/json');
  print json_encode(array('pathfile'=>'http://localhost/jazz/temp/Reservaciones.xlsx'));
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Incorrecto')));
}
?>