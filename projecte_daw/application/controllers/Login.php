<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $this->load->view('login');
	}
    
    public function verify_user(){
        
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        
        //user object
        //$user = new User($u, $p, null, null);
        $user = new User($u, $p, null, null);
        $user->setUsername($u);
        $user->setPassword($p);
        
        
        
        if($user->validate()){
            echo "user valid: " . $user->toString();
            
            //envio al panell d'user o de company
            if($user->getRole() == 1) redirect('Company/index');
            else if($user->getRole() == 2) redirect('Client/index');
        }else redirect('login/error');
        
    }
    
    public function error(){
        
        echo "Wrong credentials. try again";exit;
        
    }
}
