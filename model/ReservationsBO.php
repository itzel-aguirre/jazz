<?php
include_once 'ConectDB.php';
include_once 'Reservations.php';
include '../lib/PHPExcel.php';
include '../lib/PHPExcel/Writer/Excel2007.php';

class ReservationsBO
{

  public function __construct()
  { }
  public function GetReservations()
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

    $resultQuery = $databaseConected->consulta($query);

    if ($resultQuery->num_rows > 0) {

      while ($row = $resultQuery->fetch_assoc()) {
        $constructReservation = Reservations::constructNewReservation($row["ID_RESERVACION"], $row["ID_ESPECTACULO"], $row["ID_MESA"], $row["ID_FECHA_HR"], $row["NOMBRE_COMPLETO"], $row["CORREO"], $row["CELULAR"], $row["DEPOSITO_REALIZADO"], $row["NO_PERSONAS"], $row["ARTISTA"], $row["COVER"], $row["FECHA"], $row["HORA"], $row["NO_MESA"]);
        $reservation_list[] = $constructReservation;
      }
      /* $databaseConected->desconectar(); */
      return $reservation_list;
    } else {
      return json_encode(array('error' => "Sin reservaciones"));
    }
    $databaseConected->desconectar();
  }

  public function DeleteReservation($idReservation)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "DELETE FROM `reservaciones` WHERE reservaciones.ID_RESERVACION= ".$idReservation.";";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      return json_encode(TRUE);
    } else { 
      return json_encode(array('error' => FALSE));
    }
  }

  public function UpdateReservation($ReservationData)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "UPDATE `reservaciones` SET `ID_ESPECTACULO`=" . $ReservationData->id_show . ", `ID_MESA`=" . $ReservationData->id_table . ", `ID_FECHA_HR`=" . $ReservationData->id_date_hr . ", ";
    $query .= "`NOMBRE_COMPLETO`='" . $ReservationData->full_name . "', `CORREO`='" . $ReservationData->mail . "', `CELULAR`=" . $ReservationData->cell_phone . ", `DEPOSITO_REALIZADO`=" . $ReservationData->deposit_made . ", `NO_PERSONAS`=" . $ReservationData->no_people . " ";
    $query .= "WHERE `ID_RESERVACION`=" . $ReservationData->id_reservation . ";";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      return json_encode(TRUE);
    } else {
      return json_encode(array('error' => FALSE));
    }
  }

  public function CreateReservation($reservation)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $var_Folio = "";

    $query = "SELECT FECHA FROM `fecha_hr_espectaculo` WHERE ID_ESPECTACULO = " . $reservation->id_show . " AND ID_FECHA_HR = " . $reservation->id_date_hr . " ";
    $resultQueryFecha = $databaseConected->consulta($query);

    while ($row = $resultQueryFecha->fetch_assoc()) {
      $var_Folio = "PL" . str_replace("-", "", $row["FECHA"]) . $reservation->no_people;
    }

    $reservation->folio = $var_Folio;

    $query = "INSERT INTO `reservaciones` ";
    $query .= "(`ID_ESPECTACULO`, `ID_MESA`, `ID_FECHA_HR`, `NOMBRE_COMPLETO`, `CORREO`, `CELULAR`, `DEPOSITO_REALIZADO`, `NO_PERSONAS`, `FOLIO`) VALUES ";
    $query .= "(" . $reservation->id_show . ", " . $reservation->id_table . ", " . $reservation->id_date_hr . ", '" . $reservation->full_name . "', '" . $reservation->mail . "', " . $reservation->cell_phone . ", '0', " . $reservation->no_people . ", '" . $var_Folio . "')";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      $reservation = $this->getDataToEmail($reservation);
     // $this->sendEmail($reservation);
      return (true);
      
    } else {
      return json_encode(array('error' => FALSE));
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
    $j = 2;

    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7A2810');
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray(array('font' => array('size' => 9, 'bold' => true, 'color' => array('rgb' => 'FFFFFF'))));

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

    foreach ($usrResponse as $obj) {
      $objPHPExcel->getActiveSheet()->SetCellValue('A' . $j, $obj->full_name);
      $objPHPExcel->getActiveSheet()->SetCellValue('B' . $j, $obj->mail);
      $objPHPExcel->getActiveSheet()->SetCellValue('C' . $j, $obj->cell_phone);
      $objPHPExcel->getActiveSheet()->SetCellValue('D' . $j, $obj->deposit_made);
      $objPHPExcel->getActiveSheet()->SetCellValue('E' . $j, $obj->no_people);
      $objPHPExcel->getActiveSheet()->SetCellValue('F' . $j, $obj->artist);
      $objPHPExcel->getActiveSheet()->SetCellValue('G' . $j, $obj->cover);
      $objPHPExcel->getActiveSheet()->SetCellValue('H' . $j, $obj->date);
      $objPHPExcel->getActiveSheet()->SetCellValue('I' . $j, date("H:i", strtotime($obj->hour)));
      $objPHPExcel->getActiveSheet()->SetCellValue('J' . $j, $obj->no_table);
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

  public function getDataToEmail($reservation)
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();

    $query = "SELECT NO_MESA FROM `mesas` WHERE ID_MESA = " . $reservation->id_table . ";";
    $result = $databaseConected->consulta($query);
    $row = $result->fetch_assoc();
    $reservation->no_table = $row["NO_MESA"];

    $query = "SELECT ARTISTA FROM `espectaculos` WHERE ID_ESPECTACULO=" . $reservation->id_show . ";";
    $result = $databaseConected->consulta($query);
    $row = $result->fetch_assoc();
    $reservation->artist = $row["ARTISTA"];

    $query = "SELECT FECHA, HORA FROM `fecha_hr_espectaculo` WHERE ID_ESPECTACULO=" . $reservation->id_show . " AND ID_FECHA_HR=" . $reservation->id_date_hr . ";";
    $result = $databaseConected->consulta($query);
    $row = $result->fetch_assoc();
    $reservation->date = $row["FECHA"];
    $reservation->hour = date('H:i', strtotime($row["HORA"]));

    $databaseConected->desconectar();
    return $reservation;
  }
  public function sendEmail($reservation)
  {
    // Multiple recipients
    $to = $reservation->mail; // note the comma

    // Subject
    $subject = 'Reservación Parker&Lenox';

    // Message
    $message = '
      <html>
      <head>
        <title>Reservación Parker&Lenox</title>
      </head>
      <body>
        <p>Tu experiencia Parker&Lenox comienza ahora, prepárate para disfrutar de una mágica experiencia sonora, la mejor gastronómica y una exclusiva selección de cócteles clásicos y de autor.</p>
        <p><strong>Datos de la reservación</strong></p>
        <ul>
          <li><strong>Reservación a nombre de: </strong>'.$reservation->full_name.'</li>
          <li><strong>Día y Horario: </strong>'.$reservation->date.' / '.$reservation->hour.'h</li>
          <li><strong>Número de mesa: </strong>'.$reservation->no_table.'</li>
          <li><strong>Espectáculo: </strong>'.$reservation->artist.'</li>
          <li><strong>Folio: </strong>'.$reservation->folio.'</li>
        </ul>
        <p>Recuerda que tu reservación tiene un tiempo máximo de 15 minutos de tolerancia, después de dicho tiempo se cancelará automáticamente y deberás pasar a la lista de espera presencial. El cover lo pagarás al acceder al evento y el pago es únicamente en efectivo. </p>
      ';
    if($reservation->no_people >= 7 ){
      $message .= '
      <p>Para realizar una reservación de 7 o más personas requerimos depositar el 100% de los covers del total de personas que nos visitarán, el acceso por persona es de $150.00, de este modo podemos asegurar tu mesa.  
      Una vez realizado el depósito envía una foto con el comprobante a <a href="mailto:operacion@parker-lenox.com">operacion@parker-lenox.com</a> o manda Whats App <a href="https://wa.me/=5215578933140">5578933140</a>, en caso de que esto no ocurra el espacio será liberado. Gracias por compartir la experiencia Parker&Lenox.</p>
      <p><strong>Datos bancarios</strong></p>'.
      '<ul>
        <li><strong>CLABE: </strong>07218 0002 1167 62696</li>
        <li><strong>Banco: </strong> Banorte</li>
      </ul>
      <p>A nombre de <strong>Dos Con Todo SA de CV</strong></p>
      <p>Pago directo en ventanilla a la cuenta <strong>0211676269</strong></p>';
    }

    $message .= '</body>
    </html>';

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // Additional headers
    $headers[] = 'To: ' . $reservation->full_name . ' <' . $reservation->mail . '>';
    $headers[] = 'From: Somefriends <contacto@somefriends.pro>';

    // Mail it
    mail($to, $subject, wordwrap($message, 80), implode("\r\n", $headers));
  }
}
