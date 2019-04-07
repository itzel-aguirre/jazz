<?php
include_once 'ConectaBD.php';
include_once 'User.php';
class UserBO
{
  //Atributos
  private $post;

  //Constructor
  public function __construct($post)
  {
    $this->post = $post;
  }

  //Methods
  public function Login($loginData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "SELECT usuarios.USUARIO, usuarios.ROL FROM `usuarios` WHERE usuarios.CORREO = '".$loginData->email."' AND usuarios.CONTRASEÑA= '".$loginData->password."'";
    $user = $databaseConected->consulta($query);
    $databaseConected->desconectar();

    if ($user->num_rows > 0) {
        $info = $$user->fetch_fields();
        $row = mysqli_fetch_array($info, MYSQLI_ASSOC);

        return  $row["USUARIO"] . $row["ROL"];
      } else {
      return json_encode (array('error'=>'No existe usuario'));
    }
  }

  public function DeleteUser($idUser)
  { }
  public function UpdateUser($userData)
  { }
  public function CreateUser($userData)
  { }
}
