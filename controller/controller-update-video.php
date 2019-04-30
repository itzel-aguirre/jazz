<?php
include_once '../model/UpdateUrl.php';
include_once '../model/UpdateUrlBO.php';

# Get JSON as a string
$json_str = file_get_contents('php://input');
# Get as an object
$json_obj = json_decode($json_str);

$url = $json_obj->url;
$urlLogic = new UpdateUrlBO();
$videoData = UpdateUrl::constructNewUrl($url);
$updateUrl = $urlLogic->UpdateVideoUrl($videoData);

if($updateUrl){
  header('Content-Type: application/json');
  print json_encode($updateUrl);
}
else{
  header('HTTP/1.1 420 Method Failure');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode (array('error'=>'Error')));
} 
?>