<?php
include APPPATH . '/third_party/vendor/autoload.php';

use Dompdf\Dompdf;

class Payrolls_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}



	function get_payroll( $id ) {
		return $this->db->get_where( 'payrolls', array( 'id' => $id ) )->row_array();
	}
	

	function get_payrolls($id)
	{
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim, recurring.id as recurring_id');
		$this->db->join('staff', 'payrolls.payroll_relation_id = staff.id', 'left');
		$this->db->join('recurring', 'recurring.relation = payrolls.payroll_id AND recurring.relation_type = "payroll"', 'left');
		$this->db->order_by('payrolls.payroll_id', 'desc');
		return $this->db->get_where('payrolls', array('payrolls.payroll_id' => $id))->row_array();
	}

	function get_all_payrolls()
	{
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim, recurring.id as recurring_id');
		$this->db->join('staff', 'payrolls.payroll_relation_id = staff.id', 'left');
		$this->db->join('recurring', 'recurring.relation = payrolls.payroll_id AND recurring.relation_type = "payroll"', 'left');
		$this->db->order_by('payrolls.payroll_id', 'desc');
		return $this->db->get_where('payrolls', array(''))->result_array();
	}

	function get_all_payroll_by_privilege($staff_id = '')
	{
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim, staff.id as id, recurring.id as recurring_id');
		$this->db->join('staff', 'payrolls.payroll_relation_id = staff.id', 'left');
		$this->db->join('recurring', 'recurring.relation = payrolls.payroll_id AND recurring.relation_type = "payroll"', 'left');
		$this->db->order_by('payrolls.payroll_id', 'desc');
		if ($staff_id) {
			return $this->db->get_where('payrolls', array('payrolls.payroll_relation_id' => $staff_id))->result_array();
		} else {
			return $this->db->get_where('payrolls', array(''))->result_array();
		}
	}

	function get_payroll_detail_by_privilege($id, $staff_id = '')
	{
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim, recurring.id as recurring_id');
		$this->db->join('staff', 'staff.id = payrolls.payroll_relation_id ', 'left');
		$this->db->join('recurring', 'recurring.relation = payrolls.payroll_id AND recurring.relation_type = "payroll"', 'left');
		$this->db->join('departments', 'staff.department_id = departments.id', 'left');
		if ($staff_id) {
			return $this->db->get_where('payrolls', array('payrolls.payroll_id' => $id, 'payrolls.payroll_relation_id' => $this->session->usr_id))->row_array();
		} else {
			return $this->db->get_where('payrolls', array('payrolls.payroll_id' => $id))->row_array();
		}
	}

	function payroll_add($params)
	{
		$this->db->insert('payrolls', $params);
		$payroll = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['payroll_series'] ? $appconfig['payroll_series'] : $payroll;
		$payroll_number = $appconfig['payroll_prefix'] . $number;
		$this->db->where('payroll_id', $payroll)->update('payrolls', array('payroll_number' => $payroll_number));

		$allowances = $this->input->post('allowances', TRUE);
		$deductions = $this->input->post('deductions', TRUE);

		$i = 0;
		foreach ($allowances as $allowance) {
			$this->db->insert('payroll_item', array(
				'relation_id' => $payroll,
				'payroll_item_type' => "allowance",
				'payroll_item_name' => $allowance['name'],
				'payroll_item_description' => $allowance['description'],
				'payroll_item_time' => $allowance['time'],
				'payroll_item_quantity' => $allowance['quantity'],
				'payroll_item_price' => $allowance['price'],
				'payroll_item_total' => $allowance['quantity'] * $allowance['price'] * $allowance['time'],
			));
			$i++;
		};

		$j = 0;
		foreach ($deductions as $deduction) {
			$this->db->insert('payroll_item', array(
				'relation_id' => $payroll,
				'payroll_item_type' => "deduction",
				'payroll_item_name' => $deduction['name'],
				'payroll_item_description' => $deduction['description'],
				'payroll_item_time' => $deduction['time'],
				'payroll_item_quantity' => $deduction['quantity'],
				'payroll_item_price' => $deduction['price'],
				'payroll_item_total' => $deduction['quantity'] * $deduction['price'] * $deduction['time'],
			));
			$j++;
		};
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		// $this->db->insert( 'logs', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="invoices/invoice/' . $invoice . '">' . get_number('invoices',$invoice,'invoice','inv') . '</a>.' ),
		// 	'staff_id' => $loggedinuserid,
		// 	'customer_id' => $this->input->post( 'customer' )
		// ) );
		// //NOTIFICATION
		// $staffname = $this->session->staffname;
		// $staffavatar = $this->session->staffavatar;
		// $this->db->insert( 'notifications', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
		// 	'customer_id' => $this->input->post( 'customer' ),
		// 	'perres' => $staffavatar,
		// 	'target' => '' . base_url( 'area/invoices/invoice/' . $params['token'] . '' ) . ''
		// ) );
		// //--------------------------------------------------------------------------------------
		// $status_value = $this->input->post( 'status' );
		// if ( $status_value == 'true' ) {
		// 	$status = 2;
		// } else {
		// 	$status = 3;
		// }
		// $this->db->insert( $this->db->dbprefix . 'sales', array(
		// 	'invoice_id' => '' . $invoice . '',
		// 	'status_id' => $status,
		// 	'staff_id' => $loggedinuserid,
		// 	'customer_id' => $this->input->post( 'customer' ),
		// 	'total' => $this->input->post( 'total' ),
		// 	'date' => date( 'Y-m-d H:i:s' )
		// ) );
		//----------------------------------------------------------------------------------------
		return $payroll;
	}

	function get_payroll_items($type, $id)
	{
		$results = $this->db->select('*')->get_where('payroll_item', array('relation_id' => $id, 'payroll_item_type' => $type))->result_array();
		$data = array();
		foreach($results as $result){
			if($result['payroll_item_time'] == '30'){
				$time = lang('daily');
			} elseif ($result['payroll_item_time'] == '1') {
				$time = lang('monthly');
			}
			$data[] = array(
				'payroll_item_id' => $result['payroll_item_id'],
				'payroll_item_type' => $result['payroll_item_type'],
				'relation_id' => $result['relation_id'],
				'payroll_item_name' => $result['payroll_item_name'],
				'payroll_item_description' => $result['payroll_item_description'],
				'payroll_item_time' => $result['payroll_item_time'],
				'payroll_item_time_des' => $time,
				'payroll_item_quantity' => $result['payroll_item_quantity'],
				'payroll_item_price' => $result['payroll_item_price'],
				'payroll_item_total' => $result['payroll_item_total'],
			);
		}
		return $data;
	}

	function update_payroll($id, $params)
	{
		$appconfig = get_appconfig();
		//$invoice_data = $this->get_invoices($id);

		$this->db->where('payroll_id', $id);
		$payroll = $id;
		$response = $this->db->update('payrolls', $params);
		$allowances = $this->input->post('allowances', TRUE);
		$deductions = $this->input->post('deductions', TRUE);

		if (!empty($allowances)) {
			$i = 0;
			foreach ($allowances as $allowance) {
				if (isset($allowance['payroll_item_id'])) {
					$params = array(
						'relation_id' => $payroll,
						'payroll_item_type' => "allowance",
						'payroll_item_name' => $allowance['payroll_item_name'],
						'payroll_item_description' => $allowance['payroll_item_description'],
						'payroll_item_time' => $allowance['payroll_item_time'],
						'payroll_item_quantity' => $allowance['payroll_item_quantity'],
						'payroll_item_price' => $allowance['payroll_item_price'],
						'payroll_item_total' => $allowance['payroll_item_quantity'] * $allowance['payroll_item_price'] * $allowance['payroll_item_time'],
					);
					$this->db->where('payroll_item_id', $allowance['payroll_item_id']);
					$response = $this->db->update('payroll_item', $params);
				}
				if (empty($allowance['payroll_item_id'])) {
					$this->db->insert('payroll_item', array(
						'relation_id' => $payroll,
						'payroll_item_type' => "allowance",
						'payroll_item_name' => $allowance['payroll_item_name'],
						'payroll_item_description' => $allowance['payroll_item_description'],
						'payroll_item_time' => $allowance['payroll_item_time'],
						'payroll_item_quantity' => $allowance['payroll_item_quantity'],
						'payroll_item_price' => $allowance['payroll_item_price'],
						'payroll_item_total' => $allowance['payroll_item_quantity'] * $allowance['payroll_item_price'] * $allowance['payroll_item_time'],
					));
				}
				$i++;
			};
		}

		if (!empty($deductions)) {
			$j = 0;
			foreach ($deductions as $deduction) {
				if (isset($deduction['payroll_item_id'])) {
					$params = array(
						'relation_id' => $payroll,
						'payroll_item_type' => "deduction",
						'payroll_item_name' => $deduction['payroll_item_name'],
						'payroll_item_description' => $deduction['payroll_item_description'],
						'payroll_item_time' => $deduction['payroll_item_time'],
						'payroll_item_quantity' => $deduction['payroll_item_quantity'],
						'payroll_item_price' => $deduction['payroll_item_price'],
						'payroll_item_total' => $deduction['payroll_item_quantity'] * $deduction['payroll_item_price'] * $deduction['payroll_item_time'],
					);
					$this->db->where('payroll_item_id', $deduction['payroll_item_id']);
					$response = $this->db->update('payroll_item', $params);
				}
				if (empty($deduction['payroll_item_id'])) {
					$this->db->insert('payroll_item', array(
						'relation_id' => $payroll,
						'payroll_item_type' => "deduction",
						'payroll_item_name' => $deduction['payroll_item_name'],
						'payroll_item_description' => $deduction['payroll_item_description'],
						'payroll_item_time' => $deduction['payroll_item_time'],
						'payroll_item_quantity' => $deduction['payroll_item_quantity'],
						'payroll_item_price' => $deduction['payroll_item_price'],
						'payroll_item_total' => $deduction['payroll_item_quantity'] * $deduction['payroll_item_price'] * $deduction['payroll_item_time'],
					));
				}
				$j++;
			};
		}
		//$invoices = $this->Invoices_Model->get_invoices( $id );
		// $response = $this->db->where( 'invoice_id', $id )->update( 'sales', array(
		// 	'status_id' => $invoices[ 'status_id' ],
		// 	'staff_id' => $this->session->usr_id,
		// 	'customer_id' => $this->input->post( 'customer' ),
		// 	'total' => $this->input->post( 'total' ),
		// ) );
		//LOG
		// $staffname = $this->session->staffname;
		// $loggedinuserid = $this->session->usr_id;
		// $appconfig = get_appconfig();
		// $this->db->insert( 'logs', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="invoices/invoice/' . $id . '">' . get_number('invoices',$id,'invoice','inv') . '</a>.' ),
		// 	'staff_id' => $loggedinuserid,
		// 	'customer_id' => $this->input->post( 'customer' )
		// ) );
		//NOTIFICATION
		// $staffname = $this->session->staffname;
		// $staffavatar = $this->session->staffavatar;
		// $this->db->insert( 'notifications', array(
		// 	'date' => date( 'Y-m-d H:i:s' ),
		// 	'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedinvoice' ) . '' ),
		// 	'customer_id' => $this->input->post( 'customer' ),
		// 	'perres' => $staffavatar,
		// 	'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		// ) );
	}

	function payslips_for_payroll($id)
	{
		$this->db->select('payslip_id, payslip_payroll_id, payslip_created, payslip_number, payslip_grand_total, payslip_created');
		$this->db->order_by('payslip_id', 'desc');
		$this->db->where('payslip_payroll_id = ' . $id . '');
		$result = $this->db->get('payslips')->result_array();
		return $result;
	}

	function delete_payroll($id)
	{
		$this->db->delete('payrolls', array('payroll_id' => $id));
		$this->db->delete('payroll_item', array('relation_id' => $id));
	}

	function recurring_add($params)
	{
		$this->db->insert('recurring', $params);
		$sharax = $this->db->insert_id();
		return $sharax;
	}

	function update_recurring_date($id)
	{
		$this->db->where('payroll_id', $id);
		return $this->db->update('payrolls', array('payroll_last_recurring'  => date('Y-m-d')));
	}

	function get_all_recurring()
	{
		$this->db->select('*');
		$this->db->order_by('id', 'asc');
		return $this->db->get_where('recurring', array('status' => '0', 'relation_type' => 'payroll'))->result_array();
	}

	function recurring_update($id, $params)
	{
		$this->db->select('*');
		$payroll = $this->db->get_where('recurring', array('relation_type' => 'payroll', 'relation' => $id))->row_array();
		if ($payroll) {
			$this->db->where('relation', $id)->where('relation_type', 'payroll');
		$sharax = $this->db->update('recurring', $params);
		} else {
			$sharax = $this->db->insert('recurring', $params);
		}
		return $sharax;
	}
}
