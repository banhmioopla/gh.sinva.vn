<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibFinance {
    public $CI;

    const ROLE_ADMIN = 'admin';
    const ROLE_PM = 'product-manager';
    const ROLE_CONSULTANT = 'consultant';
    const ROLE_HUMAN_RESOURCES = 'human-resources';
    const ROLE_CC = 'customer-care';
    const ROLE_MARKETING_MANAGER = 'marketing-manager';
    const ROLE_TEAM_LEADER = 'team-leader';
    const ROLE_PRODUCT_CEO = 'product-ceo';
    const ROLE_CEO = 'ceo';
    const ROLE_BUSINESS_MANAGER = 'business-manager';
    const ROLE_DEVELOPER = 'developer';
    const ROLE_COLLABORATORS = 'collaborators';
    const ROLE_COO = 'coo';

    const PARTIAL_BUSINESS_RATE = 0.6;
    const PARTIAL_CD_RATE = 0.4;
    const INCOME_RATE_COLLABORATORS = 0.4;
    const INCOME_RATE_COLLABORATORS_RECEIVING_CUSTOMER = 0.2;
    const INCOME_RATE_COLLABORATORS_PASSING_CUSTOMER = 0.4;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model([
            'ghUser',
            'ghContract',
            'ghApartment',
            'ghRoom',
            'ghUserIncomeDetail',
            'ghContractCollaborators'
        ]);

        $this->CI->load->config('internal_mechanism_income_rate_control_department.php');
        $this->CI->load->config('internal_mechanism_income_rate.php');

    }

    public function getTotalSale($time_from, $time_to) {
        $list_contract = $this->CI->ghContract->get(['time_insert >=' => strtotime($time_from), 'time_insert <=' => strtotime($time_to) + 86399]);

        $output = [
            'total_sale' => 0,
            'contract_qtt' => count($list_contract),
        ];
        foreach ($list_contract as $item) {
            $output['total_sale'] += (double) $item['room_price'] * $item['commission_rate']/100;
        }

        return [
            'status' => true,
            'data' => $output
        ];
    }


    public function getPartialBigSumSale($time_from, $time_to) {
        $total_sale = $this->getTotalSale($time_from, $time_to);
        $total = $total_sale['data']['total_sale'];
        return [
            'status' => true,
            'data' => [
                'sale' => [
                    'business' => (double) $total * self::PARTIAL_BUSINESS_RATE,
                    'cd' => (double) $total * self::PARTIAL_CD_RATE,
                    'total' => $total
                ],
            ]
        ];
    }


    public function getIncomeMechanismByRole($role_code)
    {
        $income_matching = [];
        $mechanism_CD = $this->CI->config->item('internal_mechanism_income_rate_control_department');
        $mechanism_general = $this->CI->config->item('internal_mechanism_income_rate');

        switch ($role_code) {
            case self::ROLE_PM:
            case self::ROLE_CC:
            case self::ROLE_CONSULTANT:
                $income_matching = $mechanism_general["index_consultant"];
                break;

            default:
                return [
                    'status' => false,
                    'data' => [],
                ];
        }

        return [
            'status' => true,
            'data' => [
                'role_code' => $role_code,
                'statistics' => $income_matching
            ]
        ];
    }

    public function getIncomeCollaborator($time_from, $time_to, $account_id) {
        $list_contract = $this->CI->ghContract->get([
            'time_insert >=' => strtotime($time_from),
            'time_insert <=' => strtotime($time_to) + 86399,
            "consultant_id" => $account_id,
        ]);
        $output = [
            'total_sale' => 0, // Doanh Thu
            'contract_qtt' => 0,
            'total_income' => 0,
            'description' => "",
        ];

        foreach ($list_contract as $item) {
            $contract_total_sale = (double) $item['room_price'] * $item['commission_rate']/100;
            $collaborator = $this->CI->ghContractCollaborators->getFirstByContractId($item['id']);
            $type = '';
            $rate = 0;
            if($collaborator) {
                $type = $collaborator['type']; //
            }

            if($type == $this->CI->ghContractCollaborators::TYPE_RECEIVING_CUSTOMER) {
                $rate = self::INCOME_RATE_COLLABORATORS_RECEIVING_CUSTOMER;
            }

            if($type == $this->CI->ghContractCollaborators::TYPE_PASSING_CUSTOMER) {
                $rate = self::INCOME_RATE_COLLABORATORS_PASSING_CUSTOMER;
            }

            if($type == $this->CI->ghContractCollaborators::TYPE_NONE) {
                $rate = self::INCOME_RATE_COLLABORATORS;
            }

            $income_contract = $contract_total_sale * $rate;
        }

        return [
            'status' => true,
            'data' => $output
        ];
    }

    public function getPersonalIncome($account_id, $time_from, $time_to) {
        $user = $this->CI->ghUser->getFirstByAccountid($account_id);
        switch ($user['role_code']) {
            case self::ROLE_CONSULTANT:

                break;
        }

    }
}
?>