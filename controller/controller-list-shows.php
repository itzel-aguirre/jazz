<?php
include_once '../model/ShowBO.php';

$showLogic = new ShowBO();
$shows = $showLogic->ListShows();

header('Content-Type: application/json');
print json_encode($shows);

?>