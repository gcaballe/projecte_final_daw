<?php
// **********************************************
// Author: Guillem Caball� Tom�s
// **********************************************

// Review class
class Review extends CI_Model
{
    private $user;
    private $activity;
    private $enrolled;
    private $rating;
    private $text;
    
    function __construct($user = null, $activity = null, $enrolled = null, $rating = null, $text = null) {
        
        parent::__construct();
        $this->setUser($user);
        $this->setActivity($activity);
        $this->setEnrolled($enrolled);
        $this->setRating($rating);
        $this->setText($text);
    }
    
    //setter
    
    public function setUser($param){
        $this->user = $param;
    }
    
    public function setActivity($param){
        $this->activity = $param;
    }
    
    public function setEnrolled($param){
        $this->enrolled = $param;
    }
    
    public function setRating($param){
        $this->rating = $param;
    }
    
    public function setText($param){
        $this->text = $param;
    }

    
    //getter
    
    public function getUser(){
        return $this->user;
    }
    
    public function getActivity(){
        return $this->activity;
    }
    
    public function getEnrolled(){
        return $this->enrolled;
    }
   
    public function getRating(){
        return $this->rating;
    }
    
    public function get_text(){
        return $this->text;
    }
   
    
    //funcions

    public function toString(){
        $aux = "Object Review:<br>";
        $aux .= "User: $this->user.<br>";
        $aux .= "Activity: $this->activity.<br>";
        $aux .= "Enrolled: $this->enrolled.<br>";
        $aux .= "Rating: $this->rating.<br>";
        $aux .= "Text: $this->text.<br>";
        return $aux . "<br>";
    }
	
    public function enroll(){
        $u = $this->getUser();
        $a = $this->getActivity();
        $e = $this->getEnrolled();
        //$r = $this->getRating();
        //$t = $this->get_text();
        $sql = "INSERT INTO review (user, activity, enrolled) VALUES ($u, $a, 1)";
        return $this->db->query($sql);
    }
    
    public function update_rating(){
        $u = $this->getUser();
        $a = $this->getActivity();
        $r = $this->getRating();
        $t = $this->get_text();
        
        $sql = "UPDATE review SET rating='$r', text='$t' WHERE user=$u AND activity = $a";
        return $this->db->query($sql);
    }
    
    /**
    deletes a review, or an enrollment
    */
    public function delete_review(){
        $u = $this->getUser();
        $a = $this->getActivity();
        
        $sql = "DELETE FROM review WHERE user=$u AND activity = $a";
        return $this->db->query($sql);
    }
    
    
    public static function getEnrollments($user_id, $act_arr){

        $CI =& get_instance();
        
        $arr = array();
        foreach ($act_arr as $act){
            
            $a = $act->getId();
            $sql = "SELECT enrolled FROM review WHERE user = $user_id AND activity = $a";
            
            if($r = $CI->db->query($sql)->row()) $arr[] = $r->enrolled;
        }
        return $arr;
        
    }
    
    /*
    //returns a product object $p
    public static function get($id){
        $CI =& get_instance();
        $sql = "SELECT * FROM product WHERE id = $id";
        $r = $CI->db->query($sql)->row();
        $p = new Product($r->id, $r->company, $r->name, $r->description);
        return $p;
    }
    
    //returns an array of product objects
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
    }*/

}
?>