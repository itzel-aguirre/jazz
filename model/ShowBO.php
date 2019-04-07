<?php
include_once 'ConectaBD.php';
include_once 'Show.php';
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
    $DBConestarBd = new ConectDB;
    $DBConestarBd->conectar();
    $query = "SELECT usuarios.USUARIO, usuarios.ROL FROM `usuarios` WHERE usuarios.CORREO = '' AND usuarios.CONTRASEÑA= ''";
    $respuesta=$DBConestarBd->consulta($query);
    $DBConestarBd->desconectar();
    $row_cnt = $respuesta->num_rows;
    if($row_cnt>0)
    {
    $info = $resultrespuestaado->fetch_fields();
    $row = mysqli_fetch_array($info, MYSQLI_ASSOC);
 
    return  $row["USUARIO"].$row["ROL"];
    }
    else{
    return "No existe usuario"; 
    }

  }

  public function deleteShow($idShow){

  }
  public function updateShow($showData){
    
  }
}
?>