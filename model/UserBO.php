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
    $query = "SELECT usuarios.USUARIO, usuarios.ROL FROM `usuarios` WHERE usuarios.CORREO = '" . $loginData->email . "' AND usuarios.CONTRASEÑA= '" . $loginData->password . "'";
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

  public function DeleteUser($id_user)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "DELETE FROM `usuarios` WHERE `id_usuario`='" . $id_user . "'";
    $resultUser = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultUser) {
      return json_encode(TRUE);
    } else {
      return json_encode(array('error' => FALSE));
    }
  }

  public function UpdateUser($userData)
  { }

  public function CreateUser($userData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "INSERT INTO `usuarios` (`USUARIO`, `CONTRASEÑA`, `ROL`, `CORREO`) VALUES ('" . $userData->user . "', '" . $userData->password . "'', '" . $userData->role . "', '" . $userData->email . "'); ";
    $resultUser = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultUser) {
      return json_encode(TRUE);
    } else {
      return json_encode(array('error' => FALSE));
    }
  }

  public function ListUser(){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $users = array();
    
    $query = "SELECT ID_USUARIO, USUARIO, CONTRASEÑA, ROL FROM `usuarios` ";

    $userInfo = $databaseConected->consulta($query);
    if ($userInfo->num_rows > 0) {
		  while($row = $userInfo->fetch_assoc()) {
            $user = User::constructUserList($row["ID_USUARIO"], $row["USUARIO"], $row["CONTRASEÑA"], $row["ROL"]);
			      $users[]= $user;
			}
		}
    $databaseConected->desconectar();

    return $users;
  }
}
