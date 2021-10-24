<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUser');
		$this->load->model('ghRole');
		$this->default_url = '/admin/list-apartment';
		$this->logout_url = '/admin/logout';
	}
	public function show()
	{
		$data['account_id'] = $this->input->post('account_id');
		$data['password'] = $this->input->post('password');
		if(!empty(get_cookie('gh_account_id')) AND !empty(get_cookie('gh_password'))){
			$data['account_id'] = get_cookie('gh_account_id');
			$data['password'] = get_cookie('gh_password');
			$user_profile = $this->ghUser->login($data);
			if($user_profile) {
                $this->session->set_userdata(['auth' => $user_profile]);
                $role = $this->ghRole->getFirstByCode($user_profile['role_code']);
                $permission_set = json_decode($role['list_function'], true);
                if($this->isYourPermission('Dashboard', 'showListProject', $permission_set)){
                    $this->default_url = '/admin/dashboard/show/project';
                }
                $this->input->cookie('gh_account_id',$user_profile['account_id'], time()+60*60*24*365);
                $this->input->cookie('gh_password',$user_profile['password'], time()+60*60*24*365);
                return redirect($this->default_url);
			} else {
				return redirect($this->logout_url);
			}
		}
		
		
		$submit = $this->input->post('submit');
		if(isset($submit) or !empty($data['account_id'])) {
			$user_profile = $this->ghUser->login($data);
			if($user_profile) {
				$this->session->set_userdata(['auth' => $user_profile]);
                $role = $this->ghRole->getFirstByCode($user_profile['role_code']);
                $permission_set = json_decode($role['list_function'], true);

                if($this->isYourPermission('Dashboard', 'showListProject', $permission_set)){
                    $this->default_url = '/admin/dashboard/show/project';
                }

                $this->input->cookie('gh_account_id',$user_profile['account_id'], time()+60*60*24*365);
                $this->input->cookie('gh_password',$user_profile['password'], time()+60*60*24*365);
				return redirect($this->default_url);
			}
		}
		// load_view
		$this->load->view('login/show');
	}

	public function logout(){
		unset($_COOKIE['gh_account_id']);
		unset($_COOKIE['gh_password']);
		unset($_SESSION['auth']);
		unset($_SESSION['isTriggerFiveDay']);
		delete_cookie('gh_account_id');
		delete_cookie('gh_password');
		return $this->show();
	}

    protected function isYourPermission($controller, $action, $permission_set){
        $list_controller = array_keys($permission_set);
        if(in_array($controller, $list_controller) && isset($permission_set[$controller]) && in_array($action, $permission_set[$controller])) {
            return true;
        }
        return false;

    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */