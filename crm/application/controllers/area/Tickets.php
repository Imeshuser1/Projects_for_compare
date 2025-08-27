<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Tickets extends AREA_Controller {


	function index() {
		$data[ 'title' ] = lang( 'areatitletickets' );
		$data[ 'ttc' ] = $this->Area_Model->ttc();
		$data[ 'otc' ] = $this->Area_Model->otc();
		$data[ 'ipc' ] = $this->Area_Model->ipc();
		$data[ 'atc' ] = $this->Area_Model->atc();
		$data[ 'ctc' ] = $this->Area_Model->ctc();
		$data[ 'ysy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'otc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'bsy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ipc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'twy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'atc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'iey' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ctc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'tickets' ] = $this->db->select( '*,customers.type as type,customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid, tickets.id as id ' )->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' )->join( 'customers', 'contacts.customer_id = customers.id', 'left' )->join( 'departments', 'tickets.department_id = departments.id', 'left' )->join( 'staff', 'tickets.staff_id = staff.id', 'left' )->get_where( 'tickets', array( 'contact_id' => $this->session->contact_id ) )->result_array();
		$data[ 'departments' ] = $this->db->get_where( 'departments', array( '' ) )->result_array();
		//Detaylar 
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/inc/header', $data );
		$this->load->view( 'area/tickets/index', $data );
		$this->load->view( 'area/inc/footer', $data );

	}

	function create_ticket() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$this->form_validation->set_rules('subject', lang('subject'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('department', lang('department'), 'trim|required|integer');
			$this->form_validation->set_rules('priority', lang('priority'), 'trim|required|integer');
			$this->form_validation->set_rules('message', lang('message'), 'trim|required|max_length[65535]');
			$data['message'] = '';
			if ($this->form_validation->run() == false) {
				$data['success'] = false;
				$data['message'] = validation_errors();
				echo json_encode($data);
			}else {
					if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
						$config['upload_path'] = './uploads/attachments/';
						$config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
						$config['max_size'] = '9000';
						$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
						$config['file'] = $new_name;
						$this->load->library('upload', $config);
						$this->upload->do_upload('file');
						$data_upload_files = $this->upload->data();
						$image_data = $this->upload->data();
						$filename = $image_data['file_name'];
					} else {
						$filename = NULL;
					}
					$params = array(
							'contact_id' => $this->session->contact_id,
							'customer_id' => $this->session->customer,
							'email' => $this->session->email,
							'department_id' => $this->input->post( 'department' ),
							'priority' => $this->input->post( 'priority' ),
							'status_id' => 1,
							'subject' => $this->input->post( 'subject' ),
							'message' => $this->input->post( 'message' ),
							'attachment' => $image_data[ 'file_name' ],
							'date' => date( " Y.m.d H:i:s " ),
						);
			$this->session->set_flashdata( 'ntf1', 'Ticket added' );
			$tickets_id = $this->Area_Model->add_tickets( $params );

			$template = $this->Emails_Model->get_template('ticket', 'new_customer_ticket');
			if ($template['status'] == 1) {
				$ticket = $this->Tickets_Model->get_tickets( $tickets_id );
				$admins = $this->Staff_Model->get_all_admins(); 
				switch ( $this->input->post( 'priority' ) ) {
					case '1':
						$priority = lang( 'low' );
						break;
					case '2':
						$priority = lang( 'medium' );
						break;
					case '3':
						$priority = lang( 'high' );
						break;
				};

				$message_vars = array(
					'{customer_id}' => $this->session->customer,
					'{customer}' => $this->session->name,
					'{name}' => $this->session->name,
					'{email_signature}' => $this->session->email,
					'{ticket_subject}' => $this->input->post( 'subject' ),
					'{ticket_message}' => $this->input->post( 'message' ),
					'{ticket_department}' => $ticket['department'],
					'{ticket_priority}' => $priority,
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
					'email' => $admins['email'],
					'subject' => $subject,
					'message' => $message,
					'created' => date( "Y.m.d H:i:s" )
				);
				if ($param['email']) {
					$this->db->insert( 'email_queue', $param );
				}
			}
			$template = $this->Emails_Model->get_template('ticket', 'ticket_autoresponse');
			if ($template['status'] == 1) {
				$ticket = $this->Tickets_Model->get_tickets( $tickets_id );
				switch ( $this->input->post( 'priority' ) ) {
					case '1':
						$priority = lang( 'low' );
						break;
					case '2':
						$priority = lang( 'medium' );
						break;
					case '3':
						$priority = lang( 'high' );
						break;
				};

				$message_vars = array(
					'{customer_id}' => $this->session->customer,
					'{customer}' => $this->session->name,
					'{name}' => $this->session->name,
					'{email_signature}' => $this->session->email,
					'{ticket_subject}' => $this->input->post( 'subject' ),
					'{ticket_message}' => $this->input->post( 'message' ),
					'{ticket_department}' => $ticket['department'],
					'{ticket_priority}' => $priority,
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
					'email' => $this->session->email,
					'subject' => $subject,
					'message' => $message,
					'created' => date( "Y.m.d H:i:s" )
				);
				if ($this->session->email) {
					$this->db->insert( 'email_queue', $param );
				}
			}
			$appconfig = get_appconfig();
			if($appconfig['ticket_series']){
				$ticket_number = $appconfig['ticket_series'];
				$ticket_number = $ticket_number + 1 ;
				$this->Settings_Model->increment_series('ticket_series',$ticket_number);
			}
			redirect( 'area/tickets' );
		}
	}
}

	function ticket( $id ) {
		$permission = $this->Tickets_Model->check_tickets_permission($id, $this->session->contact_id);
		if ($permission) {
			$data[ 'title' ] = lang( 'areatitletickets' );
			$data[ 'ticketstatustitle' ] = lang('alltickets');
			$data[ 'ttc' ] = $this->Area_Model->ttc();
			$data[ 'otc' ] = $this->Area_Model->otc();
			$data[ 'ipc' ] = $this->Area_Model->ipc(); 
			$data[ 'atc' ] = $this->Area_Model->atc();
			$data[ 'ctc' ] = $this->Area_Model->ctc();
			$data[ 'ysy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'otc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
			$data[ 'bsy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ipc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
			$data[ 'twy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'atc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
			$data[ 'iey' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ctc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
			$data[ 'ticket' ] = $this->Tickets_Model->get_tickets( $id );
			$data[ 'dtickets' ] = $this->db->select( '*,customers.type as type,customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid, tickets.id as id ' )->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' )->join( 'customers', 'contacts.customer_id = customers.id', 'left' )->join( 'departments', 'tickets.department_id = departments.id', 'left' )->join( 'staff', 'tickets.staff_id = staff.id', 'left' )->get_where( 'tickets', array( 'contact_id' => $this->session->contact_id ) )->result_array();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view( 'area/inc/header', $data );
			$this->load->view( 'area/tickets/ticket', $data );
			$this->load->view( 'area/inc/footer', $data );
		} else {
			redirect( 'area/tickets' );
		}
	}

	function reply( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			// $hasError = false;
			// $data['message'] = '';
			// if ($this->input->post( 'message' ) == '') {
			// 	$hasError = true;
			// 	$data['message'] = lang('invalidmessage'). ' ' .lang('message');
			// }
			// if ($hasError) {
			// 	$data['success'] = false;
			// 	echo json_encode($data);
			// }
			// if (!$hasError) {
			$this->form_validation->set_rules('message', lang('message'), 'trim|required|max_length[65535]');
			$data['message'] = '';
			if ($this->form_validation->run() == false) {
				$data['success'] = false;
				$data['message'] = validation_errors();
				echo json_encode($data);
			} else {
				$ticket = $this->Tickets_Model->get_tickets( $id );
				if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
					$config[ 'upload_path' ] = './uploads/attachments/';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
					$config['file'] = $new_name;
					$this->load->library( 'upload', $config );
					$this->upload->do_upload('file');
					$data_upload_files = $this->upload->data();
					$image_data = $this->upload->data();
					$filename = $image_data['file_name'];
				} else {
					$filename = NULL;
				}
				$params = array(
					'ticket_id' => $id,
					'staff_id' => $ticket[ 'staff_id' ],
					'contact_id' => $this->session->contact_id,
					'date' => date( " Y.m.d H:i:s " ),
					'name' => $this->session->name,
					'message' => $this->input->post( 'message' ),
					'attachment' => $filename,
				);
				$contact = $this->session->name;
				$contactavatar = 'n-img.png';
				$this->Notifications_Model->add_notification([
					'detail' => ( '' . $contact . ' '. lang( 'replied' ).' ' . lang( 'ticket' ) . '-' . $id . '' ),
					'perres' => $contactavatar,
					'staff_id' => $ticket[ 'staff_id' ],
					'target' => '' . base_url( 'tickets/ticket/' . $id . '' ) . ''
				]);
				$response = $this->db->where( 'id', $id )->update( 'tickets', array(
					'status_id' => 1,
					'lastreply' => date( "Y.m.d H:i:s " ),
				) );

				$template = $this->Emails_Model->get_template('ticket', 'ticket_reply_to_staff');
				if ($template['status'] == 1) {
					if ( $ticket[ 'type' ] == 0 ) {
						$customer = $ticket[ 'company' ];
					} else {
						$customer = $ticket[ 'namesurname' ];
					} 

					switch ( $ticket[ 'priority' ] ) {
						case '1':
							$priority = lang( 'low' );
							break;
						case '2':
							$priority = lang( 'medium' );
							break;
						case '3':
							$priority = lang( 'high' );
							break;
					};

					if ($ticket['staffemail']) {
						$email = $ticket['staffemail'];
					} else {
						$admins = $this->Staff_Model->get_all_admins();
						$email = $admins['email'];
					}

					$message_vars = array(
						'{customer}' => $customer,
						'{name}' => $this->session->name,
						'{email_signature}' => $this->session->email,
						'{ticket_subject}' => $ticket['subject'],
						'{ticket_message}' => $this->input->post( 'message' ),
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
						'email' => $email,
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" )
					);
					if ($email) {
						$this->db->insert( 'email_queue', $param );
					}
				}
				$replyid = $this->Tickets_Model->add_reply_contact( $params );
				$data['success'] = true;
				$data['message'] = lang('ticket').' '.lang('replied');
				echo json_encode($data);
			}
		}
	}

	function attachments($file) {
		if (is_file('./uploads/attachments/' . $file)) {
    		$this->load->helper('file');
    		$this->load->helper('download');
    		$data = file_get_contents('./uploads/attachments/' . $file);
    		force_download($file, $data);
    	} else {
    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
    		redirect('tickets/index');
    	}
	}
}
