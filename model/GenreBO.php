<?php
include_once 'ConectDB.php';
include_once 'Genre.php';

class GenreBO
{
  //Attributes
  //Constructor
  public function __construct()
  {

  }

  //Methods
   public function CreateGenre($genreData){
  
  }

  public function DeleteGenre($idGenre){

  }
  public function ListGenres(){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $genres = array();
    
    $query = "SELECT * FROM `generos`";

    $genresInfo = $databaseConected->consulta($query);
    if ($genresInfo->num_rows > 0) {
		  while($row = $genresInfo->fetch_assoc()) {
            $genre = Genre::constructNewGenre($row["ID_GENERO"],$row["GENERO"]);
			      $genres[]= $genre;
			}
		}
    $databaseConected->desconectar();

    return $genres;
  }

}
?>