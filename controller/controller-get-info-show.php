<?php
include_once '../model/ShowBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idShow = $json_obj->idShow;

$showLogic = new ShowBO();
$shows = $showLogic->GetListShowsUpdate($idShow);

header('Content-Type: application/json');
print json_encode($shows);

?>