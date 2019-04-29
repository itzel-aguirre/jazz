<?php
class DataTable implements JsonSerializable
{
 //Attributes
 protected $id_table;
 protected $no_table;
 protected $min_person;
 protected $max_person;
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

  public static function constructNewTableJson($id_table, $no_table, $min_person, $max_person) {
    $instance = new self();
    $instance->id_table = $id_table;
    $instance->no_table = $no_table;
    $instance->min_person = $min_person;
    $instance->max_person= $max_person;
    return $instance; 
  }

  public static function constructPost($tableData){
    $instance = new self();
    $instance->no_table = $tableData->noTable;
    $instance->min_person =  $tableData->minPerson;
    $instance->max_person =  $tableData->maxPerson;
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
      'id_table' => $this->id_table,
      'min_person' => $this->min_person,
      'max_person' => $this->max_person,
    ];
  }
}
?>