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
    private $product;
    private $description;
    private $status;
    private $timestamp;
    
    //constructor with id
    function __construct($id = null, $name = null, $product = null, $description = null, $status = null, $timestamp = null) {
        
        parent::__construct();
        $this->setId($id);
        $this->setName($name);
        $this->setProduct($product);
        $this->setDescription($description);
        if($status == null) $this->setStatus("open");
        else $this->setStatus($status);
        $this->setTimestamp($timestamp);
        if($timestamp == null) $this->setTimestamp(time());
    }
    
    //setter
    
    public function setId($param){
        $this->id = $param;
    }
    
    public function setName($param){
        $this->name = $param;
    }
    
    public function setProduct($param){
        $this->product = $param;
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
    
    public function getProduct(){
        return $this->product;
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
  
    
    /*public function getTimestampString(){
        return gmdate('Y-m-d h:i:s \G\M\T', $this->getTimestamp());
    }*/
    

    public function toString(){
        $aux = "Object Activity:<br>";

        $aux .= "Id: ".$this->getId()."<br>";
        $aux .= "Name: ".$this->getName()."<br>";

        if($this->getProduct() instanceof Product) $aux .= "<br>Product: ".$this->getProduct()->toString()."<br>";
        else $aux .= "Product: ".$this->getProduct()."<br>";

        $aux .= "Description: ".$this->getDescription()."<br>";
        $aux .= "Status: ".$this->getStatus()."<br>";
        $aux .= "Timestamp: ".$this->getTimestamp()."<br>";
        
        return $aux;
    }
	
    public function insert(){
        $n = $this->getName();
        $p = $this->getProduct();
        $d = $this->getDescription();
        $s = $this->getStatus();
        $tt = $this->getTimestamp();
        $sql = "INSERT INTO activity (name, product, description, status, timestamp) VALUES ('$n', $p, '$d', '$s', TIMESTAMP('$tt'))";
        return $this->db->query($sql);
    }
    
    //returns an activity object
    public function get($id){
        $sql = "SELECT * FROM activity WHERE id = $id";
        $r = $this->db->query($sql)->row();
        $a = new Activity($r->id, $r->name, $r->product, $r->description, $r->status, $r->timestamp);
        return $a;
    }
    
    //returns an array of activity objects, TO-DO implement filters
    public static function getAllOpen(){
        
        $CI =& get_instance();

        $sql = "SELECT * FROM activity WHERE status = 'open'";
        
        $result = $CI->db->query($sql)->result();
        
        $arr = array();
        foreach ($result as $r){
            
            $p = Product::get($r->product);
            
            $a = new Activity($r->id, $r->name, $p, $r->description, $r->status, $r->timestamp);
            $arr[] = $a;
        }
        return $arr;
    }
    
    
    //returns an array of activity objects
    public static function getAllDoneByUser($user){
        
        $CI =& get_instance();
        
        $sql_aux = "SELECT activity FROM review WHERE user = $user";

        $sql = "SELECT * FROM activity WHERE id IN ($sql_aux) AND status = 'done'";
        
        $result = $CI->db->query($sql)->result();
        
        $arr = array();
        foreach ($result as $r){
            
            $p = Product::get($r->product);

            $a = new Activity($r->id, $r->name, $p, $r->description, $r->status, $r->timestamp);
            $arr[] = $a;
        }
        return $arr;
    }
    
    //returns an array of activity objects of a certain $company
    public static function getAllByCompany($company){
        //com que es method static he de fer aixo
        $CI =& get_instance();
 
        $sql = "SELECT * FROM activity WHERE product IN (SELECT id FROM product WHERE company = $company)";
        
        $result = $CI->db->query($sql)->result();
        
        $arr = array();
        foreach ($result as $r){

            $p = Product::get($r->product);
            
            $a = new Activity($r->id, $r->name, $p, $r->description, $r->status, $r->timestamp);
            $arr[] = $a;
        }
        return $arr;
    }

    /** returns array of User objects */
    public static function getEnrolledUsers($arr_act){
        $CI =& get_instance();

        $arr = array();
        foreach($arr_act as $act){
            $sql = "SELECT id, username, email FROM user WHERE id IN (
                SELECT user from review where enrolled = 1 AND activity = " . $act->getId() .
            ")";
            
            $result = $CI->db->query($sql)->result();
            
            $arr_u = array();
            foreach ($result as $r){
                $u = new User($r->id, $r->username, null, $r->email, null);
                $arr_u[] = $u;
            }
            $arr[$act->getId()] = $arr_u;
        }
        return $arr;
    }
    
    
    public static function update_status($id, $status){
        $CI =& get_instance();
        $sql = "UPDATE activity SET status = '$status' WHERE id = $id";
        return $CI->db->query($sql);
    }
    
}
?>