<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CustomBaseStep {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUser');
		$this->load->helper('cookie');
	}
	public function show()
	{
		// $this->logout();
		$data['account_id'] = $this->input->post('account_id');
		$data['password'] = $this->input->post('password');
		if(!empty(get_cookie('account_id')) AND !empty(get_cookie('password'))){
			$data['account_id'] = get_cookie('account_id');
			$data['password'] = get_cookie('password');
		}
		
		$submit = $this->input->post('submit');
		if(isset($submit) and !empty($data)) {
			$user_profile = $this->ghUser->login($data);
			if( !empty($user_profile)) {
				$this->session->set_userdata(['auth' => $user_profile[0]]);
				if(empty(get_cookie('account_id'))) {
					set_cookie('account_id', $data['account_id'],2592000);
					set_cookie('password', $data['password'], 2592000);
				}
				var_dump($this->session);
				return redirect('/admin/list-user');
			}
		}
		// load_view
		$this->load->view('login/show');
	}

	public function logout(){
		$this->session->sess_destroy();
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */