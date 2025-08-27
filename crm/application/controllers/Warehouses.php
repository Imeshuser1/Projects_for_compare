<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Warehouses extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'warehouses' );  
		$this->load->view( 'warehouses/index', $data );
	}


	function categories()
	{
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$data = $this->Warehouses_Model->get_categories();
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$data = $this->Warehouses_Model->get_categories($this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
		$data[intval(count($data))]['message'] = lang("product")."<br>".lang("warehouse");
		echo json_encode($data);
	}

	function get_warehouses() {
		$data_warehouse = array();
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$warehouses = $this->Warehouses_Model->get_warehouses_by_privileges( );
		} else if ($this->Privileges_Model->check_privilege( 'warehouses', 'own') ) {
			$warehouses = $this->Warehouses_Model->get_warehouses_by_privileges( $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
		if($warehouses) {
			foreach ($warehouses as $warehouse) {
				$data_warehouse[] = array(
					'warehouse_id' => $warehouse['warehouse_id'],
					'warehouse_name' => $warehouse['warehouse_name'],
					'warehouse_number' => $warehouse['warehouse_number'],
					'state' => get_state_name('', $warehouse['state']),
					'city' => $warehouse['city'],
					'address' => $warehouse['address'],
					'phone' => $warehouse['phone'],
					'staffname' => $warehouse['staffname'],
					'total_product' => $this->Warehouses_Model->count_product($warehouse['warehouse_id'])
				);
			};
		}
		echo json_encode($data_warehouse);
	}

	function get_warehouse($id) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$warehouse = $this->Warehouses_Model->get_warehouse_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege( 'warehouses', 'own') ) {
			$warehouse = $this->Warehouses_Model->get_warehouse_by_privileges($id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
		if($warehouse) {
			$data_warehouse = array(
				'warehouse_id' => $warehouse['warehouse_id'],
				'warehouse_name' => $warehouse['warehouse_name'],
				'warehouse_number' => $warehouse['warehouse_number'],
				'state_name' => get_state_name('', $warehouse['state']),
				'country_name' => get_country($warehouse['country']),
				'country' => $warehouse['country'] ,
				'state' => $warehouse['state'],
				'city' => $warehouse['city'],
				'zip' => $warehouse['zip'],
				'address' => $warehouse['address'],
				'phone' => $warehouse['phone'],
				'total_product' => $this->Warehouses_Model->count_product($warehouse['warehouse_id'])
			);
			echo json_encode($data_warehouse);
		}
	}

	function add_warehouse() {
		$data[ 'title' ] = lang( 'new' ).' '.lang('warehouse');
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$hasError = false;
				$this->form_validation->set_rules('name', lang('invalidmessage'). ' ' .lang('warehouse'), 'required|trim|max_length[50]');
				$this->form_validation->set_rules('phone', lang('invalidmessage'). ' ' .lang('phone'), 'required|trim|max_length[20]');
				$this->form_validation->set_rules('country', lang('selectinvalidmessage'). ' ' .lang('country'), 'required|trim');
				$this->form_validation->set_rules('state', lang('selectinvalidmessage'). ' ' .lang('state'), 'required|trim');
				$this->form_validation->set_rules('city', lang('city'). ' ' .lang('city'), 'required|trim|max_length[50]');
				$this->form_validation->set_rules('zipcode', lang('invalidmessage'). ' ' .lang('zip'), 'required|trim|max_length[20]');
				$this->form_validation->set_rules('address', lang('invalidmessage'). ' ' .lang('address'), 'required|trim|max_length[255]');
				if($this->form_validation->run() == false) {
					$hasError = true;
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				}
				if(!$hasError) {
					$params = array(
						'warehouse_name' => $this->input->post('name'),
						'country' => $this->input->post('country'),
						'state' => $this->input->post('state'),
						'city' => $this->input->post('city'),
						'zip' => $this->input->post('zipcode'),
						'address' => $this->input->post('address'),
						'phone' => $this->input->post('phone'),
						'created_by' => $this->session->usr_id
					);
					$id = $this->Warehouses_Model->create($params);
					if($id) {
						$appconfig = get_appconfig();
						if($appconfig['warehouse_series']){
							$warehouse_number = $appconfig['warehouse_series'];
							$warehouse_number = $warehouse_number + 1 ;
							$this->Settings_Model->increment_series('warehouse_series',$warehouse_number);
						}
					}
					$data['success'] = true;
					$data['message'] = lang('warehouse').' '.lang('createmessage');
					echo json_encode($data);
				}
			} else {
				$this->load->view( 'warehouses', $data );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
	}

	function warehouse($id) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$warehouse = $this->Warehouses_Model->get_warehouse_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege( 'warehouses', 'own') ) {
			$warehouse = $this->Warehouses_Model->get_warehouse_by_privileges($id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
		if($warehouse) {
			$data[ 'title' ] = $warehouse['warehouse_number'];
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				if ( $this->Privileges_Model->check_privilege( 'warehouses', 'edit' ) ) {
					$hasError = false;
					$this->form_validation->set_rules('name', lang('invalidmessage'). ' ' .lang('warehouse'), 'required|trim|max_length[50]');
					$this->form_validation->set_rules('phone', lang('invalidmessage'). ' ' .lang('phone'), 'required|trim|max_length[20]');
					$this->form_validation->set_rules('country', lang('selectinvalidmessage'). ' ' .lang('country'), 'required|trim');
					$this->form_validation->set_rules('state', lang('selectinvalidmessage'). ' ' .lang('state'), 'required|trim');
					$this->form_validation->set_rules('city', lang('city'). ' ' .lang('city'), 'required|trim|max_length[50]');
					$this->form_validation->set_rules('zipcode', lang('invalidmessage'). ' ' .lang('zip'), 'required|trim|max_length[20]');
					$this->form_validation->set_rules('address', lang('invalidmessage'). ' ' .lang('address'), 'required|trim|max_length[255]');
					if($this->form_validation->run() == false) {
						$hasError = true;
						$data['success'] = false;
						$data['message'] = validation_errors();
						echo json_encode($data);
					}
					if(!$hasError) {
						$params = array(
							'warehouse_name' => $this->input->post('name'),
							'country' => $this->input->post('country'),
							'state' => $this->input->post('state'),
							'city' => $this->input->post('city'),
							'zip' => $this->input->post('zipcode'),
							'address' => $this->input->post('address'),
							'phone' => $this->input->post('phone'),
							'created_by' => $this->session->usr_id
						);
						$id = $this->Warehouses_Model->update($id, $params);
						$data['success'] = true;
						$data['message'] = lang('warehouse').' '.lang('updatemessage');
						echo json_encode($data);
					}
				} else {
					$data['success'] = false;
					$data['message'] = lang( 'you_dont_have_permission' );
					echo json_encode($data);
				}
			} else {
				$data[ 'warehouse' ] = $warehouse;
				$this->load->view( 'warehouses/warehouse' , $data );
			}
		}
	}

	function remove_warehouse( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'delete' ) ) {
			$warehouse = $this->Inventory_Model->get_warehouse( $id );
			if ( isset( $warehouse[ 'warehouse_id' ] ) ) { 
				if ($this->Inventory_Model->check_warehouse($id) == 0) {
					$this->Inventory_Model->remove_warehouse( $id );
					$data['success'] = true;
					$data['message'] = lang('warehouse'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('warehouse').' '.lang('is_linked').' '.lang('with').' '.lang('inventory').', '.lang('so').' '.lang('cannot_delete').' '.lang('warehouse');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
}