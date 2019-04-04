<?php

class Show{
  //Attributes
  private id_show;
  private id_genre;
  private id_date_hr;
  private artist;
  private amount;
  private url_img_mobile;
  private url_img_desktop;
  //Constructor
  public function __construct()
  {

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
}

?>