<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
require_once FCPATH . 'modules/hr/core/HR_Controller.php';
class Api extends HR_Controller
{

	function index()
	{
		echo 'Ciuis HR Module RestAPI Service';
	}


	function payrolls()
	{
		$payrolls = array();
		if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
			$payrolls = $this->Payrolls_Model->get_all_payroll_by_privilege();
		} else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
			$payrolls = $this->Payrolls_Model->get_all_payroll_by_privilege($this->session->usr_id);
		}
		$data_payrolls = array();
		foreach ($payrolls as $payroll) {
			$data_payrolls[] = array(
				'payroll_id' => $payroll['payroll_id'],
				'payroll_number' => $payroll['payroll_number'],
				'payroll_staff_number' => $payroll['staff_number'],
				'payroll_staff_name' => $payroll['staffmembername'],
				'payroll_start_date' => date(get_dateFormat(), strtotime($payroll['payroll_start_date'])),
				'payroll_start_date_stamp' => strtotime($payroll['payroll_start_date']),
				'payroll_end_date' => date(get_dateFormat(), strtotime($payroll['payroll_end_date'])),
				'payroll_end_date_stamp' => strtotime($payroll['payroll_end_date']),
				'payroll_base_salary' => $payroll['payroll_base_salary'],
				'payroll_base_salary_float' => floatval($payroll['payroll_base_salary']),
				'payroll_grand_total' => $payroll['payroll_grand_total'],
				'payroll_grand_total_float' => floatval($payroll['payroll_grand_total']),
			);
		}
		echo json_encode($data_payrolls);
	}

	function payslips()
	{
		$payslips = array();
		if ($this->Privileges_Model->check_privilege('payslips', 'all')) {
			$payslips = $this->Payslips_Model->get_all_payslip_by_privilege();
		} else if ($this->Privileges_Model->check_privilege('payslips', 'own')) {
			$payslips = $this->Payslips_Model->get_all_payslip_by_privilege($this->session->usr_id);
		}
		$data_payslips = array();
		foreach ($payslips as $payslip) {
			$data_payslips[] = array(
				'payslip_id' => $payslip['payslip_id'],
				'payslip_number' => $payslip['payslip_number'],
				'payslip_staff_id' => $payslip['staff_number'],
				'payslip_staff_name' => $payslip['staffmembername'],
				'payslip_start_date' => date(get_dateFormat(), strtotime($payslip['payslip_start_date'])),
				'payslip_start_date_stamp' => strtotime($payslip['payslip_start_date']),
				'payslip_end_date' => date(get_dateFormat(), strtotime($payslip['payslip_end_date'])),
				'payslip_end_date_stamp' => strtotime($payslip['payslip_end_date']),
				'payslip_base_salary' => $payslip['payslip_base_salary'],
				'payslip_base_salary_float' => floatval($payslip['payslip_base_salary']),
			);
		}
		echo json_encode($data_payslips);
	}
}
