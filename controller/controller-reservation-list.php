<?php
include_once '../model/ReservationsBO.php';

$reservationLogic = new ReservationsBO();
$reservations = $reservationLogic->GetReservations();

header('Content-Type: application/json');
print json_encode($reservations);

?>