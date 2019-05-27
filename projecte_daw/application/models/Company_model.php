<?php
// **********************************************
// Author: Guillem Caball� Tom�s
// **********************************************

// Company class is the registry of a company linked to a user
class Company_model extends CI_Model
{
  //unique code
  private $id;
  
  //the company name
  private $name;

  //cif
  private $cif;
  
  //user id
  private $user;
  
  //address 
  private $address;
  
  function __construct($paramName = null, $paramCif = null, $paramUser = null, $paramAddress = null) {
      parent::__construct();
      $this->setName($paramName);
      $this->setCif($paramCif);
      $this->setUser($paramUser);
      $this->setAddress($paramAddress);
  }
  
  //setter
  public function setId($param){
    $this->id = $param;
  }
  
  public function setName($param){
      $this->name = $param;
  }
  
  public function setCif($param){
      $this->cif = $param;
  }
  
  public function setUser($param){
      $this->user = $param;
  }
  
  public function setAddress($param){
      $this->address = $param;
  }
  
  
  //getter
  
  public function getId(){
      return $this->id;
  }
  
  public function getName(){
      return $this->name;
  }
  
  public function getCif(){
      return $this->cif;
  }
  
  public function getUser(){
      return $this->user;
  }
  
  public function getAddress(){
      return $this->address;
  }
  
  
    public function insert(){
        //id es autocomplete
        $n = $this->getName();
        $c = $this->getCif();
        $u = $this->getUser();
        $a = $this->getAddress();

        $sql = "INSERT INTO company (name, cif, user, address) VALUES ('$n','$c', $u, '$a')";
        return $this->db->query($sql);
    }
	
}
?>