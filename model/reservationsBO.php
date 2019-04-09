<?php
include_once 'ConectaBD.php';
include_once 'reservations.php';


class reservationsBO
{
    //Atributos
  private $post;

  //Constructor
  public function __construct($post)
  {
    $this->post = $post;
  }

  public function Reservation($reservationDData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "SELECT ";
    $query .= "reservaciones.ID_RESERVACION, espectaculos.ID_ESPECTACULO, mesas.ID_MESA, fecha_hr_espectaculo.ID_FECHA_HR";
    $query .= ", reservaciones.NOMBRE_COMPLETO, reservaciones.CORREO, reservaciones.CELULAR, reservaciones.DEPOSITO_REALIZADO, reservaciones.NO_PERSONAS";
    $query .= ", espectaculos.ARTISTA, espectaculos.COVER, fecha_hr_espectaculo.FECHA, fecha_hr_espectaculo.HORA";
    $query .= ", mesas.NO_MESA";
    $query .= "FROM `reservaciones`";
    $query .= "INNER JOIN `espectaculos` ON reservaciones.ID_ESPECTACULO= espectaculos.ID_ESPECTACULO";
    $query .= "INNER JOIN `fecha_hr_espectaculo` ON reservaciones.ID_FECHA_HR = fecha_hr_espectaculo.ID_FECHA_HR";
    $query .= "INNER JOIN `mesas` ON reservaciones.ID_MESA = mesas.ID_MESA";
    $Reservation = $databaseConected->consulta($query);
   
    if ($Reservation->num_rows > 0) {
        $info = $Reservation->fetch_fields();
        $row = mysqli_fetch_array($info, MYSQLI_ASSOC);
        $databaseConected->desconectar();
        return $info;
      } else {
        $databaseConected->desconectar();
      return json_encode (array('error'=>'No hay datos a mostrar'));
    }
   
  }

  public function DeleteReservation($idReservation)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "DELETE FROM `reservaciones` WHERE `id_reservacion`=".$idReservation."";
    $databaseConected->consulta($query);

    if ($databaseConected->query($query) == FALSE) {
        $databaseConected->desconectar();
        return "Genero Eliminado";
    }
    else{
        $databaseConected->desconectar();
        return "Error: " . mysqli_error($databaseConected);
    }
    
}

  public function UpdateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="UPDATE `reservaciones` SET ,`ID_ESPECTACULO`=".$ReservationData->id_show.", `ID_MESA`=".$ReservationData->id_mesa.", `ID_FECHA_HR`=".$ReservationData->id_date_hr.", ";
    $query .="`NOMBRE_COMPLETO`='".$ReservationData->full_name."', `CORREO`='".$ReservationData->email."', `CELULAR`=".$ReservationData->cell_phone.", `DEPOSITO_REALIZADO`=".$ReservationData->deposit_made.", `NO_PERSONAS`=".$ReservationData->no_people." ";
    $query .="WHERE `ID_RESERVACION`=".$ReservationData->id_reservation." ";
    $ReservationInfo = $databaseConected->consulta($query);
    
    if ($databaseConected->query($query) === TRUE) {
        $databaseConected->desconectar();
        return true; //"Reservación actualizada";
    }
    else{
        $databaseConected->desconectar();
        return "Error: " . mysqli_error($databaseConected);
   }
 
}

  public function CreateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="INSERT INTO `RESERVACIONES` (`ID_ESPECTACULO`, `ID_FECHA_HR`, ";
    $query .="`ID_MESA`, `NOMBRE_COMPLETO`, `CORREO`, `CELULAR`, `DEPOSITO_REALIZADO`) VALUES ";
    $query .="(".$ReservationData->id_show.", ".$ReservationData->id_date_hr.", ".$ReservationData->id_mesa.", '".$ReservationData->full_name."', '".$ReservationData->email."', ".$ReservationData->cell_phone.", '0')";
    $ReservationInfo = $databaseConected->consulta($query);
    if ($ReservationInfo->num_rows > 0) {
      
        $databaseConected->desconectar();
        return json_encode (array('error'=>'Rerervación registrada'));
      } else {
        $databaseConected->desconectar();
      return json_encode (array('error'=>'Error al registrar la reservación'));
    }
    }
}
?>