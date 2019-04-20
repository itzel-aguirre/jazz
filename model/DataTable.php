<?php
class DataTable implements JsonSerializable
{
 //Attributes
 protected $id_table;
 protected $no_table;
 //Constructor
 public function __construct()
 {
     
 }

 public static function constructNewTable($id_table, $no_table) {
    $instance = new self();
    $instance->id_table = $id_table;
    $instance->no_table = $no_table;
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

  public function jsonSerialize(){
    return
    [
      'no_table' => $this->no_table,
      'no_people_min' => $this->no_people_min,
      'no_people_max' => $this->no_people_max,
    ];
  }
}
?>