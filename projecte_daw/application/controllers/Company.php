<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->view('company');
        
	}
    
    public function add_activity(){
        
        //id ho crea la BD
        
        
        //agafem del formulari: name, product, type, description, timestamp

        $n = $this->input->post("name");
        $c = 3; //company ho agafo de la session
        $p = $this->input->post("product");
        $t = $this->input->post("type");
        $d = $this->input->post("description");
        $tt = null;//$tt = $this->input->post("timestamp");
        
        $a = new Activity($n, $c, $p, $t, $d, $tt);
        
        $a->insert();
        
    }
    
    
    
    
}
