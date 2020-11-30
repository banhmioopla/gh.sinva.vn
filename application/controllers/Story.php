<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghStory');
        $this->load->model('ghBaseRoomType');
        $this->load->model('ghApartment');
        $this->load->library('LibUser', null, 'libUser');
    }

    public function show(){
        /*--- Load View ---*/
        $data['list_story'] = $this->ghStory->get([
            'time_insert > ' => 0,
        ]);
        $data['libUser'] = $this->libUser;
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('story/show', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        $data['user_create_id'] = $this->auth['account_id'];
        $data['time_insert'] = time();

        if(!empty($data['content'])) {
            $this->ghStory->insert($data);
            return redirect('admin/list-story');
        }
    }

    // Ajax
    public function update() {
        $partner_id = $this->input->post('story_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');

        if(!empty($partner_id) and !empty($field_name)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghStory->updateById($partner_id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $partner_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($partner_id) and !empty($field_name)) {
            $data = [
                $field_name => $field_value
            ];

            $old_partner = $this->ghStory->getById($partner_id);
            $old_log = json_encode($old_partner[0]);

            $result = $this->ghStory->updateById($partner_id, $data);

            $modified_partner = $this->ghStory->getById($partner_id);
            $modified_log = json_encode($modified_partner[0]);

            $log = [
                'table_name' => 'gh_story',
                'old_content' => $old_log,
                'modified_content' => $modified_log,
                'time_insert' => time(),
                'action' => 'update'
            ];
            $tracker = $this->ghActivityTrack->insert($log);

            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }


}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */