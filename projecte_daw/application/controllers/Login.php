<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
        $this->load->view('login');
	}
    
    public function verify_user(){
        
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        
        //user object
        //$user = new User($u, $p, null, null);
        $user = new User();
        $user->setUsername($u);
        $user->setPassword($p);
        
        
        
        if($user->validate()){
            echo "user valid: " . $user->toString();
            
            //envio al panell d'user o de company
            
            if($user->role == 1) redirect('company/index');
            else redirect('client/index');
            
        }else redirect('login/error');
        
    }
    
    public function error(){
        
        echo "Wrong credentials. try again";exit;
        
    }
}
