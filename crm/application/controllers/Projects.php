<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Projects extends CIUIS_Controller
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
		$data['title'] = lang('projects');
		$data['projects'] = $this->Projects_Model->get_all_projects();
		$this->load->view('projects/index', $data);
	}

	function project($id)
	{
		$project = $this->Projects_Model->get_projects($id);
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$data['title'] = $project['name'];
			$data['projects'] = $project;
			$this->load->view('inc/header', $data);
			$this->load->view('projects/project', $data);
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			if (($project['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($project['id'], $this->session->usr_id)) == 'true') {
				$data['title'] = $project['name'];
				$data['projects'] = $project;
				$this->load->view('inc/header', $data);
				$this->load->view('projects/project', $data);
			} else {
				$this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
				redirect(base_url('projects'));
			}
		} else {
			$this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
			redirect(base_url('projects'));
		}
	}

	function create()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[50]');
				$template = $this->input->post('template');
				if ($template == false) {
					$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
				}
				$this->form_validation->set_rules('start', lang('startdate'), 'trim|required|valid_date');
				$this->form_validation->set_rules('deadline', lang('deadline'), 'trim|required|valid_date|callback_compareDate');
				$this->form_validation->set_rules('value', lang('projectcost'), 'trim|required');
				$this->form_validation->set_rules('tax', lang('tax'), 'trim|required');
				$this->form_validation->set_rules('description', lang('description'), 'trim|required|max_length[65535]');
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$name = $this->input->post('name');
					$customer_id = $this->input->post('customer');
					$tax = $this->input->post('tax');
					$value = $this->input->post('value');
					$start_date = $this->input->post('start');
					$end_date = $this->input->post('deadline');
					if ($template == 'false' || $template == '0' || !$template) {
						$template = 0;
					} else if ($template == 'true' || $template == '1') {
						$template = 1;
						$customer_id = 0;
					}
					$data['message'] = '';
					$appconfig = get_appconfig();
					$params = array(
						'name' => $name,
						'description' => $this->input->post('description', true),
						'customer_id' => $customer_id,
						'projectvalue' => $value,
						'tax' => $tax,
						'start_date' => $start_date,
						'deadline' => $end_date,
						'staff_id' => $this->session->userdata('usr_id'),
						'status_id' => 1,
						'template' => $template,
						'created' => date('Y-m-d H:i:s'),
					);
					$project_add = $this->Projects_Model->add_projects( $params );
					// $this->db->insert('projects', $params);
					$project_id = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['project_series'] ? $appconfig['project_series'] : $project_id;
					$project_number = $appconfig['project_prefix'] . $number;
					$this->db->where('id', $project_id)->update('projects', array('project_number' => $project_number));
					if ($appconfig['project_series']) {
						$project_number = $appconfig['project_series'];
						$project_number = $project_number + 1;
						$this->Settings_Model->increment_series('project_series', $project_number);
					}

					// Custom Field Post
					if ($this->input->post('custom_fields')) {
						$custom_fields = array(
							'custom_fields' => $this->input->post('custom_fields')
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'project', $project_id);
					}
					$this->db->insert('logs', array(
						'date' => date('Y-m-d H:i:s'),
						'detail' => ('<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang('added') . ' ' . lang('project') . ' ' . ' <a href="projects/project/' . $project_id . '">' . get_number('projects', $project_id, 'project', 'project') . '</a>'),
						'staff_id' => $this->session->usr_id,
						'project_id' => $project_id,
						'customer_id' => $customer_id
					));
					$template = $this->Emails_Model->get_template('project', 'project_notification');
					if ($template['status'] == 1) {
						$status_project = [];
						$project = $this->Projects_Model->get_projects($project_id);
						$project_url = '' . base_url('area/projects/project/' . $project_id . '') . '';
						switch (isset($project['status'])) {
							case '1':
								$status_project = lang('notstarted');
								break;
							case '2':
								$status_project = lang('started');
								break;
							case '3':
								$status_project = lang('percentage');
								break;
							case '4':
								$status_project = lang('cancelled');
								break;
							case '5':
								$status_project = lang('complete');
								break;
						};

						if (isset($project['namesurname'])) {
							$customer = isset($project['namesurname']) ?? $project['namesurname'];
						} else {
							$customer = isset($project['customercompany']) ?? $project['customer'];
						}
						$message_vars = array(
							'{customer}' => $customer,
							'{project_name}' => $name,
							'{project_start_date}' => $_POST['start'],
							'{project_end_date}' => $_POST['deadline'],
							'{project_value}' => $value,
							'{project_tax}' => $tax,
							'{project_url}' => $project_url,
							'{project_status}' => $status_project,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{project_description}' =>isset($project['description']) ?? $project['description'],
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
							'email' => isset($project['customeremail']) ?? $project['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s")
						);
						if (isset($project['customeremail'])) {
							$this->db->insert('email_queue', $param);
						}
					}
					$data['success'] = true;
					$data['message'] = lang('project') . ' ' . lang('createmessage');
					$data['id'] = $project_id;
					if ($appconfig['project_series']) {
						$project_number = $appconfig['project_series'];
						$project_number = $project_number + 1;
						$this->Settings_Model->increment_series('project_series', $project_number);
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



	function compareDate()
	{
		$start_date = strtotime($this->input->post('start'));
		$end_date =  strtotime($this->input->post('deadline'));
		if ($end_date >= $start_date)
			return True;
		else {
			$this->form_validation->set_message('compareDate', lang('startdate') . ' ' . lang('date_error') . ' ' . lang('deadline'));
			return False;
		}
	}

	function compare_date()
	{
		$startDate = strtotime($this->input->post('date'));
		$endDate = strtotime($this->input->post('opentill'));
		if ($endDate >= $startDate)
			return True;
		else {
			$this->form_validation->set_message('compare_date', lang('Date of Issuance', 'date_error', 'opentill'));
			return False;
		}
	}

	function update($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$data['project'] = $this->Projects_Model->get_project_by_priviliges($id);
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			$projects = $this->Projects_Model->get_projects($id);
			if (($projects['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($projects['id'], $this->session->usr_id)) == 'true') {
				$data['project'] = $this->Projects_Model->get_projects($id);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($data['project']) {
			if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
				if (isset($data['project']['id'])) {
					if (isset($_POST) && count($_POST) > 0) {
						$this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[50]');
						$template = $this->input->post('template');
						if ($template == false) {
							$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
						}
						$this->form_validation->set_rules('start', lang('startdate'), 'trim|required|valid_date');
						$this->form_validation->set_rules('deadline', lang('deadline'), 'trim|required|valid_date|callback_compareDate');
						$this->form_validation->set_rules('value', lang('projectcost'), 'trim|required');
						$this->form_validation->set_rules('tax', lang('tax'), 'trim|required');
						$this->form_validation->set_rules('description', lang('description'), 'trim|required|max_length[65535]');
						$data['message'] = '';
						if ($this->form_validation->run() == false) {
							$data['success'] = false;
							$data['message'] = validation_errors();
							echo json_encode($data);
						} else {
							$name = $this->input->post('name');
							$customer_id = $this->input->post('customer');

							$tax = $this->input->post('tax');
							$value = $this->input->post('value');

							$template = $this->input->post('template');
							if ($template == 'false' || $template == '0' || !$template) {
								$template = 0;
							} else if ($template == 'true' || $template == '1') {
								$template = 1;
								$customer_id = 0;
							}
							$params = array(
								'name' => $name,
								'description' => $this->input->post('description', true),
								'customer_id' => $customer_id,
								'projectvalue' => $value,
								'tax' => $tax,
								'start_date' => $_POST['start'],
								'deadline' => $_POST['deadline'],
								'staff_id' => $this->session->userdata('usr_id'),
								'status_id' => 1,
								'created' => date('Y-m-d H:i:s'),
							);
							$this->Projects_Model->update($id, $params);
							// Custom Field Post
							if ($this->input->post('custom_fields')) {
								$custom_fields = array(
									'custom_fields' => $this->input->post('custom_fields')
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'project', $id);
							}
							$data['success'] = true;
							$data['message'] = lang('project') . ' ' . lang('updatemessage');
							echo json_encode($data);
						}
					} else {
						$this->load->view('projects/index', $data);
					}
				} else {
					show_error('The task you are trying to edit does not exist.');
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('projects'));
		}
	}

	function createticket($id)
	{
		if ($this->Privileges_Model->check_privilege('tickets', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[300]');
				$this->form_validation->set_rules('customer', lang('customer'), 'trim|required|integer');
				$this->form_validation->set_rules('contact', lang('contact'), 'trim|required|integer');
				$this->form_validation->set_rules('department', lang('department'), 'trim|required|integer');
				$this->form_validation->set_rules('priority', lang('priority'), 'trim|required|in_list[1,2,3]');
				$this->form_validation->set_rules('message', lang('message'), 'trim|required|max_length[65535]');
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$contact_id = $this->input->post('contact');
					$customer_id = $this->input->post('customer');
					$department_id = $this->input->post('department');
					$subject = $this->input->post('subject');
					$message = $this->input->post('message');
					$priority = $this->input->post('priority');
					$appconfig = get_appconfig();
					$params = array(
						'contact_id' => $this->input->post('contact'),
						'customer_id' => $this->input->post('customer'),
						'department_id' => $this->input->post('department'),
						'priority' => $this->input->post('priority'),
						'status_id' => 1,
						'subject' => $this->input->post('subject'),
						'message' => $this->input->post('message'),
						'relation_id' => $id,
						'relation' => 'project',
						'date' => date(" Y.m.d H:i:s "),
						'ticket_number' => $appconfig['ticket_prefix'] . $appconfig['ticket_series'],
						'staff_id' => $this->session->usr_id
					);
					$tickets_id = $this->Tickets_Model->add_tickets($params);

					$template = $this->Emails_Model->get_template('ticket', 'new_ticket');
					if ($template['status'] == 1) {
						$ticket = $this->Tickets_Model->get_tickets($tickets_id);
						if ($ticket['type'] == 0) {
							$customer = $ticket['company'];
						} else {
							$customer = $ticket['namesurname'];
						}

						switch ($ticket['priority']) {
							case '1':
								$priority = lang('low');
								break;
							case '2':
								$priority = lang('medium');
								break;
							case '3':
								$priority = lang('high');
								break;
						};

						$message_vars = array(
							'{customer}' => $customer,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{ticket_subject}' => $this->input->post('subject'),
							'{ticket_message}' => $this->input->post('message'),
							'{ticket_priority}' => $priority,
							'{ticket_department}' => $ticket['department'],
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
							'email' => $ticket['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s")
						);
						if ($ticket['customeremail']) {
							$this->db->insert('email_queue', $param);
						}
					}
					$data['success'] = true;
					$ticket_number = $appconfig['ticket_series'];
					$ticket_number = $ticket_number + 1;
					$this->Settings_Model->increment_series('ticket_series', $ticket_number);
					$data['message'] = lang('ticket') . ' ' . lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function ticket_markas()
	{
		if ($this->Privileges_Model->check_privilege('tickets', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$response = $this->db->where('id', $_POST['ticket_id'])->update('tickets', array('status_id' => $_POST['status_id']));
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function tickets($id)
	{
		$tickets = $this->Projects_Model->get_all_tickets($id);
		$data_tickets = array();
		foreach ($tickets as $ticket) {
			$data_tickets[] = array(
				'id' => $ticket['id'],
				'staffname' => $ticket['staffmembername'],
				'department' => $ticket['department'],
				'subject' => $ticket['subject'],
				'message' => $ticket['message'],
				'contactname' => '' . $ticket['contactname'] . ' ' . $ticket['contactsurname'] . '',
				'priority' => $ticket['priority'],
				'date' => date(get_dateTimeFormat(), strtotime($ticket['date'])),
				'lastreply' => $ticket['lastreply'] ? (date(get_dateTimeFormat(), strtotime($ticket['lastreply']))) : lang('n_a'),
				'status_id' => $ticket['status_id'],
				'ticket_number' => get_number('tickets', $ticket['id'], 'ticket', 'ticket'),
				'customername' => $ticket['company'] ? $ticket['company'] : $ticket['namesurname'],
			);
		}
		echo json_encode($data_tickets);
	}

	function remove_ticket($id)
	{
		if ($this->Privileges_Model->check_privilege('tickets', 'delete')) {
			$tickets = $this->Projects_Model->get_tickets($id);
			if (isset($tickets['id'])) {
				if ($this->Projects_Model->delete_tickets($id)) {
					$data['success'] = true;
					$data['message'] = lang('ticket') . ' ' . lang('deletemessage');
				}
			} else
				show_error('Eror');
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	/*url call change for copyProject to copyproject*/
	function copy_project($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'create')) {
			$project = $this->Projects_Model->get_projects($id);
			$params = array(
				'customer_id' => $this->input->post('customer_id'),
				'name' => $project['name'] . '-Copy',
				'staff_id' => $this->session->userdata('usr_id'),
				'status_id' => 1,
				'created' => date('Y-m-d H:i:s'),
				'projectvalue' => $project['projectvalue'],
				'tax' => $project['tax'],
				'start_date' => $this->input->post('startdate'),
				'deadline' => $this->input->post('enddate'),
				'description' => $project['description'],
				'template' => 0
			);
			$this->db->insert('projects', $params);
			$projectId = $this->db->insert_id();
			$appconfig = get_appconfig();
			$number = $appconfig['project_series'] ? $appconfig['project_series'] : $projectId;
			$project_number = $appconfig['project_prefix'] . $number;
			$this->db->where('id', $projectId)->update('projects', array('project_number' => $project_number));
			if ($appconfig['project_series']) {
				$project_number = $appconfig['project_series'];
				$project_number = $project_number + 1;
				$this->Settings_Model->increment_series('project_series', $project_number);
			}
			$loggedinuserid = $this->session->usr_id;
			$staffname = $this->session->staffname;
			$this->db->insert('logs', array(
				'date' => date('Y-m-d H:i:s'),
				'detail' => ('' . $staffname . lang('created_a_new_project')),
				'staff_id' => $loggedinuserid,
				'project_id' => $projectId,
			));

			// Items List to be copied:
			$isExpenses = $this->input->post('expenses');
			$isServices = $this->input->post('services');
			$isMilestones = $this->input->post('milestones');
			$isTasks = $this->input->post('tasks');
			$isPeoples = $this->input->post('peoples');
			$isFiles = $this->input->post('files');
			$isNotes = $this->input->post('notes');

			if ($isServices == 'true') {
				$services = $this->Projects_Model->get_project_services($id);
				$this->Projects_Model->copy_services($services, $projectId);
			}
			if ($isExpenses == 'true') {
				$expenses = $this->Expenses_Model->get_all_expenses_by_relation('project', $id);
				$this->Projects_Model->copy_expenses($expenses, $projectId);
			}
			if ($isMilestones == 'true') {
				$milestones = $this->Projects_Model->get_all_project_milestones($id);
				$this->Projects_Model->copy_milestones($milestones, $projectId);
			}
			if ($isTasks == 'true') {
				$tasks = $this->Tasks_Model->get_project_tasks($id);
				$this->Projects_Model->copy_tasks($tasks, $projectId);
			}
			if ($isPeoples == 'true') {
				$members = $this->Projects_Model->get_members($id);
				$this->Projects_Model->copy_members($members, $projectId);
			}
			if ($isFiles == 'true') {
				$files = $this->Projects_Model->get_project_files($id);
				$this->Projects_Model->copy_files($files, $projectId);
			}
			if ($isNotes == 'true') {
				$notes = $this->db->select('*')->get_where('notes', array('relation' => $id, 'relation_type' => 'project'))->result_array();
				$this->Projects_Model->copy_notes($notes, $projectId);
			}
			$data['success'] = true;
			$data['message'] = lang('project') . ' ' . lang('createmessage');
			$data['id'] = $projectId;
			echo json_encode($data);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function addservice()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST)) {
				if (isset($_POST) && count($_POST) > 0) {
					// $categoryid = $this->input->post('categoryid');
					// $productid = $this->input->post('productid');
					// $servicename = $this->input->post('servicename');
					// $serviceprice = $this->input->post('serviceprice');
					// $servicetax = $this->input->post('servicetax');
					// $quantity = $this->input->post('quantity');
					// $unit = $this->input->post('unit');
					// $servicedescription = $this->input->post('servicedescription');
					// $project_id = $this->input->post('projectid');
					// $hasError = false;
					// $data['message'] = '';
					// if ($categoryid == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('selectinvalidmessage') . ' ' . lang('category');
					// } else if ($productid == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('selectinvalidmessage') . ' ' . lang('product');
					// } else if ($servicename == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('productname');
					// } else if ($serviceprice == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('price');
					// } else if ($servicetax == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('tax');
					// } else if ($quantity == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('quantity');
					// } else if ($unit == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('unit');
					// } else if ($servicedescription == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('description');
					// }

					// if ($hasError) {
					// 	$data['success'] = false;
					// 	echo json_encode($data);
					// }

					// if (!$hasError) {
					$this->form_validation->set_rules('categoryid', lang('category'), 'trim|required|integer');
					$this->form_validation->set_rules('productid', lang('product'), 'trim|required|integer');
					$this->form_validation->set_rules('servicename', lang('productservice'), 'trim|required|max_length[50]');
					$this->form_validation->set_rules('serviceprice', lang('price'), 'trim|required|numeric');
					$this->form_validation->set_rules('servicetax', lang('tax'), 'trim|required|numeric');
					$this->form_validation->set_rules('quantity', lang('quantity'), 'trim|required|max_length[20]');
					$this->form_validation->set_rules('unit', lang('unit'), 'trim|required|max_length[25]');
					$this->form_validation->set_rules('servicedescription', lang('servicedescription'), 'trim|required|max_length[255]');
					$this->form_validation->set_rules('projectid', lang('project'), 'trim|integer');
					$data['message'] = '';
					if ($this->form_validation->run() == false) {
						$data['success'] = false;
						$data['message'] = validation_errors();
						echo json_encode($data);
					} else {
						$categoryid = $this->input->post('categoryid');
						$productid = $this->input->post('productid');
						$servicename = $this->input->post('servicename');
						$serviceprice = $this->input->post('serviceprice');
						$servicetax = $this->input->post('servicetax');
						$quantity = $this->input->post('quantity');
						$unit = $this->input->post('unit');
						$servicedescription = $this->input->post('servicedescription');
						$project_id = $this->input->post('projectid');
						$params = array(
							'categoryid' => $categoryid,
							'productid' => $productid,
							'servicename' => $servicename,
							'serviceprice' => $serviceprice,
							'servicetax' => $servicetax,
							'quantity' => $quantity,
							'unit' => $unit,
							'servicedescription' => $servicedescription,
							'projectid' => $this->input->post('projectid'),
						);
						$this->db->insert('projectservices', $params);
						$this->db->insert('logs', array(
							'date' => date('Y-m-d H:i:s'),
							'detail' => ('' . $this->session->staffname . ' ' . lang('added') . ' ' . lang('service') . ' ' . lang('for') . ' ' . get_number('projects', $project_id, 'project', 'project')),
							'staff_id' => $this->session->usr_id,
							'project_id' => $project_id,
						));
						$project = $this->db->insert_id();
						$data['success'] = true;
						$data['message'] = lang('service') . ' ' . lang('createmessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function updateservice($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && $id) {
				if (isset($_POST) && count($_POST) > 0) {
					// $categoryid = $this->input->post('categoryid');
					// $productid = $this->input->post('productid');
					// $servicename = $this->input->post('servicename');
					// $serviceprice = $this->input->post('serviceprice');
					// $servicetax = $this->input->post('servicetax');
					// $servicedescription = $this->input->post('servicedescription');
					// $quantity = $this->input->post('quantity');
					// $unit = $this->input->post('unit');
					// $project_id = $this->input->post('projectid');
					$this->form_validation->set_rules('categoryid', lang('category'), 'trim|required|integer');
					$this->form_validation->set_rules('productid', lang('product'), 'trim|required|integer');
					$this->form_validation->set_rules('servicename', lang('product / Service Name'), 'trim|required|max_length[50]');
					$this->form_validation->set_rules('serviceprice', lang('price'), 'trim|required|numeric');
					$this->form_validation->set_rules('servicetax', lang('tax'), 'trim|required|numeric');
					$this->form_validation->set_rules('quantity', lang('qty'), 'trim|required|max_length[20]');
					$this->form_validation->set_rules('unit', lang('unit'), 'trim|required|max_length[25]');
					$this->form_validation->set_rules('servicedescription', lang('description'), 'trim|required|max_length[255]');
					$this->form_validation->set_rules('projectid', lang('project'), 'trim|integer');
					$hasError = false;
					$data['message'] = '';
					// if ($categoryid == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('selectinvalidmessage') . ' ' . lang('category');
					// } else if ($productid == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('selectinvalidmessage') . ' ' . lang('product');
					// } else if ($servicename == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('productname');
					// } else if ($serviceprice == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('price');
					// } else if ($servicetax == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('tax');
					// } else if ($quantity == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('quantity');
					// } else if ($unit == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('unit');
					// } else if ($servicedescription == '') {
					// 	$hasError = true;
					// 	$data['message'] = lang('invalidmessage') . ' ' . lang('description');
					// }

					// if ($hasError) {
					// 	$data['success'] = false;
					// 	echo json_encode($data);
					// }

					// if (!$hasError) {
					$data['message'] = '';
					if ($this->form_validation->run() == false) {
						$data['success'] = false;
						$data['message'] = validation_errors();
						echo json_encode($data);
					} else {
						$categoryid = $this->input->post('categoryid');
						$productid = $this->input->post('productid');
						$servicename = $this->input->post('servicename');
						$serviceprice = $this->input->post('serviceprice');
						$servicetax = $this->input->post('servicetax');
						$servicedescription = $this->input->post('servicedescription');
						$quantity = $this->input->post('quantity');
						$unit = $this->input->post('unit');
						$project_id = $this->input->post('projectid');
						$params = array(
							'categoryid' => $categoryid,
							'productid' => $productid,
							'servicename' => $servicename,
							'serviceprice' => $serviceprice,
							'servicetax' => $servicetax,
							'quantity' => $quantity,
							'unit' => $unit,
							'servicedescription' => $servicedescription,
							'projectid' => $this->input->post('projectid'),
						);
						$this->db->where('id', $id);
						$this->db->update('projectservices', $params);
						$this->db->insert('logs', array(
							'date' => date('Y-m-d H:i:s'),
							'detail' => ('' . $this->session->staffname . ' ' . lang('updated') . ' ' . lang('service') . ' ' . lang('for') . ' ' . get_number('projects', $project_id, 'project', 'project')),
							'staff_id' => $this->session->usr_id,
							'project_id' => $project_id,
						));
						$data['success'] = true;
						$data['message'] = lang('service') . ' ' . lang('updatemessage');
						echo json_encode($data);
					}
				}
			} else {

				$data['success'] = false;
				$data['message'] = lang('errormessage');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function get_project_services($id)
	{
		$data = $this->Projects_Model->get_project_services($id);
		echo json_encode($data);
	}

	function get_products_by_category($id)
	{
		$data = $this->Projects_Model->get_products_by_category($id);
		echo json_encode($data);
	}

	function markas_complete()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$params = array(
					'project_id' => $_POST['project_id'],
					'status_id' => '5',
				);
				$response = $this->Projects_Model->markas_complete();
				$template = $this->Emails_Model->get_template('project', 'project_status_changed');
				if ($template['status'] == 1) {
					$project = $this->Projects_Model->get_projects($_POST['project_id']);
					$project_url = '' . base_url('area/projects/project/' . $_POST['project_id'] . '') . '';
					if ($project['namesurname']) {
						$customer = $project['namesurname'];
					} else {
						$customer = $project['customercompany'];
					}
					$message_vars = array(
						'{customer}' => $customer,
						'{project_name}' => $project['name'],
						'{project_start_date}' => $project['start_date'],
						'{project_end_date}' => $project['deadline'],
						'{project_value}' => $project['projectvalue'],
						'{project_tax}' => $project['tax'],
						'{project_url}' => $project_url,
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
						'{loggedin_staff}' => $this->session->userdata('staffname'),
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
						'email' => $project['customeremail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date("Y.m.d H:i:s")
					);
					if ($project['customeremail']) {
						$this->db->insert('email_queue', $param);
					}
				}
				$return['success'] = true;
				$return['message'] = lang('project_complete');
			}
		} else {
			$return['success'] = false;
			$return['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($return);
	}

	function markas()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$params = array(
					'project_id' => $_POST['project_id'],
					'status_id' => $_POST['status_id'],
				);
				$tickets = $this->Projects_Model->markas();

				$template = $this->Emails_Model->get_template('project', 'project_status_changed');
				if ($template['status'] == 1) {
					$project = $this->Projects_Model->get_projects($_POST['project_id']);
					$project_url = '' . base_url('area/projects/project/' . $_POST['project_id'] . '') . '';
					if ($project['namesurname']) {
						$customer = $project['namesurname'];
					} else {
						$customer = $project['customercompany'];
					}
					$message_vars = array(
						'{customer}' => $customer,
						'{project_name}' => $project['name'],
						'{project_start_date}' => $project['start_date'],
						'{project_end_date}' => $project['deadline'],
						'{project_value}' => $project['projectvalue'],
						'{project_tax}' => $project['tax'],
						'{loggedin_staff}' => $this->session->userdata('staffname'),
						'{project_url}' => $project_url,
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
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
						'email' => $project['customeremail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date("Y.m.d H:i:s")
					);
					if ($project['customeremail']) {
						$this->db->insert('email_queue', $param);
					}
				}
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function addmilestone($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				// $name = $this->input->post('name');
				// $order = $this->input->post('order');
				// $description = $this->input->post('description');
				// $hasError = false;
				// $data['message'] = '';
				// if ($name == '') {
				// 	$hasError = true;
				// 	$data['message'] = lang('invalidmessage') . ' ' . lang('name');
				// } else if ($this->input->post('duedate') == '') {
				// 	$hasError = true;
				// 	$data['message'] = lang('invalidmessage') . ' ' . lang('duedate');
				// } else if ($description == '') {
				// 	$hasError = true;
				// 	$data['message'] = lang('invalidmessage') . ' ' . lang('description');
				// }

				// if ($hasError) {
				// 	$data['success'] = false;
				// 	echo json_encode($data);
				// }

				// if (!$hasError) {
				$this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[50]');
				$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date_time');
				$this->form_validation->set_rules('description', lang('description'), 'trim|required|max_length[65535]');
				$this->form_validation->set_rules('order', lang('milestoneorder'), 'trim|integer|max_length[5]');
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$name = $this->input->post('name');
					$order = $this->input->post('order');
					$description = $this->input->post('description');
					$params = array(
						'project_id' => $id,
						'name' => $name,
						'order' => $order,
						'duedate' => $this->input->post('duedate'),
						'description' => $description,
						'created' => date('Y-m-d'),
						'color' => 'green',
					);
					$response = $this->Projects_Model->add_milestone($id, $params);
					$data['success'] = true;
					$data['message'] = lang('milestone') . ' ' . lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function updatemilestone($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$name = $this->input->post('name');
				$description = $this->input->post('description');
				$hasError = false;
				$data['message'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('name');
				} else if ($this->input->post('duedate') == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('duedate');
				} else if ($description == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage') . ' ' . lang('description');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'order' => $this->input->post('order'),
						'name' => $this->input->post('name'),
						'description' => $this->input->post('description'),
						'duedate' => $this->input->post('duedate'),
					);
					$response = $this->Projects_Model->update_milestone($id, $params);
					$data['success'] = true;
					$data['message'] = lang('milestone') . ' ' . lang('updatemessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function removemilestone()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST['milestone'])) {
				$milestone = $_POST['milestone'];
				$response = $this->db->delete('milestones', array('id' => $milestone));
				$data['success'] = true;
				$data['message'] = lang('milestone') . lang('deleted');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function addtask($id)
	{
		if ($this->Privileges_Model->check_privilege('tasks', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[50]');
				$this->form_validation->set_rules('hourlyrate', lang('hourlyrate'), 'trim|required');
				$this->form_validation->set_rules('startdate', lang('startdate'), 'trim|required|valid_date');
				$this->form_validation->set_rules('duedate', lang('duedate'), 'trim|required|valid_date');
				$this->form_validation->set_rules('assigned', lang('assigned'), 'trim|required|integer');
				$this->form_validation->set_rules('priority', lang('priority'), 'trim|required|integer');
				$this->form_validation->set_rules('milestone', lang('milestone'), 'trim|required|integer');
				$this->form_validation->set_rules('description', lang('description'), 'trim|required|max_length[65535]');
				$this->form_validation->set_rules('billable', lang('billable'), 'trim|integer|in_list[0,1]');
				$this->form_validation->set_rules('public', lang('public'), 'trim|integer|in_list[0,1]');
				$this->form_validation->set_rules('visible', lang('visible'), 'trim|integer|in_list[0,1]');
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$name = $this->input->post('name');
					$description =  $this->input->post('description');
					$priority = $this->input->post('priority');
					$assigned = $this->input->post('assigned');
					$appconfig = get_appconfig();
					$params = array(
						'name' => $name,
						'description' => $description,
						'priority' => $priority,
						'assigned' => $assigned,
						'relation_type' => 'project',
						'relation' => $id,
						'milestone' => $this->input->post('milestone'),
						'public' => $this->input->post('public'),
						'billable' => $this->input->post('billable'),
						'visible' => $this->input->post('visible'),
						'hourly_rate' => $this->input->post('hourlyrate'),
						'startdate' => $this->input->post('startdate'),
						'duedate' => $this->input->post('duedate'),
						'addedfrom' => $this->session->userdata('usr_id'),
						'status_id' => 1,
						'created' => date('Y-m-d H:i:s'),
					);
					$this->session->set_flashdata('ntf1', '<b>' . lang('task_added') . '</b>');
					$this->db->insert('tasks', $params);
					$task_id = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['task_series'] ? $appconfig['task_series'] : $task_id;
					$task_number = $appconfig['task_prefix'] . $number;
					$this->db->where('id', $task_id)->update('tasks', array('task_number' => $task_number));
					if ($appconfig['task_series']) {
						$task_number = $appconfig['task_series'];
						$task_number = $task_number + 1;
						$this->Settings_Model->increment_series('task_series', $task_number);
					}
					$loggedinuserid = $this->session->usr_id;
					$staffname = $this->session->staffname;
					$this->db->insert('logs', array(
						'date' => date('Y-m-d H:i:s'),
						'detail' => ('' . $this->session->staffname . ' ' . lang('added') . ' ' . lang('task') . ' ' . lang('for') . ' ' . get_number('projects', $id, 'project', 'project')),
						'staff_id' => $loggedinuserid,
						'project_id' => $id,
					));
					$this->Notifications_Model->add_notification([
						'relation_type' => 'task',
						'relation'=>$task_id,
						'detail' => $this->session->staffname . ' ' . lang('assigned') . ' ' . lang('task'),
						'perres' => $this->session->staffavatar,
						'staff_id' => $this->input->post('assigned'),
						'target' => '' . base_url('tasks/task/' . $task_id) . ''
					]);
					$template = $this->Emails_Model->get_template('task', 'new_task_assigned');
					if ($template['status'] == 1) {
						$tasks = $this->Tasks_Model->get_task_detail($task_id);
						$task_url = '' . base_url('tasks/task/' . $task_id . '') . '';
						switch ($tasks['status_id']) {
							case '0':
								$status = lang('new');
								break;
							case '1':
								$status = lang('open');
								break;
							case '2':
								$status = lang('inprogress');
								break;
							case '3':
								$status = lang('waiting');
								break;
							case '4':
								$status = lang('complete');
								break;
							case '5':
								$status = lang('cancelled');
								break;
						};
						switch ($tasks['priority']) {
							case '1':
								$priority = lang('low');
								break;
							case '2':
								$priority = lang('medium');
								break;
							case '3':
								$priority = lang('high');
								break;
							default:
								$priority = lang('medium');
								break;
						};
						$message_vars = array(
							'{staffname}' => $tasks['assigner'],
							'{task_name}' => $tasks['name'],
							'{task_startdate}' => $tasks['startdate'],
							'{task_duedate}' => $tasks['duedate'],
							'{task_priority}' => $priority,
							'{task_url}' => $task_url,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{task_status}' => $status,
							'{task_description}' => $tasks['description'],
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
							'email' => $tasks['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s")
						);
						if ($tasks['staffemail']) {
							$this->db->insert('email_queue', $param);
						}
					}
					$data['success'] = true;
					$data['message'] = lang('task') . ' ' . lang('createmessage');
					echo json_encode($data);
				}
			} else {

				$data['success'] = false;
				$data['message'] = lang('errormessage');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function addmember()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST) && count($_POST) > 0) {
				$staff = $_POST['staff'];
				$projectId = $_POST['project'];
				$members = $this->Projects_Model->get_members($projectId);
				$hasError = false;
				$data['message'] = '';
				if ($staff == '' || $staff == null) {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage') . ' ' . lang('staff');
				} else {
					foreach ($members as $member) {
						if (($member['project_id'] == $projectId) && ($member['staff_id'] == $staff)) {
							$hasError = true;
							$data['message'] = lang('same') . ' ' . lang('staff') . ' ' . lang('duplicate_message');
							continue;
						}
					}
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'staff_id' => $staff,
						'project_id' => $_POST['project'],
					);
					$this->db->insert('projectmembers', $params);
					$this->Notifications_Model->add_notification([
						'relation_type' => 'project',
						'relation' => $projectId,
						'detail' => (lang('assignednewproject')),
						'perres' => $this->session->staffavatar,
						'staff_id' => $_POST['staff'],
						'target' => '' . base_url('projects/project/' . $_POST['project'] . '') . ''
					]);
					$this->db->insert('logs', array(
						'date' => date('Y-m-d H:i:s'),
						'detail' => ('' . $this->session->staffname . lang('added_a_member_project')),
						'staff_id' => $this->session->usr_id,
						'project_id' => $_POST['project'],
					));
					$member_detail = $this->Staff_Model->get_staff($_POST['staff']);

					$template = $this->Emails_Model->get_template('project', 'staff_added');
					if ($template['status'] == 1) {
						$project = $this->Projects_Model->get_projects($_POST['project']);
						$project_url = '' . base_url('projects/project/' . $_POST['project'] . '') . '';
						if ($project['namesurname']) {
							$customer = $project['namesurname'];
						} else {
							$customer = $project['customercompany'];
						}
						$message_vars = array(
							'{customer}' => $customer,
							'{project_name}' => $project['name'],
							'{project_start_date}' => $project['start_date'],
							'{project_end_date}' => $project['deadline'],
							'{project_value}' => $project['projectvalue'],
							'{project_tax}' => $project['tax'],
							'{loggedin_staff}' => $this->session->userdata('staffname'),
							'{project_url}' => $project_url,
							'{staff}' => $member_detail['staffname'],
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
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
							'email' => $member_detail['email'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s")
						);
						if ($member_detail['email']) {
							$this->db->insert('email_queue', $param);
						}
					}

					$data['success'] = true;
					$data['message'] = lang('project') . ' ' . lang('createmessage');
					$data['member'] = $member_detail;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function unlinkmember($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($_POST['linkid'])) {
				$linkid = $_POST['linkid'];
				$response = $this->db->where('id', $linkid)->delete('projectmembers', array('id' => $linkid));
				$data['success'] = true;
				$data['message'] = lang('staff') . ' ' . lang('deletemessage');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function delete_file($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file($id);
				if ($fileData) {
					$response = $this->db->where('id', $id)->delete('files', array('id' => $id));
					if ($fileData['is_old'] == '1') {
						if (is_file('./uploads/files/' . $fileData['file_name'])) {
							unlink('./uploads/files/' . $fileData['file_name']);
						}
					} else {
						if (is_file('./uploads/files/projects/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
							unlink('./uploads/files/projects/' . $fileData['relation'] . '/' . $fileData['file_name']);
						}
					}
					if ($response) {
						$data['success'] = true;
						$data['message'] = lang('file') . ' ' . lang('deletemessage');
					} else {
						$data['success'] = false;
						$data['message'] = lang('errormessage');
					}
					echo json_encode($data);
				}
			} else {
				redirect('projects');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function add_file($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			if (isset($id)) {
				if (isset($_POST)) {
					if (!is_dir('uploads/files/projects/' . $id)) {
						mkdir('./uploads/files/projects/' . $id, 0777, true);
					}
					$config['upload_path'] = './uploads/files/projects/' . $id . '';
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
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/projects/' . $id . '/' . $image_data['file_name'])) {
							$params = array(
								'relation_type' => 'project',
								'relation' => $id,
								'file_name' => $image_data['file_name'],
								'created' => date(" Y.m.d H:i:s "),
								'is_old' => '0'
							);
							$this->db->insert('files', $params);
							$template = $this->Emails_Model->get_template('project', 'new_file_uploaded_to_customer');
							if ($template['status'] == 1) {
								$project = $this->Projects_Model->get_projects($id);
								$project_url = '' . base_url('area/projects/project/' . $id . '') . '';
								if ($project['namesurname']) {
									$customer = $project['namesurname'];
								} else {
									$customer = $project['customercompany'];
								}
								$message_vars = array(
									'{customer}' => $customer,
									'{project_name}' => $project['name'],
									'{project_start_date}' => $project['start_date'],
									'{project_end_date}' => $project['deadline'],
									'{project_value}' => $project['projectvalue'],
									'{project_tax}' => $project['tax'],
									'{project_url}' => $project_url,
									'{name}' => $this->session->userdata('staffname'),
									'{email_signature}' => $this->session->userdata('email'),
									'{loggedin_staff}' => $this->session->userdata('staffname'),
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
									'email' => $project['customeremail'],
									'subject' => $subject,
									'message' => $message,
									'created' => date("Y.m.d H:i:s")
								);
								if ($project['customeremail']) {
									$this->db->insert('email_queue', $param);
								}
							}
							$data['success'] = true;
							$data['message'] = lang('file') . ' ' . lang('uploadmessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = lang('errormessage');
							echo json_encode($data);
						}
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function download_file($id)
	{
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file($id);
			if ($fileData['is_old'] == '1') {
				if (is_file('./uploads/files/' . $fileData['file_name'])) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/' . $fileData['file_name']);
					force_download($fileData['file_name'], $data);
				} else {
					$this->session->set_flashdata('ntf4', lang('filenotexist'));
					redirect('projects/project/' . $fileData['relation']);
				}
			} else {
				if (is_file('./uploads/files/projects/' . $fileData['relation'] . '/' . $fileData['file_name'])) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/projects/' . $fileData['relation'] . '/' . $fileData['file_name']);
					force_download($fileData['file_name'], $data);
				} else {
					$this->session->set_flashdata('ntf4', lang('filenotexist'));
					redirect('projects/project/' . $fileData['relation']);
				}
			}
		}
	}

	function checkpinned()
	{
		if (isset($_POST['project'])) {
			$project = $_POST['project'];
			$response = $this->db->where('id', $project)->update('projects', array('pinned' => 1));
			$data['success'] = true;
			$data['message'] = lang('pinnedprojects');
		}
		echo json_encode($data);
	}

	function unpinned()
	{
		if (isset($_POST['pinnedproject'])) {
			$pinnedproject = $_POST['pinnedproject'];
			$response = $this->db->where('id', $pinnedproject)->update('projects', array('pinned' => 0));
			$data['success'] = true;
			$data['message'] = lang('unpinned') . ' ' . lang('project');
		}
		echo json_encode($data);
	}

	function addexpense($id)
	{
		if ($this->Privileges_Model->check_privilege('expenses', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('title', lang('title'), 'trim|required|max_length[200]');
				$this->form_validation->set_rules('amount', lang('amount'), 'trim|required');
				$this->form_validation->set_rules('date', lang('date'), 'trim|required|valid_date');
				$this->form_validation->set_rules('category', lang('category'), 'trim|required|integer');
				$this->form_validation->set_rules('account', lang('account'), 'trim|required|integer');
				$this->form_validation->set_rules('description', lang('description'), 'trim|max_length[65535]');
				$this->form_validation->set_rules('name', lang('name'), 'trim|max_length[255]');
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$category_id = $this->input->post('category');
					$customer_id = $this->input->post('customer');
					$account_id = $this->input->post('account');
					$title = $this->input->post('title');
					$date = $this->input->post('date');
					$amount = $this->input->post('amount');
					$description = $this->input->post('description');
					$appconfig = get_appconfig();
					$params = array(
						'category_id' => $category_id,
						'staff_id' => $this->session->usr_id,
						'customer_id' => $customer_id,
						'relation_type' => 'project',
						'relation' => $id,
						'account_id' => $account_id,
						'title' => $title,
						'date' => $date,
						'created' => date('Y-m-d H:i:s'),
						'amount' => $amount,
						'description' => $description,
						'internal' => '1',
						'total_tax' => '0',
						'total_discount' => '0',
						'sub_total' => $amount,
					);
					$this->db->insert('expenses', $params);
					$expense_id = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['expense_series'] ? $appconfig['expense_series'] : $expense_id;
					$expense_number = $appconfig['expense_prefix'] . $number;
					$this->db->where('id', $expense_id)->update('expenses', array('expense_number' => $expense_number));
					$this->db->insert('payments', array(
						'transactiontype' => 1,
						'is_transfer' => 0,
						'expense_id' => $expense_id,
						'staff_id' => $this->session->usr_id,
						'amount' => $amount,
						'account_id' => $account_id,
						'customer_id' => $customer_id,
						'not' => 'Outgoings for <a href="' . base_url('expenses/receipt/' . $expense_id . '') . '">' . $expense_number . '</a>',
						'date' => $date,
					));
					if ($appconfig['expense_series']) {
						$expense_number = $appconfig['expense_series'];
						$expense_number = $expense_number + 1;
						$this->Settings_Model->increment_series('expense_series', $expense_number);
					}

					$item = array(
						'relation_type' => 'expense',
						'relation' => $expense_id,
						'product_id' => '',
						'code' => '',
						'name' => $this->input->post('name'),
						'description' => $description,
						'quantity' => '1',
						'unit' => '',
						'price' => $amount,
						'tax' => '0',
						'discount' => '0',
						'total' => $amount,
					);
					$this->db->insert('items', $item);
					$loggedinuserid = $this->session->usr_id;
					$appconfig = get_appconfig();
					$this->db->insert('logs', array(
						'date' => date('Y-m-d H:i:s'),
						'detail' => ('' . $this->session->staffname . ' ' . lang('added') . ' ' . lang('expense') . ' ' . lang('for') . ' ' . get_number('projects', $id, 'project', 'project')),
						'staff_id' => $loggedinuserid,
						'project_id' => $id,
						'customer_id' => $this->input->post('customer')
					));
					$template = $this->Emails_Model->get_template('expense', 'expense_created');
					if ($template['status'] == 1) {
						$expense = $this->Expenses_Model->get_expenses($expense_id);
						if ($expense['individual']) {
							$customer = $expense['individual'];
						} else {
							$customer = $expense['customer'];
						}
						$message_vars = array(
							'{customer}' => $customer,
							'{expense_number}' => get_number('expenses', $expense['id'], 'expense', 'expense'),
							'{expense_title}' => $expense['title'],
							'{expense_category}' => $expense['category'],
							'{expense_date}' => $expense['date'],
							'{expense_description}' => $expense['description'],
							'{expense_amount}' => $expense['amount'],
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
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
							'email' => $expense['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date("Y.m.d H:i:s")
						);
						if ($expense['customeremail']) {
							$this->db->insert('email_queue', $param);
						}
					}
					$data['success'] = true;
					$data['message'] = lang('expense') . ' ' . lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function convert($id)
	{
		if ($this->Privileges_Model->check_privilege('invoices', 'create')) {
			$project = $this->Projects_Model->get_projects($id);
			if (isset($_POST) && count($_POST) > 0) {
				$services = $this->Projects_Model->get_project_services($id);
				$params = array(
					'token' => md5(uniqid()),
					'staff_id' => $project['staff_id'],
					'customer_id' => $project['customer_id'],
					'created' => date('Y-m-d H:i:s'),
					'status_id' => 3,
					'total_discount' => 0,
					'total_tax' => 0,
					'total' => $this->input->post('total'),
					'project_id' => $id,
					'sub_total' => $this->input->post('total'),
				);
				$this->db->insert('invoices', $params);
				$invoice = $this->db->insert_id();
				$total = 0;
				$total_tax = 0;
				$sub_total = 0;
				foreach ($services as $service) {
					$this->db->insert('items', array(
						'relation_type' => 'invoice',
						'relation' => $invoice,
						'name' => $service['servicename'],
						'description' => $service['servicedescription'],
						'quantity' => $service['quantity'],
						'unit' => $service['unit'],
						'price' => $service['serviceprice'],
						'tax' => $service['servicetax'],
						'discount' => 0,
						'total' => $service['quantity'] * $service['serviceprice'] + (($service['servicetax']) / 100 * $service['quantity'] * $service['serviceprice']),
					));
					$total += $service['quantity'] * $service['serviceprice'] + (($service['servicetax']) / 100 * $service['quantity'] * $service['serviceprice']);
					$total_tax += ($service['servicetax']) / 100 * $service['quantity'] * $service['serviceprice'];
				};

				$invoice_id_no = $this->get_invoice_id();
				$sub_total = $total - $total_tax;
				$response = $this->db->where('id', $invoice)->update('invoices', array('total' => $total, 'sub_total' => $sub_total, 'total_tax' => $total_tax,'invoice_number' => 'INV-'.$invoice_id_no));

				$this->db->insert($this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project['customer_id'],
					'total' => $total,
					'date' => date('Y-m-d H:i:s')
				));
				$staffname = $this->session->staffname;
				$this->db->insert('logs', array(
					'date' => date('Y-m-d H:i:s'),
					'detail' => ('' . $message = sprintf(lang('projecttoinvoicelog'), $staffname, $project['id']) . ''),
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project['customer_id'],
				));
				$response = $this->db->where('id', $id)->update('projects', array('invoice_id' => $invoice));
				$data['id'] = $invoice;
				$data['success'] = true;
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
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

	function convertwithcost($id)
	{		
		if ($this->Privileges_Model->check_privilege('invoices', 'create')) {
			$project = $this->Projects_Model->get_projects($id);
			if (isset($_POST) && count($_POST) > 0) {
				//$services = $this->Projects_Model->get_project_values($id);
				$params = array(
					'token' => md5(uniqid()),
					'staff_id' => $project['staff_id'],
					'customer_id' => $project['customer_id'],
					'created' => date('Y-m-d H:i:s'),
					'status_id' => 3,
					'total_discount' => 0,
					'total_tax' => 0,
					'total' => $this->input->post('total'),
					'project_id' => $id,
					'sub_total' => $this->input->post('total'),
				);
				$this->db->insert('invoices', $params);
				$invoice = $this->db->insert_id();

				$this->db->insert('items', array(
					'relation_type' => 'invoice',
					'relation' => $invoice,
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'quantity' => 1,
					'unit' => 'Unit',
					'price' => $this->input->post('cost'),
					'tax' => $this->input->post('tax'),
					'discount' => 0,
					'total' => 1 * $this->input->post('cost') + (($this->input->post('tax')) / 100 * 1 * $this->input->post('cost')),
				));

				$total = 0;
				$sub_total = 0;
				$total_tax = ($this->input->post('tax')) / 100 * 1 * $this->input->post('cost');
				$total = 1 * $this->input->post('cost') + (($this->input->post('tax')) / 100 * 1 * $this->input->post('cost'));
				$sub_total = $total - $total_tax;


				$invoice_id_no = $this->get_invoice_id();
				$invoice_id_no = intval($invoice_id_no);
				$response = $this->db->where('id', $invoice)->update('invoices', array('total' => $total, 'sub_total' => $total, 'total_tax' => $total_tax,'invoice_number' => 'INV-'.$invoice_id_no));

				$this->db->insert($this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project['customer_id'],
					'total' => $total,
					'date' => date('Y-m-d H:i:s')
				));
				$staffname = $this->session->staffname;
				$this->db->insert('logs', array(
					'date' => date('Y-m-d H:i:s'),
					'detail' => ('' . $message = sprintf(lang('projecttoinvoicelog'), $staffname, $project['id']) . ''),
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project['customer_id'],
				));
				$response = $this->db->where('id', $id)->update('projects', array('invoice_id' => $invoice));
				$data['id'] = $invoice;
				$data['success'] = true;
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function removeService($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			$services = $this->Projects_Model->get_project_service($id);
			if (isset($services['id'])) {
				$number = get_number('projects', $services['projectid'], 'project', 'project');
				$this->Projects_Model->delete_service($id, $number);
				$data['success'] = true;
				$data['message'] = lang('service') . ' ' . lang('deletemessage');
			} else {
				$data['success'] = false;
				$data['message'] = lang('servicedoesnotexist');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	/* Remove Project */
	function remove($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$project = $this->Projects_Model->get_project_by_priviliges($id);
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			$projects = $this->Projects_Model->get_projects($id);
			if (($projects['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($projects['id'], $this->session->usr_id)) == 'true') {
				$project = $projects;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($project) {
			if ($this->Privileges_Model->check_privilege('projects', 'delete')) {
				if (isset($project['id'])) {
					$this->Projects_Model->delete_projects($id, get_number('projects', $id, 'project', 'project'));
					$data['success'] = true;
				} else {
					show_error('The projects you are trying to delete does not exist.');
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
			echo json_encode($data);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function customer_proposals($id)
	{
		$project = $this->Projects_Model->get_projects($id);
		if (isset($project['id'])) {
			$proposals = $this->Proposals_Model->customer_proposals($project['customer_id']);
			echo json_encode($proposals);
		}
	}

	function get_proposals($id)
	{
		$project = $this->Projects_Model->get_projects($id);
		if (isset($project['id'])) {
			$proposals = $this->Proposals_Model->project_proposals($id);
			$data_proposals = array();
			foreach ($proposals as $proposal) {
				$pro = $this->Proposals_Model->get_proposals($proposal['id'], $proposal['relation_type']);
				if (isset($pro['relation_type']) && $pro['relation_type'] == 'customer') {
					if ($pro['customercompany'] === NULL) {
						$customer = $pro['namesurname'];
					} else $customer = $pro['customercompany'];
				}
				if ($pro['relation_type'] && $pro['relation_type'] == 'lead') {
					$customer = $pro['leadname'];
				}
				switch ($proposal['status_id']) {
					case '0':
						$status = lang('quote') . ' ' . lang('request');
						$class = 'proposal-status-open';
						break;
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
				};
				$appconfig = get_appconfig();
				$data_proposals[] = array(
					'id' => $proposal['id'],
					'assigned' => $proposal['assigned'],
					'prefix' => $appconfig['proposal_prefix'],
					'longid' => get_number('proposals', $proposal['id'], 'proposal', 'proposal'),
					'subject' => $proposal['subject'],
					'customer' => $customer,
					'relation' => $proposal['relation'],
					'date' => date(get_dateFormat(), strtotime($proposal['date'])),
					'opentill' => date(get_dateFormat(), strtotime($proposal['opentill'])),
					'status' => $status,
					'status_id' => $proposal['status_id'],
					'staff' => $proposal['staffmembername'],
					'staffavatar' => $proposal['staffavatar'],
					'total' => $proposal['total'],
					'class' => $class,
					'relation_type' => $proposal['relation_type'],
					'' . lang('relationtype') . '' => $proposal['relation_type'],
					'' . lang('filterbystatus') . '' => $status,
					'' . lang('filterbycustomer') . '' => $customer,
					'' . lang('filterbyassigned') . '' => $proposal['staffmembername'],
				);
			};
			echo json_encode($data_proposals);
		}
	}

	function link_proposal($id)
	{
		if ($this->Privileges_Model->check_privilege('projects', 'edit')) {
			$project = $this->Projects_Model->get_projects($id);
			if (isset($project['id'])) {
				$pro_id = $this->input->post('proposal');
				$check = $this->Proposals_Model->check_project_id($id, $pro_id);
				$hasError = false;
				if ($pro_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage') . ' ' . lang('proposal');
				} else if ($check == 'exist') {
					$hasError = true;
					$data['message'] = lang('proposal') . ' ' . lang('already_linked') . ' ' . lang('project');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$this->db->where('id', $pro_id);
					$response = $this->db->update('proposals', array('project_id' => $id));
					$data['message'] = lang('proposal') . ' ' . lang('link_message');
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

	function proposal_create($id)
	{
		if ($this->Privileges_Model->check_privilege('proposals', 'create')) {
			$project = $this->Projects_Model->get_projects($id);
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[300]');
				$this->form_validation->set_rules('date', lang('issue') . ' ' . lang('date'), 'trim|required|valid_date');
				$this->form_validation->set_rules('assigned', lang('assigned'), 'trim|required|integer');
				$this->form_validation->set_rules('status', lang('status'), 'trim|required|integer');
				$this->form_validation->set_rules('opentill',  lang('end') . ' ' . lang('date'), 'trim|required|valid_date|callback_compare_date');
				$this->form_validation->set_rules('content', lang('description'), 'trim|required|max_length[4294967295]');
				$this->form_validation->set_rules('comment', lang('comments'), 'trim|in_list[true,false]');
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
						$data['message'] = lang('invalid_items');
					} else if ($total == 0) {
						$data['message'] = lang('Total can not be 0');
					} else {
						$customer = $this->input->post('customer');
						$subject = $this->input->post('subject');
						$data['message'] = '';
						$allow_comment = $this->input->post('comment');
						if ($allow_comment != true) {
							$comment_allow = 0;
						} else {
							$comment_allow = 1;
						};
						$params = array(
							'token' => md5(uniqid()),
							'subject' => $this->input->post('subject'),
							'content' => $this->input->post('content'),
							'date' => _pdate($this->input->post('date')),
							'created' => date('Y-m-d H:i:s'),
							'opentill' => _pdate($this->input->post('opentill')),
							'relation_type' => 'customer',
							'relation' => $project['customer_id'],
							'assigned' => $this->input->post('assigned'),
							'project_id' => $id,
							'addedfrom' => $this->session->usr_id,
							'datesend' => _pdate($this->input->post('datesend')),
							'comment' => $comment_allow,
							'status_id' => $this->input->post('status'),
							'invoice_id' => $this->input->post('invoice'),
							'dateconverted' => $this->input->post('dateconverted'),
							'sub_total' => $this->input->post('sub_total'),
							'total_discount' => $this->input->post('total_discount'),
							'total_tax' => $this->input->post('total_tax'),
							'total' => $this->input->post('total'),
						);
						$proposals_id = $this->Projects_Model->proposal_add($params);
						$template = $this->Emails_Model->get_template('proposal', 'send_proposal');
						if ($template['status'] == 1) {
							$pro = $this->Proposals_Model->get_pro_rel_type($proposals_id);
							$rel_type = $pro['relation_type'];
							$proposal = $this->Proposals_Model->get_proposals($proposals_id, $rel_type);
							if ($rel_type == 'customer') {
								$customer = $proposal['customercompany'] ? $proposal['customercompany'] : $proposal['namesurname'];
							} else {
								$customer = $proposal['leadname'];
							}
							$link = base_url('share/proposal/' . $proposal['token'] . '');
							$message_vars = array(
								'{proposal_to}' => $customer,
								'{proposal_link}' => $link,
								'{subject}' => $this->input->post('subject'),
								'{details}' => $this->input->post('content'),
								'{name}' => $this->session->userdata('staffname'),
								'{email_signature}' => $this->session->userdata('email'),
								'{open_till}' => _pdate($this->input->post('opentill')),
								'{company_name}' => setting['company'],
								'{company_email}' => setting['email'],
								'{site_url}' => site_url(),
								'{logo}' => rebrand['app_logo'],
								'{footer_logo}' => rebrand['nav_logo'],
								'{email_banner}' => rebrand['email_banner'],
								'{proposal_number}' => get_number('proposals', $proposals_id, 'proposal', 'proposal'),
							);
							$subject = strtr($template['subject'], $message_vars);
							$message = strtr($template['message'], $message_vars);
							$param = array(
								'from_name' => $template['from_name'],
								'email' => $proposal['toemail'],
								'subject' => $subject,
								'message' => $message,
								'created' => date("Y.m.d H:i:s")
							);
							if ($proposal['toemail']) {
								$this->db->insert('email_queue', $param);
							}
						}
						$data['success'] = true;
						$data['message'] = lang('proposal') . ' ' . lang('createmessage');
						$data['proposal_id'] = $proposals_id;
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

	function download_pdf($id)
	{
		if (isset($id)) {
			$appconfig = get_appconfig();
			$file_name = '' . get_number('project', $id, 'project', 'project') . '.pdf';
			if (is_file('./uploads/files/expenses/' . $id . '/' . $file_name)) {
				$this->load->helper('file');
				$this->load->helper('download');
				$data = file_get_contents('./uploads/files/expenses/' . $id . '/' . $file_name);
				force_download($file_name, $data);
			} else {
				$this->session->set_flashdata('ntf4', lang('filenotexist'));
				redirect('expenses/receipt/' . $id);
			}
		} else {
			redirect('expenses/receipt/' . $id);
		}
	}

	function create_pdf($id)
	{
		$status_project = [];
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$project = $this->Projects_Model->get_project_by_priviliges($id);
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			$projects = $this->Projects_Model->get_projects($id);
			if (($projects['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($projects['id'], $this->session->usr_id)) == 'true') {
				$project = $this->Projects_Model->get_projects($id);
			}
		} else {
			$result['success'] = false;
			$result['message'] = lang('you_dont_have_permission');
			echo json_encode($result);
		}
		if ($project) {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '2048M');
			if (!is_dir('uploads/files/projects/' . $id)) {
				mkdir('./uploads/files/projects/' . $id, 0777, true);
			}
			switch (isset($project['status'])) {
				case '1':
					$status_project = lang('notstarted');
					break;
				case '2':
					$status_project = lang('started');
					break;
				case '3':
					$status_project = lang('percentage');
					break;
				case '4':
					$status_project = lang('cancelled');
					break;
				case '5':
					$status_project = lang('completed');
					break;
			};
			$data['logs'] = $this->projecttimelogs($id);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
			$data['country'] = get_country($data['settings']['country_id']);
			$data['billing_country'] = get_country($project['country_id']);
			$data['billing_state'] = get_state_name($project['billing_state'], $project['billing_state_id']);
			$data['project'] = $project;
			$data['status'] = $status_project;
			$data['color'] = $this->input->post('color');
			$data['services'] = '';
			$data['customer'] = false;
			$data['is_summary'] = false;
			$data['milestones'] = '';
			$data['tasks'] = '';
			$data['expenses'] = '';
			$data['proposals'] = '';
			$data['tickets'] = '';
			$data['members'] = '';
			$data['files'] = '';
			$data['notes'] = '';
			$data['time_logs'] = '';


			if ($this->input->post('customer') == 'true') {
				$data['customer'] = true;
			} else {
				$data['customer'] = false;
			}
			if ($this->input->post('services') == 'true') {
				$data['services'] = $this->Projects_Model->get_project_services($id);
			} else {
				$data['services'] = '';
			}
			// if ($this->input->post('projectservices') == 'true') {
			// 	$data['projectservices'] = $this->Projects_Model->get_project_value($id);
			// } else {
			// 	$data['projectservices'] = '';
			// }
			if ($this->input->post('milestones') == 'true') {
				$data['milestones'] = $this->Projects_Model->get_all_project_milestones($id);
			} else {
				$data['milestones'] = '';
			}
			if ($this->input->post('tasks') == 'true') {
				$data['tasks'] = $this->Tasks_Model->get_project_tasks($id);
			} else {
				$data['tasks'] = '';
			}
			if ($this->input->post('expenses') == 'true') {
				$data['expenses'] = $this->Expenses_Model->get_all_expenses_by_relation('project', $id);
			} else {
				$data['expenses'] = '';
			}
			if ($this->input->post('proposals') == 'true') {
				$data['proposals'] = $this->Proposals_Model->project_proposals($id);
			} else {
				$data['proposals'] = '';
			}
			if ($this->input->post('tickets') == 'true') {
				$data['tickets'] = $this->Projects_Model->get_all_tickets($id);
			} else {
				$data['tickets'] = '';
			}
			if ($this->input->post('peoples') == 'true') {
				$data['members'] = $this->Projects_Model->get_members_index($id);
			} else {
				$data['members'] = '';
			}
			if ($this->input->post('files') == 'true') {
				$data['files'] = $this->Projects_Model->get_project_files($id);
			} else {
				$data['files'] = '';
			}
			if ($this->input->post('notes') == 'true') {
				$data['notes'] = $this->Projects_Model->get_project_notes($id);
			} else {
				$data['notes'] = '';
			}
			if ($this->input->post('time_logs') == 'true') {
				$data['time_logs'] = $data['logs'];
			} else {
				$data['time_logs'] = '';
			}
			if ($this->input->post('summary') == 'true') {
				$data['is_summary'] = true;
				$data['summary'] = $this->project_summary($id);
			} else {
				$data['is_summary'] = false;
			}
			$appconfig = get_appconfig();
			$file_name = '' . get_number('projects', $id, 'project', 'project') . '.pdf';
			$html = $this->load->view('projects/pdf', $data, TRUE);
			$this->load->library('dom');
			$this->dompdf->loadHtml($html);
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->setPaper('A4', 'portrait');
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents('uploads/files/projects/' . $id . '/' . $file_name . '', $output);
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ($output) {
				$result = array(
					'success' => true,
					'file_name' => $file_name,
				);
				$this->Projects_Model->update_pdf_status($id, '1');
				echo json_encode($result);
			} else {
				redirect(base_url('projects/pdf_fault/'));
			}
		} else {
			$result['success'] = false;
			$result['message'] = lang('you_dont_have_permission');
			echo json_encode($result);
		}
	}

	function project_summary($id)
	{
		$summary = array(
			'expenses' => $this->db->get_where('expenses', array('relation' => $id, 'relation_type' => 'project'))->num_rows(),
			'tickets' => $this->db->get_where('tickets', array('relation_id' => $id, 'relation' => 'project',))->num_rows(),
			'proposals' => $this->db->get_where('proposals', array('proposals.project_id' => $id))->num_rows(),
			'tasks' => $this->db->get_where('tasks', array('tasks.relation_type' => 'project', 'tasks.relation' => $id))->num_rows(),
			'milestones' => $this->db->get_where('milestones', array('project_id' => $id))->num_rows(),
			'members' => $this->db->get_where('projectmembers', array('projectmembers.project_id' => $id))->num_rows(),
			'files' => $this->db->get_where('files', array('files.relation_type' => 'project', 'files.relation' => $id))->num_rows(),
			'services' => $this->db->get_where('projectservices', array('projectservices.projectid' => $id))->num_rows(),
			'projectservices'=> $this->db->get_where('projects', array('projects.id' => $id ))->num_rows()
		);
		return $summary;
	}

	function pdf_generates($file)
	{
		return true;
	}

	function pdf_generated($file)
	{
		$result = array(
			'status' => true,
			'file_name' => $file,
		);
		echo json_encode($result);
	}

	function projecttimelogs($id)
	{
		$timelogs = $this->Projects_Model->get_project_time_log($id);
		$data_timelogs = array();
		foreach ($timelogs as $timelog) {
			$task = $this->Tasks_Model->get_task($timelog['task_id']);
			$date1 = new DateTime($timelog['start']);
			$diffs = $date1->diff(new DateTime($timelog['end']));
			$h = $diffs->days * 24;
			$h += $diffs->h;
			$minutes = $diffs->i;
			$seconds = $diffs->s;
			if ($minutes < 10) {
				$minutes = $minutes;
			}
			if ($seconds < 10) {
				$seconds = $seconds;
			}
			if ($h < 10) {
				$h = $h;
			}
			$total = $h . ':' . $minutes . ':' . $seconds;
			$minutess = $h * 60 + $minutes;
			if (isset($task) && $task['hourly_rate'] > 0) {
				$amounts = ($h + ($minutes / 60)) * $task['hourly_rate'];
			} else {
				$amounts = 0;
			}
			if (!isset($task) || $task['status_id'] != 5) {
				$data_timelogs[] = array(
					'id' => $timelog['id'],
					'start' => $timelog['start'],
					'end' => $timelog['end'],
					'note' => $timelog['note'],
					'staff' => $timelog['staffmember'],
					'status' => $timelog['status'],
					//'timed' => $timed_minute,
					'total_logged' => $total,
					'total_amount' => $amounts,
					'minutes' => $minutess,
					'rate' => $task['hourly_rate'] ?? 0,
					'amount' => $amounts,
				);
			}
		};
		return $data_timelogs;
	}

	function projects_stats()
	{
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$stats = $this->Projects_Model->get_projects_stats();
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			$stats = $this->Projects_Model->get_projects_stats($this->session->usr_id);
		}
		echo json_encode($stats);
	}

	function get_project($id)
	{
		$project = array();
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			$project = $this->Projects_Model->get_projects($id);
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			$projects = $this->Projects_Model->get_projects($id);
			if (($projects['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($projects['id'], $this->session->usr_id)) == 'true') {
				$project = $projects;
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('projects'));
		}
		if ($project) {
			$status_project = [];
			$settings = $this->Settings_Model->get_settings_ciuis();
			$projectmembers = $this->Projects_Model->get_members($id);
			$project_logs = $this->Logs_Model->project_logs($id);
			$totaltasks = $this->Report_Model->totalprojecttasks($id);
			$opentasks = $this->Report_Model->openprojecttasks($id);
			$completetasks = $this->Report_Model->completeprojecttasks($id);
			$progress = ($totaltasks > 0 ? number_format(($completetasks * 100) / $totaltasks) : 0);
			$customer = ($project['customercompany']) ? $project['customercompany'] : $project['namesurname'];
			$contact = $this->Contacts_Model->get_customer_contacts($project['customer_id']);
			$enddate = $project['deadline'];
			$current_date = new DateTime(date('Y-m-d'), new DateTimeZone($settings['default_timezone']));
			$end_date = new DateTime("$enddate", new DateTimeZone($settings['default_timezone']));
			$interval = $current_date->diff($end_date);
			$project_left_date = $interval->format('%a day(s)');
			if (date("Y-m-d") > $project['deadline']) {
				$ldt = 'Time\'s up!';
			} else $ldt = $project_left_date;
			switch ($project['status']) {
				case '1':
					$status_project = lang('notstarted');
					break;
				case '2':
					$status_project = lang('started');
					break;
				case '3':
					$status_project = lang('percentage');
					break;
				case '4':
					$status_project = lang('cancelled');
					break;
				case '5':
					$status_project = lang('completed');
					break;
			};
			if (in_array(current_user_id, array_column($projectmembers, 'staff_id')) || isAdmin()) {
				$authorization = "true";
			} else {
				$authorization = 'false';
			};
			if ($project['invoice_id'] > 0) {
				$billed = lang('yes');
			} else {
				$billed = lang('no');
			}
			$data_projectlog = array();
			foreach ($project_logs as $logs) {
				$data_projectlog[] = array(
					'date' => date(get_dateTimeFormat(), strtotime($logs['date'])),
					'detail' => str_replace('<a href="','<a href="'.base_url(),$logs['detail']),
				);
			}
			$tasks = $this->Tasks_Model->get_project_tasks($id);
			$data_projecttasks = array();
			foreach ($tasks as $task) {
				$settings = $this->Settings_Model->get_settings_ciuis();
				switch ($task['status_id']) {
					case '1':
						$status = lang('open');
						$taskdone = '';
						break;
					case '2':
						$status = lang('inprogress');
						$taskdone = '';
						break;
					case '3':
						$status = lang('waiting');
						$taskdone = '';
						break;
					case '4':
						$status = lang('complete');
						$taskdone = 'done';
						break;
					case '5':
						$status = lang('cancelled');
						$taskdone = '';
						break;

					default:
						$status = lang('open');
						$taskdone = '';
						break;
				};
				switch ($task['relation_type']) {
					case 'project':
						$relationtype = 'Project';
						break;
					case 'ticket':
						$relationtype = 'Tıcket';
						break;
					case 'proposal':
						$relationtype = 'Proposal';
						break;
				};
				switch ($task['priority']) {
					case '1':
						$priority = lang('low');
						break;
					case '2':
						$priority = lang('medium');
						break;
					case '3':
						$priority = lang('high');
						break;
				};
				$data_projecttasks[] = array(
					'id' => $task['id'],
					'name' => $task['name'],
					'description' => $task['description'],
					'relationtype' => $relationtype,
					'status' => $status,
					'status_id' => $task['status_id'],
					'duedate' => date(get_dateFormat(), strtotime($task['duedate'])),
					'startdate' => date(get_dateFormat(), strtotime($task['startdate'])),
					'done' => $taskdone,
					'task_number' => get_number('tasks', $task['id'], 'task', 'task'),
				);
			};
			$appconfig = get_appconfig();
			$data_projectdetail = array(
				'id' => $project['id'],
				'name' => $project['name'],
				'value' => $project['projectvalue'],
				'status_id' => $project['status'],
				'tax' => $project['tax'],
				'description' => $project['description'],
				'start' => $project['start_date'],
				'start_edit' => $project['start_date'],
				'deadline' => date(get_dateFormat(), strtotime($project['deadline'])),
				'deadline_edit' => $project['deadline'],
				'created' => $project['created'],
				'finished' => $project['finished'],
				'template' => $project['template'],
				'status' => $status_project,
				'progress' => $progress,
				'totaltasks' => $totaltasks,
				'opentasks' => $opentasks,
				'completetasks' => $completetasks,
				'customer' => $customer,
				'customer_id' => $project['customer_id'],
				'ldt' => $ldt,
				'authorization' => $authorization,
				'billed' => $billed,
				'tasks' => $data_projecttasks,
				'members' => $projectmembers,
				'project_logs' => $data_projectlog,
				'pdf_report' => $project['pdf_report'],
				'file_name' =>  get_number('projects', $project['id'], 'project', 'project') . '.pdf',
				'project_number' => get_number('projects', $project['id'], 'project', 'project'),
				'customercontact' => $contact,
			);
			echo json_encode($data_projectdetail);
		}
	}
	function projectmilestones($id)
	{
		$milestones = $this->Projects_Model->get_all_project_milestones($id);
		$data_milestones = array();
		foreach ($milestones as $milestone) {
			if (date("Y-m-d") > $milestone['duedate']) {
				$status = 'is-completed';
			} else if (date("Y-m-d") < $milestone['duedate']) {
				$status = 'is-future';
			} else {
				$status = 'is-completed';
			}
			$tasks = $this->Projects_Model->get_all_project_milestones_task($milestone['id']);
			$data_milestones[] = array(
				'id' => $milestone['id'],
				'name' => $milestone['name'],
				'duedate' => date(get_dateTimeFormat(), strtotime($milestone['duedate'])),
				'description' => $milestone['description'],
				'order' => $milestone['order'],
				'due' => date(get_dateFormat(), strtotime($milestone['duedate'])),
				'status' => $status,
				'tasks' => $tasks,
			);
		};
		echo json_encode($data_milestones);
	}

	function projectfiles($id)
	{
		if (isset($id)) {
			$files = $this->Projects_Model->get_project_files($id);
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf') {
					$type = 'pdf';
				}
				if ($ext == 'zip' || $ext == 'rar' || $ext == 'tar') {
					$type = 'archive';
				}
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$display = true;
				} else {
					$display = false;
				}
				if ($ext == 'pdf') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				if ($file['is_old'] == '1') {
					$path = base_url('uploads/files/' . $file['file_name']);
				} else {
					$path = base_url('uploads/files/projects/' . $id . '/' . $file['file_name']);
				}
				$data[] = array(
					'id' => $file['id'],
					'project_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}

	function get_projecttimelogs($id)
	{
		$timelogs = $this->Projects_Model->get_project_time_log($id);
		$data_timelogs = array();
		foreach ($timelogs as $timelog) {
			$task = $this->Tasks_Model->get_task($timelog['task_id']);
			$start = $timelog['start'];
			$end = $timelog['end'];
			$timed_minute = intval(abs(strtotime($start) - strtotime($end)) / 60);
			$amount = $timed_minute / 60 * $task['hourly_rate'];

			$date1 = new DateTime($timelog['start']);
			$diffs = $date1->diff(new DateTime($timelog['end']));
			$h = $diffs->days * 24;
			$h += $diffs->h;
			$minutes = $diffs->i;
			$seconds = $diffs->s;
			if ($minutes < 10) {
				$minutes = $minutes;
			}
			if ($seconds < 10) {
				$seconds = $seconds;
			}
			if ($h < 10) {
				$h = $h;
			}
			$total = $h . ':' . $minutes . ':' . $seconds;
			$minutess = $h * 60 + $minutes;
			if ($task['hourly_rate'] > 0) {
				$amounts = ($h + ($minutes / 60)) * $task['hourly_rate'];
			} else {
				$amounts = 0;
			}
			if ($task['status_id'] != 5) {
				$data_timelogs[] = array(
					'id' => $timelog['id'],
					'start' => date(get_dateTimeFormat(), strtotime($timelog['start'])),
					'end' => date(get_dateTimeFormat(), strtotime($timelog['end'])),
					'staff' => $timelog['staffmember'],
					'status' => $timelog['status'],
					'timed' => $timed_minute,
					'amount' => $amount,
					'total_logged' => $total,
					'total_amount' => $amounts,
					'minutes' => $minutess,
				);
			}
		};
		echo json_encode($data_timelogs);
	}

	function get_projects()
	{
		$projects = $this->Projects_Model->get_all_projects();
		$data_projects = array();
		if ($this->Privileges_Model->check_privilege('projects', 'all')) {
			foreach ($projects as $project) {
				$settings = $this->Settings_Model->get_settings_ciuis();
				$totaltasks = $this->Report_Model->totalprojecttasks($project['id']);
				$opentasks = $this->Report_Model->openprojecttasks($project['id']);
				$completetasks = $this->Report_Model->completeprojecttasks($project['id']);
				$progress = ($totaltasks > 0 ? number_format(($completetasks * 100) / $totaltasks) : 0);
				$project_id = $project['id'];
				switch ($project['status']) {
					case '1':
						$projectstatus = 'notstarted';
						$icon = 'notstarted.png';
						$status = lang('notstarted');
						break;
					case '2':
						$projectstatus = 'started';
						$icon = 'started.png';
						$status = lang('started');
						break;
					case '3':
						$projectstatus = 'percentage';
						$icon = 'percentage.png';
						$status = lang('percentage');
						break;
					case '4':
						$projectstatus = 'cancelled';
						$icon = 'cancelled.png';
						$status = lang('cancelled');
						break;
					case '5':
						$projectstatus = 'complete';
						$icon = 'complete.png';
						$status = lang('complete');
						break;
				}
				if ($project['status'] == '5') {
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang('completed');
					$progress = 100;
				}
				if ($project['template'] == '1') {
					$projectstatus = 'template';
				}
				$customer = ($project['customercompany']) ? $project['customercompany'] : $project['namesurname'];
				$enddate = $project['deadline'];
				$current_date = new DateTime(date('Y-m-d'), new DateTimeZone('Asia/Dhaka'));
				$end_date = new DateTime("$enddate", new DateTimeZone('Asia/Dhaka'));
				$interval = $current_date->diff($end_date);
				$leftdays = $interval->format('%r%a day(s)');
				$members = $this->Projects_Model->get_members_index($project_id);
				$milestones = $this->Projects_Model->get_all_project_milestones($project_id);
				$appconfig = get_appconfig();
				$data_projects[] = array(
					'id' => $project['id'],
					'project_id' => $project['id'],
					'name' => $project['name'],
					'pinned' => $project['pinned'],
					'value' => $project['projectvalue'],
					'tax' => $project['tax'],
					'template' => $project['template'],
					'status_id' => $project['status'],
					'progress' => $progress,
					'startdate' => date(get_dateFormat(), strtotime($project['start_date'])),
					'leftdays' => $leftdays,
					'customer' => $customer,
					'customeremail' => $project['customeremail'],
					'status_icon' => $icon,
					'status' => $status,
					'status_class' => $projectstatus,
					'customer_id' => $project['customer_id'],
					'members' => $members,
					'milestones' => $milestones,
					lang('filterbystatus') => lang($projectstatus),
					lang('filterbycustomer') => $customer,
					'project_number' => get_number('projects', $project['id'], 'project', 'project'),
				);
			}
		} else if ($this->Privileges_Model->check_privilege('projects', 'own')) {
			foreach ($projects as $project) {
				if (($project['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($project['id'], $this->session->usr_id)) == 'true') {
					$settings = $this->Settings_Model->get_settings_ciuis();
					$totaltasks = $this->Report_Model->totalprojecttasks($project['id']);
					$opentasks = $this->Report_Model->openprojecttasks($project['id']);
					$completetasks = $this->Report_Model->completeprojecttasks($project['id']);
					$progress = ($totaltasks > 0 ? number_format(($completetasks * 100) / $totaltasks) : 0);
					$project_id = $project['id'];
					switch ($project['status']) {
						case '1':
							$projectstatus = 'notstarted';
							$icon = 'notstarted.png';
							$status = lang('notstarted');
							break;
						case '2':
							$projectstatus = 'started';
							$icon = 'started.png';
							$status = lang('started');
							break;
						case '3':
							$projectstatus = 'percentage';
							$icon = 'percentage.png';
							$status = lang('percentage');
							break;
						case '4':
							$projectstatus = 'cancelled';
							$icon = 'cancelled.png';
							$status = lang('cancelled');
							break;
						case '5':
							$projectstatus = 'complete';
							$icon = 'complete.png';
							$status = lang('complete');
							break;
					}
					if ($project['status'] == '5') {
						$projectstatus = 'complete';
						$icon = 'complete.png';
						$status = lang('completed');
						$progress = 100;
					}
					if ($project['template'] == '1') {
						$projectstatus = 'template';
					}
					$customer = ($project['customercompany']) ? $project['customercompany'] : $project['namesurname'];
					$enddate = $project['deadline'];
					$current_date = new DateTime(date('Y-m-d'), new DateTimeZone('Asia/Dhaka'));
					$end_date = new DateTime("$enddate", new DateTimeZone('Asia/Dhaka'));
					$interval = $current_date->diff($end_date);
					$leftdays = $interval->format('%r%a day(s)');
					$members = $this->Projects_Model->get_members_index($project_id);
					$milestones = $this->Projects_Model->get_all_project_milestones($project_id);
					$appconfig = get_appconfig();
					$data_projects[] = array(
						'id' => $project['id'],
						'project_id' => $project['id'],
						'name' => $project['name'],
						'pinned' => $project['pinned'],
						'value' => $project['projectvalue'],
						'tax' => $project['tax'],
						'template' => $project['template'],
						'status_id' => $project['status'],
						'progress' => $progress,
						'startdate' => date(get_dateFormat(), strtotime($project['start_date'])),
						'leftdays' => $leftdays,
						'customer' => $customer,
						'customeremail' => $project['customeremail'],
						'status_icon' => $icon,
						'status' => $status,
						'status_class' => $projectstatus,
						'customer_id' => $project['customer_id'],
						'members' => $members,
						'milestones' => $milestones,
						lang('filterbystatus') => lang($projectstatus),
						lang('filterbycustomer') => $customer,
						'project_number' => get_number('projects', $project['id'], 'project', 'project'),
					);
				}
			}
		} else {
			$data_projects = array();
		}
		echo json_encode($data_projects);
	}
}
