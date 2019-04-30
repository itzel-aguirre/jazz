<?php
include_once '../model/UserBO.php';

$userLogic = new UserBO();
$users = $userLogic->ListUser();

header('Content-Type: application/json');
print json_encode($users);

?>