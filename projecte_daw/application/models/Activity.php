<?php
// **********************************************
// Author: Guillem Caball� Tom�s
// **********************************************

// Activity class
class Activity extends CI_Model
{
    //unique code
    private $id;

    private $name;
    private $company;
    private $product;
    private $type;
    private $description;
    private $status;
    private $date;
    private $timestamp;
    
    function __construct($name = null, $company = null, $product = null, $type = null, $description = null, $timestamp = null/* = time()*/) {
        
        parent::__construct();
        $this->setName($name);
        $this->setTimestamp($timestamp);
        $this->setProduct($product);
        $this->set_type($type);
        $this->setDescription($description);
        //status
        $this->setTimestamp($timestamp);
    }
    
    //setter
    
    public function setId($param){
        $this->id = $param;
    }
    
    public function setName($param){
        $this->name = $param;
    }
    
    public function setCompany($param){
        $this->company = $param;
    }
    
    public function setProduct($param){
        $this->product = $param;
    }
    
    public function set_type($param){
        $this->type = $param;
    }
    
    public function setDescription($param){
        $this->description = $param;
    }
    
    public function setStatus($param){
        $this->status = $param;
    }
    
    public function setTimestamp($param){
        $this->timestamp = $param;
    }
    
    //getter
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getCompany(){
        return $this->company;
    }
    
    public function getProduct(){
        return $this->product;
    }
    
    public function get_type(){
        return $this->type;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getTimestamp(){
        return $this->timestamp;
    }
  
    /*
    public function getTimestampString(){
        return gmdate('Y-m-d h:i:s \G\M\T', $this->getTimestamp());
    }
    */

    public function toString(){
        
        $aux = "Object Activity:<br>";

        $aux .= "Id: ".$this->getId()."<br>";
        $aux .= "Name: ".$this->getName()."<br>";
        $aux .= "Company: ".$this->getCompany()."<br>";
        $aux .= "Product: ".$this->getProduct()."<br>";
        $aux .= "Type: ".$this->get_type()."<br>";
        $aux .= "Description: ".$this->getDescription()."<br>";
        $aux .= "Status: ".$this->getStatus()."<br>";
        //$aux .= "Date: ".$this->getDate()."<br>";
        $aux .= "Timestamp: ".$this->getTimestamp()."<br>";
        
        return $aux;
    }
	
    public function insert(){
        $n = $this->getName();
        $c = $this->getCompany();
        $p = $this->getProduct();
        $t = $this->get_type();
        $s = $this->getStatus();
        $tt = $this->getTimestamp();
        $sql = "INSERT INTO activity (name, company, product, type, status, timestamp) VALUES ('$n', $c, $p, '$t', '$s', $tt)";
        return $this->db->query($sql);
    }
    
    //returns an activity object
    public function get($id){
        $sql = "SELECT * FROM activity WHERE id = $id";
        $r = $this->db->query($sql)->row();
        $a = new Activity($r->name, $r->company, $r->product, $r->type, $r->description, $r->status, $r->timestamp);
        return $a;
    }
    
    //returns an array of activity objects, TO-DO implement filters
    public function getAll($filter = null){
        
        if($filter != null){
            $key = key($filter);
            $val = $filter[$key];
        }
        
        $sql = "SELECT * FROM activity";
        if($filter != null) $sql .= " WHERE $key = $val";
        
        $result = $this->db->query($sql)->result();
        
        $arr = array();
        foreach ($result as $r){
            $a = new Activity($r->name, $r->company, $r->product, $r->type, $r->description, $r->status, $r->timestamp);
            $arr[] = $a;
        }
        return $arr;
    }
    
    /*
    public function update($id){
        $sql = "UPDATE activity SET name='$n', company = , product, type, status, timestamp) VALUES ('$n', $c, $p, '$t', '$s', $tt)";
        return $this->db->query($sql);
    }
    */
}
?>