<?php
require_once APPPATH . '/third_party/vendor/autoload.php';

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
class Invoices extends CIUIS_Controller
{

	function __construct()
	{
		parent::__construct();
		$path = $this->uri->segment(1);
		if (!$this->Privileges_Model->has_privilege($path)) {
			$this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
			redirect('panel/');
			die;
		}
	}

	function index()
	{
		$data['title'] = lang('invoices');
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$data['invoices'] = $this->Invoices_Model->get_all_invoices_by_privileges();
			$data['off'] = $this->Report_Model->pff();
			$data['ofv'] = $this->Report_Model->ofv();
			$data['oft'] = $this->Report_Model->oft();
			$data['vgf'] = $this->Report_Model->vgf();
			$data['tfa'] = $this->Report_Model->tfa();
			$data['pfs'] = $this->Report_Model->pfs();
			$data['otf'] = $this->Report_Model->otf();
			$data['tef'] = $this->Report_Model->tef();
			$data['vdf'] = $this->Report_Model->vdf();
			$data['fam'] = $this->Report_Model->fam();
		} else {
			$data['invoices'] = $this->Invoices_Model->get_all_invoices_by_privileges($this->session->usr_id);
			$data['off'] = $this->Report_Model->total_amount_by_status('1', 'invoices');
			$data['ofv'] = $this->Report_Model->total_amount_by_status('2', 'invoices');
			$data['oft'] = $this->Report_Model->total_amount_by_status('3', 'invoices');
			$data['vgf'] = $this->Report_Model->total_amount_by_status('due', 'invoices');
			$data['tfa'] = $this->Report_Model->total_number_of_data_by_status('4', 'invoices');
			$data['pfs'] = $this->Report_Model->total_number_of_data_by_status('1', 'invoices');
			$data['otf'] = $this->Report_Model->total_number_of_data_by_status('2', 'invoices');
			$data['tef'] = $this->Report_Model->total_number_of_data_by_status('3', 'invoices');
			$data['vdf'] = $this->Report_Model->total_number_of_data_by_status('due', 'invoices');
			$data['fam'] = $this->Report_Model->total_amount_by_status('', 'invoices');
		}
		$data['ofy'] = ($data['tfa'] > 0 ? number_format(($data['tef'] * 100) / $data['tfa']) : 0);
		$data['ofx'] = ($data['tfa'] > 0 ? number_format(($data['otf'] * 100) / $data['tfa']) : 0);
		$data['vgy'] = ($data['tfa'] > 0 ? number_format(($data['vdf'] * 100) / $data['tfa']) : 0);
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view('invoices/index', $data);
	}

	function get_content($type, $id = null)
	{
		$html = "";
		if ($type == 'index') {
			$data['title'] = lang('invoices');
			$data['off'] = $this->Report_Model->pff();
			$data['ofv'] = $this->Report_Model->ofv();
			$data['oft'] = $this->Report_Model->oft();
			$data['vgf'] = $this->Report_Model->vgf();
			$data['tfa'] = $this->Report_Model->tfa();
			$data['pfs'] = $this->Report_Model->pfs();
			$data['otf'] = $this->Report_Model->otf();
			$data['tef'] = $this->Report_Model->tef();
			$data['vdf'] = $this->Report_Model->vdf();
			$data['fam'] = $this->Report_Model->fam();
			$data['ofy'] = ($data['tfa'] > 0 ? number_format(($data['tef'] * 100) / $data['tfa']) : 0);
			$data['ofx'] = ($data['tfa'] > 0 ? number_format(($data['otf'] * 100) / $data['tfa']) : 0);
			$data['vgy'] = ($data['tfa'] > 0 ? number_format(($data['vdf'] * 100) / $data['tfa']) : 0);
			$data['invoices'] = $this->Invoices_Model->get_all_invoices();
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$html = $this->load->view('invoices/invoices', $data, true);
		}
		if ($type == 'invoice' && isset($id)) {
			$appconfig = get_appconfig();
			$invoices = $this->Invoices_Model->get_invoice_detail($id);
			$data['title'] = '' . get_number('invoices', $invoices['id'], 'invoice', 'inv') . ' ' . lang('detail') . '';
			$data['invoices'] = $this->Invoices_Model->get_invoice_detail($id);
			$html = $this->load->view('invoices/invoice', $data);
		}
		//$html = $this->output->get_output($html);
		echo $html;
	}

	function create()
	{
		$data['title'] = lang('newinvoice');
		if ($this->Privileges_Model->check_privilege('invoices', 'create') && $this->session->role_type != 'sadmin') {
			//form validation 
			if (isset($_POST) && count($_POST) > 0) {

				$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');

				$this->form_validation->set_rules('serie', lang('serie'), 'trim|max_length[100]');
				$this->form_validation->set_rules('no', lang('no'), 'trim|max_length[50]');
				$this->form_validation->set_rules('created', lang('dateofissuance'), 'trim|required|valid_date');
				$this->form_validation->set_rules('status', lang('Status'), 'trim|in_list[true,false]');
				$status = $this->input->post('status');
				$paid = ($status == 'true') ? '1' : '0';
				if ($paid == '1') {
					$this->form_validation->set_rules('account', lang('account'), 'trim|required|integer');
					$this->form_validation->set_rules('datepayment', lang('datepaid'), 'trim|required|valid_date');
				} else if ($paid == '0') {
					$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date|callback_compareDate');
					$this->form_validation->set_rules('duenote', lang('duenote'), 'trim|max_length[255]');
				}

				$this->form_validation->set_rules('recurring', lang('recurring'), 'trim|integer|in_list[0,1]');
				$recurring = $this->input->post('recurring');
				if ($recurring == '1') {
					$this->form_validation->set_rules('recurring_period', lang('recurring_period'), 'trim|required|integer');
					$this->form_validation->set_rules('end_recurring', lang('Ends On'), 'trim|max_length[100]');
					$this->form_validation->set_rules('recurring_type', lang('recurring_type'), 'trim|required|integer');
				}
				$this->form_validation->set_rules('default_payment_method', lang('default_payment_method'), 'trim|max_length[50]');
				$this->form_validation->set_rules('billing_country', lang('Billing', 'Country'), 'trim|integer|max_length[50]');
				$this->form_validation->set_rules('billing_state_id', lang('Billing', 'State'), 'trim|integer');
				$this->form_validation->set_rules('billing_city', lang('Billing', 'City'), 'trim|max_length[50]');
				$this->form_validation->set_rules('billing_zip', lang('Billing', 'Zip Code'), 'trim|max_length[20]');
				$this->form_validation->set_rules('billing_street', lang('billing_address'), 'trim|max_length[100]');
				$this->form_validation->set_rules('shipping_country', lang('Shipping', 'Country'), 'trim|integer|max_length[50]');
				$this->form_validation->set_rules('shipping_state_id', lang('Shipping', 'State'), 'trim|integer');
				$this->form_validation->set_rules('shipping_city', lang('Shipping', 'City'), 'trim|max_length[50]');
				$this->form_validation->set_rules('shipping_zip', lang('Shipping', 'Zip Code'), 'trim|max_length[20]');
				$this->form_validation->set_rules('shipping_street', lang('Shipping', 'Address'), 'trim|max_length[200]');
				$this->form_validation->set_rules('sub_total', lang('SUB TOTAL'), 'trim|numeric');
				$this->form_validation->set_rules('total_discount', lang('Total Discount'), 'trim|numeric');
				$this->form_validation->set_rules('total_tax', lang('Tax'), 'trim|numeric');
				$this->form_validation->set_rules('total', lang('GRAND TOTAL'), 'trim|numeric');
				$datas['message'] = '';
				if ($this->form_validation->run() == false) {
					$datas['success'] = false;
					$datas['message'] = validation_errors();
					echo json_encode($datas);
				} else {
					$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
					$datas['success'] = false;
					if (((int)($this->input->post('totalItems'))) == 0) {
						$datas['message'] = lang('invalid_items');
					} else if ($total == 0) {
						$datas['message'] = lang('invalid_total');
					} else {
						$duedate = $this->input->post('duedate');
						$datepayment = $this->input->post('datepayment');
						$appconfig = get_appconfig();
						$status_value = $this->input->post('status');
						if ($status_value == 'true') {
							$datepayment = $this->input->post('datepayment');
							$duenote = null;
							$duedate = null;
							$status = 2;
						} else {
							$duedate = $this->input->post('duedate');
							$duenote = $this->input->post('duenote');
							$datepayment = null;
							$status = 3;
						}
						$params = array(
							'token' => md5(uniqid()),
							'no' => $this->input->post('no'),
							'serie' => $this->input->post('serie'),
							'customer_id' => $this->input->post('customer'),
							'staff_id' => $this->session->usr_id,
							'status_id' => $status,
							'created' => $this->input->post('created'),
							'last_recurring' => $this->input->post('created'),
							'duedate' => $duedate,
							'datepayment' => $datepayment,
							'duenote' => $duenote,
							'sub_total' => $this->input->post('sub_total'),
							'total_discount' => $this->input->post('total_discount'),
							'total_tax' => $this->input->post('total_tax'),
							'total' => $this->input->post('total'),
							'billing_street' => $this->input->post('billing_street'),
							'billing_city' => $this->input->post('billing_city'),
							'billing_state_id' => $this->input->post('billing_state_id'),
							'billing_zip' => $this->input->post('billing_zip'),
							'billing_country' => $this->input->post('billing_country'),
							'shipping_street' => $this->input->post('shipping_street'),
							'shipping_city' => $this->input->post('shipping_city'),
							'shipping_state_id' => $this->input->post('shipping_state_id'),
							'shipping_zip' => $this->input->post('shipping_zip'),
							'shipping_country' => $this->input->post('shipping_country'),
							'default_payment_method' => $this->input->post('default_payment_method'),
						);

						$invoices_id = $this->Invoices_Model->invoice_add($params);
						// Custom Field Post
						if ($this->input->post('custom_fields')) {
							$custom_fields = array(
								'custom_fields' => $this->input->post('custom_fields')
							);
							$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'invoice', $invoices_id);
						}
						$this->Settings_Model->create_process('pdf', $invoices_id, 'invoice', 'invoice_message');
						if ($this->input->post('recurring') == 'true'  || $this->input->post('recurring') == '1') {
							$SHXparams = array(
								'relation_type' => 'invoice',
								'relation' => $invoices_id,
								'period' => $this->input->post('recurring_period'),
								'end_date' => $this->input->post('end_recurring'),
								'type' => $this->input->post('recurring_type'),
							);
							$recurring_invoices_id = $this->Invoices_Model->recurring_add($SHXparams);
						}
						$datas['success'] = true;
						$datas['id'] = $invoices_id;
						if ($appconfig['invoice_series']) {
							$invoice_number = $appconfig['invoice_series'];
							$invoice_id_no = $this->get_invoice_id();
							$invoice_id_no = intval($invoice_id_no + 1);
							$invoice_number = $invoice_id_no;
							$this->Settings_Model->increment_series('invoice_series', $invoice_number);

						}
						$datas['message'] = "Xyz";
					}
					echo json_encode($datas);
				}
			} else {
				$this->load->view('invoices/create', $data);
			}
		} else {
			$this->session->set_flashdata('ntf3',  lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

    function get_invoice_id(){
        $this->db->select("id");
        $this->db->from("invoices");
        $this->db->limit(1);
        $this->db->order_by('id',"DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->id;
    }

	function compareDate()
	{
		$created = strtotime($this->input->post('created'));
		$duedate = strtotime($this->input->post('duedate'));
		if ($duedate >= $created)
			return True;
		else {
			$this->form_validation->set_message('compareDate', lang('date') . ' ' . lang('date_error') . ' ' . lang('duedate'));
			return False;
		}
	}

	function update($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoices = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoices = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$datas['success'] = false;
			$datas['message'] = lang('you_dont_have_permission');
			echo json_encode($datas);
		}
		if ($invoices['status_id'] == '2') {
			$this->session->set_flashdata('ntf4', lang('paid') . ' ' . lang('invoice') . ' ' . lang('cant_update'));
			redirect('invoices/invoice/' . $id);
		} else {
			if ($invoices) {
				if ($this->Privileges_Model->check_privilege('invoices', 'edit')) {
					$data['payment'] = $this->Settings_Model->get_payment_gateway_data();
					if (!$this->session->userdata('other')) {
						$appconfig = get_appconfig();
						$data['title'] = '' . lang('updateinvoicetitle') . ' ' . get_number('invoices', $id, 'invoice', 'inv');
						if (isset($invoices['id'])) {
							if (isset($_POST) && count($_POST) > 0) {
								$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
								$this->form_validation->set_rules('serie', lang('serie'), 'trim|max_length[100]');
								$this->form_validation->set_rules('no', lang('no'), 'trim|max_length[50]');
								$this->form_validation->set_rules('created', lang('dateofissuance'), 'trim|required|valid_date');
								$this->form_validation->set_rules('status', lang('status'), 'trim|in_list[true,false]');

								$status = $this->input->post('status');

								$paid = ($status == 'true') ? '1' : '0';
								if ($paid == '1') {
									$this->form_validation->set_rules('account', lang('account'), 'trim|required|integer');
									$this->form_validation->set_rules('datepayment', lang('datepaid'), 'trim|required|valid_date');
								} else if ($paid == '0') {
									$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date|callback_compareDate');
								}
								//	$this->form_validation->set_rules('notes', lang('Notes'), 'trim|max_length[255]');
								$this->form_validation->set_rules('recurring', lang('recurring'), 'trim|in_list[true,false]');

								if ($this->input->post('recurring') == 'true') {
									$this->form_validation->set_rules('recurring_period', lang('recurring_period'), 'trim|required|integer');
									$this->form_validation->set_rules('end_recurring', lang('ends_on'), 'trim|max_length[100]');
									$this->form_validation->set_rules('recurring_type', lang('recurring_type'), 'trim|required|integer');
								}
								$this->form_validation->set_rules('default_payment_method', lang('default_payment_method'), 'trim|max_length[50]');
								$this->form_validation->set_rules('billing_country_id', lang('Billing', 'Country'), 'trim|integer|max_length[50]');
								$this->form_validation->set_rules('billing_state_id', lang('Billing', 'State'), 'trim|integer');
								$this->form_validation->set_rules('billing_city', lang('Billing', 'City'), 'trim|max_length[50]');
								$this->form_validation->set_rules('billing_zip', lang('Billing', 'Zip Code'), 'trim|max_length[20]');
								$this->form_validation->set_rules('billing_street', lang('Billing', 'Address'), 'trim|max_length[100]');
								$this->form_validation->set_rules('shipping_country_id', lang('Shipping', 'Country'), 'trim|integer|max_length[50]');
								$this->form_validation->set_rules('shipping_state_id', lang('Shipping', 'State'), 'trim|integer');
								$this->form_validation->set_rules('shipping_city', lang('Shipping', 'City'), 'trim|max_length[50]');
								$this->form_validation->set_rules('shipping_zip', lang('Shipping', 'Zip Code'), 'trim|max_length[20]');
								$this->form_validation->set_rules('shipping_street', lang('Shipping', 'Address'), 'trim|max_length[200]');
								$this->form_validation->set_rules('sub_total', lang('SUB TOTAL'), 'trim|numeric');
								$this->form_validation->set_rules('total_discount', lang('Total Discount'), 'trim|numeric');
								$this->form_validation->set_rules('total_tax', lang('Tax'), 'trim|numeric');
								$this->form_validation->set_rules('total', lang('GRAND TOTAL'), 'trim|numeric');
								$datas['message'] = '';
								if ($this->form_validation->run() == false) {
									$datas['success'] = false;
									$datas['message'] = validation_errors();
									echo json_encode($datas);
								} else {
									$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
									$datas['success'] = false;
									if (((int)($this->input->post('totalItems'))) == 0) {
										$datas['message'] = lang('invalid_items');
									} else if ($total == 0) {
										$datas['message'] = lang('invalid_total');
									} else {

										$duedate = $this->input->post('duedate');
										$duenote = $this->input->post('duenote');
										$datepayment = null;

										$params = array(
											'no' => $this->input->post('no'),
											'serie' => $this->input->post('serie'),
											'customer_id' => $this->input->post('customer'),
											'created' => $this->input->post('created'),
											'last_recurring' => $this->input->post('created'),
											'duedate' => $duedate,
											'duenote' => $duenote,
											'sub_total' => $this->input->post('sub_total'),
											'total_discount' => $this->input->post('total_discount'),
											'total_tax' => $this->input->post('total_tax'),
											'total' => $this->input->post('total'),
											'billing_street' => $this->input->post('billing_street'),
											'billing_city' => $this->input->post('billing_city'),
											'billing_state_id' => $this->input->post('billing_state_id'),
											'billing_zip' => $this->input->post('billing_zip'),
											'billing_country' => $this->input->post('billing_country'),
											'shipping_street' => $this->input->post('shipping_street'),
											'shipping_city' => $this->input->post('shipping_city'),
											'shipping_state_id' => $this->input->post('shipping_state_id'),
											'shipping_zip' => $this->input->post('shipping_zip'),
											'shipping_country' => $this->input->post('shipping_country'),
											'default_payment_method' => $this->input->post('default_payment_method'),
										);

										// Mark as paid
										if ($paid == '1') {
											$params['account_id'] = $this->input->post('account');
											$params['datepayment'] = $this->input->post('datepayment');
											$params['status_id'] = 2;
										}

										$result = $this->Invoices_Model->update_invoices($id, $params);
										// Custom Field Post
										if ($this->input->post('custom_fields')) {
											$custom_fields = array(
												'custom_fields' => $this->input->post('custom_fields')
											);
											$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'invoice', $id);
										}

										// START Recurring Invoice
										if ($this->input->post('recurring') == 'true') {
											$SHXparams = array(
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
												'status' => 0,
											);
											$recurring_invoices_id = $this->Invoices_Model->recurring_update($id, $SHXparams);
										} else {
											$SHXparams = array(
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
												'status' => 1,
											);
											$recurring_invoices_id = $this->Invoices_Model->recurring_update($id, $SHXparams);
										}
										if (!is_numeric($this->input->post('recurring_id')) && ($this->input->post('recurring_status') == 'true')) { // NEW Recurring From Update
											$SHXparams = array(
												'relation_type' => 'invoice',
												'relation' => $id,
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
											);
											$recurring_invoices_id = $this->Invoices_Model->recurring_add($SHXparams);
										}
										$this->Invoices_Model->update_pdf_status($id, '0');
										$datas['success'] = true;
										$datas['id'] = $id;
										$datas['message'] = lang('invoice') . ' ' . lang('updatemessasge');
									}
									echo json_encode($datas);
								}
								// END Recurring Invoice
							} else {
								$data['invoices'] = $invoices;
								$this->load->view('invoices/update', $data);
							}
						} else
							$this->session->set_flashdata('ntf3', '' . $id . lang('error'));
					} else {
						$this->session->set_flashdata('ntf3', '' . $id . lang('you_dont_have_permission'));
						redirect('invoices');
					}
				} else {
					$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
					redirect('invoices/invoice/' . $id);
				}
			} else {
				$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
				redirect('invoices');
			}
		}
	}

	function invoice($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
		if ($invoice) {
			$data['title'] = '' . get_number('invoices', $id, 'invoice', 'inv');
			$data['invoices'] = $invoice;
			$this->load->view('invoices/invoice', $data);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function record_payment()
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'edit')) {
			$amount = $this->input->post('amount');
			$invoicetotal = $this->input->post('invoicetotal');
			if (isset($_POST) && count($_POST) > 0) {
				$amount = $amount;
				$not = $this->input->post('not');
				$account = $this->input->post('account');
				$invoice_id =  $this->input->post('invoice');
				$hasError = false;
				if ($amount == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('amount');
				} else if ($not == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('description');
				} else if ($account == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('account') . ' ' . lang('type');
				} else if ($amount > $invoicetotal) {
					$hasError = true;
					$data['message'] = lang('paymentamounthigh') . ' ' . lang('invoice');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				$expenseID = intval($this->get_current_id("expenses"))+1;
				if (!$hasError) {
					$params = array(
						'token' => md5(uniqid()),
						'relation_type' => lang('invoice'),
						'category_id' => $this->Invoices_Model->get_category_id(),
						'staff_id' => $this->session->usr_id,
						'customer_id' => $this->input->post('customer'),
						'invoice_id' =>  $invoice_id,
						'account_id' => $this->input->post('account'),
						'title' => lang('invoice'),
						'date' => $this->input->post('date'),
						'created' => date('Y-m-d H:i:s'),
						'amount' => $amount,
						'total_tax' => '0',
						'sub_total' => $amount,
						'description' => $this->input->post('not'),
						'status' => '2',
						'last_recurring' => date('Y-m-d')
					);

					$paramsExpense = array(
						'category_id' => $this->Invoices_Model->get_category_id(),
						'staff_id' => $this->session->usr_id,
						'account_id' => $this->input->post('account'),
						'customer_id' => $this->input->post('customer'),
						'title' => lang('invoice'),
						'date' => $this->input->post('date'),
						'created' => date('Y-m-d H:i:s'),
						'amount' => $amount,
						'description' => $this->input->post('not'),
						'invoice_id' =>  $invoice_id,
						'internal' => '1',
						'total_tax' => '0',
						'sub_total' => $amount,
						'total_discount' => '0'
						
					);

					$this->Expenses_Model->create_expense_invoice($paramsExpense);

					$this->Payments_Model->addpayment($params, $expenseID);

					$template = $this->Emails_Model->get_template('invoice', 'invoice_payment');
					if ($template['status'] == 1) {
						$invoice = $this->Invoices_Model->get_invoice_detail($invoice_id);
						$appconfig = get_appconfig();
						$inv_number = get_number('invoices', $invoice_id, 'invoice', 'inv');
						$name = $invoice['customercompany'] ? $invoice['customercompany'] : $invoice['individualindividual'];
						$link = base_url('share/invoice/' . $invoice['token'] . '');
						$message_vars = array(
							'{invoice_number}' => $inv_number,
							'{invoice_link}' => $link,
							'{payment_total}' => $amount,
							'{payment_date}' => $this->input->post('date'),
							'{email_signature}' => $this->session->userdata('email'),
							'{name}' => $this->session->userdata('staffname'),
							'{customer}' => $name,
							'{site_url}' => site_url(),
							'{company_name}' =>  setting['company'],
							'{company_email}' =>  setting['email'],
							'{logo}' => rebrand['app_logo'],
							'{footer_logo}' => rebrand['nav_logo'],
							'{email_banner}' => rebrand['email_banner'],
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);
						$param = array(
							'from_name' => $template['from_name'],
							'email' => $invoice['email'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s"),
						);
						if ($invoice['email']) {
							$this->db->insert('email_queue', $param);
						}
					}					
					$data['success'] = true;
					$data['id'] = $invoice_id;
					$data['message'] = lang('paymentaddedsuccessfully');
					if ($appconfig['deposit_series']) {
						$deposit_number = $appconfig['deposit_series'];
						$deposit_number = $deposit_number + 1;
						$this->Settings_Model->increment_series('deposit_series', $deposit_number);
					}
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function get_current_id( $tableName=null ){     
        $this->db->select("id");
        $this->db->from($tableName);
        $this->db->limit(1);
        $this->db->order_by('id',"DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->id;
    }

	function download_pdf($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
		if ($invoice) {
			if (isset($id)) {
				$file_name = '' . get_number('invoices', $id, 'invoice', 'inv') . '.pdf';
				if (is_file('./uploads/files/invoices/' . $id . '/' . $file_name)) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/invoices/' . $id . '/' . $file_name);
					force_download($file_name, $data);
				} else {
					$this->session->set_flashdata('ntf4', lang('filenotexist'));
					redirect('invoices/invoice/' . $id);
				}
			} else {
				redirect('invoices/invoice/' . $id);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function create_pdf($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
		if ($invoice) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/invoices/' . $id)) {
				mkdir('./uploads/files/invoices/' . $id, 0777, true);
			}
			$data['invoice'] = $invoice;
			$data['billing_country'] = get_country($data['invoice']['bill_country']);
			$data['billing_state'] = get_state_name($data['invoice']['bill_state'], $data['invoice']['bill_state_id']);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['custom_fields'] = $this->Fields_Model->get_custom_fields_data_by_type('invoice', $id);
			$dafault_payment_method = $data['invoice']['default_payment_method'];
			if ($dafault_payment_method == 'bank') {
				$modes = $this->Settings_Model->get_payment_gateway_data();
				$method = $modes['bank'];
			} else {
				$method = lang($data['invoice']['default_payment_method']);
			}
			$data['default_payment'] = $method;
			$data['payments'] = $this->Invoices_Model->get_invoices_payment($id);
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'invoice', 'relation' => $id))->result_array();
			$this->load->view('invoices/pdf', $data);
			$appconfig = get_appconfig();
			$file_name =  get_number('invoices', $id, 'invoice', 'inv') . '.pdf';
			$html = $this->output->get_output();
			require_once APPPATH . '/third_party/vendor/autoload.php';
			$this->dompdf = new DOMPDF();
			//$this->load->library( 'dom' );
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('uploads/files/invoices/' . $id . '/' . $file_name . '', $output);
			$this->Invoices_Model->update_pdf_status($id, '1');
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ($output) {
				redirect(base_url('invoices/pdf_generated/' . $file_name . ''));
			} else {
				redirect(base_url('invoices/pdf_fault/'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function print_($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
		if ($invoice) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/invoices/' . $id)) {
				mkdir('./uploads/files/invoices/' . $id, 0777, true);
			}
			$data['payments'] = $this->Invoices_Model->get_invoices_payment($id);
			$data['invoice'] = $invoice;
			$data['billing_country'] = get_country($data['invoice']['bill_country']);
			$data['billing_state'] = get_state_name($data['invoice']['bill_state'], $data['invoice']['bill_state_id']);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['custom_fields'] = $this->Fields_Model->get_custom_fields_data_by_type('invoice', $id);
			$dafault_payment_method = $data['invoice']['default_payment_method'];
			if ($dafault_payment_method == 'bank') {
				$modes = $this->Settings_Model->get_payment_gateway_data();
				$method = $modes['bank'];
			} else {
				$method = lang($data['invoice']['default_payment_method']);
			}
			$data['default_payment'] = $method;
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'invoice', 'relation' => $id))->result_array();
			$this->load->view('invoices/pdf', $data);
			$file_name = get_number('invoices', $id, 'invoice', 'inv') . '.pdf';
			$html = $this->output->get_output();
			$this->dompdf = new DOMPDF();
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('uploads/files/invoices/' . $id . '/' . $file_name . '', $output);
			if ($output) {
				redirect(base_url('uploads/files/invoices/' . $id . '/' . $file_name . ''));
				//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			} else {
				redirect(base_url('invoices/pdf_falut/'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function pdf_generated($file)
	{
		$result = array(
			'status' => true,
			'file_name' => $file,
		);
		echo json_encode($result);
	}

	function pdf_fault()
	{
		$result = array(
			'status' => false,
		);
		echo json_encode($result);
	}

	function dp($id)
	{
		$data['invoice'] = $this->Invoices_Model->get_invoice_detail($id);
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'invoice', 'relation' => $id))->result_array();
		$this->load->view('invoices/pdf', $data);
	}

	function send_invoice_email($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
		if ($invoice) {
			$template = $this->Emails_Model->get_template('invoice', 'invoice_message');
			$path = '';
			if ($template['attachment'] == '1') {
				if ($invoice['pdf_status'] == '0') {
					$this->Invoices_Model->generate_pdf($id);
					$file = get_number('invoices', $invoice['id'], 'invoice', 'inv');
					$path = base_url('uploads/files/invoices/' . $id . '/' . $file . '.pdf');
				} else {
					$file = get_number('invoices', $invoice['id'], 'invoice', 'inv');
					$path = base_url('uploads/files/invoices/' . $id . '/' . $file . '.pdf');
				}
			}

			$inv_number = '' . get_number("invoices", $invoice['id'], 'invoice', 'inv') . '';
			if ($invoice['status_id'] == 1) {
				$invoicestatus = lang('draft');
			}
			if ($invoice['status_id'] == 3) {
				$invoicestatus = lang('unpaid');
			}
			if ($invoice['status_id'] == 4) {
				$invoicestatus = lang('cancelled');
			}
			if ($invoice['status_id'] == 2) {
				$invoicestatus = lang('partial');
			}
			$name = $invoice['customercompany'] ? $invoice['customercompany'] : $invoice['individualindividual'];
			$link = base_url('share/invoice/' . $invoice['token'] . '');

			$message_vars = array(
				'{invoice_number}' => $inv_number,
				'{invoice_link}' => $link,
				'{invoice_status}' => $invoicestatus,
				'{email_signature}' => $this->session->userdata('email'),
				'{name}' => $this->session->userdata('staffname'),
				'{customer}' => $name,
				'{site_url}' => site_url(),
				'{company_name}' =>  setting['company'],
				'{company_email}' =>  setting['email'],
				'{logo}' => rebrand['app_logo'],
				'{footer_logo}' => rebrand['nav_logo'],
				'{email_banner}' => rebrand['email_banner'],
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);
			$param = array(
				'from_name' => $template['from_name'],
				'email' => $invoice['email'],
				'subject' => $subject,
				'message' => $message,
				'created' => date("Y.m.d H:i:s"),
				'status' => 0,
				'attachments' => $path ? $path : NULL,
			);
			$this->load->library('mail');
			$data = $this->mail->send_email($invoice['email'], $template['from_name'], $subject, $message, $path);
			if ($data['success'] == true) {
				$now = new DateTime();
				$currentDate = $now->format('Y-m-d H:i:s');

				$this->Invoices_Model->update_invoice_only($id, [
					'datesend' => $currentDate
				]);
				
				$currentDate = date_create($currentDate);
				$currentDate = date_format($currentDate,"d F Y,  g:i a");
				$return['sent_on'] = lang('sent_on') .' '. $currentDate;
				$return['status'] = true;
				$return['message'] = $data['message'];
				if ($invoice['email']) {
					$this->db->insert('email_queue', $param);
				}
				echo json_encode($return);
			} else {				
				$return['status'] = false;
				$return['message'] = lang('errormessage');
				echo json_encode($return);
			}
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
	}

	function share($id)
	{
		$inv = $this->Invoices_Model->get_invoice_detail($id);
		// SEND EMAIL SETTINGS
		switch ($inv['type']) {
			case '0':
				$invcustomer = $inv['customercompany'];
				break;
			case '1':
				$invcustomer = $inv['namesurname'];
				break;
		}
		$subject = lang('yourinvoicedetails');
		$to = $inv['email'];
		$data = array(
			'customer' => $invcustomer,
			'customermail' => $inv['email'],
			'invoicelink' => '' . base_url('share/invoice/' . $inv['token'] . '') . ''
		);
		$body = $this->load->view('email/invoices/sendinvoice.php', $data, TRUE);
		$result = send_email($subject, $to, $data, $body);
		if ($result) {
			$response = $this->db->where('id', $id)->update('invoices', array('datesend' => date('Y-m-d H:i:s')));
			$this->session->set_flashdata('ntf1', '<b>' . $inv['email'], lang('sendmailcustomer') . '</b>');
			redirect('invoices/invoice/' . $id . '');
		} else {
			$this->session->set_flashdata('ntf4', '<b>' . lang('sendmailcustomereror') . '</b>');
			redirect('invoices/invoice/' . $id . '');
		}
	}

	function mark_as_draft($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'edit')) {
			$response = $this->db->where('id', $id)->update('invoices', array('status_id' => 1));
			$response = $this->db->update('sales', array('invoice_id' => $id, 'status_id' => 1));
			
			$this->db->delete('payments', array('invoice_id' => $id));
			
			$data['success'] = true;
			$data['message'] = lang('markedasdraft');
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function mark_as_cancelled($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'edit')) {
			$response = $this->db->where('id', $id)->update('invoices', array('status_id' => 4));
			$response = $this->db->delete('sales', array('invoice_id' => $id));
			$response = $this->db->delete('payments', array('invoice_id' => $id));
			$data['success'] = true;
			$data['message'] = lang('markedascancelled');
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
		if ($invoice) {
			if ($this->Privileges_Model->check_privilege('invoices', 'delete')) {
				if (isset($invoice['id'])) {
					$this->load->helper('file');
					$folder = './uploads/files/invoices/' . $id;
					if (file_exists($folder)) {
						delete_files($folder, true);
						rmdir($folder);
					}
					//logo's for invoice
					$this->Invoices_Model->delete_invoices($id, get_number('invoices', $id, 'invoice', 'inv'), $invoice['customer_id']);
					$data['success'] = true;
					$data['message'] = lang('invoicedeleted');
				} else {
					show_error('The invoices you are trying to delete does not exist.');
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
			echo json_encode($data);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function remove_item($id)
	{
		$response = $this->db->delete('items', array('id' => $id));
	}

	function get_invoice($id)
	{
		$invoice = array();
		if ($this->Privileges_Model->check_privilege('invoices', 'all')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('invoices', 'own')) {
			$invoice = $this->Invoices_Model->get_invoice_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}

		if ($invoice) {
			$fatop = $this->Invoices_Model->get_items_invoices($id);
			$tadtu = $this->Invoices_Model->get_paid_invoices($id);
			$total = $invoice['total'];
			$today = time();
			$duedate = strtotime($invoice['duedate']); // or your date as well
			$created = strtotime($invoice['created']);
			$paymentday = $duedate - $created; // Bunun sonucu 14 gün olcak
			$paymentx = $today - $created;
			$datepaymentnet = $paymentday - $paymentx;
			if ($invoice['duedate'] == 0) {
				$duedate_text = 'No Due Date';
			} else {
				if ($datepaymentnet < 0) {
					$duedate_text = lang('overdue');
					$duedate_text = '' . floor($datepaymentnet / (60 * 60 * 24)) . ' days';
				} else {
					$duedate_text = lang('payableafter') . floor($datepaymentnet / (60 * 60 * 24)) . ' ' . lang('day') . '';
				}
			}
			if ($invoice['datesend'] == 0) {
				$mail_status = lang('notyetbeensent');
			} else $mail_status = lang('sent_on') . ' ' . _adate($invoice['datesend']);
			$kalan = $total - $tadtu->row()->amount;
			$net_balance = $kalan;
			if ($tadtu->row()->amount < $total && $tadtu->row()->amount > 0) {
				$partial_is = true;
			} else $partial_is = false;
			$payments = $this->db->select('*,accounts.name as accountname,payments.id as id, payments.expense_id as expense_id')->join('accounts', 'payments.account_id = accounts.id', 'left')->get_where('payments', array('invoice_id' => $id))->result_array();
			$items = $this->Report_Model->get_items('invoice', $id);

			if ($invoice['type'] == 1) {
				$customer = $invoice['individualindividual'];
			} else {
				$customer = $invoice['customercompany'];
			}

			$properties = array(
				'invoice_id' => '' .  get_number('invoices', $invoice['id'], 'invoice', 'inv') . '',
				'customer' => $customer,
				'customer_address' => $invoice['customeraddress'],
				'customer_phone' => $invoice['customerphone'],
				'invoice_staff' => $invoice['staffmembername'],
				'invoice_number' => $invoice['invoice_number']
			);

			if ($invoice['recurring_endDate'] != 'Invalid date') {
				$recurring_endDate =  date(DATE_ISO8601, strtotime($invoice['recurring_endDate']));
			} else {
				$recurring_endDate = date(DATE_ISO8601);
			}
			$billing_country = get_country($invoice['bill_country']);
			$shipping_country = get_country($invoice['shipp_country']);
			$billing_state = get_state_name($invoice['bill_state'], $invoice['bill_state_id']);
			$shipping_state = get_state_name($invoice['shipp_state'], $invoice['shipp_state_id']);
			$invoice_details = array(
				'id' => $invoice['id'],
				'sub_total' => $invoice['sub_total'],
				'total_discount' => $invoice['total_discount'],
				'total_tax' => $invoice['total_tax'],
				'total' => $invoice['total'],
				'no' => $invoice['no'],
				'serie' => $invoice['serie'],
				'created' => date(get_dateFormat(), strtotime($invoice['created'])),
				'duedate' => date(get_dateFormat(), strtotime($invoice['duedate'])),
				'created_edit' => $invoice['created'],
				'duedate_edit' => $invoice['duedate'],
				'customer' => $invoice['customer_id'],
				'billing_street' => $invoice['bill_street'],
				'billing_city' => $invoice['bill_city'],
				'billing_state' => $billing_state,
				'billing_state_id' => $invoice['bill_state_id'],
				'billing_zip' => $invoice['bill_zip'],
				'billing_country' => $billing_country,
				'billing_country_id' => $invoice['bill_country'],
				'shipping_street' => $invoice['shipp_street'],
				'shipping_city' => $invoice['shipp_city'],
				'shipping_state' => $shipping_state,
				'shipping_state_id' => $invoice['shipp_state_id'],
				'shipping_zip' => $invoice['shipp_zip'],
				'shipping_country' => $shipping_country,
				'shipping_country_id' => $invoice['shipp_country'],
				'datepayment' => $invoice['datepayment'],
				'duenote' => $invoice['duenote'],
				'status_id' => $invoice['status_id'],
				'default_payment_method' => $invoice['default_payment_method'],
				'duedate_text' => $duedate_text,
				'mail_status' => $mail_status,
				'balance' => $net_balance,
				'partial_is' => $partial_is,
				'items' => $items,
				'payments' => $payments,
				// Recurring Invoice
				'recurring_endDate' => $recurring_endDate,
				'recurring_id' => $invoice['recurring_id'],
				'recurring_status' => $invoice['recurring_status'] == '0' ? true : false,
				'recurring_period' => (int)$invoice['recurring_period'],
				'recurring_type' => $invoice['recurring_type'] ? $invoice['recurring_type'] : 0,
				// END Recurring Invoice
				'payments' => $payments,
				'properties' => $properties,
				'invoice_number' => $invoice['invoice_number'],
				'pdf_status' => $invoice['pdf_status'],
				'customer_contacts' => $this->Contacts_Model->get_customer_contacts($invoice['customer_id']),
			);
			echo json_encode(($invoice_details));
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('invoices'));
		}
	}

	function send_emails($id)
	{
		if (isset($_POST)) {
			$emails = $this->input->post('emails');
			$recipients = array();
			if ($emails) {
				foreach ($emails as $email) {
					$recipients[] = $email['email'];
				}
			}
			if ($this->input->post('include_myself') == '1') {
				$recipients[] = $this->session->userdata('email');
			}
			$invoice = $this->Invoices_Model->get_invoice_detail($id);
			$template = $this->Emails_Model->get_template('invoice', 'invoice_message');
			$appconfig = get_appconfig();
			$inv_number =  get_number("invoices", $invoice['id'], 'invoice', 'inv');
			if ($invoice['status_id'] == 1) {
				$invoicestatus = lang('draft');
			}
			if ($invoice['status_id'] == 3) {
				$invoicestatus = lang('unpaid');
			}
			if ($invoice['status_id'] == 4) {
				$invoicestatus = lang('cancelled');
			}
			if ($invoice['status_id'] == 2) {
				$invoicestatus = lang('partial');
			}
			$name = $invoice['customercompany'] ? $invoice['customercompany'] : $invoice['individualindividual'];
			$link = base_url('share/invoice/' . $invoice['token'] . '');
			$message_vars = array(
				'{invoice_number}' => $inv_number,
				'{invoice_link}' => $link,
				'{invoice_status}' => $invoicestatus,
				'{email_signature}' => $this->session->userdata('email'),
				'{name}' => $this->session->userdata('staffname'),
				'{customer}' => $name,
				'{site_url}' => site_url(),
				'{company_name}' =>  setting['company'],
				'{company_email}' =>  setting['email'],
				'{logo}' => rebrand['app_logo'],
				'{footer_logo}' => rebrand['nav_logo'],
				'{email_banner}' => rebrand['email_banner'],
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);
			if (sizeof($recipients) > 0) {
				$param = array(
					'from_name' => $template['from_name'],
					'email' => serialize($recipients),
					'subject' => $subject,
					'message' => $message,
					'created' => date("Y.m.d H:i:s"),
					'status' => 0
				);
				$this->load->library('mail');
				$data = $this->mail->send_email($invoice['email'], $template['from_name'], $subject, $message);
				
				$now = new DateTime();
				$currentDate = $now->format('Y-m-d H:i:s');

				$this->Invoices_Model->update_invoice_only($id, [
					'datesend' => $currentDate
				]);
				
				$currentDate = date_create($currentDate);
				$currentDate = date_format($currentDate,"d F Y,  g:i a");
				$return['sent_on'] = lang('sent_on') .' '. $currentDate;
				$return['success'] = true;
				$return['message'] = lang('email_sent_success');
				if ($param['email']) {
					$this->db->insert('email_queue', $param);
				}
			} else {
				$return['success'] = false;
				$return['message'] = lang('errormessage');
			}
			echo json_encode($return);
		}
	}

	function get_files($id)
	{
		if (isset($id)) {
			$files = $this->Invoices_Model->get_files($id);
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				$display = false;
				$pdf = false;
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
					$display = true;
				} else if ($ext == 'pdf') {
					$type = 'pdf';
					$pdf = true;
				} else if ($ext == 'zip' || $ext == 'rar' || $ext == 'tar') {
					$type = 'archive';
				} else {
					$display = false;
					$pdf = false;
				}
				$data[] = array(
					'id' => $file['id'],
					'invoice_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => base_url('uploads/files/invoices/' . $id . '/' . $file['file_name']),
				);
			}
			echo json_encode($data);
		}
	}

	function add_file($id)
	{
		if (isset($id)) {
			if (isset($_POST)) {
				if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
					if (!is_dir('uploads/files/invoices/' . $id)) {
						mkdir('./uploads/files/invoices/' . $id, 0777, true);
					}
					$config['upload_path'] = './uploads/files/invoices/' . $id . '';
					$config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
					$config['file'] = $new_name;
					$this->upload->initialize($config);
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('file')) {
						$data['success'] = false;
						$data['message'] = $this->upload->display_errors();
						echo json_encode($data);
					} else {
						$data_upload_files = $this->upload->data();
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/invoices/' . $id . '/' . $image_data['file_name'])) {
							$params = array(
								'relation_type' => 'invoice',
								'relation' => $id,
								'file_name' => $image_data['file_name'],
								'created' => date(" Y.m.d H:i:s "),
							);
							$this->Invoices_Model->update_pdf_status($id, '0');
							$this->db->insert('files', $params);
							$data['success'] = true;
							$data['message'] = lang('file') . ' ' . lang('uploadmessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = $this->upload->display_errors();
							echo json_encode($data);
						}
					}
				} else {
					$data['success'] = false;
					$data['message'] = lang('select_file_error_message');
					echo json_encode($data);
				}
			}
		}
	}

	function download_file($id)
	{
		if (isset($id)) {
			$fileData = $this->Invoices_Model->get_file($id);
			if (is_file('./uploads/files/invoices/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
				$this->load->helper('download');
				$data = file_get_contents('./uploads/files/invoices/' . $fileData['relation'] . '/' . $fileData['file_name']);
				force_download($fileData['file_name'], $data);
			} else {
				$this->session->set_flashdata('ntf4', lang('filenotexist'));
				redirect('invoices/invoice/' . $fileData['relation']);
			}
		}
	}

	function delete_file($id)
	{
		if (isset($id)) {
			$fileData = $this->Invoices_Model->get_file($id);
			$response = $this->db->where('id', $id)->delete('files', array('id' => $id));
			if (is_file('./uploads/files/invoices/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
				unlink('./uploads/files/invoices/' . $fileData['relation'] . '/' . $fileData['file_name']);
			}
			if ($response) {
				$data['success'] = true;
				$data['message'] = lang('file') . ' ' . lang('deletemessage');
			} else {
				$data['success'] = false;
				$data['message'] = lang('errormessage');
			}
			echo json_encode($data);
		} else {
			redirect('invoices');
		}
	}
}
