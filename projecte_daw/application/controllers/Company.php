<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function index()
	{
        $user = unserialize($this->session->user);
        $company_id = Company_Model::getCompanyIdByUserId($user->getId());

        $data['products'] = Product::getAllByCompany($company_id);
        
        $data['activities'] = Activity::getAllByCompany($company_id);

        $data['enrolled_users'] = Activity::getEnrolledUsers($data['activities']);
        $data['ratings'] = Review::getReviewsOfActivities($data['activities']);

        $this->load->view('company', $data);
        
	}
    
    public function add_activity(){
        
        //id ho crea la BD
        
        
        //agafem del formulari: name, product, type, description, timestamp

        $n = $this->input->post("name");
        $p = $this->input->post("product");
        $d = $this->input->post("description");
        $da = $this->input->post("date");
        $h = $this->input->post("hour");

        echo $da;
        echo "<br>";
        echo $h;

        $tt = strtotime($da . " " . $h);        
        
        $a = new Activity(null, $n, $p, $d, null, date("Y-m-d H:i:s", $tt));
        
        echo $a->toString();

        echo $a->insert();
       
        redirect('Company/index');
        //hauria de omplir la session-->feedback o session-->error
        
    }

    public function mark_as_done($act_id){
        Activity::update_status($act_id, "done");
        redirect('Company/index');
    }
    public function mark_as_closed($act_id){
        Activity::update_status($act_id, "closed");
        redirect('Company/index');
    }
    
    public function import_data(){
        $user = unserialize($this->session->user);
        $company_id = Company_Model::getCompanyIdByUserId($user->getId());

        $ext = pathinfo($_FILES['dir_to_search']['name'], PATHINFO_EXTENSION);
        $path = $_FILES['dir_to_search']['tmp_name'];

        $numProd = $numAct = 0;

        if($ext == "csv"){
            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if($data[0] == "prod"){
                        $p = new Product($data[1], $company_id, $data[2], $data[3]);
                        $numProd++;
                        echo $p->insert();
                    }else if ($data[0] == "act"){
                        $act = new Activity(null, $data[1], $data[2], $data[3], null, $data[4]);
                        $numAct++;
                        $act->insert();
                    }
                }
                fclose($handle);
            }

        }else if ($ext == "xml"){
            $xml = simplexml_load_file($path);

            foreach($xml->products->children() as $p){
                $prod = new Product($p['id'], $company_id, $p->name,$p->description);
                $numProd++;
                $prod->insert();
            }

            foreach($xml->activities->children() as $a){
                $act = new Activity(null, $a->name, $a->product, $a->description, null, $a->timestamp);
                $numAct++;
                $act->insert();
            }
        }
        redirect('Company/index');
        /*
        echo "Inserted $numProd products and $numAct activities";
        echo "<a href='" . site_url('Company/index') . "'><button>Back.</button></a>";
        */
    }

    public function logout(){
        
        session_destroy();
        redirect('Login/index');
        
    }
    
    
}
