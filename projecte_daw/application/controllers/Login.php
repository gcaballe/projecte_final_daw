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
        $user = new User(null, $u, $p, null, null);       
        
        
        if($user->validate()){
            //echo "user valid: " . $user->toString();

			if($user->getActivated() == NULL) {
				echo "User is still not activated. Check your email: " . $user->getEmail();
				exit;
			}

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
        
        $user = new User(null, $u, $p, $e, 2);
        
		//atribute 'activated' is NULL
        $user->insert();


        $config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'guillemcaballe95@gmail.com',
			'smtp_pass' => 'cadira1995',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('no_reply@infomila.info', 'NO REPLY');
		$this->email->to($user->getEmail());

		$this->email->subject('Account registration confirmation');

		//creo un codi

		$code = md5( md5($user->getUsername()) . md5($user->getPassword()) );

		$url = site_url("login/confirm_user/$code");

		$this->email->message('To activate this account, click on this link.' . "\n$url");

		$result = $this->email->send();

		redirect('Login/index');
    }

	public function confirm_user($code){
		$r = User::activate_user($code);
		redirect('Login/index');
	}
    
    /** Register a acompany
    */
    public function register_company(){

        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $e = $this->input->post('email');
        
        $cn = $this->input->post('company_name');
        $c = $this->input->post('cif');
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
        
        $user = new User(null, $u, $p, $e, 1);
        $user->insert();
        

        $user->getIdByUsername();

        $company = new Company_model($cn, $c, $user->getId(), $lat, $lng);
        
        $company->insert();        
        
        $config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'guillemcaballe95@gmail.com',
			'smtp_pass' => 'cadira1995',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('no_reply@infomila.info', 'NO REPLY');
		$this->email->to($user->getEmail());

		$this->email->subject('Account registration confirmation');

		//creo un codi

		$code = md5( md5($user->getUsername()) . md5($user->getPassword()) );

		$url = site_url("login/confirm_user/$code");

		$this->email->message('To activate this account, click on this link.' . "\n$url");

		$result = $this->email->send();
        
		redirect('Login/index');
    }
	
	public function logout(){
        
        session_destroy();
        redirect('Login/index');
        
	}
	
    public function error(){
        
        echo "Wrong credentials. try again";exit;
        
    }
}
