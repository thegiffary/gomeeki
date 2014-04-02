<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/history/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		
		$this->load->model('search_history_model');
		$data['keyword_list'] = $this->search_history_model->getAll();
		$this->load->view('history', $data);
		
	}
}

