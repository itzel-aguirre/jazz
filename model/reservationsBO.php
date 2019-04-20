<?php
include_once 'ConectDB.php';
include_once 'Reservations.php';
include '../lib/PHPExcel.php';
include '../lib/PHPExcel/Writer/Excel2007.php';

class ReservationsBO
{
 
  public function __construct()
  {

  }
  public function selectReservation()
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $reservation_list = array();

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
    $resultQuery = $databaseConected->consulta($query);
    

    if ($resultQuery->num_rows > 0) {

      while($row = $resultQuery->fetch_assoc()) {
        $constructReservation = Reservations::constructNewReservation($row["ID_RESERVACION"],$row["ID_ESPECTACULO"], $row["ID_MESA"], $row["ID_FECHA_HR"], $row["NOMBRE_COMPLETO"], $row["CORREO"], $row["CELULAR"], $row["DEPOSITO_REALIZADO"], $row["NO_PERSONAS"], $row["ARTISTA"], $row["COVER"], $row["FECHA"], $row["HORA"], $row["NO_MESA"]);
        $reservation_list[]= $constructReservation;
      }
        /* $databaseConected->desconectar(); */
        return $reservation_list;
      } else {
        return json_encode (array('error'=>"Sin reservaciones"));
    }
    $databaseConected->desconectar();
  }

  public function DeleteReservation($idReservation)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "DELETE FROM `reservaciones` WHERE reservaciones.ID_RESERVACION=".$idReservation->id_reservation.";";
    $resultQuery =$databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      return json_encode(TRUE);  
    }
    else{
      return json_encode (array('error'=>FALSE));
    }
    
  }

  public function UpdateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="UPDATE `reservaciones` SET `ID_ESPECTACULO`=".$ReservationData->id_show.", `ID_MESA`=".$ReservationData->id_table.", `ID_FECHA_HR`=".$ReservationData->id_date_hr.", ";
    $query .="`NOMBRE_COMPLETO`='".$ReservationData->full_name."', `CORREO`='".$ReservationData->mail."', `CELULAR`=".$ReservationData->cell_phone.", `DEPOSITO_REALIZADO`=".$ReservationData->deposit_made.", `NO_PERSONAS`=".$ReservationData->no_people." ";
    $query .="WHERE `ID_RESERVACION`=".$ReservationData->id_reservation.";";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      return json_encode(TRUE);  
    }
    else{
      return json_encode (array('error'=>FALSE));
    }
  }

  public function CreateReservation($ReservationData)
  {  $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query ="INSERT INTO `RESERVACIONES` "; 
    $query .="(`ID_ESPECTACULO`, `ID_MESA`, `ID_FECHA_HR`, `NOMBRE_COMPLETO`, `CORREO`, `CELULAR`, `DEPOSITO_REALIZADO`, `NO_PERSONAS`) VALUES ";
    $query .="(".$ReservationData->show.", ".$ReservationData->table.", ".$ReservationData->dateTime.", '".$ReservationData->name."', '".$ReservationData->email."', ".$ReservationData->mobile.", '0', ".$ReservationData->clients.")";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      //Obtenemos el ID del registro
      //$IdReservation = $databaseConected->insert_id;
        return json_encode(TRUE);  
    }
    else{
        return json_encode (array('error'=>FALSE));
    }
  }

  public function generateExcel()
  {
    //excel
  $objPHPExcel = new PHPExcel();
  $reservationLogic = new ReservationsBO();
  $usrResponse = $reservationLogic->generateExcel();
                        
  $objPHPExcel->getProperties()->setCreator("Parker & Lenox");
  $objPHPExcel->getProperties()->setTitle("Listado de reservaciones");
  $objPHPExcel->setActiveSheetIndex(0); 
  $j =2;
  
  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7A2810');
  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray(array('font' => array('size' => 9,'bold' => true,'color' => array('rgb' => 'FFFFFF'))));

//ENCABEZADO 
  $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
  $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CORREO');
  $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'CELULAR');
  $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'DEPOSITO REALZADO');
  $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NO. PERSONAS');
  $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ARTISTA');
  $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'COVER');
  $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'FECHA');
  $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'HORA');
  $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'NO. MESA');

  //DATOS

  foreach($usrResponse as $obj){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $obj->full_name);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $obj->mail);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$j, $obj->cell_phone);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$j, $obj->deposit_made);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$j, $obj->no_people);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$j, $obj->artist);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$j, $obj->cover);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$j, $obj->date);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$j, date( "H:i", strtotime($obj->hour)));
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$j, $obj->no_table);
    $j++;
  }
  //Asignar nombre
  $objPHPExcel->getActiveSheet()->setTitle('Reservaciones'); 
  //Mostrar primera hoja
  $objPHPExcel->setActiveSheetIndex(0);

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  unlink('../temp/Reservaciones.xlsx'); //Elimina el archivo
  $objWriter->save('../temp/Reservaciones.xlsx'); //Almacenar reporte en carpeta
  exit;
  }


}
?>