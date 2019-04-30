<?php

include_once '../model/UpdateUrlBO.php';

$newData = new UpdateUrlBO();
$video  = $newData->selectUrl();

header('Content-Type: application/json');
print json_encode($video);
?>