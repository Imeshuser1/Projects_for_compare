<?php
include APPPATH . '/third_party/vendor/autoload.php';

use Dompdf\Dompdf;

class Payslips_Model extends CI_Model
{
	public $status_of_adding = null;
	function __construct()
	{
		parent::__construct();
	}

	function get_all_payslip_by_privilege($staff_id = '')
	{
		$this->db->select('*,staff.staffname as staffmembername, staff.staffavatar as staffmemberresim, staff.id as id');
		$this->db->join('staff', 'payslips.payslip_relation_id = staff.id', 'left');
		$this->db->order_by('payslips.payslip_id', 'desc');
		if ($staff_id) {
			return $this->db->get_where('payslips', array('payslips.payslip_relation_id' => $staff_id))->result_array();
		} else {
			return $this->db->get_where('payslips', array(''))->result_array();
		}
	}

	function get_payslip_detail_by_privilege($id, $staff_id = '')
	{
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim, staff.id as id');
		$this->db->join('staff', 'staff.id = payslips.payslip_relation_id ', 'left');
		$this->db->join('departments', 'staff.department_id = departments.id', 'left');
		if ($staff_id) {
			return $this->db->get_where('payslips', array('payslips.payslip_id' => $id, 'payslips.payslip_relation_id' => $this->session->usr_id))->row_array();
		} else {
			return $this->db->get_where('payslips', array('payslips.payslip_id' => $id))->row_array();
		}
	}

	function get_payslip_items($type, $id)
	{
		$results = $this->db->select('*')->get_where('payslip_item', array('relation_id' => $id, 'payslip_item_type' => $type))->result_array();
		$data = array();
		foreach($results as $result){
			if($result['payslip_item_time'] == '30'){
				$time = lang('daily');
			} elseif($result['payslip_item_time'] == '1') {
				$time = lang('monthly');
			}
			$data[] = array(
				'payslip_item_id' => $result['payslip_item_id'],
				'payslip_item_type' => $result['payslip_item_type'],
				'relation_id' => $result['relation_id'],
				'payslip_item_name' => $result['payslip_item_name'],
				'payslip_item_description' => $result['payslip_item_description'],
				'payslip_item_time' => $result['payslip_item_time'],
				'payslip_item_time_des' => $time,
				'payslip_item_quantity' => $result['payslip_item_quantity'],
				'payslip_item_price' => $result['payslip_item_price'],
				'payslip_item_total' => $result['payslip_item_total'],
			);
		}
		return $data;
	}

	function get_payslip_items_ids($type, $id) {
		return array_column(
			$this->db->select('payslip_item_id')->get_where('payslip_item', ['relation_id' => $id, 'payslip_item_type' => $type])->result_array(),
			'payslip_item_id'
		);
	}

	function get_paid_payslip($id)
	{
		$this->db->select_sum('amount');
		$this->db->from('payments');
		$this->db->where('(payslip_id = ' . $id . ') ');
		return $this->db->get();
	}

	function addpayment($params)
	{
		$this->db->insert('expenses', $params);
		$expense = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['expense_series'] ? $appconfig['expense_series'] : $expense;
		$expense_number = $appconfig['expense_prefix'] . $number;
		$this->db->where('id', $expense)->update('expenses', array('expense_number' => $expense_number));
		if ($this->input->post('balance') == 0) {
			$response = $this->db->where('payslip_id', $this->input->post('payslip'))->update('payslips', array('payslip_status' => 1));
		} else {
			$response = $this->db->where('payslip_id', $this->input->post('payslip'))->update('payslips', array('payslip_status' => 3));
		}
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert('payments', array(
			'transactiontype' => '1',
			'is_transfer' => '0',
			'payslip_id' => $this->input->post('payslip'),
			'amount' => $this->input->post('amount'),
			'account_id' => $this->input->post('account'),
			'date' => $this->input->post('date'),
			'not' => $this->input->post('not'),
			'staff_id' => $loggedinuserid,
		));
		$payment_id = $this->db->insert_id();

		$this->db->insert('items', array(
			'relation_type' => 'expense',
			'relation' => $expense,
			'code' => 'expense',
			'description' => get_number('expenses', $expense, 'expense', 'expense'),
			'name' => 'expense',
			'quantity' => '1',
			'price' => $this->input->post('amount'),
			'total' => $this->input->post('amount'),
		));

		//LOG
		// $staffname = $this->session->staffname;
		// $this->db->insert( 'logs', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="expenses/expense/' . $expense . '">' . get_number('expenses',$expense,'expense','expense'). '</a>.' ),
		// 	'staff_id' => $loggedinuserid,
		// ) );

		return $payment_id;
	}

	function delete_payslip($id)
	{
		$response = $this->db->delete('payslips', array('payslip_id' => $id));
		$response = $this->db->delete('payslip_item', array('relation_id' => $id));

		// LOG
		// $staffname = $this->session->staffname;
		// $loggedinuserid = $this->session->usr_id;
		// $this->db->insert( 'logs', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang('payslip') . ' ' . $id . '' ),
		// 	'staff_id' => $loggedinuserid
		// ) );
	}

	function delete_payslips($ids)
	{
		foreach ($ids as $id) {
			$this->delete_payslip($id);
		}
	}

	function add_payslip($data)
	{
		if (!isset($data['payslip_payroll_id'])) {
			return null;
		}
		$payroll_id = $data['payslip_payroll_id'];
		$old_payslip_ids = array_column(
			$this->db->select('payslip_id')->get_where('payslips', ['payslip_payroll_id' => $payroll_id])->result_array(),
			'payslip_id'
		);
		$old_payslip_id = array_pop($old_payslip_ids);
		if (count($old_payslip_ids) > 0) {
			$this->delete_payslips($old_payslip_ids);
		}
		if ($old_payslip_id) {
			$this->db->update('payslips', $data, ['payslip_id' => $old_payslip_id]);
			$this->status_of_adding = 'updated';
			return $old_payslip_id;
		} else {
			$this->db->insert('payslips', $data);
			$this->status_of_adding = 'new';
			return $this->db->insert_id();
		}
	}
}
