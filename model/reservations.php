<?php
class reservationsBO
{
 //Attributes
  private $id_reservation;
  private $id_show;
  private $id_mesa;
  private $id_date_hr;
  private $full_name;
  private $mail;
  private $cell_phone;
  private $deposit_made;
  private $no_people;

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