<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchases extends CIUIS_Controller
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
		$data['title'] = lang('purchases');
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$data['purchases'] = $this->Purchases_Model->get_all_purchases_by_privileges();
			$data['off'] = $this->Report_Model->pff_purchases();
			$data['ofv'] = $this->Report_Model->ofv_purchases();
			$data['oft'] = $this->Report_Model->oft_purchases();
			$data['vgf'] = $this->Report_Model->vgf_purchases();
			$data['tfa'] = $this->Report_Model->tfa_purchases();
			$data['pfs'] = $this->Report_Model->pfs_purchases();
			$data['otf'] = $this->Report_Model->otf_purchases();
			$data['tef'] = $this->Report_Model->tef_purchases();
			$data['vdf'] = $this->Report_Model->vdf_purchases();
			$data['fam'] = $this->Report_Model->fam_purchases();
		} else {
			$data['purchases'] = $this->Purchases_Model->get_all_purchases_by_privileges($this->session->usr_id);
			$data['off'] = $this->Report_Model->total_amount_by_status('1', 'purchases');
			$data['ofv'] = $this->Report_Model->total_amount_by_status('2', 'purchases');
			$data['oft'] = $this->Report_Model->total_amount_by_status('3', 'purchases');
			$data['vgf'] = $this->Report_Model->total_amount_by_status('due', 'purchases');
			$data['tfa'] = $this->Report_Model->total_number_of_data_by_status('4', 'purchases');
			$data['pfs'] = $this->Report_Model->total_number_of_data_by_status('1', 'purchases');
			$data['otf'] = $this->Report_Model->total_number_of_data_by_status('2', 'purchases');
			$data['tef'] = $this->Report_Model->total_number_of_data_by_status('3', 'purchases');
			$data['vdf'] = $this->Report_Model->total_number_of_data_by_status('due', 'purchases');
			$data['fam'] = $this->Report_Model->total_amount_by_status('', 'purchases', 'purchases');
		}

		$data['ofy'] = ($data['tfa'] > 0 ? number_format(($data['tef'] * 100) / $data['tfa']) : 0);
		$data['ofx'] = ($data['tfa'] > 0 ? number_format(($data['otf'] * 100) / $data['tfa']) : 0);
		$data['vgy'] = ($data['tfa'] > 0 ? number_format(($data['vdf'] * 100) / $data['tfa']) : 0);

		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view('purchases/index', $data);
	}

	function create()
	{

		if ($this->Privileges_Model->check_privilege('purchases', 'create')) {
			$data['title'] = lang('newpurchase');
			$settings = $this->Settings_Model->get_settings_ciuis();
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('vendor', lang('vendor'), 'trim|required|integer');
				$this->form_validation->set_rules('serie', lang('series'), 'trim|max_length[25]');
				$this->form_validation->set_rules('no', lang("purchase_number"), 'trim|integer');
				$this->form_validation->set_rules('created', lang('dateofissuance'), 'trim|required|valid_date');
				$this->form_validation->set_rules('status', lang('status'), 'trim|in_list[true,false]');
				$status = $this->input->post('status');
				$paid = ($status == 'true') ? '1' : '0';
				if ($paid == '1') {
					$this->form_validation->set_rules('account', lang('account'), 'trim|required|integer');
					$this->form_validation->set_rules('datepayment', lang('datepaid'), 'trim|required|valid_date');
				} else if ($paid == '0') {
					$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date|callback_compareDate');
					$this->form_validation->set_rules('duenote', lang('duenote'), 'trim|max_length[65535]');
				}
				$this->form_validation->set_rules('recurring', lang('recurring'), 'trim|in_list[0,1]');
				$recurring= $this->input->post('recurring');
				if ($recurring == '1') {
					$this->form_validation->set_rules('recurring_period', lang('recurring_period'), 'trim|required|is_natural_no_zero');
					$this->form_validation->set_rules('end_recurring', lang('ends_on'), 'trim|max_length[100]');
					$this->form_validation->set_rules('recurring_type', lang('recurring_type'), 'trim|required|integer');
				}
				$this->form_validation->set_rules('sub_total', lang('SUB TOTAL'), 'trim|numeric');
				$this->form_validation->set_rules('total_discount', lang('Total Discount'), 'trim|numeric');
				$this->form_validation->set_rules('total_tax', lang('Tax'), 'trim|numeric');
				$this->form_validation->set_rules('total', lang('GRAND TOTAL'), 'trim|numeric');
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
					$data['success'] = false;
					if (((int)($this->input->post('totalItems'))) == 0) {
						$data['message'] = lang('invalid_items');
					} else if ($total == 0) {
						$data['message'] = lang('Total can not be 0');
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
							'vendor_id' => $this->input->post('vendor'),
							'staff_id' => $this->session->usr_id,
							'status_id' => $status,
							'created' => $this->input->post('created'),
							'last_recurring' => date('Y-m-d'),
							'duedate' => $duedate,
							'datepayment' => $datepayment,
							'duenote' => $duenote,
							'sub_total' => $this->input->post('sub_total'),
							'total_discount' => $this->input->post('total_discount'),
							'total_tax' => $this->input->post('total_tax'),
							'total' => $this->input->post('total'),
						);
						$purchase_id = $this->Purchases_Model->purchases_add($params);
						if ($purchase_id == 'required') {
							$hasError = true;
							$datas['message'] = lang('selectinvalidmessage') . ' ' . lang('warehouse');
						} else if ($purchase_id == 'required_type') {
							$hasError = true;
							$datas['message'] = lang('selectinvalidmessage') . ' ' . lang('type');
						} else {
							if ($status == '2') {
								$params = array(
									'staff_id' => $this->session->usr_id,
									'account_id' => $this->input->post('account'),
									'title' => lang('purchase'),
									'date' => $datepayment,
									'created' => date('Y-m-d H:i:s'),
									'amount' =>  $this->input->post('total'),
									'purchase_id' => $purchase_id,
									'internal' => '1',
									'sub_total' => $this->input->post('sub_total'),
									'total_discount' => $this->input->post('total_discount'),
									'total_tax' => $this->input->post('total_tax'),
								);
								$payments = $this->Expenses_Model->create_expense($params);
								$payments_details = $this->Payments_Model->get_payment_details($payments);
							}
							$this->Settings_Model->create_process('pdf', $purchase_id, 'purchase', 'purchase_message');
							// START Recurring Purchase
							if ($this->input->post('recurring') == 'true' || $this->input->post('recurring') == '1') {
								$SHXparams = array(
									'relation_type' => 'purchase',
									'relation' => $purchase_id,
									'period' => $this->input->post('recurring_period'),
									'end_date' => $this->input->post('end_recurring'),
									'type' => $this->input->post('recurring_type'),
								);
								$recurring_purchases_id = $this->Purchases_Model->recurring_add($SHXparams);
								// END Recurring Purchase
							}
							$datas['success'] = true;
							$datas['id'] = $purchase_id;
							if ($appconfig['purchase_series']) {
								$purchase_number = $appconfig['purchase_series'];
								$purchase_number = $purchase_number + 1;
								$this->Settings_Model->increment_series('purchase_series', $purchase_number);
							}
							$datas['message'] = lang('purchases') . ' ' . lang('createmessasge');
							echo json_encode($datas);
						}
					}
				}
			} else {
				$data['all_vendors'] = $this->Vendors_Model->get_all_vendors();
				$data['all_accounts'] = $this->Accounts_Model->get_all_accounts();
				$data['settings'] = $this->Settings_Model->get_settings_ciuis();
				$this->load->view('purchases/create', $data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function update($id = '')
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchases['status_id'] == '2') {
			$this->session->set_flashdata('ntf4', lang('paid') . ' ' . lang('purchase') . ' ' . lang('cant_update'));
			redirect('purchases/purchase/' . $id);
		} else {
			if ($purchases) {
				if ($this->Privileges_Model->check_privilege('purchases', 'edit')) {
					$appconfig = get_appconfig();
					$data['title'] = '' . get_number('purchases', $id, 'purchase', 'purchase') . '';
					$data['purchases'] = $purchases;
					if (isset($purchases['id'])) {
						if (isset($_POST) && count($_POST) > 0) {
							$this->form_validation->set_rules('vendor', lang('vendor'), 'trim|required|integer');
							$this->form_validation->set_rules('serie', lang('series'), 'trim|max_length[25]');
							$this->form_validation->set_rules('no', lang("purchase_number"), 'trim|integer');
							$this->form_validation->set_rules('created', lang('dateofissuance'), 'trim|required|valid_date');
							$this->form_validation->set_rules('status', lang('status'), 'trim|in_list[true,false]');
							$status = $this->input->post('status');
							$paid = ($status == 'true') ? '1' : '0';
							if ($paid == '1') {
								$this->form_validation->set_rules('account', lang('account'), 'trim|required|integer');
								$this->form_validation->set_rules('datepayment', lang('datepaid'), 'trim|required|valid_date');
							} else if ($paid == '0') {
								$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date|callback_compareDate');
								$this->form_validation->set_rules('duenote', lang('duenote'), 'trim|max_length[65535]');
							}
							$this->form_validation->set_rules('recurring_status', lang('RECURRING'), 'trim|in_list[0,1]');
								if ($this->input->post('recurring_status') == 'true') {
								$this->form_validation->set_rules('recurring_period', lang('recurring_period'), 'trim|required|is_natural_no_zero');
								$this->form_validation->set_rules('end_recurring', lang('ends_on'), 'trim|max_length[100]');
								$this->form_validation->set_rules('recurring_type', lang('recurring_type'), 'trim|required|integer');
							}
							$this->form_validation->set_rules('sub_total', lang('SUB TOTAL'), 'trim|numeric');
							$this->form_validation->set_rules('total_discount', lang('Total Discount'), 'trim|numeric');
							$this->form_validation->set_rules('total_tax', lang('Tax'), 'trim|numeric');
							$this->form_validation->set_rules('total', lang('GRAND TOTAL'), 'trim|numeric');
							$data['message'] = '';
							if ($this->form_validation->run() == false) {
								$data['success'] = false;
								$data['message'] = validation_errors();
								echo json_encode($data);
							} else {
								$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
								$data['success'] = false;
								if (((int) ($this->input->post('totalItems'))) == 0) {
									$data['message'] = lang('invalid_items');
								} else if ($total == 0) {
									$data['message'] = lang('invalid_total');
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
										'no' => $this->input->post('no'),
										'serie' => $this->input->post('serie'),
										'vendor_id' => $this->input->post('vendor'),
										'created' => $this->input->post('created'),
										'last_recurring' => date('Y-m-d'),
										'duedate' => $duedate,
										'duenote' => $duenote,
										'datepayment' => $datepayment,
										'sub_total' => $this->input->post('sub_total'),
										'total_discount' => $this->input->post('total_discount'),
										'total_tax' => $this->input->post('total_tax'),
										'total' => $this->input->post('total'),
										'status_id' => $status,
									);
									$result = $this->Purchases_Model->update_purchases($id, $params);
									if ($result == 'required') {
										$hasError = true;
										$data['message'] = lang('selectinvalidmessage') . ' ' . lang('warehouse');
									} else if ($result == 'required_type') {
										$hasError = true;
										$data['message'] = lang('selectinvalidmessage') . ' ' . lang('type');
									} else {
										if ($status == '2') {
											$params = array(
												'staff_id' => $this->session->usr_id,
												'account_id' => $this->input->post('account'),
												'title' => lang('purchase'),
												'date' => $datepayment,
												'created' => date('Y-m-d H:i:s'),
												'amount' =>  $this->input->post('total'),
												'purchase_id' => $id,
												'internal' => '1',
												'sub_total' => $this->input->post('total'),
												'total_discount' => '0',
												'total_tax' => '0'
											);
											$payments = $this->Expenses_Model->create_expense($params);
											$payments_details = $this->Payments_Model->get_payment_details($payments);
										}
										// START Recurring Purchase
										if ($this->input->post('recurring') == 'true') {
											$SHXparams = array(
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
												'status' => 0,
											);
											$recurring_purchases_id = $this->Purchases_Model->recurring_update($id, $SHXparams);
										} else {
											$SHXparams = array(
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
												'status' => 1,
											);
											$recurring_purchases_id = $this->Purchases_Model->recurring_update($id, $SHXparams);
										}
										if (!is_numeric($this->input->post('recurring_id')) && ($this->input->post('recurring_status') == 'true')) { // NEW Recurring From Update
											$SHXparams = array(
												'relation_type' => 'purchase',
												'relation' => $id,
												'period' => $this->input->post('recurring_period'),
												'end_date' => $this->input->post('end_recurring'),
												'type' => $this->input->post('recurring_type'),
											);
											$recurring_purchases_id = $this->Purchases_Model->recurring_add($SHXparams);
										}
										$this->Purchases_Model->update_pdf_status($id, '0');
										$data['success'] = true;
										$data['id'] = $id;
										$data['message'] = lang('purchase') . ' ' . lang('updatemessage');
									}
								}

								echo json_encode($data);
							}
							// END Recurring Invoice
						} else {
							$this->load->view('purchases/update', $data);
						}
					} else {
						$this->session->set_flashdata('ntf3', '' . $id . lang('error'));
						redirect('purchases');
					}
				} else {
					$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
					redirect(base_url('purchases/purchase/' . $id));
				}
			} else {
				$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
				redirect(base_url('purchases'));
			}
		}
	}

	function compareDate()
	{
		$created = strtotime($this->input->post('created'));
		$duedate = strtotime($this->input->post('duedate'));
		if ($duedate >= $created)
			return True;
		else {
			$this->form_validation->set_message('compareDate', lang('dateofissuance') . ' ' . lang('date_error') . ' ' . lang('duedate'));
			return False;
		}
	}

	function purchase($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchase) {
			if (isset($purchase['id'])) {
				$appconfig = get_appconfig();
				$data['title'] = '' . get_number('purchases', $id, 'purchase', 'purchase') . ' ' . lang('detail') . '';
				$data['purchases'] = $purchase;
				$this->load->view('purchases/purchase', $data);
			} else {
				redirect(base_url('purchases'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function record_payment()
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'edit')) {
			$amount = $this->input->post('total');
			$purchasetotal = $this->input->post('purchasetotal');
			if (isset($_POST) && count($_POST) > 0) {
				$amount = $amount;
				$not = $this->input->post('not');
				$account = $this->input->post('account');
				$purchase_id = $this->input->post('purchase');
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
				} else if ($amount > $purchasetotal) {
					$hasError = true;
					$data['message'] = lang('paymentamounthigh') . ' ' . lang('purchase');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'category_id' => $this->Purchases_Model->get_category_id(),
						'staff_id' => $this->session->usr_id,
						'account_id' => $this->input->post('account'),
						'title' => lang('purchase'),
						'date' => $this->input->post('date'),
						'created' => date('Y-m-d H:i:s'),
						'amount' =>  $amount,
						'description' => $this->input->post('not'),
						'purchase_id' => $this->input->post('purchase'),
						'internal' => '1',
						'sub_total' => $amount,
						'total_discount' => '0',
						'total_tax' => '0'
					);
					$items = $this->Report_Model->get_items('purchase', $purchase_id);
					$payments = $this->Expenses_Model->create_expense($params, $items);
					$template = $this->Emails_Model->get_template('purchase', 'purchase_payment');
					if ($template['status'] == 1) {
						$payments_details = $this->Payments_Model->get_payment_details($payments);
						$appconfig = get_appconfig();
						$purchase = $this->Purchases_Model->get_purchases_detail($purchase_id);
						$purchase_number = get_number('purchases', $purchase['id'], 'purchase', 'purchase');
						$purchasestatus = $this->Purchases_Model->get_status($purchase)['status'];
						$name = $purchase['vendorcompany'];
						$link = base_url('share/purchases/' . $purchase['token'] . '');

						$message_vars = array(
							'{purchase_number}' => $purchase_number,
							'{vendor_name}' => $name,
							'{issuance_date}' => $purchase['created'],
							'{due_date}' => $purchase['duedate'],
							'{payment_date}' => $payments_details['date'],
							'{payment_amount}' => $payments_details['amount'],
							'{payment_account}' => $payments_details['name'],
							'{payment_description}' => $payments_details['not'],
							'{payment_made_by}' => $payments_details['staffname'],
							'{purchase_status}' => $purchasestatus,
							'{total_amount}' => $purchase['total'],
							'{company_name}' => setting['company'],
							'{company_email}' => setting['email'],
							'{site_url}' => site_url(),
							'{due_note}' => $purchase['duenote'],
							'{purchase_link}' => $link,
							'{logo}' => rebrand['app_logo'],
							'{footer_logo}' => rebrand['nav_logo'],
							'{email_banner}' => rebrand['email_banner'],

						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $purchase['email'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s"),
						);
						if ($purchase['email']) {
							$this->db->insert('email_queue', $param);
						}
					}
					$data['success'] = true;
					$data['id'] = $purchase_id;
					$data['message'] = lang('paymentaddedsuccessfully');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function print_($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchases) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/purchases/' . $id)) {
				mkdir('./uploads/files/purchases/' . $id, 0777, true);
			}
			$data['title'] = '' . get_number('purchases', $id, 'purchase', 'purchase') . '';
			$data['purchase'] = $purchases;
			$data['vendor_country'] = get_country($data['purchase']['vendorcountry']);
			$data['vendor_state'] = get_state_name(' ', $data['purchase']['vendorstate']);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'purchase', 'relation' => $id))->result_array();
			$this->load->view('purchases/pdf', $data);
			$file_name = '' . get_number('purchases', $id, 'purchase', 'purchase') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library('dom');
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('uploads/files/purchases/' . $id . '/' . $file_name . '', $output);
			if ($output) {
				redirect(base_url('uploads/files/purchases/' . $id . '/' . $file_name . ''));
				//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			} else {
				redirect(base_url('purchases/pdf_falut/'));
			}
			$this->dompdf->stream('' . $file_name . '', array("Attachment" => 0));
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function create_pdf($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchases = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchases) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/purchases/' . $id)) {
				mkdir('./uploads/files/purchases/' . $id, 0777, true);
			}
			$data['title'] = '' . get_number('purchases', $id, 'purchase', 'purchase') . '';
			$data['purchase'] = $purchases;
			$data['vendor_country'] = get_country($data['purchase']['vendorcountry']);
			$data['vendor_state'] = get_state_name(' ', $data['purchase']['vendorstate']);
			// $data['vendor_country'] = get_country($data[ 'purchase' ]['country_id']);
			// $data['vendor_state'] = get_state_name(' ',$data['purchase']['state']);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'purchase', 'relation' => $id))->result_array();
			$this->load->view('purchases/pdf', $data);

			$file_name = '' . get_number('purchases', $id, 'purchase', 'purchase') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library('dom');
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('uploads/files/purchases/' . $id . '/' . $file_name . '', $output);
			$this->Purchases_Model->update_pdf_status($id, '1');
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ($output) {
				redirect(base_url('purchases/pdf_generated/' . $file_name . ''));
			} else {
				redirect(base_url('purchases/pdf_fault/'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function send_purchase_email($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchase) {
			$template = $this->Emails_Model->get_template('purchase', 'purchase_message');
			$purchase_number = get_number('purchases', $id, 'purchase', 'purchase');
			$path = '';
			if ($template['attachment'] == '1') {
				if ($purchase['pdf_status'] == '0') {
					$this->Purchases_Model->generate_pdf($id);
					$file = get_number('purchases', $purchase['id'], 'purchase', 'purchase');
					$path = base_url('uploads/files/purchases/' . $id . '/' . $file . '.pdf');
				} else {
					$file = get_number('purchases', $purchase['id'], 'purchase', 'purchase');
					$path = base_url('uploads/files/purchases/' . $id . '/' . $file . '.pdf');
				}
			}
			$purchasestatus = $this->Purchases_Model->get_status($purchase)['status'];
			$name = $purchase['vendorcompany'];
			$link = base_url('share/purchases/' . $purchase['token'] . '');

			$message_vars = array(
				'{purchase_number}' => $purchase_number,
				'{vendor_name}' => $name,
				'{issuance_date}' => $purchase['created'],
				'{due_date}' => $purchase['duedate'],
				'{purchase_status}' => $purchasestatus,
				'{total_amount}' => $purchase['total'],
				'{company_name}' => setting['company'],
				'{company_email}' => setting['email'],
				'{site_url}' => site_url(),
				'{due_note}' => $purchase['duenote'],
				'{purchase_link}' => $link,
				'{logo}' => rebrand['app_logo'],
				'{footer_logo}' => rebrand['nav_logo'],
				'{email_banner}' => rebrand['email_banner'],
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);

			$param = array(
				'from_name' => $template['from_name'],
				'email' => $purchase['email'],
				'subject' => $subject,
				'message' => $message,
				'created' => date("Y.m.d H:i:s"),
				'status' => 0,
				'attachments' => $path ? $path : NULL,
			);

			$this->load->library('mail');
			$data = $this->mail->send_email($purchase['email'], $template['from_name'], $subject, $message, $path);
			if ($data['success'] == true) {
				$now = new DateTime();
                $currentDate = $now->format('Y-m-d H:i:s ');
                $this->Purchases_Model->update_purchase_only($id, [
					'datesend' => $currentDate
				]);
				$return['status'] = true;
				$return['message'] = $data['message'];
				if ($purchase['email']) {
					$this->db->insert('email_queue', $param);
				}
				$currentDate = date_create($currentDate);
                $currentDate = date_format($currentDate,"d F Y,  H:i a");
                $return['sent_on'] = lang('sent_on') .' '. $currentDate;
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
		$inv = $this->Purchases_Model->get_purchases_detail($id);

		$invcustomer = $inv['vendorcompany'];
		$data = array(
			'customer' => $invcustomer,
			'customermail' => $inv['email'],
			'invoicelink' => '' . base_url('share/purchases/' . $inv['token'] . '') . ''
		);
		$body = $this->load->view('email/invoices/sendpurchase.php', $data, TRUE);
		$subject = lang('yourinvoicedetails');
		$to = $inv['email'];
		$result = send_email($subject, $to, $data, $body);

		if ($result) {

			$response = $this->db->where('id', $id)->update('purchases', array('datesend' => date('Y-m-d H:i:s')));
			$this->session->set_flashdata('ntf1', '<b>' . $inv['email'], lang('sendmailvendor') . '</b>');
			redirect('purchases/purchase/' . $id . '');
		} else {

			$this->session->set_flashdata('ntf4', '<b>' . lang('sendmailcustomereror') . '</b>');
			redirect('purchases/purchase/' . $id . '');
		}
	}

	function mark_as_draft($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'edit')) {
			$response = $this->db->where('id', $id)->update('purchases', array('status_id' => 1));
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
		if ($this->Privileges_Model->check_privilege('purchases', 'edit')) {
			$response = $this->db->where('id', $id)->update('purchases', array('status_id' => 4));
			$response = $this->db->delete('payments', array('purchase_id' => $id));
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
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($purchase) {
			if ($this->Privileges_Model->check_privilege('purchases', 'delete')) {
				if (isset($purchase['id'])) {
					//log's
					$this->Purchases_Model->delete_purchases($id, get_number('purchases', $id, 'purchase', 'purchase'),$purchase['vendor_id']);
					$data['success'] = true;
					$data['message'] = lang('purchase') . ' ' . lang('deletemessage');
					echo json_encode($data);
				} else
					redirect(base_url('purchases'));
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function remove_item($id)
	{
		$response = $this->db->delete('items', array('id' => $id));
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

	function download_pdf($id)
	{
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchase) {
			if (isset($id)) {
				$file_name = '' . get_number('purchases', $id, 'purchase', 'purchase') . '.pdf';
				if (is_file('./uploads/files/purchases/' . $id . '/' . $file_name)) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/purchases/' . $id . '/' . $file_name);
					force_download($file_name, $data);
				} else {
					$this->session->set_flashdata('ntf4', lang('filenotexist'));
					redirect('purchases/purchase/' . $id);
				}
			} else {
				redirect('purchases/purchase/' . $id);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function get_purchase($id)
	{
		$purchase = array();
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchase = $this->Purchases_Model->get_purchase_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
		if ($purchase) {

			$fatop = $this->Purchases_Model->get_items_purchases($id);
			$tadtu = $this->Purchases_Model->get_paid_purchases($id);
			$appconfig = get_appconfig();
			$total = $purchase['total'];
			$today = time();
			$duedate = strtotime($purchase['duedate']);
			$created = strtotime($purchase['created']);
			$paymentday = $duedate - $created;
			$paymentx = $today - $created;
			$datepaymentnet = $paymentday - $paymentx;
			if ($purchase['duedate'] == 0) {
				$duedate_text = 'No Due Date';
			} else {
				if ($datepaymentnet < 0) {
					$duedate_text = lang('overdue');
					$duedate_text = '' . floor($datepaymentnet / (60 * 60 * 24)) . ' days';
				} else {
					$duedate_text = lang('payableafter') . floor($datepaymentnet / (60 * 60 * 24)) . ' ' . lang('day') . '';
				}
			}
			if ($purchase['datesend'] == 0) {
				$mail_status = lang('notyetbeensent');
			} else $mail_status = lang('sent_on') .' '. _adate($purchase['datesend']);
			$kalan = $total - $tadtu->row()->amount;
			$net_balance = $kalan;
			if ($tadtu->row()->amount < $total && $tadtu->row()->amount > 0) {
				$partial_is = true;
			} else $partial_is = false;
			$payments = $this->db->select('*,accounts.name as accountname,payments.id as id ')->join('accounts', 'payments.account_id = accounts.id', 'left')->get_where('payments', array('purchase_id' => $id))->result_array();
			$items = $this->Report_Model->get_items('purchase', $id);
			$properties = array(
				'purchase_id' => '' . get_number("purchases", $purchase['id'], 'purchase', 'purchase') . '',
				'vendor_company' => $purchase['vendorcompany'],
				'vendor_address' => $purchase['vendoraddress'],
				'vendor_phone' => $purchase['vendor_phone'],
				'purchase_staff' => $purchase['staffmembername'],

			);
			if ($purchase['recurring_endDate'] != 'Invalid date') {
				$recurring_endDate = date(DATE_ISO8601, strtotime($purchase['recurring_endDate']));
			} else {
				$recurring_endDate = '';
			}
			$purchase_details = array(
				'id' => $purchase['id'],
				'sub_total' => $purchase['sub_total'],
				'total_discount' => $purchase['total_discount'],
				'total_tax' => $purchase['total_tax'],
				'total' => $purchase['total'],
				'no' => $purchase['no'],
				'serie' => $purchase['serie'],
				'created' => date(get_dateFormat(), strtotime($purchase['created'])),
				'duedate' => date(get_dateFormat(), strtotime($purchase['duedate'])),
				'created_edit' => $purchase['created'],
				'duedate_edit' => $purchase['duedate'],
				'vendor' => $purchase['vendor_id'],
				'datepayment' => $purchase['datepayment'],
				'duenote' => $purchase['duenote'],
				'status_id' => $purchase['status_id'],
				'duedate_text' => $duedate_text,
				'mail_status' => $mail_status,
				'balance' => $net_balance,
				'partial_is' => $partial_is,
				'items' => $items,
				'payments' => $payments,
				// Recurring Purchase, end date
				'end_recurring' => $recurring_endDate,
				'recurring_id' => $purchase['recurring_id'],
				'recurring_status' => $purchase['recurring_status'] == '0' ? true : false,
				'recurring_period' => (int)$purchase['recurring_period'],
				'recurring_type' => $purchase['recurring_type'] ? $purchase['recurring_type'] : 0,
				// END Recurring Purchase
				'payments' => $payments,
				'properties' => $properties,
				'purchase_number' => $purchase['purchase_number'],
				'pdf_status' => $purchase['pdf_status'],
			);
			echo json_encode($purchase_details);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('purchases'));
		}
	}

	function get_purchases()
	{
		$purchases = array();
		if ($this->Privileges_Model->check_privilege('purchases', 'all')) {
			$purchases = $this->Purchases_Model->get_all_purchases_by_privileges();
		} else if ($this->Privileges_Model->check_privilege('purchases', 'own')) {
			$purchases = $this->Purchases_Model->get_all_purchases_by_privileges($this->session->usr_id);
		}
		$data_purchases = array();
		foreach ($purchases as $purchase) {
			if ($purchase['duedate'] == 0000 - 00 - 00) {
				$realduedate = 'No Due Date';
			} else {
				$realduedate = date(get_dateFormat(), strtotime($purchase['duedate']));
			}
			['status' => $purchasesstatus, 'color' => $color] = $this->Purchases_Model->get_status($purchase);
			$customer = $purchase['vendorcompany'];
			$appconfig = get_appconfig();
			$data_purchases[] = array(
				'id' => $purchase['id'],
				'prefix' => $appconfig['purchase_prefix'],
				'longid' => get_number("purchases", $purchase['id'], 'purchase', 'purchase'),
				'created' => date(get_dateFormat(), strtotime($purchase['created'])),
				'duedate' => $realduedate,
				'customer' => $customer,
				'vendor_id' => $purchase['vendor_id'],
				'recurring_status' => $purchase['recurring_status'] == '0' ? true : false,
				'staff_id' => $purchase['staff_id'],
				'total' => (float)$purchase['total'],
				'status' => $purchasesstatus,
				'color' => $color,
				'' . lang('filterbystatus') . '' => $purchasesstatus,
				'' . lang('filterbyvendor') . '' => $customer,
				'staff' => $purchase['staffmembername'],
				'staffavatar' => $purchase['staffmemberresim'],
			);
		};

		echo json_encode($data_purchases);
	}
}
