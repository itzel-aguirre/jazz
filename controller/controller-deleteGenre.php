<?php
include_once '../model/GenreBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$idGenre = $json_obj->idGenre;
$genre ="";
$genreLogic = new GenreBO();
$GenreData = Genre::constructNewGenre($idGenre, $genre);
$deleteGenre = $genreLogic->DeleteGenre($GenreData);

if($deleteGenre){
  header('Content-Type: application/json');
  print json_encode($deleteGenre);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error al eliminar un genero')));
} 
?>