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
        $query .= " WHERE ";
        $query .= " (mesas.NO_PERSONAS_MIN>= '".$listData->no_people."' AND '".$listData->no_people."' <= mesas.NO_PERSONAS_MAX) ";
        $query .= " OR (mesas.NO_PERSONAS_MIN >= '".$listData->no_people."' OR '".$listData->no_people."' <= mesas.NO_PERSONAS_MAX) ";
        $query .= " )  MESAS WHERE ID_MESA NOT IN (SELECT ID_MESA FROM reservaciones WHERE reservaciones.ID_FECHA_HR = '".$listData->fecha_Hr."') ";

        $resultQuery = $databaseConected->consulta($query);

        if ($resultQuery->num_rows > 0) {
    
          while($row = $resultQuery->fetch_assoc()) {
              $construct_Info = DataTable::constructNewTable($row["ID_MESA"], $row["NO_MESA"]);
              $list_Array[]= $construct_Info;
          }
            return $list_Array;
          } else {
            return json_encode (array('error'=>"Sin mesas"));
        }
        $databaseConected->desconectar();
    }

}
?>