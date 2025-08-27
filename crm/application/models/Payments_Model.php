<?php
class Payments_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function addpayment( $params, $expensesID) {
		$this->db->insert('deposits', $params);
		$deposit = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['deposit_series'] ? $appconfig['deposit_series'] : $deposit;
		$deposit_number = $appconfig['deposit_prefix'].$number;
		$this->db->where('id', $deposit)->update( 'deposits', array('deposit_number' => $deposit_number ) );
		if ( $this->input->post( 'balance' ) == 0 ) {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 2, 'duedate' => 0 ) );
			$response = $this->db->where( 'invoice_id', $this->input->post( 'invoice' ) )->update( 'sales', array( 'status_id' => 2 ) );
		} else {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 3 ) );
			$response = $this->db->where( 'invoice_id', $this->input->post( 'invoice' ) )->update( 'sales', array( 'status_id' => 3 ) );
		}
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'payments', array(
			'transactiontype' => '0',
			'is_transfer' => '0',
			'invoice_id' => $this->input->post( 'invoice' ),
			'amount' => $this->input->post( 'amount' ),
			'account_id' => $this->input->post( 'account' ),
			'date' => $this->input->post( 'date' ),
			'not' => $this->input->post( 'not' ),
			'attachment' => $this->input->post( 'attachment' ),
			'customer_id' => $this->input->post( 'customer' ),
			'expense_id' => $expensesID,
			'staff_id' => $loggedinuserid,
		) );
		$payment_id = $this->db->insert_id();

		$this->db->insert( 'items', array(
			'relation_type' => 'deposit',
			'relation' => $deposit,
			'code' =>'deposit',
			'description' => get_number('deposits', $deposit, 'deposit', 'deposit'),
			'name' => 'deposit',
			'quantity' => '1',
			'price' => $this->input->post( 'amount' ),
			'total' => $this->input->post( 'amount' ),
		));

		//LOG
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="deposits/deposit/' . $deposit . '">' . get_number('deposits',$deposit,'deposit','deposit'). '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );

		return $payment_id;
	}

	function todaypayments() {
		return $this->db->get_where( 'payments', array( 'DATE(date)' => date( 'Y-m-d' ) ) )->result_array();
	}

	function todaypayments_by_staff() {
		return $this->db->get_where( 'payments', array( 'DATE(date)' => date( 'Y-m-d' ), 'staff_id' => $this->session->usr_id ) )->result_array();
	}

	//Return the payment details
	function get_payment_details($id)
	{
		$this->db->join('accounts ac', 'ac.id = vp.account_id');
		$this->db->join('staff st', 'st.id = vp.staff_id');
		$this->db->where('vp.id', $id);
		return $this->db->get('payments vp')->row_array();
	}

	function updatePartiallyAmount($value)
	{

		$date = date('Y-m-d h:i:s', time());

		$tillPaid = $this->db->select("sum(amount) as paid")->where('invoice_id', $value['invoiceID'])->get('payments')->row_array();
		
		$Amount = $this->db->select("total")->where('id', $value['invoiceID'])->get('invoices')->row_array();


		$tillPaid = floatval($tillPaid['paid']) ;
		$Amount = floatval($Amount['total']);
	
		if($tillPaid > $Amount ){
				return False;

		} else{
			$updateStatus = $this->db->where('id', $value['paymentID'])->update( 'payments', array('amount' => $value['amount'],'not' => $value['not'],'account_id' => $value['account']) );

			$expenseStatus = $this->db->where('id', $value['expenseID'])->update( 'expenses', array('amount' => $value['amount'],'sub_total' => $value['amount'],'description' => $value['not'],'account_id' => $value['account']) );

			if($updateStatus){

			$tillPaid = $this->db->select("sum(amount) as paid")->where('invoice_id', $value['invoiceID'])->get('payments')->row_array();

			$AmountStatus = floatval($Amount - $tillPaid['paid']);
			
			if($AmountStatus == 0)
				return $updateStatus = $this->db->where('id', $value['invoiceID'])->update( 'invoices', array('status_id' => 2));
			
			}

			return true;
			
		}

}


	function delete_Payment($id){
		return $this->db->delete( 'payments', array( 'id' => $id ) );
	
	}
}