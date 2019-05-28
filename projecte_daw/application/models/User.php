<?php

// **********************************************
// Author: Guillem Caballé Tomàs
// **********************************************

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// User class is the user of the webpage
class User extends CI_Model
{
    
  //integer id, unique
  private $id = null;
  
  private $username;
  
  //md5 encripted password
  private $password;
  
  private $email;
  
  /*TO-DO + info*/
  private $activated;

  //integer
  private $role; 
  
  function __construct($paramId = null, $paramUsername = null, $paramPassword = null, $paramEmail = null, $paramRole = null) {
    
    parent::__construct();
    
    $this->setId($paramId);
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

  public function setActivated($param){
      $this->activated = $param;
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

  public function getActivated(){
      return $this->activated;
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
  
  public function insert(){
      $u = $this->getUsername();
      $p = $this->getPassword();
      $e = $this->getEmail();
      $r = $this->getRole();
      $sql = "INSERT INTO user (username, password, email, role) VALUES ('$u','$p','$e',$r)";
      return $this->db->query($sql);
  }

  public static function activate_user($code){
	  $CI =& get_instance();
	  $sql = "UPDATE user SET activated = 1 WHERE '$code' = MD5( CONCAT( MD5(username), MD5(password) ) );";
	  return $CI->db->query($sql);
  }
  
  public function getIdByUsername(){
      
      $u = $this->getUsername();
      $sql = "SELECT id FROM user WHERE username like '$u'";
      $r = $this->db->query($sql)->row();
      $this->setId($r->id);
      
  }
  
  //returns 0 if not valid, 1 if valid
  public function validate(){
      $u = $this->getUsername();
      $p = $this->getPassword();
      $sql = "SELECT id, username, email, role, activated FROM user WHERE username like '$u' AND password like '$p'";
      $r = $this->db->query($sql)->row();

      if($r != null) {
			$this->setId($r->id);
			$this->setEmail($r->email);
			$this->setRole($r->role);
			$this->setActivated($r->activated);
			return 1;
      }else{
          return 0;
      }
  }
  
  
}
?>
