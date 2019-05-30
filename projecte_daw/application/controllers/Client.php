<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    

	public function index()
	{
        $user = unserialize($this->session->user);
        
        $data['activities'] = Activity::getAllOpen();
        
        //agafo les activitats per a posar rating
        $data['myDoneActivities'] = Activity::getAllDoneByUser($user->getId()); //user id surt de session

        $data['enrollments'] = Review::getEnrollments($user->getId(), $data['activities']);
		$data['user_session'] = $user;

//		var_dump($data['enrollments']);exit;
        $this->load->view('client', $data);
	}
    
    public function enroll($activity_id){
        
        $user = unserialize($this->session->user);
        $review = new Review($user->getId(), $activity_id, 1, null, null);
        
        echo $review->toString();
        
        $review->enroll();
        
        redirect('Client/index');
        
    }
    
    public function undo_enroll($activity_id){
        $user = unserialize($this->session->user);
        $review = new Review($user->getId(), $activity_id, 0, null, null);
        $review->delete_review();
        
        redirect('Client/index');
    }
    
    public function rate_activity(/*$activity_id, $rating, $text*/){
		$u = $this->input->post('user_id');
		$a = $this->input->post('act_id');
		$r = $this->input->post('rate');
		$t = $this->input->post('text_review');

        $review = new Review($u, $a, null, $r, $t);
        $review->update_rating();
        echo "updated";
		 redirect('Client/index');
    }
    
    public function logout(){
        
        session_destroy();
        redirect('Login/index');
        
    }
    
   
}
