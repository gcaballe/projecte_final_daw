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
    
    public function rate_activity($activity_id, $rating, $text){
        
        $u = 1; //agafo del session
        $review = new Review($u, $activity_id, null, $rating, $text);
        $review->update_rating();
        
        echo "updated";
        
    }
    
    public function logout(){
        
        session_destroy();
        redirect('Login/index');
        
    }
    
   
}
