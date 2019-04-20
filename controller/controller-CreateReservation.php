<?php
include_once '../model/Reservations.php';
include_once '../model/ReservationsBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$reservationLogic = new ReservationsBO();
//se envian los datos a registrar, almacenados en $json_obj
$ResponseDataReservation = $reservationLogic->CreateReservation($json_obj);

if($ResponseDataReservation){
  header('Content-Type: application/json');
  //$arrayReponse = array('name'=>$usrResponse);
  print json_encode($ResponseDataReservation);

}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Incorrecto')));
} 


/* 
$genreLogic = new GenreBO();
$genres = $genreLogic->ListGenres();

header('Content-Type: application/json');
print json_encode($genres); */

/* 
include_once '../model/Show_GenreBO.php';

$ShowGenreDat = new Show_GenreBO();
$ShowGenreList = $ShowGenreDat->ShowGenre();
//$ShowGenreList = $ShowGenreDat->CreateShowGenre(1,15);
//$ShowGenreList = $ShowGenreDat->UpdateShowGenre(1,7);
//$ShowGenreList=$ShowGenreDat->DeleteShowGenre(1, 15);
header('Content-Type: application/json');
$arrayReponse = array('id_espectaculo'=>$ShowGenreList->id_show,'ID_GENERO'=>$ShowGenreList->id_genre, 'GENERO'=>$ShowGenreList->genre);
print json_encode($ShowGenreList); */



/* include_once '../model/GenerousBO.php';

$ShowGenreDat = new GenreBO();
//$ShowGenreList = $ShowGenreDat->Generous();
//$ShowGenreList = $ShowGenreDat->DeleteGenerous(13);
$prueba = new GenreBO();
$prueba->id_genre = 17; // $dataGenreInfo->id_genre;
$prueba->genre = 'Swing'; // $dataGenreInfo->genre;
$ShowGenreList = $ShowGenreDat->Generous();
header('Content-Type: application/json');
print json_encode($ShowGenreList); */
?>