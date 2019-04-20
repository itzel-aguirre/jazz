<?php
class Genre implements JsonSerializable
{
//Attributes
protected $id_genre;
protected $genre;

 //Constructor
 public function __construct()
 {

 }

 public static function constructPost($dataGenreInfo){
   $instance = new self();
   $instance->id_genre = $dataGenreInfo->id_genre;
   $instance->genre = $dataGenreInfo->genre;
   return $instance;
   }

 public static function constructNewGenre($id_genre, $genre){
   $instance = new self();
   $instance->id_genre = $id_genre;
   $instance->genre = $genre;
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
      'id_genre' => $this->id_genre,
      'genre' => $this->genre,
    ];
  }
}
?>