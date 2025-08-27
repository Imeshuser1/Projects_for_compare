<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Appointments extends AREA_Controller
{

	function index()
	{
		echo 'Appointments';
	}

	function new_appointment()
	{
		if (isset($_POST) && count($_POST) > 0) {
			$this->form_validation->set_rules('booking_date', lang('booking_date'), 'trim|required|valid_date');
			$this->form_validation->set_rules('start_time', lang('start_time'), 'trim|required');
			$this->form_validation->set_rules('end_time', lang('end_time'), 'trim|required');
			$this->form_validation->set_rules('staff_id', lang('staff'), 'trim|required|integer');
			$data['message'] = '';
			if ($this->form_validation->run() == false) {
				$data['success'] = false;
				$data['message'] = validation_errors();
				echo json_encode($data);
			} else {
				$booked_date_time = '' . $_POST['booking_date'] . ' ' . $_POST['start_time'] . ':00';
				$minutes_to_add = 30;
				$time = new DateTime($booked_date_time);
				$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
				$params = array(
					'booking_date' => $_POST['booking_date'],
					'start_time' => $_POST['start_time'],
					'staff_id' => $_POST['staff_id'],
					'end_time' => $time->format('H:i:s'),
					'contact_id' => $this->session->contact_id,
				);
				$template = $this->Emails_Model->get_template('staff', 'new_appointment');
				if ($template['status'] == 1) {
					$contact = $this->Contacts_Model->get_contacts($this->session->contact_id);
					$customer = $this->Customers_Model->get_customers($contact['customer_id']);
					$staff = $this->Staff_Model->get_staff($_POST['staff_id']);
					$settings = $this->Settings_Model->get_settings_ciuis();
					$message_vars = array(
						'{staff_name}' => $staff['staffname'],
						'{customer_name}' => $customer['company'] ? $customer['company'] : $customer['namesurname'],
						'{contact_name}' => $contact['name'] . ' ' . $contact['surname'],
						'{appointment_date}' => $_POST['booking_date'],
						'{appointment_time}' => $_POST['start_time'],
						'{company_name}' => $settings['company'],
						'{company_email}' => $settings['email'],
						'{site_url}' => site_url(),
						'{logo}' => rebrand['app_logo'],
						'{footer_logo}' => rebrand['nav_logo'],
						'{email_banner}' => rebrand['email_banner'],
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $staff['email'],
						'subject' => $subject,
						'message' => $message,
						'created' => date("Y.m.d H:i:s"),
					);
					if ($param['email']) {
						$this->db->insert('email_queue', $param);
					}
				}
				$appointment = $this->Appointments_Model->new_appointment($params);
				$this->Notifications_Model->add_notification([
					'detail' => '' . $message = sprintf(lang('x_wants_an_appointment'), $this->session->name) . '',
					'perres' => 'n-img.png',
					'staff_id' => $_POST['staff_id'],
					'target' => '' . base_url('calendar') . ''
				]);
				echo lang('appointment_request_sent');
			}
		}
	}
}
