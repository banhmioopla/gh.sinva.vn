<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Fee extends CustomBaseStep {

    const INCOME_TYPE_CONTRACT = 'Contract';
    const INCOME_TYPE_CONTRACT_SUPPORTER = 'ContractSupporter';
    const INCOME_TYPE_PENALTY = 'Penalty';
    const INCOME_TYPE_REFER_USER = 'ReferUser';
    const INCOME_TYPE_GET_NEW_APARTMENT = 'GetNewApartment';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghService');
        $this->load->model('ghIncomeContract');
        $this->load->model('ghUserPenalty');
        $this->load->model('ghContract');
        $this->load->model('ghApartment');
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->model('ghConsultantBooking');
        $this->load->model('ghCustomer');
        $this->load->model('ghRoom');
        $this->load->model('ghUserIncomeDetail');
        $this->load->model('ghUserCumulativeSale');
        $this->load->model('ghPublicConsultingPost');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibPhone', null, 'libPhone');
        $this->load->library('LibTime', null, 'libTime');
        $this->load->library('LibPenalty', null, 'libPenalty');
        $this->load->library('LibCustomer', null, 'libCustomer');
        $this->load->config('internal_mechanism_income_rate_control_department.php');
        $this->load->config('internal_mechanism_income_rate.php');
        $this->load->config('label.apartment');

        $this->rate_personal_consultant_support_id = 0.7;
        $this->rate_personal_is_support_control = 0.9;
        $this->refer_rate = 0.05;
        $this->get_new_apartment_rate = 0.03;
    }


    public function showPersonalProfile(){
        $current_url = $_SERVER["REQUEST_URI"];
        $pos = strpos($current_url, '?');
        if(!$this->input->get('from-month')) {
            if($pos === false ) {
                return redirect($current_url.'?from-month='.date('m'));
            } else {
                return redirect($current_url.'&from-month='.date('m'));
            }
        }

        if(!$this->input->get('account_id')) {
            $user = $this->ghUser->getFirstByAccountId($this->auth['account_id']);
        } else {
            $user = $this->ghUser->getFirstByAccountId($this->input->get('account_id'));
        }

        $list_role = $this->ghRole->get([
            'is_control_department' => 'YES'
        ]);

        $data = $this->getTotalContract();

        $arr_is_control_department = [];
        foreach ($list_role as $item) {
            $arr_is_control_department[] = $item['code'];
        }
        $this_month = $this->input->get('from-month');
        $year = date('Y');

        $last_date = cal_days_in_month(CAL_GREGORIAN, $this_month, $year);

        $time_start = '01-'.$this_month.'-'.$year;
        $time_end = $last_date.'-'.$this_month.'-'.$year;
        $view_data_income[$user['account_id']] =
            $this->syncPersonalIncome($user['account_id'], $data['quantity'], $data['total_sale'], $time_start, $time_end);


        $personal_penalty = $this->ghUserPenalty->get(['user_penalty_id' =>
            $user['account_id'], 'time_insert >= ' => strtotime($time_start) ]);


        $list_contract = $this->ghContract->get(['consultant_id' => $user['account_id']]);
        $list_booking = $this->ghConsultantBooking->get(['booking_user_id' => $user['account_id']]);
        $list_customer = [];

        $list_customer_id = [];
        foreach ($list_contract as $c) {
            $customer = $this->ghCustomer->get(['id' => $c['customer_id']]);
            if(count($customer)) {
                if(!in_array((string)$c['customer_id'], $list_customer_id)) {
                    $list_customer_id[] = $c['customer_id'];
                    $list_customer [] = $customer[0];
                }
            }
        }

        foreach ($list_booking as $c) {
            $customer = $this->ghCustomer->get(['id' => $c['customer_id']]);
            if(count($customer)) {
                if(!in_array((string)$c['customer_id'], $list_customer_id)) {
                    $list_customer [] = $customer[0];
                    $list_customer_id[] = $c['customer_id'];
                }
            }
        }
        usort($list_customer, function ($item1, $item2) {
            return $item2['id'] <=> $item1['id'];
        });

        usort($list_booking, function ($item1, $item2) {
            return $item2['time_booking'] <=> $item1['time_booking'];
        });

        usort($list_contract, function ($item1, $item2) {
            return $item2['id'] <=> $item1['id'];
        });

        $list_consultant_post = $this->ghPublicConsultingPost->get(['user_create_id' => $user['account_id']]);



        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('fee/show-personal-profile', [
            'list_user_income' => $view_data_income,
            'libUser' => $this->libUser,
            'list_consultant_post' => $list_consultant_post,
            'total_sale' => $data['total_sale'],
            'quantity_contract' => $data['quantity'],
            'personal_penalty' => $personal_penalty,
            'libPenalty' => $this->libPenalty,
            'libCustomer' => $this->libCustomer,
            'libPhone' => $this->libPhone,
            'list_contract' => $list_contract,
            'list_customer' => $list_customer,
            'list_booking' => $list_booking,
            'ghRoom' => $this->ghRoom,
            'ghApartment' => $this->ghApartment,
            'ghConsultantBooking' => $this->ghConsultantBooking,
            'label_apartment' => $this->config->item('label.apartment'),
            'user' => $user,
            'role' => $this->ghRole->get(['code' => $user['role_code']])[0]

        ]);
        $this->load->view('components/footer');
    }


    public function showOverviewIncome(){
        if(empty($this->input->get('month'))) {
            return redirect('/admin/list-fee-contract-income?month='.date('m'));
        }
        $list_user = $this->ghUser->get([
            'active' => 'YES',
            'account_id >=' => 171020000
        ]);
        $list_role_cd = $this->ghRole->get([
            'is_control_department' => 'YES'
        ]);

        $metric_contract = $this->getTotalContract();

        $arr_is_control_department = [];
        foreach ($list_role_cd as $item) {
            $arr_is_control_department[] = $item['code'];
        }
        $this_month = $this->input->get('month');
        $year = date('Y');

        $last_date = cal_days_in_month(CAL_GREGORIAN, $this_month, $year);

        $time_start = '01-'.$this_month.'-'.$year;
        $time_end = $last_date.'-'.$this_month.'-'.$year;

        $view_data_income = [];
        foreach ($list_user as $user) {
            $view_data_income[$user['account_id']] =
                $this->syncPersonalIncome($user['account_id'],
                    $metric_contract['quantity'],
                    $metric_contract['total_sale'],
                    $time_start,
                    $time_end);
        }

        $this->load->view('components/header');
        $this->load->view('fee/show-overview-income', [
            'list_user_income' => $view_data_income,
            'libUser' => $this->libUser,
            'total_sale' => $metric_contract['total_sale'],
            'quantity_contract' => $metric_contract['quantity'],
            'list_user_sale' => $metric_contract['sale_department'],
            'list_user_cd' => $metric_contract['control_department'],
            'arr_account_id_sale' => $metric_contract['arr_account_id_sale'],
            'arr_account_id_cd' => $metric_contract['arr_account_id_cd'],

        ]);
        $this->load->view('components/footer');
    }

    public function buildChart(){
        $time_from = '01-01-2021';
        $time_to = date('d-m-Y');
        $chart_data = [['Tháng', 'Doanh Thu', 'Thành Viên']];

        $int_time_from = strtotime($time_from);
        $int_time_to = strtotime($time_to);

        $temp = $int_time_from;

        while($temp <= $int_time_to+86399) {
            $last_date = cal_days_in_month(CAL_GREGORIAN, date('m', $temp), "2021");

            $user = $this->ghUser->get(['time_joined <= ' => $temp]);
            $contract = $this->ghContract->get(['time_check_in <=' => $temp+86400*$last_date, 'time_check_in >=' => $temp]);
            $total_sale = 0;
            foreach ($contract as $c) {
                $total_sale += (int) ($c['room_price'] * $c['commission_rate'] / 100) / 1000000;
            }

            $chart_data[] = [ 'tháng '. date('m', $temp), $total_sale ,count($user)];

            $temp += 86400*$last_date;
        }
        echo json_encode(['chart'=> $chart_data, 'from_date' => $time_from, 'to_date' => $time_to]); die;
    }

    private function getNumberOfMonth($date1, $date2) {
        $date1 = '2000-01-25';
        $date2 = '2010-02-20';
        $d1=new DateTime($date2);
        $d2=new DateTime($date1);
        $Months = $d2->diff($d1);
        $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
    }



    public function showUserCumulativeSale(){
        $list_user = $this->ghUser->get(['active' => 'YES', 'account_id >=' => 171020000 ]);


        $this->load->view('components/header');
        $this->load->view('fee/show-user-cumulative-sale', [
            'list_user' => $list_user,
            'ghUserCumulativeSale' => $this->ghUserCumulativeSale
        ]);
        $this->load->view('components/footer');
    }

    public function updateUserCumulativeSaleEditable(){
        $user_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($user_id) and !empty($field_name)) {

            $data = [
                $field_name => $field_value
            ];
            $old_user = $this->ghUserCumulativeSale->getByUserId($user_id);
            if($old_user) {
                $result = $this->ghUserCumulativeSale->updateByUserId($user_id, $data);
            } else {
                $result = $this->ghUserCumulativeSale->insert([
                    'user_id' => $user_id,
                    $field_name => $field_value
                ]);
            }
            $old_log = count($old_user) ? json_encode($old_user[0]): '';

            $modified_user = $this->ghUserCumulativeSale->getByUserId($user_id);
            $modified_log = json_encode($modified_user[0]);

            $log = [
                'table_name' => 'gh_user_cumulative_sale',
                'old_content' => $old_log,
                'modified_content' => $modified_log,
                'time_insert' => time(),
                'action' => 'update'
            ];
            $this->ghActivityTrack->insert($log);

            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }


    /*Tổng doanh số bpkd*/
    private function getTotalContract() {
        $list_user = $this->ghUser->get(['account_id >=' => 171020000, 'active' => 'YES']);
        $list_role_sale = $this->ghRole->get(['is_control_department' => 'NO']);
        $arr_account_id = [];
        $arr_account_id_cd = [];
        $arr_user = [];
        $arr_user_cd = [];
        $arr_role = [];

        foreach ($list_role_sale as $item) {
            $arr_role[] = $item['code'];
        }
        foreach ($list_user as $item) {
            if(in_array($item['role_code'], $arr_role) && !in_array
                ($item['account_id'], $this->arr_general)) {
                $arr_account_id[] = $item['account_id'];
                $arr_user[] = $item;
            } else {
                $arr_user_cd[] = $item;
                $arr_account_id_cd[] = $item['account_id'];
            }
        }

        $last_date = $this->libTime->calDayInMonthThisYear(date('m'));
        $start_date = date('01-m-Y');
        $end_date = date($last_date.'-m-Y');


        $list_contract = $this->ghContract->get([
            'time_insert >=' => strtotime($start_date),
            'time_insert <=' => strtotime($end_date) + 86399,
        ]);

        $result = [
            'quantity' => 0,
            'total_sale' => 0,
            'sale_department' => $arr_user,
            'control_department' => $arr_user,
            'arr_account_id_sale' => $arr_account_id,
            'arr_account_id_cd' => $arr_account_id_cd
         ];
        foreach ($list_contract as $item) {
            if(in_array($item['consultant_id'], $arr_account_id)) {
                $result['total_sale'] += $item['room_price'] * (double)$item['commission_rate']/100;
                $result['quantity'] ++;
            }
        }
        return $result;
    }

    /*Cơ chế mới cho mỗi thành viên*/
    private function syncPersonalIncome($user_id = null, $total_contract = 0, $total_sale = 0,
                                                     $start_time, $end_time
    ) {
        $cd_config = $this->config->item('internal_mechanism_income_rate_control_department');
        $sale_config = $this->config->item('internal_mechanism_income_rate');

        /*Tổng doanh số cho vận hành*/
        $total_sale_for_cd = $total_sale * (double)
            $cd_config['total_sale_sinva']['basic_control_department'] / 100;

        /*Tổng số lượng hợp đồng bpkd*/
        $round_contract_to_compare = $total_contract;
        $description = "";

        $start_date = $start_time;
        $end_date = $end_time;


        $list_contract = $this->ghContract->get([
            'time_insert >=' => strtotime($start_date),
            'time_insert <=' => strtotime($end_date),
        ]);

        /*Tính Doanh Số, Số lượng HD Của 1 TV*/
        $total_user_contract = 0;
        $total_sale_sinva = 0;
        foreach ($list_contract as $item) {
            if($item['consultant_id'] === $user_id) {
                $total_user_contract ++;
                $total_sale_sinva += (double)$item['room_price'] * $item['commission_rate'] / 100;
            }
        }

        $user = $this->ghUser->get(['account_id' => $user_id])[0];
        $user_role = $this->ghRole->get(['code' => $user['role_code']])[0];

        $result['rate'] = 0;
        $is_cd = false;
        $mapping_cd = [];

        /*Thuộc VH*/
        if($user_role['is_control_department'] == "YES") {
            $description = "(1) Vận Hành <br>";
            $is_cd = true;

            /*Vận Hành Chung*/
            if(in_array($user['account_id'], $this->arr_general)) {
                $description = "(1) Vận Hành Chung <br>";
                $mapping_cd = $cd_config['index_extra_general'];
            } else {
                /*Không thuộc vận hành chung*/
                $mapping_cd = $cd_config['index_extra_' . $user['role_code']];
            }
        }

        if(in_array($user['account_id'], $this->arr_general)) {
            $is_cd = true;
            $mapping_cd = $cd_config['index_extra_general'];
            $description = "(1) Vận Hành Chung <br>";
        }


        $max_room_price = 0;
        $max_number_of_month = 0;
        $max_contract_id = 0;
        $max_consultant_support_id = 0;
        $max_is_support_control = "NO";
        $max_time_apply = null;
        $max_consultant_id = 0;
        $temp1 = 0;
        $total_b1 = 0;
        $total_b2 = 0;
        $total_personal_income = 0;
        $extra_rate_cd = 0;
        if($is_cd) {

            /*Cơ bản => Vận hành*/
            foreach($mapping_cd as $item) {
                if($item['quantity_min'] <= $round_contract_to_compare && $round_contract_to_compare >= $item['quantity_max']) {
                    $extra_rate_cd = $item['rate'];
                    break;
                }
            }
            $sub_description = "(2) Tỉ lệ cơ bản: ".$extra_rate_cd."% <br>";

            /*(1) - CƠ BẢN*/
            $total_extra_personal_income = $extra_rate_cd * (double)$total_sale_for_cd
                / count($this->arr_general);
            $sub_description .= " Cơ Bản = " . $total_extra_personal_income . "<br>";

            /*(2) - Hợp Đồng B1 -- HD có doanh số cao nhất*/
            foreach ($list_contract as $item) {
                if($item['consultant_id'] !== $user_id) {
                    continue;
                }

                if($item['room_price'] * $item['commission_rate'] >= $temp1) {
                    $temp1 = $item['room_price'] * $item['commission_rate'];
                    $max_room_price = $item['room_price'];
                    $max_number_of_month = $item['number_of_month'];
                    $max_contract_id = $item['id'];
                    $max_consultant_support_id = $item['consultant_support_id'];
                    $max_is_support_control = $item['is_support_control'];
                    $max_time_apply = $item['time_insert'];
                    $max_consultant_id  = $item['consultant_id'];
                }
            }
            $sub_description .= "(3) HĐ cao nhất: $max_room_price ($max_number_of_month tháng) <br>";
            /*So khớp với bảng B1*/
            foreach ($cd_config['index_master_b1'] as $b1) {
                if($max_room_price > $b1['room_price_min'] && $max_room_price <= $b1['room_price_max']) {
                    $total_b1 = $b1['income_unit'] * $max_number_of_month;
                    if($max_consultant_support_id >= 171020000) {
                        $total_b1 = (double) $total_b1 * 0.7;
                    }

                    if($max_is_support_control == 'YES') {
                        $total_b1 = (double) $total_b1 * 0.9;
                    }
                    $sub_description .= "(4) B1: $max_number_of_month th x " .$b1['income_unit']." = ". $total_b1 .
                        "<br>";

                    if($max_contract_id > 0) {
                        $this->updateToIncomeContract([
                            'contract_id' => $max_contract_id,
                            'contract_income_total' => $total_b1,
                            'apply_time' => $max_time_apply,
                            'type' => self::INCOME_TYPE_CONTRACT,
                            'user_id' => $max_consultant_id
                        ]);
                    }

                    break;
                }
            }


            /*Bảng B2*/
            $sub_description .= " (5) B2: |Chi tiết hợp đồng nhỏ| <br>";
            foreach ($list_contract as $item) {
                if(!$this->isValidPersonalContract($item, $user_id)) {
                    continue;
                }
                if($item['id'] === $max_contract_id) {
                    continue;
                }

                foreach ($cd_config['index_master_b2'] as $b2) {
                    if($item['room_price'] >= $b2['room_price_min'] && $item['room_price'] < $b2['room_price_max']) {
                        $temp_income =  $b2['income_unit'] * $item['number_of_month'];
                        if($item['consultant_id'] == $user_id) {
                            if($item['consultant_support_id'] >= 171020000) {
                                $temp_income -= (double) $temp_income * 0.3;
                            }

                            if($item['is_support_control'] == 'YES') {
                                $temp_income -= (double) $temp_income * 0.1;
                            }
                            $total_b2 += $temp_income;

                            $this->updateToIncomeContract([
                                'contract_id' => $item['id'],
                                'contract_income_total' => (double)$temp_income,
                                'apply_time' => $item['time_insert'],
                                'type' => self::INCOME_TYPE_CONTRACT,
                                'user_id' => $item['consultant_id']
                            ]);
                        }

                        if($item['consultant_support_id'] == $user_id) {
                            $isB1 = $this->isB1($item, strtotime($start_date), strtotime($end_date)+86399);

                            if($isB1['status'] === true){
                                $partner_support  = $isB1['total_income'] * 0.3;
                                $total_b2 += $partner_support;
                            } else {
                                $partner_support  = $isB1['total_income'] * 0.3;
                                $total_b2 += (double)$temp_income * 0.3;
                            }

                            $this->updateToIncomeContract([
                                'contract_id' => $item['id'],
                                'contract_income_total' => (double)$partner_support,
                                'apply_time' => $item['time_insert'],
                                'type' => self::INCOME_TYPE_CONTRACT_SUPPORTER,
                                'user_id' => $item['consultant_support_id']
                            ]);
                        }
                        break;
                    }
                }
            }
            $sub_description .= "<br>";

            /*Kiểm tra - có phải vận hành chung hay ko ?*/
            if(in_array($user['account_id'], $this->arr_general)) {
                $total_personal_income = $total_b1 + $total_b2 + $total_extra_personal_income;
            } else {
                $total_personal_income = $total_extra_personal_income;
            }
            $sub_description .= "Tổng Thu Nhập Cá Nhân = " . $total_personal_income;
            $description = $sub_description;
        } else {
            /*Thu nhập cho không phải BPVH */
            $mapping_sale = isset($sale_config['index_' . $user['role_code']]) ?
                $sale_config['index_' . $user['role_code']] : null;
            $rate = 0;
            if(is_array ($mapping_sale)) {
                foreach($mapping_sale as $item) {
                    if($item['quantity_max'] > $total_user_contract &&
                        $item['quantity_min'] <= $total_user_contract) {
                        $rate = $item['rate'];
                        break;
                    }
                }
            }

            foreach ($list_contract as $item) {
                if(!$this->isValidPersonalContract($item, $user_id)) {
                    continue;
                }
                $temp_income = $item['room_price'] * (double)
                    ($item['commission_rate'] * $rate / 10000);

                if($item['consultant_id'] == $user_id) {
                    if($item['consultant_support_id'] >= 171020000) {
                        $temp_income -= (double) $temp_income * 0.3;
                    }

                    if($item['is_support_control'] == 'YES') {
                        $temp_income -= (double) $temp_income * 0.1;
                    }
                }

                if($item['consultant_support_id'] == $user_id) {
                    $temp_support_income = (double)$temp_income * 0.3;
                    $temp_income += $temp_support_income;
                    $this->updateToIncomeContract([
                        'contract_id' => $item['id'],
                        'contract_income_total' => $temp_support_income,
                        'apply_time' => $item['time_insert'],
                        'type' => self::INCOME_TYPE_CONTRACT,
                        'user_id' => $item['consultant_support_id']
                    ]);
                }

                $total_personal_income += $temp_income;
                $this->updateToIncomeContract([
                    'contract_id' => $item['id'],
                    'contract_income_total' => $temp_income,
                    'apply_time' => $item['time_insert'],
                    'type' => self::INCOME_TYPE_CONTRACT,
                    'user_id' => $item['consultant_id']
                ]);
            }
        }

        /*Thu Nhập từ việc tuyển dụng*/
        $this_ref_total_income = (double) $this->getTotalSaleRefer($user_id, $start_time, $end_time);
        if($this_ref_total_income > 0) {
            $this->updateToReferIncomeContract([
                'user_id' => $user_id,
                'contract_income_total' => $this_ref_total_income,
                'type' => self::INCOME_TYPE_REFER_USER,
                'apply_time' => strtotime($start_time)
            ]);
        }


        $this_get_new_apartment_total = (double) $this->getTotalSaleGetNewApartment($user_id,$start_time, $end_time) * $this->get_new_apartment_rate;
        $total_personal_income += $this_ref_total_income + $this_get_new_apartment_total;
        return [
            'quantity_contract' => $total_user_contract,
            'total_sale' => $total_sale_sinva,
            'total_personal_income' => $total_personal_income,
            'total_refer_income' => $this_ref_total_income,
            'total_get_new_apartment_total' => $this_get_new_apartment_total,
            'description_income' => $description,
        ];
    }

    private function getTotalSaleGetNewApartment($user_id, $start_time, $end_time){
        $apartment = $this->ghApartment->get(['user_collected_id' => $user_id, 'time_insert >=' => $start_time]);
        $total = 0;
        if(count($apartment)) {
            foreach ($apartment as $a) {
                $contract = $this->ghContract->get(['apartment_id' => $a['id'], 'time_check_in >=' => strtotime($start_time), 'time_check_in <=' => strtotime($end_time)]);
                $sale_of_apartment = 0;
                if(count($contract)) {
                    foreach ($contract as $c) {
                        $temp_sale = (double)$c['room_price']*$c['commission_rate']*$this->get_new_apartment_rate;
                        $total += $temp_sale;
                        $sale_of_apartment+= $temp_sale;
                    }
                }
                $this->updateToGetNewApartment([
                    'user_id' => $user_id,
                    'apartment_id' => $a['id'],
                    'contract_income_total' => $sale_of_apartment,
                    'type' => self::INCOME_TYPE_GET_NEW_APARTMENT,
                    'apply_time' => $a['time_insert']
                ]);
            }
        }
        return $total;

    }

    private function updateToIncomeContract($data){
        $model = $this->ghUserIncomeDetail->getByUserIdAndContractId($data['user_id'],$data['contract_id']);
        if(count($model)) {
            $this->ghUserIncomeDetail->updateById($model[0]['id'], $data);
        }else {
            $this->ghUserIncomeDetail->insert($data);
        }

    }
    private function updateToGetNewApartment($data){
        $model = $this->ghUserIncomeDetail->getByUserIdAndApartmentId($data['user_id'], $data['apartment_id']);
        if(count($model)) {
            $this->ghUserIncomeDetail->updateById($model[0]['id'], $data);
        }else {
            $this->ghUserIncomeDetail->insert($data);
        }

    }

    private function updateToReferIncomeContract($data){
        $model = $this->ghUserIncomeDetail->getByUserIdAndTimeApply($data['user_id'], strtotime($data['apply_time']));
        if(count($model)) {
            $this->ghUserIncomeDetail->updateById($model[0]['id'], $data);
        }else {
            $this->ghUserIncomeDetail->insert($data);
        }

    }

    private function getTotalSaleRefer($user_id, $start_time, $end_time){
        $list_user = $this->ghUser->get([
            'account_id >=' => 171020000,
            'user_refer_id' => $user_id
        ]);
        $total = 0;
        foreach ($list_user as $item) {
            $list_contract = $this->ghContract->get([
                'consultant_id' => $item['account_id'],
                'time_check_in >=' => strtotime($start_time),
                'time_check_in <=' => strtotime($end_time),

            ]);
            if(count($list_contract)) {
                foreach ($list_contract as $c) {
                    $total += (double)$c['room_price']*$c['commission_rate']/100*$this->refer_rate;
                }
            }
        }

        return $total;

    }

    private function array_value_recursive($key, array $arr){
        $val = [];
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : [array_pop($val)];
    }

    private function isValidPersonalContract($contract, $user_id) {
        if(($contract['consultant_id'] == $user_id ||
            $contract['consultant_support_id'] == $user_id))
            return true;

        return false;
    }

    private function isB1($contract, $start, $end){
        $list_contract = $this->ghContract->get([
            'consultant_id' => $contract['consultant_id'],
            'time_check_in >=' => $start,
            'time_check_in <=' => $end,
        ]);
        $cd_config = $this->config->item('internal_mechanism_income_rate_control_department');
        $sale_config = $this->config->item('internal_mechanism_income_rate');
        if(count($list_contract) == 1) {
            foreach ($cd_config['index_master_b1'] as $b1) {
                if($contract['room_price'] > $b1['room_price_min'] && $contract['room_price'] <= $b1['room_price_max']) {
                    $total_income = $b1['income_unit'] * $contract['number_of_month'];
                    return ['status' => true, 'total_income' => $total_income];
                }
            }
        }
        if(count($list_contract) > 1){
            $max_value = 0;
            $max_value_id = 0;
            $max_room_price=0;
            $max_month = 0;
            foreach ($list_contract as $item) {
                if($item['room_price'] * $item['commission_rate'] > $max_value) {
                    $max_value = $item['room_price'] * $item['commission_rate'];
                    $max_value_id = $item['id'];
                    $max_room_price = $item['room_price'];
                    $max_month = $item['number_of_month'];
                }
            }
            if($max_value_id ===$contract['id']){
                foreach ($cd_config['index_master_b1'] as $b1) {
                    if($max_room_price > $b1['room_price_min'] && $max_room_price <= $b1['room_price_max']) {
                        $total_income = $b1['income_unit'] * $max_month;
                        return ['status' => true, 'total_income' => $total_income];
                    }
                }
            }
        }
        return ['status' => false];
    }

    public function sendEmailNotificationPersonalIncome(){
        $user_to_account = $this->input->get('uid');
        $user_to = $this->ghUser->getFirstByAccountId($user_to_account);
        $this->load->library('LibEmail', null, 'libEmail');
        $data_income = $this->ghUserIncomeDetail->get(['user_id' => $user_to_account]);
        $total = 0;
        if(count($data_income)) {
            foreach ($data_income as $income) {
                $total += $income['contract_income_total'];
            }
        }
        $contentEmail = $this->libEmail->contentNotificationPersonalIncome();
//        echo $contentEmail; die;
        $contentEmail = str_replace('|||NOTIFICATION_TITLE|||', 'Báo Cáo Thu Nhập Cá Nhân GH*SINVA*VN'.date('m/Y'), $contentEmail);
        $contentEmail = str_replace('|||NOTIFICATION_CONTENT|||', 'GH*SINVA*VN Cám Ơn Nỗ Lực Hết Sức Mình Của *** '.$user_to['name'].' *** Trong Tháng'.date('m/Y') , $contentEmail);
        $contentEmail = str_replace('|||TOTAL_INCOME|||', number_format($total), $contentEmail);
        if($user_to['email']) {
            $this->libEmail->sendEmailFromServer($user_to['email'], $user_to['name'], 'GHSINVAVN - T.Báo TNCN '.$user_to['name'], $contentEmail);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Gửi email đến <strong>'.$user_to['email'].'</strong> thành công',
                'status' => 'success'
            ]);
        }

        return redirect('/admin/list-fee-contract-income?month='.date('m'));
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */