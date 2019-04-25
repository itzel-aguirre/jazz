<?php
class Reservations implements JsonSerializable
{
 //Attributes
 protected $id_reservation;
 protected $id_show;
 protected $id_table;
 protected $id_date_hr;
 protected $full_name;
 protected $mail;
 protected $cell_phone;
 protected $deposit_made;
 protected $no_people;
 protected $artist;
 protected $cover;
 protected $date;
 protected $hour;
 protected $no_table;
 protected $folio;

  //Constructor
  public function __construct()
  {
    
  }
  public static function constructNewReservation($id_reservation, $id_show, $id_table, $id_date_hr, $full_name, $mail, $cell_phone, $deposit_made, $no_people, $artist, $cover, $date, $hour, $no_table) {
    $instance = new self();
    
    $instance->id_reservation = $id_reservation;
    $instance->id_show = $id_show;
    $instance->id_table =  $id_table;
    $instance->id_date_hr =  $id_date_hr;
    $instance->full_name= $full_name;
    $instance->mail =  $mail;
    $instance->cell_phone =  $cell_phone;
    $instance->deposit_made = $deposit_made;
    $instance->no_people = $no_people;
    $instance->artist = $artist;
    $instance->cover = $cover;
    $instance->date = $date;
    $instance->hour = $hour;
    $instance->no_table = $no_table;
   
    return $instance; 
  }
  public static function constructPost($reservation){
    $instance = new self();
    $instance->id_show = $reservation->show;
    $instance->id_table =  $reservation->table;
    $instance->id_date_hr =  $reservation->dateTime;
    $instance->full_name= $reservation->name;
    $instance->mail =  $reservation->email;
    $instance->cell_phone =  $reservation->mobile;
    $instance->no_people =$reservation->clients;
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
      
      'id_reservation' => $this->id_reservation,
      'id_show' => $this->id_show,
      'id_table' => $this->id_table,
      'id_date_hr' => $this->id_date_hr,
      'full_name' => $this->full_name,
      'mail' => $this->mail,
      'cell_phone' => $this->cell_phone,
      'deposit_made' => $this->deposit_made,
      'no_people' => $this->no_people,
      'artist' => $this->artist,
      'cover' => $this->cover,
      'date' => $this->date,
      'hour' => $this->hour,
      'no_table' => $this->no_table,
      'folio' => $this->folio,
    ];
  }
}
