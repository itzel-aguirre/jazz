<?php
include_once 'ConectDB.php';
include_once 'DataTable.php';

class DataTableBO
{ 
    public function __construct()
    {
  
    }

    public function GetListTable($listData)
    {
        $databaseConected = new ConectDB();
        $databaseConected->conectar();
        $list_Array = array();

        $query = " SELECT ID_MESA, NO_MESA FROM ( ";
        $query .= " SELECT ";
        $query .= " mesas.ID_MESA AS ID_MESA, mesas.NO_MESA AS NO_MESA ";
        $query .= " FROM `mesas` ";
        $query .= " WHERE '".$listData->no_people."' between mesas.NO_PERSONAS_MIN AND mesas.NO_PERSONAS_MAX ";
        $query .= " )  MESAS WHERE ID_MESA NOT IN (SELECT ID_MESA FROM reservaciones WHERE reservaciones.ID_FECHA_HR = '".$listData->fecha_Hr."') ";

        $resultQuery = $databaseConected->consulta($query);

        if ($resultQuery->num_rows > 0) {
    
          while($row = $resultQuery->fetch_assoc()) {
              $construct_Info = DataTable::constructNewTable($row["ID_MESA"], $row["NO_MESA"]);
              $list_Array[]= $construct_Info;
          }
            return $list_Array;
          } else {
            return false; //json_encode (array('error'=>"Sin mesas"));
        }
        $databaseConected->desconectar();
    }

    public function CreateTable($tableData){
      $databaseConected = new ConectDB();
      $databaseConected->conectar();
      $query = "INSERT INTO `mesas` (`NO_MESA`, `NO_PERSONAS_MIN`, `NO_PERSONAS_MAX`) 
      VALUES ('" . $tableData->no_table . "', '" . $tableData->min_person . "', '" . $tableData->max_person . "')";
      $resultQuery = $databaseConected->consulta($query);
      $databaseConected->desconectar();
      if($resultQuery){
        return json_encode(TRUE);
      }
      else{
      return json_encode(array('error'=>FALSE));
      }
    }

    public function ListTable()
    {
      $databaseConected = new ConectDB();
      $databaseConected->conectar();
      $table = array();
  
      $query = "SELECT `ID_MESA`, `NO_MESA`, `NO_PERSONAS_MIN`, `NO_PERSONAS_MAX` FROM `mesas` 
      ORDER BY NO_MESA ASC ";
  
      $tableInfo = $databaseConected->consulta($query);
      if ($tableInfo->num_rows > 0) {
        while ($row = $tableInfo->fetch_assoc()) {
        $tableRow = DataTable::constructNewTableJson($row["ID_MESA"], $row["NO_MESA"], $row["NO_PERSONAS_MIN"], $row["NO_PERSONAS_MAX"]);
        $table[] = $tableRow;
        }
      }
      $databaseConected->desconectar();
  
      return $table;
    }

    public function DeleteTable($idTable){
      $databaseConected = new ConectDB();
      $databaseConected->conectar();
      $query = "DELETE FROM `mesas` WHERE `id_mesa`= '" . $idTable . "'";
      $resultQuery = $databaseConected->consulta($query);
      $databaseConected->desconectar();
      if ($resultQuery){
        return json_encode(TRUE);
      }
      else{
        return json_encode(array('error'=>FALSE));
      }
    }

}
?>