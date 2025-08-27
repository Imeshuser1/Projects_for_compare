<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Inventories extends CIUIS_Controller
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
		//define('product_type', [lang('physical_item') . ' (' . lang('inv_manage') . ')', lang('service_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('inv_manage') . ')', lang('physical_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('non_inv_manage') . ')']);
		define('product_type', [lang('physical_item') . ' (' . lang('inv_manage') . ')', lang('service_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('inv_manage') . ')', lang('physical_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('non_inv_manage') . ')']);
	}

	function index()
	{
		$data['title'] = lang('inventory');
		$this->load->view('inventories/index', $data);
	}

	function get_movement_type()
	{
		$movements = $this->Inventory_Model->get_movement_type();
		foreach ($movements as $move) {
			$data[] = array(
				'movement_id' =>  $move['movement_id'],
				'movement_name' => lang($move['movement_name']),
			);
		}
		echo json_encode($data);
	}
	/*function to lower case*/
	function create_inventory()
	{
		$data['title'] = lang('new') . ' ' . lang('inventory');
		if ($this->Privileges_Model->check_privilege('inventories', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('product_id', lang('product'), 'trim|required|max_length[255]');
				$this->form_validation->set_rules('stock', lang('stock'), 'trim|required|integer');
				$this->form_validation->set_rules('move_type', lang('move_type'), 'trim|required|integer');
				$move_type = $this->input->post('move_type');
				if ($move_type == 3) {
					$this->form_validation->set_rules('warehouse_to', lang('warehouse_to'), 'trim|required|integer');
				}
				$data['message'] = '';
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {

					$product = $this->input->post('product_id');
					$products = $this->Products_Model->get_product_by_id($product);
					$stock = $this->input->post('stock');
					$warehouse = $this->input->post('warehouse');
					$warehouse_to = $this->input->post('warehouse_to');
					$move_type = $this->input->post('move_type');
					$datas['success'] = false;
					if ($products['stock'] < $stock && ($move_type == 2 || $move_type == 3)) {
						$datas['message'] = "Stock should not be greater than total stock";
					} else {
						if ($move_type == 2) {
							$this->Inventory_Model->decrement_stock($products, $warehouse, $stock);
						} else if ($move_type == 3) {
							$this->Inventory_Model->transfer_stock($products, $warehouse, $warehouse_to, $stock);
						}
						$appconfig = get_appconfig();
						$params = array(
							'product_id' => $product,
							'product_type' => $this->input->post('product_type'),
							'category_id' => $this->input->post('category_id'),
							'cost_price' => $this->input->post('cost_price'),
							'stock_qty' => $stock,
							'warehouse' => $warehouse,
							'move_type' => $move_type,
							'inventory_created_by' => $this->session->usr_id,
							'createdat' => date('Y-m-d H:i:s'),
							// 'client_id' => $this->session->client_id,
							// 'warehouse_to' => $warehouse_to

						);
						$inventory_id = $this->Inventory_Model->inventory_add($params);
						if ($move_type == 1) {
							$this->Inventory_Model->increment_stock($products, $warehouse, $stock);
						}
						$datas['success'] = true;
						$datas['id'] = $inventory_id;
						if ($appconfig['inventory_series']) {
							$inventory_number = $appconfig['inventory_series'];
							$inventory_number = $inventory_number + 1;
							$this->Settings_Model->increment_series('inventory_series', $inventory_number);
						}
						$datas['message'] = lang('inventory') . ' ' . lang('createmessage');
					}
					echo json_encode($datas);
				}
			} else {
				$this->load->view('inventories', $data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('inventories'));
		}
	}
	/*function to lower case*/
	function update_inventory($id)
	{
		$data['title'] = lang('update') . ' ' . lang('inventory');
		if ($this->Privileges_Model->check_privilege('inventories', 'all')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('inventories', 'own')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		if ($inventory) {
			if ($this->Privileges_Model->check_privilege('inventories', 'edit')) {
				if (isset($_POST) && count($_POST) > 0) {
					$this->form_validation->set_rules('product_id', lang('product'), 'trim|required|max_length[255]');
					$this->form_validation->set_rules('stock', lang('stock'), 'trim|required|integer');
					$this->form_validation->set_rules('move_type', lang('move_type'), 'trim|required|integer');
					$this->form_validation->set_rules('warehouse', lang('warehouse'), 'trim|required|integer');
					$move_type = $this->input->post('move_type');
					if ($move_type == 3) {
						$this->form_validation->set_rules('warehouse_to', lang('warehouse_to'), 'trim|required|integer');
					}
					$data['message'] = '';
					if ($this->form_validation->run() == false) {
						$data['success'] = false;
						$data['message'] = validation_errors();
					} else {
						$product = $this->input->post('product_id');
						$products = $this->Products_Model->get_product_by_id($product);
						$stock = $this->input->post('stock');
						$warehouse = $this->input->post('warehouse');
						$move_type = $this->input->post('move_type');
						$warehouse_to = $this->input->post('warehouse_to');
						if ($products['stock'] < $stock && ($move_type == 2 || $move_type == 3)) {
							$data['message'] = "Stock should not be greater than total stock";
						} else {
							if ($move_type == 2) {
								$this->Inventory_Model->decrement_stock($products, $warehouse, $stock);
							} else if ($move_type == 3) {
								$this->Inventory_Model->transfer_stock($products, $warehouse, $warehouse_to, $stock);
							}
							$params = array(
								'product_id' => $this->input->post('product_id'),
								'product_type' => $this->input->post('product_type'),
								'category_id' => $this->input->post('category_id'),
								'cost_price' => $this->input->post('cost_price'),
								'stock_qty' => $stock,
								'warehouse' => $warehouse,
								'move_type' => $move_type,
								//	'warehouse_to' => $warehouse_to
							);
							$this->Inventory_Model->updateInventory($id, $params);
							if ($move_type == 1) {
								$this->Inventory_Model->increment_stock($products, $warehouse, $stock);
							}
							$loggedinuserid = $this->session->usr_id;
							$staffname = $this->session->staffname;
							$this->db->insert('logs', array(
								'date' => date('Y-m-d H:i:s'),
								'detail' => ('<a href="' . base_url() . 'staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang('updated') . ' <a href="' . base_url() . 'inventories/inventory/' . $id . '">' . $inventory['inventory_number'] . '</a>.'),
								'staff_id' => $loggedinuserid,
							));
							$data['id'] = $id;
							$data['success'] = true;
							$data['message'] = lang('inventory') . ' ' . lang('updatemessage');
						}
					}
				} else {
					$data['inventory'] = $inventory;
					$this->load->view('inventories/inventory', $data);
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
		}
		echo json_encode($data);
	}

	function get_inventories()
	{
		$inventories = $this->Inventory_Model->get_all_inventories();
		$data_inventories = array();
		foreach ($inventories as $inventory) {
			$data_inventories[] = array(
				'inventory_id' => $inventory['inventory_id'],
				'inventory_number' => $inventory['inventory_number'],
				'product_name' => $inventory['productname'],
				'product_type' => isset(product_type[$inventory['product_type']]) ? product_type[$inventory['product_type']] : product_type[0],
				'product_type_value' => ($inventory['product_type'] == '0' ? lang('physical_item') : lang('digital_item')),
				'category' => $inventory['name'],
				'cost_price' => $inventory['cost_price'],
				'stock_qty' => $inventory['stock_qty'],
				'warehouse' => $inventory['warehouse_name'],
				'move_type' => lang($inventory['movement_name']),
				'staffname' => $inventory['staffname'],
			);
		};
		echo json_encode($data_inventories);
	}

	function inventory($id)
	{
		if ($this->Privileges_Model->check_privilege('inventories', 'all')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('inventories', 'own')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('inventories'));
		}
		if ($inventory) {
			$data['title'] = $inventory['inventory_number'];
			$data['inventory'] = $inventory;
			$this->load->view('inventories/inventory', $data);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('inventories'));
		}
	}

	function get_inventory($id)
	{
		if ($this->Privileges_Model->check_privilege('inventories', 'all')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('inventories', 'own')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('inventories'));
		}
		$data_inventories = array();
		if ($inventory) {
			$data_inventories = array(
				'inventory_id' => $inventory['inventory_id'],
				'product_id' => $inventory['product_id'],
				'inventory_number' => $inventory['inventory_number'],
				'product_name' => $inventory['productname'],
				'product_type' => product_type[$inventory['product_type']],
				'product_type_id' => $inventory['product_type'],
				'category' => $inventory['name'],
				'category_id' => $inventory['category_id'],
				'cost_price' => $inventory['cost_price'],
				'stock_qty' => $inventory['stock_qty'],
				'warehouse' => $inventory['warehouse_name'],
				'warehouse_id' => $inventory['warehouse_id'],
				'move_type' => lang($inventory['movement_name']),
				'move_type_id' => $inventory['move_type'],
				'staffname' => $inventory['staffname'],
			);
		}
		echo json_encode($data_inventories);
	}

	function remove_inventory($id)
	{
		if ($this->Privileges_Model->check_privilege('inventories', 'all')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id);
		} else if ($this->Privileges_Model->check_privilege('inventories', 'own')) {
			$inventory = $this->Inventory_Model->get_inventory_detail_by_privilegs($id, $this->session->usr_id);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($inventory) {
			if ($this->Privileges_Model->check_privilege('inventories', 'delete')) {
				$this->Inventory_Model->delete_inventory($id, $inventory['inventory_number']);
				$data['success'] = true;
				$data['message'] = lang('inventory') . ' ' . lang('deletemessage');
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
		}
		echo json_encode($data);
	}

	
	function inventory_by_product_category()
	{
		if ($this->Privileges_Model->check_privilege('inventories', 'all')) {
			$data = $this->Inventory_Model->inventory_categories_names();
		} else if ($this->Privileges_Model->check_privilege('inventories', 'own')) {
			$data = $this->Inventory_Model->inventory_categories_names($this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang("You don't have permissions"));
			redirect(base_url('inventories'));
		}
		echo json_encode($data);
	}
}
