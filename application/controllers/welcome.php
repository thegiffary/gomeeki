<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index(){
		
		$data = array();
		
		//check if address is set on URL.
		if(isset($_GET['address']) && $_GET['address']!=''){
			$data['default_keyword'] = $_GET['address'];
		}
		else{
			$data['default_keyword'] = 'auckland';
		}
		
		//set title of this page.
		$data['title'] = 'Gomeeki Project';
		
        $this->load->view('main', $data);
		
    }

}