<?php
/**
* Product class is the product
* Example usage:
* Company::getCompanyIdByUserId($id)) ;
*
* @author Guillem Caballe
* @version $Revision: 1.0 $
* @access public 
* 
*/
class Product extends CI_Model
{
    //unique code
    private $id;
    private $company;
    private $name;
    private $description;
    
    function __construct($id = null, $company = null, $name = null, $description = null) {
        
        parent::__construct();
        $this->setId($id);
        $this->setCompany($company);
        $this->setName($name);
        $this->setDescription($description);
    }
    
    //setter
    
    public function setId($param){
        $this->id = $param;
    }
    
    public function setCompany($param){
        $this->company = $param;
    }
    
    public function setName($param){
        $this->name = str_replace("'", "\'", $param);
    }
    
    public function setDescription($param){
        $this->description = str_replace("'", "\'", $param);
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
   
    public function getDescription(){
        return $this->description;
    }
   
    
    //funcions

    public function toString(){
        
        $aux = "Object Product:<br>";

        $aux .= "Id: ".$this->getId()."<br>";
        $aux .= "Company: ".$this->getCompany()."<br>";
        $aux .= "Name: ".$this->getName()."<br>";
        $aux .= "Description: ".$this->getDescription()."<br>";
        
        return $aux;
    }
	
    /*
    * Inserts a Product object
    * 
    *
    * @return True or false
    */
    public function insert(){
        $id = $this->getId();
        $c = $this->getCompany();
        $n = $this->getName();
        $d = $this->getDescription();
        if($id == null) $sql = "INSERT INTO product (company, name, description) VALUES ($c, '$n', '$d')";
        else $sql = "INSERT INTO product (id, company, name, description) VALUES ($id, $c, '$n', '$d')";
        return $this->db->query($sql);
    }
    
    /*
    * Gets a product object by Id
    * 
    * @param int $id The id of the product you want
    *
    * @return True or false
    */
    public static function get($id){
        $CI =& get_instance();
        $sql = "SELECT * FROM product WHERE id = $id";
        $r = $CI->db->query($sql)->row();
        $p = new Product($r->id, $r->company, $r->name, $r->description);
        return $p;
    }
    
    /*
    * Gets all products of a company
    * 
    * @param int $company The id of the company
    *
    * @return Array of product objects
    */
    public static function getAllByCompany($company){
        //com que es method static he de fer aixo
        $CI =& get_instance();
 
        $sql = "SELECT * FROM product WHERE company = $company";
        
        $result = $CI->db->query($sql)->result();
        
        $arr = array();
        foreach ($result as $r){
            $p = new Product($r->id, $r->company, $r->name, $r->description);
            $arr[] = $p;
        }
        return $arr;
    }

}
?>