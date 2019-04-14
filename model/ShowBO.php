<?php
include_once 'ConectDB.php';
include_once 'Show.php';

class ShowBO
{
  //Attributes


  //Constructor
  public function __construct()
  {

  }

  //Methods
  public function CreateShow($showData){
  
  }

  public function DeleteShow($idShow){

  }
  public function UpdateShow($showData){
    
  }

  public function ListOneShow(){

  }

  public function ListShows(){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $shows = array();
    
    $query = "SELECT espectaculos.ID_ESPECTACULO, fecha_hr_espectaculo.ID_FECHA_HR, espectaculos.ARTISTA,  fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA 
    FROM `espectaculos` 
    INNER JOIN `fecha_hr_espectaculo` ON espectaculos.ID_ESPECTACULO= fecha_hr_espectaculo.ID_ESPECTACULO
    ORDER BY fecha_hr_espectaculo.FECHA DESC
    ";

    $showsInfo = $databaseConected->consulta($query);
    if ($showsInfo->num_rows > 0) {
		  while($row = $showsInfo->fetch_assoc()) {
            $show = Show::constructShowList($row["ID_ESPECTACULO"],$row["ID_FECHA_HR"],$row["ARTISTA"],$row["FECHA"],$row["HORA"]);
			      $shows[]=$show;
			}
		}
    $databaseConected->desconectar();

    return $shows;
  }
}
?>