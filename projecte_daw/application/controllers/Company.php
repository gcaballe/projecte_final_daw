<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function index()
	{
        
        $data['products'] = Product::getAllByCompany(2);
        
        $data['activities'] = Activity::getAllByCompany(2);

        $this->load->view('company', $data);
        
	}
    
    public function add_activity(){
        
        //id ho crea la BD
        
        
        //agafem del formulari: name, product, type, description, timestamp

        $n = $this->input->post("name");
        $p = $this->input->post("product");
        $d = $this->input->post("description");
        $tt = null;//$tt = $this->input->post("timestamp");
        
        $a = new Activity(null, $n, $p, $d, $tt);
        
        echo $a->toString();
        
        echo $a->insert();
       
        //hauria de omplir la session-->feedback o session-->error
        
    }
    
    
    
    
}
