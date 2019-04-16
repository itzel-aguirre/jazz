<?php
include_once '../model/Show.php';
include_once '../model/ShowBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$showLogic = new ShowBO();
$showData = Show::constructShowJson($json_obj);
$showLogic->CreateShow($showData);
print $json_str;
?>