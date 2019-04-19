<?php
include_once '../model/ShowBO.php';
$showLogic = new ShowBO();
$is_success = $showLogic->saveImages($_FILES);

if($is_success == false){
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al salvar las imágenes show')));
}
?>