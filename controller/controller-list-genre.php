<?php
include_once '../model/GenreBO.php';

$genreLogic = new GenreBO();
$genres = $genreLogic->ListGenres();

header('Content-Type: application/json');
print json_encode($genres);

?>