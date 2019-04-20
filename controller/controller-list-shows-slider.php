<?php
include_once '../model/ShowBO.php';

$showLogic = new ShowBO();
$shows = $showLogic->ListShowsSlider();

header('Content-Type: application/json');
print json_encode($shows);

?>