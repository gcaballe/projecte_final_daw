<?php
/**
* Role class is the role of an User. It can be Administrator, Client or Company
* Example usage:
* Company::getCompanyIdByUserId($id));
*
* @author Guillem Caballe
* @version $Revision: 1.0 $
* @access public 
* 
*/
class Role
{
  
  private $id;
  
  private $name;
  
  private $description;
  
  function __construct($paramId, $paramName, $paramDescription) {
      $this->setId($paramId);
      $this->setName($paramName);
      $this->setDescription($paramDescription);
  }
  
  function setId($param){
    $this->id = $param;
  }
  
  function setName($param){
    $this->name = $param;
  }
  
  function setDescription($param){
    $this->description = $param;
  }
  
  function getId(){
      return $this->id;
  }
  
  function getName(){
      return $this->name;
  }
  
  function getDescription(){
      return $this->description;
  }
  
  function toString(){
      return "Role object with id=> " . getId() . "\nname=> " . getName() . "\ndesc=> " . getDesc() . ".\n";
  }
}
?>