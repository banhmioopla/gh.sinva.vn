<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUser');
		$this->load->helper('cookie');
		$this->default_url = '/admin/list-apartment';
		$this->logout_url = '/admin/logout';
	}
	public function show()
	{
		$data['account_id'] = $this->input->post('account_id');
		$data['password'] = $this->input->post('password');
		if(!empty($_COOKIE['account_id']) AND !empty($_COOKIE['password'])){

			$data['account_id'] = $_COOKIE['account_id'];
			$data['password'] = $_COOKIE['password'];
			$user_profile = $this->ghUser->login($data);

			if(!empty($user_profile)) {
				$this->session->set_userdata(['auth' => $user_profile]);
                return redirect($this->default_url);
			} else {
				return redirect($this->logout_url);
			}
		} 
		
		
		$submit = $this->input->post('submit');
		if(isset($submit) or !empty($data['account_id'])) {
			$user_profile = $this->ghUser->login($data);
			if( !empty($user_profile)) {
				$this->session->set_userdata(['auth' => $user_profile]);
                $cookie = array(
                    'name'   => 'account_id',
                    'value'  => $user_profile['account_id'],
                    'expire' => time()+86400*30,
                );
                set_cookie($cookie);
                $cookie = array(
                    'name'   => 'password',
                    'value'  => $user_profile['password'],
                    'expire' => time()+86400*30,
                );
                set_cookie($cookie);
				return redirect($this->default_url);
			}
		}
		// load_view
		$this->load->view('login/show');
	}

	public function logout(){
		unset($_COOKIE['account_id']);
		unset($_COOKIE['password']);
		unset($_SESSION['auth']);
		delete_cookie('account_id');
		delete_cookie('password');
		return $this->show();
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */