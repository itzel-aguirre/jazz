<?php
class UpdateUrl implements JsonSerializable
{

 //Attributes
 protected $url;
  //Constructor
  public function __construct()
  {

  }

  public static function constructPost($dataInfo){
    $instance = new self();
    $instance->url = $dataInfo->url;
    return $instance;
  }

  
 public static function constructNewUrl($url) {
  $instance = new self();
  $instance->url = $url;
  return $instance;
 }

  //Methods
  // Getter/Setter not defined so set as property of object
  public function __set($name,$value){
    if(method_exists($this, $name)){
      $this->$name($value);
    }
    else{  
      $this->$name = $value;
      }
  }

  // Getter/Setter not defined so return property if it exists
  public function __get($name){
      if(method_exists($this, $name)){
        return $this->$name();
      }
      elseif(property_exists($this,$name)){
        return $this->$name;
      }
      return null;
  }

  public function jsonSerialize()
  {
      return 
      [
        'url' => $this->url,
      ];
  }
}

?>