<?php
include_once '../model/DataTableBO.php';

$tableLogic = new DataTableBO();
$table = $tableLogic->ListTable();

header('Content-Type: application/json');
print json_encode($table);

?>