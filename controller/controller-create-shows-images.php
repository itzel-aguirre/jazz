<?php
include_once '../model/ShowBO.php';
$showLogic = new ShowBO();
$showLogic->saveImages($_FILES);
?>