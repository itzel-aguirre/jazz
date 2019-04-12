<?php
class reservations
{
 //Attributes
  private $id_reservation;
  private $id_show;
  private $id_table;
  private $id_date_hr;
  private $full_name;
  private $mail;
  private $cell_phone;
  private $deposit_made;
  private $no_people;
  private $artist;
  private $cover;
  private $date;
  private $hour;
  private $no_table;

  //Constructor
  public function __construct()
  {
    
  }
  public static function constructPost( $dataReservation) {
    $instance = new self();
    $instance->id_reservation = $dataReservation->id_reservation;

    $instance->id_show = $dataReservation->id_show;
    $instance->id_table =  $dataReservation->id_table;
    $instance->id_date_hr =  $dataReservation->id_date_hr;
    $instance->full_name= $dataReservation->full_name;
    $instance->mail =  $dataReservation->mail;
    $instance->cell_phone =  $dataReservation->cell_phone;
    $instance->deposit_made = $dataReservation->deposit_made;
    $instance->no_people = $dataReservation->no_people;
   
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

}
?>