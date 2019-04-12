<?php
include_once 'ConectDB.php';
include_once 'reservations.php';

class reservationsBO
{
 
  public function Reservation($ReservationData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "SELECT ";
    $query .= "reservaciones.ID_RESERVACION, espectaculos.ID_ESPECTACULO, mesas.ID_MESA, fecha_hr_espectaculo.ID_FECHA_HR";
    $query .= ", reservaciones.NOMBRE_COMPLETO, reservaciones.CORREO, reservaciones.CELULAR, reservaciones.DEPOSITO_REALIZADO, reservaciones.NO_PERSONAS";
    $query .= ", espectaculos.ARTISTA, espectaculos.COVER, fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA";
    $query .= ", mesas.NO_MESA";
    $query .= " FROM `reservaciones` ";
    $query .= " INNER JOIN `espectaculos` ON `reservaciones`.`ID_ESPECTACULO` = `espectaculos`.`ID_ESPECTACULO`";
    $query .= " INNER JOIN `fecha_hr_espectaculo` ON reservaciones.ID_FECHA_HR = fecha_hr_espectaculo.ID_FECHA_HR";
    $query .= " INNER JOIN `mesas` ON reservaciones.ID_MESA = mesas.ID_MESA";
    //$query .= " WHERE reservaciones.ID_RESERVACION= '".$ReservationData->id_reservation."'";
    $Reservation = $databaseConected->consulta($query);
    $databaseConected->desconectar();

    if ($Reservation->num_rows > 0) {
        $dataUserObj = new reservations();
        $row = $Reservation->fetch_assoc(); 
        $dataUserObj->id_reservation = $row["ID_RESERVACION"];
        $dataUserObj->id_show = $row["ID_ESPECTACULO"];
        $dataUserObj->id_table = $row["ID_MESA"];
        $dataUserObj->id_date_hr = $row["ID_FECHA_HR"];
        $dataUserObj->full_name = $row["NOMBRE_COMPLETO"];
        $dataUserObj->mail = $row["CORREO"];
        $dataUserObj->cell_phone = $row["CELULAR"];
        $dataUserObj->deposit_made = $row["DEPOSITO_REALIZADO"];
        $dataUserObj->no_people = $row["NO_PERSONAS"];
        $dataUserObj->artist = $row["ARTISTA"];
        $dataUserObj->cover = $row["COVER"];
        $dataUserObj->date = $row["FECHA"];
        $dataUserObj->hour = $row["HORA"];
        $dataUserObj->no_table = $row["NO_MESA"];
        
        return $dataUserObj;
      } else {
        return json_encode (array('error'=>"No hay reservaciones"));
    }
   
  }

  public function DeleteReservation($idReservation)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "DELETE FROM `reservaciones` WHERE reservaciones.ID_RESERVACION=".$idReservation->id_reservation.";";
    $ReservationInfo =$databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($ReservationInfo) {
      return json_encode(TRUE);  
    }
    else{
      return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
    }
    
  }

  public function UpdateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="UPDATE `reservaciones` SET `ID_ESPECTACULO`=".$ReservationData->id_show.", `ID_MESA`=".$ReservationData->id_table.", `ID_FECHA_HR`=".$ReservationData->id_date_hr.", ";
    $query .="`NOMBRE_COMPLETO`='".$ReservationData->full_name."', `CORREO`='".$ReservationData->mail."', `CELULAR`=".$ReservationData->cell_phone.", `DEPOSITO_REALIZADO`=".$ReservationData->deposit_made.", `NO_PERSONAS`=".$ReservationData->no_people." ";
    $query .="WHERE `ID_RESERVACION`=".$ReservationData->id_reservation.";";
    $ReservationInfo = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($ReservationInfo) {
      return json_encode(TRUE);  
    }
    else{
      return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
    }
  }

  public function CreateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="INSERT INTO `RESERVACIONES` "; 
    $query .="(`ID_RESERVACION`, `ID_ESPECTACULO`, `ID_MESA`, `ID_FECHA_HR`, `NOMBRE_COMPLETO`, `CORREO`, `CELULAR`, `DEPOSITO_REALIZADO`, `NO_PERSONAS`) VALUES ";
    $query .="('', ".$ReservationData->id_show.", ".$ReservationData->id_table.", ".$ReservationData->id_date_hr.", '".$ReservationData->full_name."', '".$ReservationData->mail."', ".$ReservationData->cell_phone.", '0', ".$ReservationData->no_people.")";
    $ReservationInfo = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($ReservationInfo) {
        return json_encode(TRUE);  
    }
    else{
        return json_encode (array('error'=>"Error: " . mysqli_error($databaseConected)));
    }
  }
}
?>