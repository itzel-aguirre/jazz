<?php
include_once 'ConectaBD.php';
include_once 'Show.php';
include_once 'Show_GenreBO.php';
class ShowBO
{
  //Atributos
  private $post;

  //Constructor
  public function __construct($post)
  {
    $this->post=$post;
  }

  //Methods
  public function createShow($showData){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
   $query = "INSERT INTO `ESPECTACULOS` (`ARTISTA`, `COVER`, `IMAGEN_MOVIL`, `IMAGEN_LAP`) ";
   $query .="VALUES ('".$showData->artist."', ".$showData->amount.", ";
   $query .="'".$showData->url_img_mobile."', '".$showData->url_img_desktop."');";
    $ShowInfo = $databaseConected->consulta($query);
    if ($databaseConected->query($query) === TRUE) {
      $databaseConected->desconectar();
      
      //Se obtiene el id del registro para insertar los generos
        $Id_Show = $databaseConected->insert_id;
        $function_generous=new Show_GenreBO();
        $function_generous->CreateShowGenre();

      return json_encode(TRUE);  
     }
    else{
      $databaseConected->desconectar();
      return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
    }
 
  }



  public function deleteShow($idShow){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "DELETE FROM `espectaculos` WHERE `id_espectaculo`=".$idShow."";
    $ShowInfo = $databaseConected->consulta($query);
    if ($databaseConected->query($query) == TRUE) {
      $databaseConected->desconectar();
      return  json_encode(TRUE); 
  }
  else{
      $databaseConected->desconectar();
      return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
  }
  }

  public function updateShow($showData){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "UPDATE `espectaculos` SET  `ARTISTA`='".$showData->artist."', `COVER`=".$showData->amount.", `IMAGEN_MOVIL`='".$showData->url_img_mobile."', `IMAGEN_LAP`='".$showData->url_img_desktop."' WHERE `ID_ESPECTACULO`= ".$showData->id_show."; ";
    $ShowInfo = $databaseConected->consulta($query);
    if ($databaseConected->query($query) === TRUE) {
        $databaseConected->desconectar();
        return json_encode(TRUE);  
    }
    else{
        $databaseConected->desconectar();
        return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
   }
  }

  }
?>