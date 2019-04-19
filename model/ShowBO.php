<?php
include_once 'ConectDB.php';
include_once 'Show.php';

class ShowBO
{
  //Attributes


  //Constructor
  public function __construct()
  { }

  //Methods
  public function CreateShow($showData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
 
    $query = "INSERT INTO `ESPECTACULOS` (`ID_ESPECTACULO`,  `ARTISTA`, `COVER`, `IMAGEN_MOVIL`, `IMAGEN_LAP`) VALUES (NULL, '" . $showData->artist . "', '" . $showData->amount . "', '" . $showData->url_img_desktop . "', '" . $showData->url_img_mobile . "');";
    $is_success = $databaseConected->consulta($query);
    
    if($is_success){
      $idShow = $databaseConected->getMYSQLI()->insert_id;
      for ($i = 0; $i < sizeof($showData->genres); $i++) {
          $query = "INSERT INTO `espectaculo-genero` (`id_espectaculo`, `id_genero`) VALUES (".$idShow.", ".$showData->genres[$i].");";
          $databaseConected->consulta($query);
      }
    
      foreach ($showData->datesTime as $dateTime) {
          $query = "INSERT INTO `FECHA_HR_ESPECTACULO` (`ID_FECHA_HR`, `ID_ESPECTACULO`, `FECHA`, `HORA`) VALUES (NULL, ".$idShow.", '".$dateTime->date."', '".date("Y-m-d H:i:s", strtotime($dateTime->time))."');";
          $databaseConected->consulta($query);
      }
        $databaseConected->desconectar();
    }
  }
  public function saveImages($files){
    $is_success = false;
    $imagesDir =  '../images/slider/';
    $name= $files['img-desktop']['name'];
    $tmp_name = $files['img-desktop']['tmp_name'];
    $is_success = move_uploaded_file($tmp_name, $imagesDir.$name);

    $imagesDir =  '../images/slider/mobile/';
    $name= $files['img-mobile']['name'];
    $tmp_name = $files['img-mobile']['tmp_name'];
    $is_success = move_uploaded_file($tmp_name, $imagesDir.$name);

    return $is_success;
  }
  public function DeleteShow($idShow)
  { }
  public function UpdateShow($showData)
  { }

  public function ListOneShow()
  { }

  public function ListShows()
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $shows = array();

    $query = "SELECT espectaculos.ID_ESPECTACULO, fecha_hr_espectaculo.ID_FECHA_HR, espectaculos.ARTISTA,  fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA 
    FROM `espectaculos` 
    INNER JOIN `fecha_hr_espectaculo` ON espectaculos.ID_ESPECTACULO= fecha_hr_espectaculo.ID_ESPECTACULO
    ORDER BY fecha_hr_espectaculo.FECHA DESC
    ";

    $showsInfo = $databaseConected->consulta($query);
    if ($showsInfo->num_rows > 0) {
      while ($row = $showsInfo->fetch_assoc()) {
        $show = Show::constructShowList($row["ID_ESPECTACULO"], $row["ID_FECHA_HR"], $row["ARTISTA"], $row["FECHA"], $row["HORA"]);
        $shows[] = $show;
      }
    }
    $databaseConected->desconectar();

    return $shows;
  }
  public function ListShowsSlider()
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $shows = array();

    $query = "SELECT espectaculos.ID_ESPECTACULO, fecha_hr_espectaculo.ID_FECHA_HR, espectaculos.ARTISTA,espectaculos.IMAGEN_MOVIL,espectaculos.IMAGEN_LAP,espectaculos.COVER,  fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA 
    FROM `espectaculos` 
    INNER JOIN `fecha_hr_espectaculo` ON espectaculos.ID_ESPECTACULO= fecha_hr_espectaculo.ID_ESPECTACULO  
    ORDER BY `fecha_hr_espectaculo`.`FECHA` ASC;";

    $showsInfo = $databaseConected->consulta($query);
    if ($showsInfo->num_rows > 0) {
      while ($row = $showsInfo->fetch_assoc()) {
        $genres = array();
        $show = new Show();
        $show->id_show = $row['ID_ESPECTACULO'];
        $show->artist = $row['ARTISTA'];
        $show->amount = $row['COVER'];
        $show->date = $row['FECHA'];
        $show->time = $row['HORA'];
        $show->url_img_mobile = $row['IMAGEN_MOVIL'];
        $show->url_img_desktop = $row['IMAGEN_LAP'];

        $query ="SELECT generos.GENERO
        FROM `espectaculo-genero` 
        INNER JOIN generos ON `espectaculo-genero`.`id_genero` = generos.ID_GENERO
        WHERE `espectaculo-genero`.`id_espectaculo`= ".$show->id_show.";";
        $genresInfo = $databaseConected->consulta($query);
        while ($genre = $genresInfo->fetch_assoc()) {
          $genres[] = $genre['GENERO'];
        }
        $show->genres = $genres;
        $shows[] = $show;
      }
    }
    $databaseConected->desconectar();

    return $shows;
  }

  public function ListShedules($id_show){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $schedules = array();
    $query = "SELECT ID_FECHA_HR ,FECHA, HORA FROM `fecha_hr_espectaculo` 
    WHERE ID_ESPECTACULO = ".$id_show." ORDER BY FECHA ASC";
    
    $scheduleInfo = $databaseConected->consulta($query);
     if ( $scheduleInfo->num_rows > 0) {
      while ($row =  $scheduleInfo->fetch_assoc()) {
        $show = new Show();
        $show->date = $row['FECHA'];
        $show->time = $row['HORA'];
        $show->id_date_hr = $row['ID_FECHA_HR'];
        $schedules[] = $show;
      }
    }
    $databaseConected->desconectar();

    return $schedules;
  }
}
