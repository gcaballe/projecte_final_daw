<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

	public function index()
	{
		
		echo "Test de CSV reader:";

		echo "<form>
		
		
		</form>";
		
		$row = 1;
		$arrResult  = array();
		if (($handle = fopen("ifsc_code.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				DB::table('banks')->insert(
					array('bank_name' => $data[1], 'ifsc' => $data[2], 'micr' => $data[3], 'branch_name' => $data[4],'address' => $data[5], 'contact' => $data[6], 'city' => $data[7],'district' => $data[8],'state' => $data[9])
				);
			}
			fclose($handle);
		}


	}
}
