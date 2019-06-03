<?php
/**
* Company_model class is the info about a company
* Example usage:
* Company::getCompanyIdByUserId($id)) {
* print "I am an example.";
* }
*
* @author Guillem Caballe
* @version $Revision: 1.0 $
* @access public 
* 
*/
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
  private $lat;

  private $lng;
  
  function __construct($paramName = null, $paramCif = null, $paramUser = null, $paramLat = null, $paramLng = null) {
      parent::__construct();
      $this->setName($paramName);
      $this->setCif($paramCif);
      $this->setUser($paramUser);
      $this->setLat($paramLat);
      $this->setLng($paramLng);
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
  
  public function setLat($param){
      $this->lat = $param;
  }

  public function setLng($param){
      $this->lng = $param;
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
  
  public function getLat(){
      return $this->lat;
  }

  public function getLng(){
    return $this->lng;
}
  
    /**
    * Inserts the data of the company in the DB
    *
    */
    public function insert(){
        //id es autocomplete
        $n = $this->getName();
        $c = $this->getCif();
        $u = $this->getUser();
        $lat = $this->getLat();
        $lng = $this->getLng();

        $sql = "INSERT INTO company (name, cif, user, lat, lng) VALUES ('$n','$c', $u, $lat, $lng)";
        return $this->db->query($sql);
    }

    /**
    * Queries the DB to get the ID of a company
    *
    * @param the id of the user
    *
    * @return the id of the company
    */
    public static function getCompanyIdByUserId($id){
        $CI =& get_instance();
        $sql = "SELECT * FROM company WHERE user = $id";
        $r = $CI->db->query($sql)->row();
        return $r->id;
    }
	
}
?>
