<?php

class Show implements JsonSerializable{
  //Attributes
  protected $id_show;
  protected $id_genre;
  protected $id_date_hr;
  protected $artist;
  protected $amount;
  protected $date;
  protected $time;
  protected $url_img_mobile;
  protected $url_img_desktop;
  protected $genres;
  protected $datesTime;
  protected $sold_out;
  //Constructor
  public function __construct()
  {

  }
  public static function constructShowList( $id_show, $id_datetime, $artist,$date,$time ) {
    $instance = new self();
    $instance->id_show = $id_show;
    $instance->id_date_hr = $id_datetime;
    $instance->artist = $artist;
    $instance->date = $date;
    $instance->time = $time;
    return $instance;
  }

  public static function constructShowJson($showData){
    $instance = new self();
    $instance->artist = $showData->artist;
    $instance->amount = $showData->amount;
    $instance->genres = $showData->genres;
    $instance->datesTime = $showData->datesTime;
    $instance->url_img_mobile = $showData->imgMobile;
    $instance->url_img_desktop = $showData->imgDesktop;
    return $instance;
  }

  public static function constructDateTimeList($id_show, $fecha, $hora){
    $instance = new self();
    $instance->id_show = $id_show;
    $instance->date = $fecha;
    $instance->time = $hora;
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
        'artist' => $this->artist,
        'date' => $this->date,
        'time' => $this->time,
        'amount' => $this->amount,
        'id_show' => $this->id_show,
        'id_genre' => $this->id_genre,
        'id_date_hr'=> $this->id_date_hr,
        'url_img_mobile' => $this->url_img_mobile,
        'url_img_desktop' => $this->url_img_desktop,
        'genres' => $this->genres,
        'sold_out' => $this->sold_out,
        'datesTime' => $this->datesTime,
      ];
  }
}
?>