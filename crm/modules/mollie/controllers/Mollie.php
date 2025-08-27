<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'third_party/vendor/autoload.php' );
class Mollie extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->lang->load( 'english_default', 'english' );
		$this->lang->load( 'english', 'english' );
		$this->load->model( 'Invoices_Model' );
		$this->load->model( 'Customers_Model' );
		$this->load->model( 'Settings_Model' );
	}

	function mollie($token) {
		$appconfig = get_appconfig();
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		if ($invoice) {
			$data['payment'] = $this->Settings_Model->payment_mode('mollie');
			if ($data['payment']['active'] == '1') {
				$settings = $this->Settings_Model->get_settings_ciuis();
				$data['crm_name'] = $settings['crm_name'];
				$data['logo'] = base_url('uploads/ciuis_settings/'.$settings['logo']);
				$data['customer'] = $this->Customers_Model->get_customers( $invoice[ 'customer_id' ] );
				$data['invoice_id'] = sprintf( lang( 'paymentfor' ), get_number('invoices', $invoice[ 'id' ], 'invoice','inv') );
				$data['currency'] = $this->Settings_Model->get_currency();
				$data['invoice'] = $invoice;
				$data['invoice']['inv_id'] =   get_number('invoices', $invoice[ 'id' ], 'invoice','inv');
				$data['token'] = $token;
				$this->load->view( 'mollie', $data );
			} else {
				redirect(base_url('panel'));
			}
		}
	}

	function pay_mollie($token) {
		$mode = $this->Settings_Model->payment_mode('mollie');
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$currency = $mode['input_value2'];
		$mollie = new \Mollie\Api\MollieApiClient();
		$mollie->setApiKey($mode['input_value1']);
		$total = $invoice['total'];
		$row_num = $this->add_transaction($invoice['id'], $invoice['token']);
		$payment = $mollie->payments->create([
			"amount" => [
					"currency" => $currency,
					"value" => $total
			],
			"description" => $invoice['id'],
			"redirectUrl" => base_url('mollie/return') . '?relation_id='.$invoice["id"].'&token='.$token.'&row='.$row_num.'',
			"webhookUrl"  => base_url('mollie/webhook'),
			"metadata" => [
				"relation_id" => $invoice['id'],
				"row" => $row_num,
				"token" => $token,
			]
		]);
		$this->update_transaction($invoice["id"], $token, $row_num, $payment->id, $payment->status);
		header("Location: " . $payment->getCheckoutUrl(), true, 303);
	}

	function return() {
		$mode = $this->Settings_Model->payment_mode('mollie');
		$mollie = new \Mollie\Api\MollieApiClient();
		$mollie->setApiKey($mode['input_value1']);
		$relation_id = $_GET["relation_id"];
		$token = $_GET["token"];
		$row_num = $_GET["row"];

		$transaction = $this->read_transaction($relation_id, $token, $row_num);
		$hasError = null;
		if ($transaction['status'] == 'open') {
			$hasError = false;
			$data['heading'] = "open";
			$data['message'] = "transaction open";
			$data['id'] = $transaction['transaction_id'];
		} else if ($transaction['status'] == 'paid') {
			$hasError = false;
			$data['message'] = "transaction paid";
			$data['heading'] = "open";
			$data['id'] = $transaction['transaction_id'];
		} else {
			$hasError = true;
			$data['message'] = "failed";
		}
		if($hasError == false) {
			$this->load->view('gateway/success_with_data', $data);
		} else {
			$this->load->view('gateway/cancel', $data);
		}
	}

	function webhook(){
		$mode = $this->Settings_Model->payment_mode('mollie');
		$mollie = new \Mollie\Api\MollieApiClient();
		$mollie->setApiKey($mode['input_value1']);
		$transaction_id = $_POST["id"];
		$payment = $mollie->payments->get($_POST["id"]);
		$relation_id = $payment->metadata->relation_id;
		$row = $payment->metadata->row;
		$token = $payment->metadata->token;
		
		
		if ($payment->isPaid()) {
			$this->update_transaction($relation_id, $token, $row, $transaction_id, $payment->status);
			//update invoice

			$invoice = $this->db->get_where( 'invoices', array( 'invoices.token' => $token , 'invoices.id' => $relation_id) )->row_array();
			$response = $this->db->where( 'id', $invoice['id'] )->update( 'invoices', array( 'status_id' => 2, 'duedate' => 0 ) );

			//update sales
			$response = $this->db->where( 'invoice_id', $invoice['id'] )->update( 'sales', array(
				'status_id' => 2,
				'staff_id' => $invoice[ 'staff_id' ],
				'customer_id' => $invoice[ 'customer_id' ],
				'total' => $invoice['amount'],
			));

			//update payment
			$this->db->insert( 'payments', array(
				'transactiontype' => 0,
				'invoice_id' => $invoice['id'],
				'staff_id' => $invoice['staff_id'],
				'amount' => $invoice[ 'total' ],
				'customer_id' => $invoice['customer_id'],
				'account_id' => $mode['payment_record_account'],
				'not' => '' . lang('paymentfor').' '.lang('invoice').' '. $invoice['id'] . '',
				'mode' => 'mollie',
				'date' => date('Y-m-d H:i:s'),
			));


		} elseif ($payment->isOpen()) {

		} elseif ($payment->isPending()) {

		} elseif ($payment->isFailed()) {

		} elseif ($payment->isExpired()) {

		} elseif ($payment->isCanceled()) {

		}
			header("HTTP/1.1 200 OK");
		}


	function add_transaction($id, $token) {
		$params = array(
			'relation_id' => $id,
			'token' => $token,
			'relation_type' => 'invoice',
			'method' => 'mollie',
		);
		$this->db->insert( 'payment_transactions', $params );
		$row_num = $this->db->insert_id();
		return $row_num;
	}

	function update_transaction($relation_id, $token, $row, $transaction_id, $status) {
		$transaction = $this->db->get_where( 'payment_transactions', array( 'relation_id' => $relation_id, 'token' => $token, 'id' => $row  ) )->row_array();
		$param = array(
			'status' => $status,
			'transaction_id' => $transaction_id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where( 'id', $transaction['id'] );
		$mollie_id = $this->db->update( 'payment_transactions', $param );
	}

	function read_transaction($relation_id, $token, $row_num) {
		$result = $this->db->get_where( 'payment_transactions', array( 'relation_id' => $relation_id, 'token' => $token, 'id' => $row_num ) )->row_array();
		return $result;
	}


}









