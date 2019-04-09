<?php
include_once 'ConectaBD.php';
include_once 'Generous.php';

class reservationsBO
{
     //Atributos
  private $post;

  //Constructor
  public function __construct($post)
  {
    $this->post = $post;
  }

  public function Generous($generousDData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "SELECT GENEROS.ID_GENERO, GENEROS.GENERO FROM `generos` ORDER BY GENERO ASC;";
    $GenerousInfo = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($GenerousInfo->num_rows > 0) {
        $info = $$Genero->fetch_fields();
        return  $info;
      } else {
      return json_encode (array('error'=>'No hay datos a mostrar'));
    }
  }

  public function DeleteReservation($idGenerous)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "DELETE FROM `generos` WHERE `id_genero`=".$generousDData->gender." ";
    $databaseConected->consulta($query);
    if ($databaseConected->query($query) == FALSE) {
        $databaseConected->desconectar();
        return "Genero Eliminado";
    }
    else{
        $databaseConected->desconectar();
        return "Error: " . mysqli_error($databaseConected);
    }
  }

  public function UpdateReservation($idGenerous)  {}

  public function CreateReservation($generousDData)
  {
    $databaseConected->conectar();
    $query = "INSERT INTO `GENEROS` (`GENERO`) VALUES ('".$generousDData->gender."');";
    $GenerousInfo = $databaseConected->consulta($query);
   
    if ($ReservationInfo->num_rows > 0) {
        $databaseConected->desconectar();
        return json_encode (array('error'=>'Rerervación registrada'));
      } else {
        $databaseConected->desconectar();
      return json_encode (array('error'=>'Error al registrar la reservación'));
    }
  }
}
?>