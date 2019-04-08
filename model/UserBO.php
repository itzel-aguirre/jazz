<?php
include_once 'ConectDB.php';
include_once 'User.php';

class UserBO
{
  //Atributtes

  //Methods
  public function Login($loginData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "SELECT usuarios.USUARIO, usuarios.ROL FROM `usuarios` WHERE usuarios.CORREO = '".$loginData->email."' AND usuarios.CONTRASEÑA= '".$loginData->password."'";
    $userInfo = $databaseConected->consulta($query);
    $databaseConected->desconectar();

    if ($userInfo->num_rows > 0) {
        $dataUserObj = new User();
        $row = $userInfo->fetch_assoc();
        $dataUserObj->type = $row["ROL"];
        $dataUserObj->name = $row["USUARIO"];
        return  $dataUserObj;
      } else {
      return false;
    }
  }

  public function DeleteUser($idUser)
  { }
  public function UpdateUser($userData)
  { }
  public function CreateUser($userData)
  { }
}

?>
