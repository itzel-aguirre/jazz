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
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "INSERT INTO `GENEROS` (`GENERO`) VALUES ('".$genre."');";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if($resultQuery){
      return json_encode(TRUE);
    }
    else{
    return json_encode(array('error'=>FALSE));
    }
  }

  public function DeleteGenre($idGenre){
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "DELETE FROM `generos` WHERE `id_genero`=".$idGenre." ";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery){
      return json_encode(TRUE);
    }
    else{
      return json_encode(array('error'=>FALSE));
    }
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

  public function UpdateGenre($GenreData)  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $query = "UPDATE `generos` SET `GENERO`='".$GenreData->genre."' WHERE `ID_GENERO`=".$GenreData->id_genre." ";
    $resultQuery = $databaseConected->consulta($query);
    $databaseConected->desconectar();
    if ($resultQuery) {
      return json_encode(TRUE);  
    }
    else{
      return json_encode (array('error'=>FALSE));
    }
  }

  public function GetListGenre()
  {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $generous_list = array();
    $query = "SELECT GENEROS.ID_GENERO, GENEROS.GENERO FROM `generos` ORDER BY GENERO ASC;";
    $resultQuery = $databaseConected->consulta($query);
    
    if ($resultQuery->num_rows > 0) 
    {
      while($row = $resultQuery->fetch_assoc()) {
        $constructGenre = Genre::constructNewGenre($row["ID_GENERO"], $row["GENERO"]);
        $generous_list[]= $constructGenre;
      }
        return $generous_list;
    }
    else{
      return json_encode(array('error'=>'Sin generos'));
    }
    $databaseConected->desconectar();
  }
}
?>