<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Calendar extends CIUIS_Controller {
	function index() {
		$data[ 'title' ] = 'Calendar';
		$data[ 'logs' ] = $this->Logs_Model->get_all_logs();
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'events' ] = $this->Events_Model->get_all_events();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'calendar/index', $data );
	}

	function get_Events() {
		$data = $this->Events_Model->get_events_json();
		echo json_encode( $data );

	}

	function addevent() { 
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$this->form_validation->set_rules('title', lang('event'). ' ' .lang('title'), 'trim|required|max_length[200]');
			$this->form_validation->set_rules('eventType', lang('event').' '.lang('type'), 'trim|required|integer');
			$this->form_validation->set_rules('eventstart', lang('start'). ' ' .lang('time'), 'trim|required|valid_date_time');
			$this->form_validation->set_rules('eventend', lang('end'). ' ' .lang('time'), 'trim|required|valid_date_time');
			$this->form_validation->set_rules('detail', lang('event'). ' ' .lang('detail'), 'trim|required|max_length[255]');
			$this->form_validation->set_rules('staff_id', lang('staff'), 'trim|required|integer');
			$this->form_validation->set_rules('notification', lang('notification'), 'trim|integer|in_list[0,1]');
			if ($this->input->post('notification') == '1') {
				$this->form_validation->set_rules('notification_duration', lang('period'), 'trim|required|integer');
				$this->form_validation->set_rules('notification_type', lang('Notification', 'Type'), 'trim|max_length[100]');
				$this->form_validation->set_rules('notification_time', lang('Notification', 'Time'), 'trim|integer');
			}
			$data['message'] = '';
			if ($this->form_validation->run() == false) {
				$data['success'] = false;
				$data['message'] = validation_errors();
				echo json_encode($data);
			} else {
				$data['message'] = '';
				$event_type = $this->Events_Model->get_eventtype($this->input->post('eventType'));
				$params = array(
				
					'title' => $this->input->post('title'),
					'public' => $event_type['public'],
					'detail' => $this->input->post('detail'),
					'start' => date_by_timezone($this->input->post('eventstart')),
					'end' => date_by_timezone($this->input->post('eventend')),
					'color' => $event_type[ 'color' ],
					'is_all' => $_POST['email_to_all'],
					'event_type' => $_POST[ 'eventType' ],
					'is_all' => $this->input->post('email_to_all'),
					'event_type' => $this->input->post('eventType'),
					'reminder' => $this->input->post('notification'),
					'staff_id' => $this->input->post('staff_id'),
					'added_by' => $this->session->userdata('usr_id'),
					'staffname' => $this->session->userdata('staffname'),
					'created' => timestamp(),
				);
				$todos = $this->Events_Model->add_event( $params );
				if ($this->input->post('notification') == '1') {
					$param = array(
						'relation' => $todos,
						'relation_type' => 'event',
						'type' => $_POST['notification_type'],
						'duration_type' => $_POST[ 'notification_time' ],
						'duration_period' => $_POST[ 'notification_duration' ],
						'start' => $_POST[ 'eventstart' ],
						'end' => $_POST[ 'eventend' ],
					);
					$this->db->insert('event_triggers', $param);
				}
				if ($todos) {
					$data['success'] = true;
					$data['message'] = lang('event').' '.lang('createmessage');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = lang('errormessage');
					echo json_encode($data);
				}
			}
		}
	}

	function new_appointment() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'title' => $_POST[ 'title' ],
				'public' => $_POST[ 'public' ],
				'detail' => $_POST[ 'detail' ],
				'start' => $_POST[ 'eventstart' ],
				'end' => $_POST[ 'eventend' ],
				'staff_id' => $this->session->userdata( 'usr_id' ),
				'staffname' => $this->session->userdata( 'staffname' ),
			);
			$todos = $this->Events_Model->new_appointment( $params );
		}
	}

	function confirm_appointment( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'appointments', array( 'status' => 1 ) );
		}
	}

	function decline_appointment( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'appointments', array( 'status' => 2 ) );
		}
	}

	function mark_as_done_appointment( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'appointments', array( 'status' => 3 ) );
		}
	}

	function remove_appointment( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->delete( 'appointments', array( 'id' => $id ) );
		}
	}

	function remove( $id ) {
		$events = $this->Events_Model->remove( $id );
		if ( isset( $events[ 'id' ] ) ) {
			$this->Events_Model->remove( $id );

		}
		$this->session->set_flashdata( 'ntf1', lang( 'eventdeleted' ) );
		redirect( 'calendar/index' );
	}

	function save_colors() {
		if(isset($_POST) && count($_POST) > 0) {
			$staff = $this->db->get_where('staff',array('id' => $this->session->usr_id))->row_array();
			if($staff['admin']) {
					$params = array(
						'appointment_color' => $this->input->post('appointment_color'),
						'project_color' => $this->input->post('project_color'),
						'task_color' => $this->input->post('task_color'),
					);
					$this->Settings_Model->update_colors($params);
					$data['success'] = true;
					$data['message'] = lang('color').' '.lang('updatemessage');
					echo json_encode( $data );
				} else {
					$data['success'] = false;
					$data['message'] = lang('errormessage');
					echo json_encode( $data );
				}
		} else {
			$data['success'] = false;
			$data['message'] = lang('errormessage');
			echo json_encode( $data );
		}
	}
}