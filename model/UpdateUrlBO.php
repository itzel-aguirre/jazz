<?php
include_once 'ConectDB.php';
include_once 'UpdateUrl.php';

class UpdateUrlBO
{
  
  public function __construct()
   { }

   public function UpdateVideoUrl($Dataurl)
   { 
     $databaseConected = new ConectDB();
     $databaseConected->conectar();
     $query = "UPDATE `video` SET `url`=  '".$Dataurl->url."'";
     $UrlInfo = $databaseConected->consulta($query);
     $databaseConected->desconectar();
     if ($UrlInfo) {
       return json_encode(TRUE);
     } else {
       return json_encode(array('error' => FALSE));
     }
   }

   public function selectUrl()
   {
    $databaseConected = new ConectDB();
    $databaseConected->conectar();
    $Urls = array();
    
    $query = "SELECT * FROM `video`";

    $urlInfo = $databaseConected->consulta($query);
    if ($urlInfo->num_rows > 0) {
		  while($row = $urlInfo->fetch_assoc()) {
            $url = UpdateUrl::constructNewUrlJson($row["url"]);
			      $Urls[]= $url;
			}
		}
    $databaseConected->desconectar();

    return $Urls;
   }
}
?>
