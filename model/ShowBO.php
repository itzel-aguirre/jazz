<?php
include_once 'ConectDB.php';
include_once 'Show.php';
include_once 'Genre.php';
include_once 'GenreBO.php';
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

    if ($is_success) {
      $idShow = $databaseConected->getMYSQLI()->insert_id;
      for ($i = 0; $i < sizeof($showData->genres); $i++) {
        $query = "INSERT INTO `espectaculo-genero` (`id_espectaculo`, `id_genero`) VALUES (" . $idShow . ", " . $showData->genres[$i] . ");";
        $databaseConected->consulta($query);
      }

      foreach ($showData->datesTime as $dateTime) {
        $query = "INSERT INTO `FECHA_HR_ESPECTACULO` (`ID_FECHA_HR`, `ID_ESPECTACULO`, `FECHA`, `HORA`) VALUES (NULL, " . $idShow . ", '" . $dateTime->date . "', '" . date("Y-m-d H:i:s", strtotime($dateTime->time)) . "');";
        $databaseConected->consulta($query);
      }
      $databaseConected->desconectar();
    }
  }
  public function saveImages($files)
  {
    if ($files['img-desktop'])
    {
     $is_success = false;
     $imagesDir =  '../images/slider/';
     $name = $files['img-desktop']['name'];
     $tmp_name = $files['img-desktop']['tmp_name'];
     $is_success = move_uploaded_file($tmp_name, $imagesDir . $name);
    }
    
    if ($files['img-mobile'])
    {
      $imagesDir =  '../images/slider/mobile/';
      $name = $files['img-mobile']['name'];
      $tmp_name = $files['img-mobile']['tmp_name'];
      $is_success = move_uploaded_file($tmp_name, $imagesDir . $name);
    }
    
    return $is_success;
  }
  public function DeleteShow($idShow)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "SELECT IMAGEN_MOVIL, IMAGEN_LAP FROM `espectaculos` WHERE ID_ESPECTACULO= " . $idShow . ";";
    $ResultQuery = $databaseConected->consulta($query);

    if ($ResultQuery->num_rows > 0) {
      while ($row =  $ResultQuery->fetch_assoc()) {

        try {
          $imagesDir =  '../images/slider/';
          $imagesDirMobile =  '../images/slider/mobile/';
          unlink($imagesDir . $row['IMAGEN_LAP']);
          unlink($imagesDirMobile . $row['IMAGEN_MOVIL']);
        } catch (Exception $e) {
          return json_encode(array('error' => FALSE));
        }
      }
    }


    $query = "DELETE FROM `reservaciones` WHERE ID_ESPECTACULO = " . $idShow . ";";
    $databaseConected->consulta($query);

    $query = " DELETE FROM `espectaculo-genero` where ID_ESPECTACULO =  " . $idShow . ";";
    $databaseConected->consulta($query);

    $query = " DELETE FROM `fecha_hr_espectaculo` WHERE ID_ESPECTACULO=  " . $idShow . "; ";
    $databaseConected->consulta($query);

    $query = "DELETE FROM `espectaculos` WHERE `id_espectaculo`=  " . $idShow . "; ";
    $ShowInfo = $databaseConected->consulta($query);

    $databaseConected->desconectar();
    if ($ShowInfo) {
      return json_encode(TRUE);
    } else {
      return json_encode(array('error' => FALSE));
    }
  }

  public function UpdateShow($showData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "UPDATE `espectaculos` SET  ";
    $query .= "`ARTISTA`='" . $showData->artist . "'";
    $query .= ", `COVER`=" . $showData->amount . " ";
    if ($showData->url_img_mobile != "")
    {
      $query .= " , `IMAGEN_MOVIL`='" . $showData->url_img_mobile . "' ";
    }
    if ($showData->url_img_desktop)
    {
      $query .= " , `IMAGEN_LAP`='" . $showData->url_img_desktop . "'  ";
    }
    
    $query .= " WHERE `ID_ESPECTACULO`= " . $showData->id_show . "; "; 
    $ShowInfo = $databaseConected->consulta($query);

    if ($ShowInfo){
      $query = " DELETE FROM `espectaculo-genero` where ID_ESPECTACULO =  " . $showData->id_show . ";";
      $databaseConected->consulta($query);
      for ($i = 0; $i < sizeof($showData->genres); $i++) {
        $query = "INSERT INTO `espectaculo-genero` (`id_espectaculo`, `id_genero`) 
        VALUES (" . $showData->id_show . ", " . $showData->genres[$i] . ");";
        $databaseConected->consulta($query);
      }


      foreach ($showData->datesTime as $dateTime) {
        if ($showData->id_show != 0){
          $query = "UPDATE `fecha_hr_espectaculo` SET 
          `ID_ESPECTACULO`=" . $showData->id_show . ", 
          `FECHA`='" . $dateTime->date . "', 
          `HORA`='" . date("Y-m-d H:i:s", strtotime($dateTime->time)) . "'
           WHERE `ID_FECHA_HR`= " . $showData->idDate . "";
          $databaseConected->consulta($query);
        }
      }

      foreach ($showData->currentDates as $currentDate) {
        $query = "INSERT INTO `FECHA_HR_ESPECTACULO` (`ID_FECHA_HR`, `ID_ESPECTACULO`, `FECHA`, `HORA`)
        VALUES (NULL, " . $currentDate->id_show . ", '" . $currentDate->date . "', '" . date("Y-m-d H:i:s", strtotime($currentDate->time)) . "');";
      $databaseConected->consulta($query);
      }

      $databaseConected->desconectar();
    }
  }

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
    GROUP BY ID_ESPECTACULO
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

    $query = "SELECT espectaculos.ID_ESPECTACULO, fecha_hr_espectaculo.ID_FECHA_HR, espectaculos.ARTISTA,espectaculos.IMAGEN_MOVIL,";
    $query .= " espectaculos.IMAGEN_LAP,espectaculos.COVER,  fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA ";
    $query .= " , CASE WHEN (SELECT  COUNT(DISTINCT ID_MESA) a FROM `reservaciones` WHERE ID_ESPECTACULO =espectaculos.ID_ESPECTACULO AND ";
    $query .= " ID_FECHA_HR=fecha_hr_espectaculo.ID_FECHA_HR) = (SELECT COUNT(ID_MESA) from `mesas`)";
    $query .= " THEN 1 ELSE 0 END AS souldOut ";
    $query .= " FROM `espectaculos` ";
    $query .= " INNER JOIN `fecha_hr_espectaculo` ON espectaculos.ID_ESPECTACULO= fecha_hr_espectaculo.ID_ESPECTACULO  ";
   /*  if ($id_show != 0) {
      $query .= " WHERE  espectaculos.ID_ESPECTACULO= " . $id_show . " ";
     } */
    $query .= " ORDER BY `fecha_hr_espectaculo`.`FECHA` ASC;";

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
        $show->sold_out = $row['souldOut'];

        $query = "SELECT generos.ID_GENERO, generos.GENERO
        FROM `espectaculo-genero` 
        INNER JOIN generos ON `espectaculo-genero`.`id_genero` = generos.ID_GENERO
        WHERE `espectaculo-genero`.`id_espectaculo`= " . $show->id_show . ";";
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

  public function ListShedules($id_show)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $schedules = array();
    $query = "SELECT ID_FECHA_HR ,FECHA, HORA FROM `fecha_hr_espectaculo` 
    WHERE ID_ESPECTACULO = " . $id_show . " ORDER BY FECHA ASC";

    $scheduleInfo = $databaseConected->consulta($query);
    if ($scheduleInfo->num_rows > 0) {
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

  public function GetListShowsUpdate($id_show)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $show = new Show();

    $query = "SELECT espectaculos.ID_ESPECTACULO,  espectaculos.ARTISTA,espectaculos.IMAGEN_MOVIL,";
    $query .= " espectaculos.IMAGEN_LAP, espectaculos.COVER ";
    $query .= " FROM `espectaculos` ";
    $query .= " INNER JOIN `fecha_hr_espectaculo` ON espectaculos.ID_ESPECTACULO= fecha_hr_espectaculo.ID_ESPECTACULO  ";
    $query .= " WHERE  espectaculos.ID_ESPECTACULO= " . $id_show . " ";
    $query .= " ORDER BY `fecha_hr_espectaculo`.`FECHA` ASC;";

    $showsInfo = $databaseConected->consulta($query);
    if ($showsInfo->num_rows > 0) {
      while ($row = $showsInfo->fetch_assoc()) {
        $genres = array();
        $datesTime_Info = array();
        $show->id_show = $row['ID_ESPECTACULO'];
        $show->artist = $row['ARTISTA'];
        $show->amount = $row['COVER'];
        $show->url_img_mobile = $row['IMAGEN_MOVIL'];
        $show->url_img_desktop = $row['IMAGEN_LAP'];

        $query = "SELECT generos.ID_GENERO, generos.GENERO
        FROM `espectaculo-genero` 
        INNER JOIN generos ON `espectaculo-genero`.`id_genero` = generos.ID_GENERO
        WHERE `espectaculo-genero`.`id_espectaculo`= " . $show->id_show . ";";
        $genresInfo = $databaseConected->consulta($query);
        while ($genre = $genresInfo->fetch_assoc()) {
          $constructGenre = Genre::constructNewGenre($genre["ID_GENERO"], $genre["GENERO"]);
          $genres[] =$constructGenre; 
        }
        $show->genres = $genres;

        $query = "SELECT 
        ID_FECHA_HR, FECHA, HORA
        FROM `fecha_hr_espectaculo` WHERE ID_ESPECTACULO= " . $show->id_show . "";
        $date_timeInfo= $databaseConected->consulta($query);
        while ($info = $date_timeInfo->fetch_assoc()){
          $constructInfoDateTime = Show::constructDateTimeList($info["ID_FECHA_HR"], $info["FECHA"], $info["HORA"]);
          $datesTime_Info[] = $constructInfoDateTime; 
        }
        $show->datesTime= $datesTime_Info;

      }
    }
    $databaseConected->desconectar();

    return $show;
  }   

  public function delete_reservationDatesTime($Data)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "DELETE FROM `reservaciones` WHERE ID_ESPECTACULO = " . $Data->idShow . " AND ID_FECHA_HR = " . $Data->id_date_hr . " ;";
    $databaseConected->consulta($query);

    $query = " DELETE FROM `fecha_hr_espectaculo` WHERE ID_FECHA_HR=  " . $Data->id_date_hr . "; ";
    $ShowInfo = $databaseConected->consulta($query);

    $databaseConected->desconectar();
    if ($ShowInfo) {
      return json_encode(TRUE);
    } else {
      return json_encode(array('error' => FALSE));
    }
  }
}
