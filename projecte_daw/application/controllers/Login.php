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
        
        
        if($user->validate()){
            echo "user valid: " . $user->toString();
            $this->session->user = serialize($user);
            
            //envio al panell d'user o de company
            if($user->getRole() == 1){
                redirect('Company/index');
            }else if($user->getRole() == 2){
                redirect('Client/index');
            }
        }else redirect('login/error');
        
    }
    
    /** Register a user, not a company
    */
    public function register_user(){
        
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $e = $this->input->post('email');
        
        $user = new User($u, $p, $e, 2);
        
        $u->insert();
        
        //to-do: mail verification al registrar?
        
    }
    
    /** Register a acompany
    */
    public function register_company(){
        
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $e = $this->input->post('email');
        
        $cn = $this->input->post('company_name');
        $c = $this->input->post('cif');
        $a = $this->input->post('address');
        
        $user = new User($u, $p, $e, 1);
        $user->insert();
        
        echo $user->toString();
        
        $user->getIdByUsername();
        
        echo $user->toString();
        
        
        
        $company = new Company_model($cn, $c, $user->getId(), $a);
        
        $company->insert();        
        
        //to-do: mail verification al registrar?
        
    }
    
    public function error(){
        
        echo "Wrong credentials. try again";exit;
        
    }
}
