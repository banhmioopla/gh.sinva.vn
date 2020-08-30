<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUser');
		$this->load->helper('cookie');
	}

	public function index() {
		$this->show();
	}
	public function show()
	{
		$data['account_id'] = $this->input->post('account_id');
		$data['password'] = $this->input->post('password');
		if(!empty(get_cookie('account_id')) AND !empty(get_cookie('password'))){
			
			$data['account_id'] = get_cookie('account_id');
				$data['password'] = get_cookie('password');
				$user_profile = $this->ghUser->login($data);
				if(!empty($user_profile)) {
					$this->session->set_userdata(['auth' => $user_profile[0]]);
				}
		}
		
		$submit = $this->input->post('submit');
		if(isset($submit) or !empty($data)) {
			$user_profile = $this->ghUser->login($data);
			if( !empty($user_profile)) {
				$this->session->set_userdata(['auth' => $user_profile[0]]);
				set_cookie('account_id', $user_profile[0]['account_id'],2592000);
				set_cookie('password', $user_profile[0]['password'], 2592000);
				return redirect('/admin/list-user');
			}
		}
		// load_view
		$this->load->view('login/show');
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->show();
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */