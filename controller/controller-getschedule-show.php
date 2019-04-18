<?php
include_once '../model/ShowBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$id_show = $json_obj->id_show;
$showLogic = new ShowBO();
$schedules = $showLogic->ListShedules($id_show);

header('Content-Type: application/json');
print json_encode($schedules);

?>