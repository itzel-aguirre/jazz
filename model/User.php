<?php

class User implements JsonSerializable
{
  //Attributes
  private $id_user;
  private $name;
  private $password;
  private $type;
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
        'name' => $this->name,
        'type' => $this->type,
      ];
  }
}
