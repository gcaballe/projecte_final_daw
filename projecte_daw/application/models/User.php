<?php

// **********************************************
// Author: Guillem Caballé Tomàs
// **********************************************

// User class is the user of the webpage
class User
{
  //integer id, unique
  private $id = null;
  
  private $username;
  
  //md5 encripted password
  private $password;
  
  private $email;
  
  /*TO-DO + info*/
  
  //integer
  private $role;
  
  public function __construct($paramUsername, $paramPassword, $paramEmail, $paramRole) {
    $this->setUsername($paramUsername);
    $this->setPassword($paramPassword);
    $this->setEmail($paramEmail);
    $this->setRole($paramRole);
  }
  
  public function setId($param){
    $this->id = $param;
  }
  
  public function getId(){
    return $this->id;
  }
  
  public function setUsername($param){
    $this->username = $param;
  }
  
  public function setPassword($param){
    $this->password = md5($param);
  }
  
  public function setEmail($param){
    $this->email = $param;
  }
  
  public function setRole($param){
      $this->role = $param;
  }
  
  function getUsername(){
    return $this->username;
  }
  
  function getPassword(){
    return $this->password;
  }
  
  function getEmail(){
    return $this->email;
  }
  
  public function getRole(){
      return $this->role;
  }
  
  
  
  // FUNCTIONS
  
  
  public function toString(){
      $aux = "Object User:<br>";
      $aux .= "Id: $this->id.<br>";
      $aux .= "Username: $this->username.<br>";
      $aux .= "Password: $this->password.<br>";
      $aux .= "Email: $this->email.<br>";
      $aux .= "Role: $this->role.<br>";
      return $aux . "<br>";
  }  
  
  /**
  * return true if the user has $role
  */
  public function hasRole($role){
      return $this->role == $role;
  }
  
  public function get_insert_sql(){
      $u = $this->getUsername();
      $p = $this->getPassword();
      $e = $this->getEmail();
      $r = $this->getRole();
      $sql = "INSERT INTO user (username, password, email, role) VALUES ('$u','$p','$e',$r)";
      return return $sql;
  }
  
  
}
?>