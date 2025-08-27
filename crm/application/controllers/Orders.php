<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Orders extends CIUIS_Controller
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
		$data['title'] = lang('orders');
		$data['orders'] = $this->Orders_Model->get_all_orders();
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view('orders/index', $data);
	}

	function create()
	{
		if ($this->Privileges_Model->check_privilege('orders', 'create')) {
			$data['title'] = lang('new') . ' ' . lang('order');
			$appconfig = get_appconfig();
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[70]');
				$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
				$this->form_validation->set_rules('date', lang('issue') . ' ' . lang('date'), 'trim|required|valid_date');
				$this->form_validation->set_rules('assigned', lang('assigned'), 'trim|required|integer');
				$this->form_validation->set_rules('status', lang('status'), 'trim|required|integer');
				$this->form_validation->set_rules('opentill', lang('opentill'), 'trim|required|valid_date|callback_compareDate');
				$this->form_validation->set_rules('content', lang('description'), 'trim|required|max_length[65535]');
				$this->form_validation->set_rules('comment', lang('comments'), 'trim|in_list[true,false]');
				$this->form_validation->set_rules('recurring', lang('recurring'), 'trim|integer|in_list[0,1]');
				$recurring = $this->input->post('recurring');
				if ($recurring == '1') {
					$this->form_validation->set_rules('recurring_period', lang('recurring_period'), 'trim|required|integer');
					$this->form_validation->set_rules('end_recurring', lang('ends_recurring'), 'trim|max_length[100]');
				}
				$this->form_validation->set_rules('billing_country', lang('billing_country'), 'trim|integer');
				$this->form_validation->set_rules('billing_state_id', lang('billing_state'), 'trim|integer');
				$this->form_validation->set_rules('billing_city', lang('billing_city'), 'trim|max_length[50]');
				$this->form_validation->set_rules('billing_zip', lang('billing_zip'), 'trim|max_length[20]');
				$this->form_validation->set_rules('billing_street', lang('billing_street'), 'trim|max_length[100]');
				$this->form_validation->set_rules('shipping_country', lang('shipping_country'), 'trim|integer');
				$this->form_validation->set_rules('shipping_state_id', lang('shipping_state'), 'trim|integer');
				$this->form_validation->set_rules('shipping_city', lang('shipping_city'), 'trim|max_length[50]');
				$this->form_validation->set_rules('shipping_zip', lang('shipping_zip'), 'trim|max_length[20]');
				$this->form_validation->set_rules('shipping_street', lang('shipping_street'), 'trim|max_length[100]');
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
					if (((int)($this->input->post('total_items'))) == 0) {
						$data['message'] = lang('invalid_items');
					} else if ($total == 0) {
						$data['message'] = lang('invalid_total');
					} else {
						$customer = $this->input->post('customer');
						$subject = $this->input->post('subject');
						$assigned = $this->input->post('assigned');
						$date = $this->input->post('date');
						$opentill = $this->input->post('opentill');
						$total = $this->input->post('total');
						$status = $this->input->post('status');
						$recurring_period = $this->input->post('recurring_period');
						$allow_comment = $this->input->post('comment');
						if ($allow_comment != true) {
							$comment_allow = 0;
						} else {
							$comment_allow = 1;
						};
						$params = array(
							'token' => md5(uniqid()),
							'subject' => $subject,
							'content' => $this->input->post('content'),
							'date' => $date,
							'created' => date('Y-m-d'),
							'opentill' => $opentill,
							'relation_type' => 'customer',
							'relation' => $customer,
							'assigned' => $assigned,
							'addedfrom' => $this->session->usr_id,
							'comment' => $comment_allow,
							'status_id' => $this->input->post('status'),
							'sub_total' => $this->input->post('sub_total'),
							'total_discount' => $this->input->post('total_discount'),
							'total_tax' => $this->input->post('total_tax'),
							'total' => $total,
							'last_recurring' => date('Y-m-d'),
							'billing_street' => $this->input->post('billing_street'),
							'billing_city' => $this->input->post('billing_city'),
							'billing_state' => $this->input->post('billing_state_id'),
							'billing_zip' => $this->input->post('billing_zip'),
							'billing_country' => $this->input->post('billing_country'),
							'shipping_street' => $this->input->post('shipping_street'),
							'shipping_city' => $this->input->post('shipping_city'),
							'shipping_state' => $this->input->post('shipping_state_id'),
							'shipping_zip' => $this->input->post('shipping_zip'),
							'shipping_country' => $this->input->post('shipping_country'),
						);
						$orders_id = $this->Orders_Model->order_add($params);
						if ($orders_id == 'error') {
							$hasError = true;
							$data['message'] = lang('limited_stock');
						} elseif ($orders_id == 'required') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage') . ' ' . lang('warehouse');
						} else if ($orders_id == 'required_type') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage') . ' ' . lang('type');
						} else {
							// Custom Field Post
							if ($this->input->post('custom_fields')) {
								$custom_fields = array(
									'custom_fields' => $this->input->post('custom_fields')
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'order', $orders_id);
							}
							$this->Settings_Model->create_process('pdf', $orders_id, 'order', 'order_message');
							if ($recurring == '1') {
								$SHXparams = array(
									'relation_type' => 'order',
									'relation' => $orders_id,
									'period' => $recurring_period,
									'end_date' => $this->input->post('end_recurring'),
									'type' => $this->input->post('recurring_type'),
								);
								$this->Invoices_Model->recurring_add($SHXparams);
							}
							$data['success'] = true;
							$data['message'] = lang('order') . ' ' . lang('createmessage');
							$data['id'] = $orders_id;
							if ($appconfig['order_series']) {
								$order_number = $appconfig['order_series'];
								$order_number = $order_number + 1;
								$this->Settings_Model->increment_series('order_series', $order_number);
							}
						}
					}
					echo json_encode($data);
				}
			} else {
				$this->load->view('orders/create', $data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function compareDate()
	{
		$startDate = strtotime($this->input->post('date'));
		$endDate = strtotime($this->input->post('opentill'));
		if ($endDate >= $startDate)
			return True;
		else {
			$this->form_validation->set_message('compareDate', lang('issue') . ' ' . lang('date') . ' ' . lang('date_error') . ' ' . lang('end') . ' ' . lang('date'));
			return False;
		}
	}

	function update($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$data['order'] = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$data['order']  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($data['order']['status_id'] == '2') {
			$this->session->set_flashdata('ntf4', lang('sent') . ' ' . lang('order') . ' ' . lang('cant_update'));
			redirect(base_url('orders/order/' . $id));
		} else {
			if ($data['order']) {
				if ($this->Privileges_Model->check_privilege('orders', 'edit')) {
					$data['title'] = lang('update') . ' ' . lang('order');
					if (isset($pro['id'])) {
						if (isset($_POST) && count($_POST) > 0) {
							$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[70]');
							$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
							$this->form_validation->set_rules('date', lang('issue') . ' ' . lang('date'), 'trim|required|valid_date');
							$this->form_validation->set_rules('assigned', lang('assigned'), 'trim|required|integer');
							$this->form_validation->set_rules('status', lang('status'), 'trim|required|integer');
							$this->form_validation->set_rules('opentill', lang('opentill'), 'trim|required|valid_date|callback_compareDate');
							$this->form_validation->set_rules('content', lang('description'), 'trim|required|max_length[65535]');
							$this->form_validation->set_rules('comment', lang('comments'), 'trim|in_list[true,false]');
							$this->form_validation->set_rules('recurring', lang('recurring'), 'trim|in_list[true,false]');

								if ($this->input->post('recurring') == 'true') {
								$this->form_validation->set_rules('recurring_period', lang('recurring_type'), 'trim|required|integer');
								$this->form_validation->set_rules('end_recurring', lang('end_recurring'), 'trim|max_length[100]');
								$this->form_validation->set_rules('recurring_type', lang('recurring_type'), 'trim|required|integer');
							}
							$this->form_validation->set_rules('billing_country', lang('billing_country'), 'trim|integer');
							$this->form_validation->set_rules('billing_state_id', lang('billing_state'), 'trim|integer');
							$this->form_validation->set_rules('billing_city', lang('billing_city'), 'trim|max_length[50]');
							$this->form_validation->set_rules('billing_zip', lang('billing_zip'), 'trim|max_length[20]');
							$this->form_validation->set_rules('billing_street', lang('billing_street'), 'trim|max_length[100]');
							$this->form_validation->set_rules('shipping_country', lang('shipping_country'), 'trim|integer');
							$this->form_validation->set_rules('shipping_state_id', lang('shipping_state'), 'trim|integer');
							$this->form_validation->set_rules('shipping_city', lang('shipping_city'), 'trim|max_length[50]');
							$this->form_validation->set_rules('shipping_zip', lang('shipping_zip'), 'trim|max_length[20]');
							$this->form_validation->set_rules('shipping_street', lang('shipping_street'), 'trim|max_length[100]');
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
								if (((int) ($this->input->post('total_items'))) == 0) {
									$data['message'] = lang('Please add at least one item');
								} else if ($total == 0) {
									$data['message'] = lang('Total can not be 0');
								}
								$customer = $this->input->post('customer');
								$subject = $this->input->post('subject');
								$assigned = $this->input->post('assigned');
								$date = $this->input->post('date');
								$opentill = $this->input->post('opentill');
								$status = $this->input->post('status');
								$data['message'] = '';
								switch ($this->input->post('comment')) {
									case 'true':
										$comment_allow = 1;
										break;
									case 'false':
										$comment_allow = 0;
										break;
								};
								$params = array(
									'subject' => $subject,
									'content' => $this->input->post('content'),
									'date' => $date,
									'opentill' =>  $opentill,
									'relation_type' => 'customer',
									'relation' => $customer,
									'assigned' => $assigned,
									'addedfrom' => $this->session->usr_id,
									'comment' => $comment_allow,
									'status_id' => $status,
									'sub_total' => $this->input->post('sub_total'),
									'total_discount' => $this->input->post('total_discount'),
									'total_tax' => $this->input->post('total_tax'),
									'total' => $this->input->post('total'),
									'billing_street' => $this->input->post('billing_street'),
									'billing_city' => $this->input->post('billing_city'),
									'billing_state' => $this->input->post('billing_state_id'),
									'billing_zip' => $this->input->post('billing_zip'),
									'billing_country' => $this->input->post('billing_country'),
									'shipping_street' => $this->input->post('shipping_street'),
									'shipping_city' => $this->input->post('shipping_city'),
									'shipping_state' => $this->input->post('shipping_state_id'),
									'shipping_zip' => $this->input->post('shipping_zip'),
									'shipping_country' => $this->input->post('shipping_country'),
								);
								$order = $this->Orders_Model->update_orders($id, $params);
								if ($order == 'error') {
									$hasError = true;
									$data['message'] = lang('limited_stock');
								} elseif ($order == 'required') {
									$hasError = true;
									$data['message'] = lang('selectinvalidmessage') . ' ' . lang('warehouse');
								} else if ($order == 'required_type') {
									$hasError = true;
									$data['message'] = lang('selectinvalidmessage') . ' ' . lang('type');
								} else {
									// Custom Field Post
									if ($this->input->post('custom_fields')) {
										$custom_fields = array(
											'custom_fields' => $this->input->post('custom_fields')
										);
										$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'order', $id);
									}
									// START Recurring Order
									$SHXparams = array(
										'period' => $this->input->post('recurring_period'),
										'end_date' => $this->input->post('end_recurring'),
										'type' => $this->input->post('recurring_type'),
										'status' => ($this->input->post('recurring') == 'true' ? '0' : '1'),
									);
									$this->Orders_Model->recurring_update($id, $SHXparams);
									if (!is_numeric($this->input->post('recurring_id')) && ($this->input->post('recurring_status') == 'true')) {
										// NEW Recurring From Update
										$SHXparams = array(
											'relation_type' => 'order',
											'relation' => $id,
											'period' => $this->input->post('recurring_period'),
											'end_date' => $this->input->post('end_recurring'),
											'type' => $this->input->post('recurring_type'),
										);
										$this->Invoices_Model->recurring_add($SHXparams);
									}
									$this->Orders_Model->update_pdf_status($id, '0');
									$data['success'] = true;
									$data['id'] = $id;
									$data['message'] = lang('order') . ' ' . lang('updatemessasge');
								}
								echo json_encode($data);
							}
							// echo $id;
						} else {
							$this->load->view('orders/update', $data);
						}
					} else {
						$this->session->set_flashdata('ntf3', '' . $id . lang('orderediterror'));
					}
				} else {
					$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
					redirect(base_url('orders/order/' . $id));
				}
			} else {
				$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
				redirect(base_url('orders'));
			}
		}
	}

	function order($id)
	{
	
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$data['orders'] = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$data['orders']  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($data['orders']) {
			$data['title'] = lang('order');
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view('orders/order', $data);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
	}

	function download_pdf($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($order) {
			if (isset($id)) {
				$file_name = '' . get_number('orders', $id, 'order', 'order') . '.pdf';
				if (is_file('./uploads/files/orders/' . $id . '/' . $file_name)) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/orders/' . $id . '/' . $file_name);
					force_download($file_name, $data);
				} else {
					$this->session->set_flashdata('ntf4', lang('filenotexist'));
					redirect('orders/order/' . $id);
				}
			} else {
				redirect('orders/order/' . $id);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
	}

	function create_pdf($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($order) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/orders/' . $id)) {
				mkdir('./uploads/files/orders/' . $id, 0777, true);
			}
			$data['orders'] = $order;
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['custcountry'] = get_country($data['orders']['country_id']);
			$data['custstate'] = get_state_name($data['orders']['state'], $data['orders']['state_id']);
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'order', 'relation' => $id))->result_array();
			$this->load->view('orders/pdf', $data);
			$file_name = '' . get_number('orders', $id, 'order', 'order') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library('dom');
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			unset($this->dompdf);
			file_put_contents('uploads/files/orders/' . $id . '/' . $file_name . '', $output);
			$this->Orders_Model->update_pdf_status($id, '1');
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ($output) {
				redirect(base_url('orders/pdf_generated/' . $file_name . ''));
			} else {
				redirect(base_url('orders/pdf_fault/'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
	}

	function print_($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($order) {
			$data['orders'] = $order;
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['custcountry'] = get_country($data['orders']['country_id']);
			$data['custstate'] = get_state_name($data['orders']['state'], $data['orders']['state_id']);
			$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'order', 'relation' => $id))->result_array();
			$this->load->view('orders/pdf', $data);
			$file_name = '' . get_number('orders', $id, 'order', 'order') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library('dom');
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('assets/files/generated_pdf_files/orders/' . $file_name . '', $output);
			redirect(base_url('assets/files/generated_pdf_files/orders/' . $file_name . ''));
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
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
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		$data['orders'] = $this->Orders_Model->get_orders($id, $rel_type);
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$data['items'] = $this->db->select('*')->get_where('items', array('relation_type' => 'order', 'relation' => $id))->result_array();
		$this->load->view('orders/pdf', $data);
	}

	function share($id)
	{
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($rel_type == 'customer') {
			$order = $this->Orders_Model->get_orders($id, $rel_type);
			$data['orders'] = $this->Orders_Model->get_orders($id, $rel_type);
			switch ($order['type']) {
				case '0':
					$orderto = $order['customercompany'];
					break;
				case '1':
					$orderto = $order['namesurname'];
					break;
			}
			$ordertoemail = $order['toemail'];
		}
		if ($rel_type == 'lead') {
			$order = $this->Orders_Model->get_orders($id, $rel_type);
			$data['orders'] = $this->Orders_Model->get_orders($id, $rel_type);
			$orderto = $order['leadname'];
			$ordertoemail = $order['toemail'];
		}
		$subject = lang('neworder');
		$to = $ordertoemail;
		$data = array(
			'customer' => $orderto,
			'customermail' => $ordertoemail,
			'orderlink' => '' . base_url('share/order/' . $pro['token'] . '') . ''
		);
		$body = $this->load->view('email/orders/send.php', $data, TRUE);
		$result = send_email($subject, $to, $data, $body);
		if ($result) {
			$response = $this->db->where('id', $id)->update('orders', array('datesend' => date('Y-m-d H:i:s')));
			$this->session->set_flashdata('ntf1', '<b>' . lang('sendmailcustomer') . '</b>');
			redirect('orders/order/' . $id . '');
		} else {
			$this->session->set_flashdata('ntf4', '<b>' . lang('sendmailcustomereror') . '</b>');
			redirect('orders/order/' . $id . '');
		}
	}

	function send_order_email($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
		if ($order) {
			if ($rel_type == 'customer') {
				$data['orders'] = $order;
				switch ($order['type']) {
					case '0':
						$orderto = $order['customercompany'];
						break;
					case '1':
						$orderto = $order['namesurname'];
						break;
				}
				$ordertoemail = $order['toemail'];
			}
			if ($rel_type == 'lead') {
				$data['orders'] = $order;
				$orderto = $order['leadname'];
				$ordertoemail = $order['toemail'];
			}

			$template = $this->Emails_Model->get_template('order', 'order_message');

			$path = '';
			if ($template['attachment'] == '1') {
				if ($order['pdf_status'] == '0') {
					$this->Orders_Model->generate_pdf($id);
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/' . $id . '/' . $file . '.pdf');
				} else {
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/' . $id . '/' . $file . '.pdf');
				}
			}

			$order_number = get_number('orders', $id, 'order', 'order');
			$message_vars = array(
				'{customer}' => $orderto,
				'{order_to}' => $orderto,
				'{email_signature}' => $this->session->userdata('email'),
				'{name}' => $this->session->userdata('staffname'),
				'{order_number}' => $order_number,
				'{app_name}' => setting['company'],
				'{company_name}' => setting['company'],
				'{company_email}' => setting['email'],
				'{site_url}' => site_url(),
				'{logo}' => rebrand['app_logo'],
				'{footer_logo}' => rebrand['nav_logo'],
				'{email_banner}' => rebrand['email_banner'],
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);
			$param = array(
				'from_name' => $template['from_name'],
				'email' => $ordertoemail,
				'subject' => $subject,
				'message' => $message,
				'created' => date("Y.m.d H:i:s"),
				'status' => 0,
				'attachments' => $path ? $path : NULL,
			);
			if ($ordertoemail) {
				$this->load->library('mail');
				$data = $this->mail->send_email($ordertoemail, $template['from_name'], $subject, $message, $path);
				if ($data['success'] == true) {
					$now = new DateTime();
					$currentDate = $now->format('Y-m-d H:i:s');
	
					$this->Orders_Model->update_order_only($id, [
						'datesend' => $currentDate
					]);
					$return['status'] = true;
					$return['message'] = $data['message'];
					if ($order['email']) {
						$this->db->insert('email_queue', $param);
					}
					$currentDate = date_create($currentDate);
					$currentDate = date_format($currentDate,"d F Y,  g:i a");
					$return['sent_on'] = lang('sent_on') .' '. $currentDate;
					
					echo json_encode($return);
				} else {
					$return['status'] = false;
					$return['message'] = lang('errormessage');
					echo json_encode($return);
				}
			}
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
	}

	function expiration($id)
	{
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($rel_type == 'customer') {
			$order = $this->Orders_Model->get_orders($id, $rel_type);
			$data['orders'] = $this->Orders_Model->get_orders($id, $rel_type);
			switch ($order['type']) {
				case '0':
					$orderto = $order['customercompany'];
					break;
				case '1':
					$orderto = $order['namesurname'];
					break;
			}
			$ordertoemail = $order['toemail'];
		}
		if ($rel_type == 'lead') {
			$order = $this->Orders_Model->get_orders($id, $rel_type);
			$data['orders'] = $this->Orders_Model->get_orders($id, $rel_type);
			$orderto = $order['leadname'];
			$ordertoemail = $order['toemail'];
		}
		$subject = lang('orderexpiryreminder');
		$to = $ordertoemail;
		$data = array(
			'customer' => $orderto,
			'customermail' => $ordertoemail,
			'orderlink' => '' . base_url('share/order/' . $pro['token'] . '') . ''
		);
		$body = $this->load->view('email/orders/expiration.php', $data, TRUE);
		$result = send_email($subject, $to, $data, $body);
		if ($result) {
			$response = $this->db->where('id', $id)->update('orders', array('datesend' => date('Y-m-d H:i:s')));
			$this->session->set_flashdata('ntf1', '<b>' . lang('sendmailcustomer') . '</b>');
			redirect('orders/order/' . $id . '');
		} else {
			$this->session->set_flashdata('ntf4', '<b>' . lang('sendmailcustomereror') . '</b>');
			redirect('orders/order/' . $id . '');
		}
	}

	function convert_invoice($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'create')) {
			$data['title'] = lang('convertordertoinvoice');
			$pro = $this->Orders_Model->get_pro_rel_type($id);
			$rel_type = $pro['relation_type'];
			$order = $this->Orders_Model->get_orders($id, $rel_type);
			if ($order['status_id'] != 2) {
				$data['success'] = false;
				$data['message'] = "Order has not been sent.";
				echo json_encode($data);
			} else {
				$items = $this->db->select('*')->get_where('items', array('relation_type' => 'order', 'relation' => $order['id']))->result_array();
				$date = strtotime("+7 day");
				if (isset($order['id'])) {
					$params = array(
						'token' => md5(uniqid()),
						'no' => null,
						'serie' => null,
						'customer_id' => $order['relation'],
						'staff_id' => $this->session->usr_id,
						'status_id' => 3,
						'created' => date('Y-m-d H:i:s'),
						'duedate' => date('Y-m-d H:i:s', $date),
						'datepayment' => 0,
						'duenote' => null,
						//'order_id' => $order[ 'id' ],
						'sub_total' => $order['sub_total'],
						'total_discount' => $order['total_discount'],
						'total_tax' => $order['total_tax'],
						'total' => $order['total'],
						'billing_street' => $order['billing_street'],
						'billing_city' => $order['billing_city'],
						'billing_state' => $order['billing_state_id'],
						'billing_zip' => $order['billing_zip'],
						'billing_country' => $order['billing_country'],
						'shipping_street' => $order['shipping_street'],
						'shipping_city' => $order['shipping_city'],
						'shipping_state' => $order['shipping_state_id'],
						'shipping_zip' => $order['shipping_zip'],
						'shipping_country' => $order['shipping_country'],
					);
					$this->db->insert('invoices', $params);
					$invoice = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['invoice_series'] ? $appconfig['invoice_series'] : $invoice;
					$invoice_number = $appconfig['inv_prefix'] . $number;
					$this->db->where('id', $invoice)->update('invoices', array('invoice_number' => $invoice_number));
					if ($appconfig['invoice_series']) {
						$invoice_number = $appconfig['invoice_series'];
						$invoice_number = $invoice_number + 1;
						$this->Settings_Model->increment_series('invoice_series', $invoice_number);
					}
					$i = 0;
					foreach ($items as $item) {
						$this->db->insert('items', array(
							'relation_type' => 'invoice',
							'relation' => $invoice,
							'product_id' => $item['product_id'],
							'product_type' => $item['product_type'],
							'warehouse_id' => $item['warehouse_id'],
							'code' => $item['code'],
							'name' => $item['name'],
							'description' => $item['description'],
							'quantity' => $item['quantity'],
							'unit' => $item['unit'],
							'price' => $item['price'],
							'tax' => $item['tax'],
							'discount' => $item['discount'],
							'total' => $item['quantity'] * $item['price'] + (($item['tax']) / 100 * $item['quantity'] * $item['price']) - (($item['discount']) / 100 * $item['quantity'] * $item['price']),
						));
						$i++;
					};
					//LOG
					$staffname = $this->session->staffname;
					$loggedinuserid = $this->session->usr_id;
					$appconfig = get_appconfig();
					$this->db->insert('logs', array(
						'date' => date('Y-m-d H:i:s'),
						'detail' => ('' . $message = sprintf(lang('coverttoinvoice'), $staffname, get_number('orders', $order['id'], 'order', 'order')) . ''),
						'staff_id' => $loggedinuserid,
						'customer_id' => $order['relation']
					));
					//NOTIFICATION
					$staffname = $this->session->staffname;
					$staffavatar = $this->session->staffavatar;
					$this->Notifications_Model->add_notification([
						'relation_type' => 'invoice',
						'relation' => $invoice,
						'detail' => ('' . $staffname . ' ' . lang('isaddedanewinvoice') . ''),
						'customer_id' => $order['relation'],
						'perres' => $staffavatar,
						'target' => '' . base_url('area/invoice/' . $invoice . '') . ''
					]);
					//--------------------------------------------------------------------------------------
					$this->db->insert($this->db->dbprefix . 'sales', array(
						'invoice_id' => '' . $invoice . '',
						'status_id' => 3,
						'staff_id' => $loggedinuserid,
						'customer_id' => $order['relation'],
						'total' => $order['total'],
						'date' => date('Y-m-d H:i:s')
					));

					$response = $this->db->where('id', $id)->update('orders', array('invoice_id' => $invoice, 'status_id' => 6, 'dateconverted' => date('Y-m-d H:i:s')));
					$data['id'] = $invoice;
					$data['success'] = true;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function markas()
	{
		if ($this->Privileges_Model->check_privilege('orders', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$name = $_POST['name'];
				$params = array(
					'order_id' => $_POST['order_id'],
					'status_id' => $_POST['status_id'],
				);
				$tickets = $this->Orders_Model->markas($_POST['order_id'],$_POST['status_id']);
				$data['success'] = true;
				$data['message'] = lang('order') . ' ' . lang('markas') . ' ' . $name;
			}
		} else {

			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function cancelled()
	{
		if ($this->Privileges_Model->check_privilege('orders', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$params = array(
					'order' => $_POST['order_id'],
					'status_id' => $_POST['status_id'],
				);
				$tickets = $this->Orders_Model->cancelled();
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove($id)
	{
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($order) {
			if ($this->Privileges_Model->check_privilege('orders', 'delete')) {
				if (isset($order['id'])) {
					$this->Orders_Model->delete_orders($id, get_number('orders', $id, 'order', 'order'));
					$this->load->helper('file');
					$folder = './uploads/files/orders/' . $id;
					if (is_dir($folder)) {
						delete_files($folder, true);
						rmdir($folder);
					}
					$data['success'] = true;
					$data['message'] = lang('order') . ' ' . lang('deleted');
					echo json_encode($data);
				} else {
					show_error('The orders you are trying to delete does not exist.');
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
	}

	function remove_item($id)
	{
		$response = $this->db->delete('items', array('id' => $id));
	}

	function get_order($id)
	{
		$order = array();
		$pro = $this->Orders_Model->get_pro_rel_type($id);
		$rel_type = $pro['relation_type'];
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$order = $this->Orders_Model->get_order_by_priviliges($id, $rel_type);
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$order  = $this->Orders_Model->get_order_by_priviliges($id, $rel_type, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
		if ($order) {
			$items = $this->Report_Model->get_items('order', $id);
			$comments = $this->db->get_where('comments', array('relation' => $id, 'relation_type' => 'order'))->result_array();
			$customername = '';
			if ($rel_type == 'customer') {
				$customer_id = $order['relation'];
				$customername = $order['namesurname'] ? $order['namesurname'] : $order['customercompany'];
				$lead_id = '';
				$order_type = false;
			} else {
				$lead_id = $order['relation'];
				$customer_id = '';
				$order_type = true;
			}
			if ($order['datesend'] == 0) {
				$mail_status = lang('notyetbeensent');
			} else {
				$mail_status = lang('sent_on') .' '. _adate($order['datesend']);
			}
			if ($order['comment'] != 0) {
				$comment = true;
			} else {
				$comment = false;
			}
			switch ($order['status_id']) {
				case '1':
					$status = lang('draft');
					break;
				case '2':
					$status = lang('sent');
					break;
				case '3':
					$status = lang('open');
					break;
				case '4':
					$status = lang('revised');
					break;
				case '5':
					$status = lang('declined');
					break;
				case '6':
					$status = lang('accepted');
					break;
				default:
					$status = lang('open');
					break;
			};
			$billing_country = get_country($order['bill_country']);
			$shipping_country = get_country($order['shipp_country']);
			$billing_state = get_state_name(null,$order['bill_state']);
			$shipping_state = get_state_name(null,$order['shipp_state']);
			// var_dump($shipping_state);die;
			$order_details = array(
				'id' => $order['id'],
				'token' => $order['token'],
				'long_id' => get_number('orders', $order['id'], 'order', 'order'),
				'subject' => $order['subject'],
				'content' => $order['content'],
				'comment' => $comment,
				'sub_total' => $order['sub_total'],
				'total_discount' => $order['total_discount'],
				'total_tax' => $order['total_tax'],
				'total' => $order['total'],
				'customer' => $customer_id,
				'customername' => $customername,
				'lead' => $lead_id,
				'order_type' => $order_type,
				'created' => date(get_dateFormat(), strtotime($order['created'])),
				'date' => date(get_dateFormat(), strtotime($order['date'])),
				'date_edit' => $order['date'],
				'opentill' => date(get_dateFormat(), strtotime($order['opentill'])),
				'opentill_edit' => $order['opentill'],
				'status' => $order['status_id'],
				'assigned' => $order['assigned'],
				//'content' => $order['content'],
				'invoice_id' => $order['invoice_id'],
				'status_name' => $status,
				'items' => $items,
				'comments' => $comments,
				'order_number' => $order['order_number'],
				'pdf_status' => $order['pdf_status'],
				'billing_street' => $order['bill_street'],
				'billing_city' => $order['bill_city'],
				'billing_state' => $billing_state,
				'billing_state_id' => $order['bill_state'],
				'billing_zip' => $order['bill_zip'],
				'billing_country' => $billing_country,
				'billing_country_id' => $order['bill_country'],
				'shipping_street' => $order['shipp_street'],
				'shipping_city' => $order['shipp_city'],
				'shipping_state' => $shipping_state,
				'shipping_state_id' => $order['shipp_state'],
				'shipping_zip' => $order['shipp_zip'],
				'shipping_country' => $shipping_country,
				'shipping_country_id' => $order['shipp_country'],
				'customer_contacts' => $this->Contacts_Model->get_customer_contacts($customer_id),
				'mail_status' => $mail_status,
				'staff_name' => $order['staffmembername'],
				// Recurring Order
				'recurring_enddate' => ($order['recurring_endDate'] != 'Invalid date' ? date(DATE_ISO8601, strtotime($order['recurring_endDate'])) : ''),
				'recurring_id' => $order['recurring_id'],
				'recurring_status' => $order['recurring_status'] == '0' ? true : false,
				'recurring_period' => (int)$order['recurring_period'],
				'recurring_type' => $order['recurring_type'] ? $order['recurring_type'] : 0,
			);
			echo json_encode($order_details);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('orders'));
		}
	}

	function get_orders()
	{
		$orders = array();
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			$orders = $this->Orders_Model->get_all_orders_by_privileges();
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$orders = $this->Orders_Model->get_all_orders_by_privileges($this->session->usr_id);
		}
		$tempCustomers = array();
		$tempAssignee = array();
		$data_orders = array();
		foreach ($orders as $order) {
			$pro = $this->Orders_Model->get_orders($order['id'], $order['relation_type']);
			if ($pro['relation_type'] == 'customer') {
				if (($pro['customercompany'] === NULL) || ($pro['customercompany'] == '')) {
					$customer = $pro['namesurname'];
					$customer_email = $pro['toemail'];
				} else {
					$customer = $pro['customercompany'];
					$customer_email = $pro['toemail'];
				}
			}
			if ($pro['relation_type'] == 'lead') {
				$customer = $pro['leadname'];
				$customer_email = $pro['toemail'];
			}

			if(!isset($tempCustomers)){
				$tempCustomers[] = $customer;
			}
			if(!in_array($customer, $tempCustomers)){
				array_push($tempCustomers, $customer);
				
				$data_orders['customers'][] = array(
					'CustomerID' => $pro['relation'],
					'CustomerName' => $customer
				);	
			}
			// Assignee
			if(!isset($tempAssignee)){
				$tempAssignee[] = $order['staffmembername'];
			}
			if(!in_array($order['staffmembername'], $tempAssignee)){
				array_push($tempAssignee, $order['staffmembername']);
				
				$data_orders['assigned'][] = array(
					'assgineeID' => $order['assigned'],
					'assgineeName' => $order['staffmembername']
				);	
			}

			switch ($order['status_id']) {
				case '1':
					$status = lang('draft');
					$class = 'proposal-status-accepted';
					break;
				case '2':
					$status = lang('sent');
					$class = 'proposal-status-sent';
					break;
				case '3':
					$status = lang('open');
					$class = 'proposal-status-open';
					break;
				case '4':
					$status = lang('revised');
					$class = 'proposal-status-revised';
					break;
				case '5':
					$status = lang('declined');
					$class = 'proposal-status-declined';
					break;
				case '6':
					$status = lang('accepted');
					$class = 'proposal-status-accepted';
					break;
				default:
					$status = lang('open');
					$class = 'proposal-status-open';
					break;
			};
			$data_orders['data'][] = array(
				'id' => $order['id'],
				'assigned' => $order['assigned'],
				'prefix' => lang('orderprefix'),
				'longid' => get_number('orders', $order['id'], 'order', 'order'),
				'subject' => $order['subject'],
				'customer' => $customer,
				'relation' => $order['relation'],
				'date' => date(get_dateFormat(), strtotime($order['date'])),
				'opentill' => date(get_dateFormat(), strtotime($order['opentill'])),
				'status' => $status,
				'status_id' => $order['status_id'],
				'staff' => $order['staffmembername'],
				'staffavatar' => $order['staffavatar'],
				'total' => (float)$order['total'],
				'class' => $class,
				'relation_type' => $order['relation_type'],
				'customer_email' => $customer_email,
				'' . lang('relationtype') . '' => $order['relation_type'],
				'' . lang('filterbystatus') . '' => $status,
				'' . lang('filterbycustomer') . '' => $customer,
				'' . lang('filterbyassigned') . '' => $order['staffmembername'],
			);
		};
		$price = array_column($data_orders['customers'] , 'CustomerName');
		array_multisort($price, SORT_ASC, $data_orders['customers']);
		
		$assignee = array_column($data_orders['assigned'] , 'assgineeName');
		array_multisort($assignee, SORT_ASC, $data_orders['assigned']);
		echo json_encode($data_orders);
	}

	function get_filtered_orders($filteredID)
	{
		
		$flag = (isset($_GET['status']))? false:true;
	
		$orders = array();
		if ($this->Privileges_Model->check_privilege('orders', 'all')) {
			if($flag){
				$orders = $this->Orders_Model->get_all_orders_by_filtered_privileges("",$filteredID );
			}	else{
				$orders = $this->Orders_Model->get_all_orders_by_filtered_privileges("","", $filteredID);
			}	
		} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
			$orders = $this->Orders_Model->get_all_orders_by_filtered_privileges($this->session->usr_id);
		}
		$data_orders = array();
		foreach ($orders as $order) {
			$pro = $this->Orders_Model->get_orders($order['id'], $order['relation_type']);
			if ($pro['relation_type'] == 'customer') {
				if (($pro['customercompany'] === NULL) || ($pro['customercompany'] == '')) {
					$customer = $pro['namesurname'];
					$customer_email = $pro['toemail'];
				} else {
					$customer = $pro['customercompany'];
					$customer_email = $pro['toemail'];
				}
			}
			if ($pro['relation_type'] == 'lead') {
				$customer = $pro['leadname'];
				$customer_email = $pro['toemail'];
			}
			switch ($order['status_id']) {
				case '1':
					$status = lang('draft');
					$class = 'proposal-status-accepted';
					break;
				case '2':
					$status = lang('sent');
					$class = 'proposal-status-sent';
					break;
				case '3':
					$status = lang('open');
					$class = 'proposal-status-open';
					break;
				case '4':
					$status = lang('revised');
					$class = 'proposal-status-revised';
					break;
				case '5':
					$status = lang('declined');
					$class = 'proposal-status-declined';
					break;
				case '6':
					$status = lang('accepted');
					$class = 'proposal-status-accepted';
					break;
				default:
					$status = lang('open');
					$class = 'proposal-status-open';
					break;
			};
			$data_orders['data'][] = array(
				'id' => $order['id'],
				'assigned' => $order['assigned'],
				'prefix' => lang('orderprefix'),
				'longid' => get_number('orders', $order['id'], 'order', 'order'),
				'subject' => $order['subject'],
				'customer' => $customer,
				'relation' => $order['relation'],
				'date' => date(get_dateFormat(), strtotime($order['date'])),
				'opentill' => date(get_dateFormat(), strtotime($order['opentill'])),
				'status' => $status,
				'status_id' => $order['status_id'],
				'staff' => $order['staffmembername'],
				'staffavatar' => $order['staffavatar'],
				'total' => (float)$order['total'],
				'class' => $class,
				'relation_type' => $order['relation_type'],
				'customer_email' => $customer_email,
				'' . lang('relationtype') . '' => $order['relation_type'],
				'' . lang('filterbystatus') . '' => $status,
				'' . lang('filterbycustomer') . '' => $customer,
				'' . lang('filterbyassigned') . '' => $order['staffmembername'],
			);
		};
		echo json_encode($data_orders);
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
			if ($this->Privileges_Model->check_privilege('orders', 'all')) {
				$order = $this->Orders_Model->get_order_by_priviliges($id, 'customer');
			} else if ($this->Privileges_Model->check_privilege('orders', 'own')) {
				$order  = $this->Orders_Model->get_order_by_priviliges($id, 'customer', $this->session->usr_id);
			} else {
				$return['status'] = false;
				$return['message'] = lang('you_dont_have_permission');
				echo json_encode($return);
			}
			$template = $this->Emails_Model->get_template('order', 'order_message');
			$path = '';
			if ($template['attachment'] == '1') {
				if ($order['pdf_status'] == '0') {
					$this->Orders_Model->generate_pdf($id);
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/' . $id . '/' . $file . '.pdf');
				} else {
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/' . $id . '/' . $file . '.pdf');
				}
			}
			$order_number = get_number('orders', $id, 'order', 'order');
			$message_vars = array(
				'{customer}' => $order['customercompany'] ? $order['customercompany'] : $order['namesurname'],
				'{order_to}' => $order['customercompany'] ? $order['customercompany'] : $order['namesurname'],
				'{email_signature}' => $this->session->userdata('email'),
				'{name}' => $this->session->userdata('staffname'),
				'{order_number}' => $order_number,
				'{app_name}' => setting['company'],
				'{company_name}' => setting['company'],
				'{company_email}' => setting['email'],
				'{site_url}' => site_url(),
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
					'status' => 0,
					'attachments' => $path ? $path : NULL,
				);
				$this->load->library('mail');
				$data = $this->mail->send_email($order['toemail'], $template['from_name'], $subject, $message);

				$now = new DateTime();
				$currentDate = $now->format('Y-m-d H:i:s ');
				$this->Orders_Model->update_order_dateSend($id, $currentDate
				);
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
			$files = $this->Orders_Model->get_files($id);
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
					'order_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => base_url('uploads/files/orders/' . $id . '/' . $file['file_name']),
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
					if (!is_dir('uploads/files/orders/' . $id)) {
						mkdir('./uploads/files/orders/' . $id, 0777, true);
					}
					$config['upload_path'] = './uploads/files/orders/' . $id . '';
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
						if (is_file('./uploads/files/orders/' . $id . '/' . $image_data['file_name'])) {
							$params = array(
								'relation_type' => 'order',
								'relation' => $id,
								'file_name' => $image_data['file_name'],
								'created' => date(" Y.m.d H:i:s "),
							);
							$this->Orders_Model->update_pdf_status($id, '0');
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
			$fileData = $this->Orders_Model->get_file($id);
			if (is_file('./uploads/files/orders/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
				$this->load->helper('download');
				$data = file_get_contents('./uploads/files/orders/' . $fileData['relation'] . '/' . $fileData['file_name']);
				force_download($fileData['file_name'], $data);
			} else {
				$this->session->set_flashdata('ntf4', lang('filenotexist'));
				redirect('orders/order/' . $fileData['relation']);
			}
		}
	}

	function delete_file($id)
	{
		if (isset($id)) {
			$fileData = $this->Orders_Model->get_file($id);
			$response = $this->db->where('id', $id)->delete('files', array('id' => $id));
			if (is_file('./uploads/files/orders/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
				unlink('./uploads/files/orders/' . $fileData['relation'] . '/' . $fileData['file_name']);
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
			redirect('orders');
		}
	}
}
