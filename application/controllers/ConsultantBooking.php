<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class ConsultantBooking extends CustomBaseStep {
	private $access_control;
	public $url_show_default = '/admin/list-consultant-booking?tb1=1&filterTime=THIS_WEEK';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghConsultantBooking');
		$this->load->model('ghApartment');
		$this->load->model('ghDistrict');
		$this->load->model('ghCustomer');
		$this->load->model('ghUserTarget');
		$this->load->model('ghRoom');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibTime', null, 'libTime');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->config('label.apartment');
	}

	public function showAllTimeLine(){}

	public function showYour(){
		return $this->ghConsultantBooking->get(['time_booking > ' => strtotime('last monday'), 'booking_user_id' =>$this->auth['account_id']]);
	}

	public function syncPendingToSuccess() {
	    return $this->ghConsultantBooking->syncPendingToSuccess();
    }

	public function show(){
        $this->syncPendingToSuccess();
        $searching = $this->input->get();

        $time_from = date('d-m-Y', strtotime('last monday'));
        $time_to = date('d-m-Y', strtotime('sunday this week'));

        if($this->input->get('timeFrom')){
            $time_from = $searching['timeFrom'];
        }

        if($this->input->get('timeTo')){
            $time_to = $searching['timeTo'];
        }

		$list_booking = $this->ghConsultantBooking->get([
		    'time_booking >= ' => strtotime($time_from),
		    'time_booking <= ' => strtotime($time_to) + 86399,
        ]);
        $list = $ranker = [];

        foreach ($list_booking as $booking) {
            if(!isset($ranker[$booking['booking_user_id']])) {
                $ranker[$booking['booking_user_id']] = 1;
            } else {
                $ranker[$booking['booking_user_id']] ++;
            }



            if(strlen($this->input->get('status'))){
                if(!($searching['status'] == $booking['status'])) {
                    continue;
                }
            }

            if(strlen($this->input->get('district'))){

                if(!($searching['district'] == $booking['district_code'])) {
                    continue;
                }
            }

            if(strlen($this->input->get('department'))){
                if($searching['department'] == 'VH'){
                    if(!in_array($booking['booking_user_id'], $this->arr_general))
                    continue;
                }

                if($searching['department'] == 'KD'){
                    if(in_array($booking['booking_user_id'], $this->arr_general))
                    continue;
                }
            }


            $list[] = $booking;
        }

        arsort($ranker);

		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('consultantbooking/showV2', [
            'list_booking' => $list,
            'time_from' => $time_from,
            'time_to' => $time_to,
            'label_apartment' => $this->config->item('label.apartment'),
            'cb_district' => $this->libDistrict->cbActive(),
            'ghApartment' => $this->ghApartment,
            'ghRoom' => $this->ghRoom,
            'libDistrict' => $this->libDistrict,
            'libUser' => $this->libUser,
            'libCustomer' => $this->libCustomer,
            'ranker' => $ranker
        ]);
		$this->load->view('components/footer');
	}

	public function chart(){
	    $data_post = $this->input->post();
        $time_from = date('d-m-Y', strtotime('last monday'));
        $time_to = date('d-m-Y', strtotime('sunday this week'));
	    if(strlen($this->input->post('timeFrom'))){
            $time_from = $data_post['timeFrom'];
        }

        if(strlen($this->input->post('timeTo'))){
            $time_to = $data_post['timeTo'];
        }

        $limit_point = 15;
        $list_booking = $this->ghConsultantBooking->get([
            'time_booking >=' => strtotime($time_from),
            'time_booking <=' => strtotime($time_to) + 86399,
        ]);



        $start = strtotime($time_from);
        $chart_data = [];
        $chart_data_boom = [];
        $chart_data_success = [];
        while(true) {
            $week_number = $this->libTime->weekOfMonth(date('d-m-Y', $start));
            $month_number = date('m', $start);
            $key_time = 'Tu.'.$week_number . " (Th.{$month_number})";
            $chart_data[$key_time] =[
                'book' => 0,
                'boom' => 0,
                'success' => 0,
            ];
            $start+= 86400;
            if($start > strtotime($time_to)) {
                break;
            }
        }

        foreach ($list_booking as $booking) {

            $week_number = $this->libTime->weekOfMonth(date('d-m-Y', $booking['time_booking']));
            $month_number = date('m', $booking['time_booking']);
            $key_time = 'Tu.'.$week_number . " (Th.{$month_number})";
            $chart_data[$key_time]['book']++;

            if($booking['status'] == 'Success') {
                $chart_data[$key_time]['success']++;
            }

            if($booking['status'] == 'Cancel') {
                $chart_data[$key_time]['boom']++;
            }
        }

        echo json_encode(['data' => $chart_data, 'counter' => count($list_booking)]);die;

    }

	public function getRoomId() {
		$apartment_id = $this->input->get('apartment_id');
		$room = $this->ghRoom->get(['apartment_id' => $apartment_id, 'active' => 'YES']);
		$result = [];
		foreach($room as $item) {
			$result[] = ["value" => $item['id'], "text" => $item["code"] . ' - '. $item["price"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function create(){
		$post = $this->input->post();
        $data = [];
        $data['ghApartment'] = $this->ghApartment;
        $data['ghRoom'] = $this->ghRoom;
        $data['libDistrict'] = $this->libDistrict;
        $data['libUser'] = $this->libUser;
        $data['libCustomer'] = $this->libCustomer;
        $data['select_district'] = $this->libDistrict->cbActive();
		if($post) {
            if($post['time_booking']) {
                if(empty($post['time_booking'])) {
                    $post['time_booking'] = null;
                } else {
                    $post['time_booking'] = str_replace('/', '-', $post['time_booking']);
                    $post['time_booking'] = strtotime((string)$post['time_booking']);
                }
            } else {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Vui lòng chọn ngày dẫn khách',
                    'status' => 'danger'
                ]);
			    return redirect('admin/create-new-consultant-booking?apartment-id='.$post['apartment_id'].'&district-code='.$post['district_code'].'&mode=create');
            }
            $customer_id = $post['customer_id'];
            if(!($customer_id > 0)) {
                if(empty($post['phone_number']) || empty($post['customer_name'])) {
                    $this->session->set_flashdata('fast_notify', [
                        'message' => 'Vui lòng nhập số điện thoại, Tên khách hàng nếu bạn dẫn khách mới',
                        'status' => 'danger'
                    ]);
                    return redirect('admin/create-new-consultant-booking?apartment-id='.$post['apartment_id'].'&district-code='.$post['district_code'].'&mode=create');

                }

                $customer['name'] = $post['customer_name'];
                $customer['gender'] = $post['gender'];
                $customer['birthdate'] = strlen($post['birthdate']) > 0 ? $this->libTime->unixTimeFormat($post['birthdate'])  : null;
                $customer['status'] = 'sinva-info-form';
                $customer['source'] = $post['source'];
                $customer['phone'] = $post['phone_number'];
                $customer['email'] = $post['email'];
                $customer['user_insert_id'] = $this->auth['account_id'];
                $customer['time_insert'] = time();
                $customer['demand_price'] = $post['demand_price'];
                $customer['demand_district_code'] = $post['demand_district_code'];
                $customer['demand_time'] = strlen($post['demand_time']) ? $this->libTime->unixTimeFormat($post['demand_time']) : null;
                $customer_id = $this->ghCustomer->insert($customer);
            }
            if($customer_id > 0) {
                $data_insert['customer_id'] = $customer_id;
                $data_insert['apartment_id'] = $post['apartment_id'];
                $data_insert['booking_user_id'] = $this->auth['account_id'];
                $data_insert['time_booking'] = $post['time_booking'];
                $data_insert['room_id'] = isset($post['room_id']) ? json_encode($post['room_id']):'[]';
                $data_insert['district_code'] = $post['district_code'];
                $data_insert['status'] = 'Pending';

                if($this->ghConsultantBooking->insert($data_insert)){
                    $this->session->set_flashdata('fast_notify', [
                        'message' => 'Tạo lượt book '.$data['name'].' thành công, Chúc bạn chốt cọc ngon lành!!! ',
                        'status' => 'gh-success'
                    ]);
                    return redirect($this->url_show_default);
                }
            } else {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Không cập nhật được thông tin khách hàng',
                    'status' => 'danger'
                ]);
                return redirect('admin/create-new-consultant-booking?apartment-id='.$post['apartment_id'].'&district-code='.$post['district_code'].'&mode=create');
            }

        }

		// send Email
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('consultantbooking/create', $data);
        $this->load->view('components/footer');
//        $this->sendEmailNotification($data);
	}

	public function updateEditable() {
		$customer_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($customer_id) and !empty($field_name)) {

			if($field_name == 'room_id') {
				$field_value = json_encode($field_value);
			}

            if($field_name == 'time_booking') {
                $field_value = $field_value ? strtotime($field_value) : null;
            }
			$data = [
				$field_name => $field_value
			];

			$old_customer = $this->ghConsultantBooking->get(['id' => $customer_id]);
			$old_log = json_encode($old_customer[0]);

			$result = $this->ghConsultantBooking->updateById($customer_id, $data);
			
			$modified_customer = $this->ghConsultantBooking->get(['id' => $customer_id]);
			$modified_log = json_encode($modified_customer[0]);
			
			$log = [
				'table_name' => 'gh_consultant_booking',
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


    private function sendEmailNotification($data){
	    $subject = '[GH] '.$this->auth['name']. 'Đã Book Phòng '. date('d/m/Y H:i',
                $data['time_booking']);

	    $apartment = $this->ghApartment->get(['id' =>$data['apartment_id']])[0];
        $data['room_id'] = json_decode($data['room_id']);

        $room_code = '';
        if(count($data['room_id']) > 0) {
            foreach ($data['room_id'] as $item) {
                $roomModel = $this->ghRoom->get(['id' => $item]);
                $room_code .= $roomModel ? $roomModel[0]['code'] . '  ' : '';

            }
        }
	    $content = '<strong>'.$this->auth['name'].'</strong> đã book ^&^';
	    $content .= ' [TEST] THÔNG TIN BOOK: <br>';
	    $content .= ' - DỰ ÁN: <strong style="color: orangered">'.$apartment['address_street'].'</strong> <br>';
	    $content .= ' - Mã Phòng: <strong style="color: darkgreen">'.$room_code.'</strong> <br>';

	    $content .= ' <p style="color: yellow">Simba Chúc Bạn & Team Bạn Nổ Bùm Bùm Hợp Đồng, Nổ Sập GH Luôn Ạ</p> ';


	    $list_recipient = [
	        [
	            'email' => 'tramanh.sinvaland@gmail.com',
                'name' => ' Chị TA'
            ],
            [
                'email' => 'qbingking@gmail.com',
                'name' => 'Quốc Bình'
            ]
        ];

        foreach ($list_recipient as $item) {
            $this->emailConfig($item['email'], $item['name'],$subject, $content );
        }



    }


	private function emailConfig($mail_to = null, $name_to = null , $subject = null, $content = null)
    {
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'mynameismrbinh@gmail.com';                     // SMTP username
            $mail->Password   = 'xanhdotimvang';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('mynameismrbinh@gmail.com', 'I am Simba');
            $mail->addAddress($mail_to, $name_to);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $success = $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */