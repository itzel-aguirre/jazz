<?php

class User implements JsonSerializable
{
  //Attributes
  private $id_user;
  private $user;
  private $password;
  private $role;
  private $email;

  //Constructor
  public function __construct()
  { }
  public static function constructPost($dataUser)
  {
    $instance = new self();
    $instance->email = $dataUser->email;
    $instance->password = $dataUser->password;
    return $instance;
  }

  public static function constructUserJson($userData){
    $instance = new self();
    $instance->user = $userData->user;
    $instance->password = $userData->password;
    $instance->role = $userData->role;
    $instance->email = $userData->email;
    return $instance;
  }

  public static function constructUserList($id_user, $user, $password ,$role) {
    $instance = new self();
    $instance->id_user = $id_user;
    $instance->user = $user;
    $instance->password = $password;
    $instance->role = $role;
    //$instance->email = $email;
    return $instance;
  }

  //Methods
  // Getter/Setter not defined so set as property of object
  public function __set($name, $value)
  {
    if (method_exists($this, $name)) {
      $this->$name($value);
    } else {
      $this->$name = $value;
    }
  }
  // Getter/Setter not defined so return property if it exists
  public function __get($name)
  {
    if (method_exists($this, $name)) {
      return $this->$name();
    } elseif (property_exists($this, $name)) {
      return $this->$name;
    }
    return null;
  }
  public function jsonSerialize()
  {
    return
      [
        'id_user' => $this->id_user,
        'user' => $this->user,
        'password' => $this->password,
        'role' => $this->role,
      ];
  }
}
