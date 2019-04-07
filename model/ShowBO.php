<?php
include_once 'ConectaBD.php';
include_once 'Show.php';
class ShowBO
{
  //Atributos
  private $post;

  //Constructor
  public function __construct($post)
  {
    $this->post=$post;
  }

  //Methods
  public function createShow($showData){
  
  }

  public function deleteShow($idShow){

  }
  public function updateShow($showData){
    
  }
}
?>