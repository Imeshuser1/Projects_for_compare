<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends CIUIS_Controller
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
		define('product_type', [lang('physical_item') . ' (' . lang('inv_manage') . ')', lang('service_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('inv_manage') . ')', lang('physical_item') . ' (' . lang('non_inv_manage') . ')', lang('digital_item') . ' (' . lang('non_inv_manage') . ')']);
	}

	function index()
	{
		$data['title'] = lang('products');
		$this->load->view('products/index', $data);
	}

	function create()
	{
		if ($this->Privileges_Model->check_privilege('products', 'create')) {
			if (isset($_POST) && count($_POST) > 0) {
				$this->form_validation->set_rules('name', lang("productname"), 'required|trim|max_length[25]');
				$this->form_validation->set_rules('unit_measure', lang("uom"), 'required|trim|integer');
				$this->form_validation->set_rules('categoryid', lang('productcategory'), 'required|trim|integer');
				$this->form_validation->set_rules('product_type', lang('product') . ' ' . lang('type'), 'required|trim|integer');
				$this->form_validation->set_rules('warehouse', lang('warehouse'), 'required|trim|integer');
				$this->form_validation->set_rules('purchaseprice', lang('purchaseprice'), 'required|numeric');
				$this->form_validation->set_rules('saleprice', lang('salesprice'), 'required|trim|numeric');
				$this->form_validation->set_rules('code', lang('code'), 'required|trim|max_length[25]');
				$this->form_validation->set_rules('stock', lang('stock'), 'trim|integer');
				$this->form_validation->set_rules('description', lang('description'), 'required|trim|max_length[65535]');
				$this->form_validation->set_rules('tax', lang('tax'), 'trim|numeric');
				if ($this->form_validation->run() == false) {
					$data['success'] = false;
					$data['message'] = validation_errors();
					echo json_encode($data);
				} else {
					$appconfig = get_appconfig();
					$params = array(
						'code' => $this->input->post('code'),
						'categoryid' => $this->input->post('categoryid'),
						'productname' => $this->input->post('name'),
						'description' => $this->input->post('description'),
						'purchase_price' => $this->input->post('purchaseprice'),
						'sale_price' => $this->input->post('saleprice'),
						'stock' => $this->input->post('stock'),
						'vat' => $this->input->post('tax'),
						'product_created_by' => $this->session->usr_id,
						'product_type' => $this->input->post('product_type'),
						'unit_id' => $this->input->post('unit_measure'),
						'warehouse_id' => $this->input->post('warehouse'),
					);
					$products_id = $this->Products_Model->add_products($params);
					if ($this->input->post('custom_fields')) {
						$custom_fields = array(
							'custom_fields' => $this->input->post('custom_fields')
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'product', $products_id);
					}
					$data['success'] = true;
					$data['message'] = lang('product') . ' ' . lang('createmessage');
					$data['id'] = $products_id;
					if ($appconfig['product_series']) {
						$product_number = $appconfig['product_series'];
						$product_number = $product_number + 1;
						$this->Settings_Model->increment_series('product_series', $product_number);
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

	function categories()
	{
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$data = $this->Products_Model->get_categories();
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$data = $this->Products_Model->get_categories($this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
		echo json_encode($data);
	}

	function add_category()
	{
		if ($this->Privileges_Model->check_privilege('products', 'create')) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert('productcategories', $params);
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('productcategory') . ' ' . lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_category($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'edit')) {
			$data['category'] = $this->Products_Model->get_category($id);
			if (isset($data['category']['id'])) {
				if (isset($_POST) && count($_POST) > 0) {
					$params = array(
						'name' => $this->input->post('name'),
					);
					$this->Products_Model->update_category($id, $params);
					$data['success'] = true;
					$data['message'] = lang('productcategory') . ' ' . lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_category($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'delete')) {
			$category = $this->Products_Model->get_category($id);
			if (isset($category['id'])) {
				if ($this->Products_Model->check_category($id) == 0) {
					$this->Products_Model->remove_category($id);
					$data['success'] = true;
					$data['message'] = lang('productcategory') . ' ' . lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('category') . ' ' . lang('is_linked') . ' ' . lang('with') . ' ' . lang('product') . ', ' . lang('so') . ' ' . lang('cannot_delete') . ' ' . lang('category');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function get_product_categories()
	{
		$categories = $this->Products_Model->get_product_categories();
		$data_categories = array();
		foreach ($categories as $category) {
			$data_categories[] = array(
				'name' => $category['name'],
				'id' => $category['id'],
			);
		};
		echo json_encode($data_categories);
	}

	function update($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$product = $this->Products_Model->get_product_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$product = $this->Products_Model->get_product_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
		if ($product) {
			if ($this->Privileges_Model->check_privilege('products', 'edit')) {
				if (isset($id)) {
					if (isset($_POST) && count($_POST) > 0) {
						$this->form_validation->set_rules('name', lang('produtname'), 'required|trim|max_length[50]');
						$this->form_validation->set_rules('unit_measure', lang('unit'), 'required|trim|integer');
						$this->form_validation->set_rules('categoryid', lang('productcategory'), 'required|trim|integer');
						$this->form_validation->set_rules('product_type', lang('type'), 'required|trim|integer');
						$this->form_validation->set_rules('warehouse', lang('warehouse'), 'required|trim|integer');
						$this->form_validation->set_rules('purchaseprice', lang('purchaseprice'), 'required|numeric');
						$this->form_validation->set_rules('saleprice', lang('salesprice'), 'required|trim|numeric');
						$this->form_validation->set_rules('code', lang('productcode'), 'required|trim|max_length[25]');
						$this->form_validation->set_rules('stock', lang('instock'), 'trim|integer');
						$this->form_validation->set_rules('description', lang('description'), 'required|trim|max_length[65535]');
						$this->form_validation->set_rules('tax', lang('tax'), 'trim|numeric');

						if ($this->form_validation->run() == false) {
							$data['success'] = false;
							$data['message'] = validation_errors();
							echo json_encode($data);
						} else {
								$appconfig = get_appconfig();
								$params = array(
									'code' => $this->input->post('code'),
									'categoryid' => $this->input->post('categoryid'),
									'productname' => $this->input->post('name'),
									'description' => $this->input->post('description'),
									'purchase_price' => $this->input->post('purchaseprice'),
									'sale_price' => $this->input->post('saleprice'),
									'stock' => $this->input->post('stock'),
									'vat' => $this->input->post('tax'),
									'product_created_by' => $this->session->usr_id,
									'product_type' => $this->input->post('product_type'),
									'unit_id' => $this->input->post('unit_measure'),
									'warehouse_id' => $this->input->post('warehouse'),
								);
								$this->Products_Model->update_products($id, $params);
								// Custom Field Post
								if ($this->input->post('custom_fields')) {
									$custom_fields = array(
										'custom_fields' => $this->input->post('custom_fields')
									);
									$this->Fields_Model->custom_field_data_add_or_update_by_type($custom_fields, 'product', $id);
								}
								$data['success'] = true;
								$data['message'] = lang('product') . ' ' . lang('updatemessage');
								echo json_encode($data);
							}
						}
					
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
	}

	function get_category_id($name)
	{
		$rows = $this->db->get_where('productcategories', array(''))->result_array();
		$found = false;

		foreach ($rows as $row) {
			if ($row['name'] == $name) {
				$category_id = $row['id'];
				$found = true;
				break;
			}
		}

		if (!$found) {
			$this->db->insert('productcategories', [
				'name' => $name,
			]);
			$category_id = $this->db->insert_id();
		}

		return $category_id ? $category_id : '';
	}

	function get_warehouse_id($name)
	{
		$rows = $this->db->get('warehouses')->result_array();
		$found = false;

		foreach ($rows as $row) {
			if ($row['warehouse_name'] == $name) {
				$warehouse_id = $row['warehouse_id'];
				$found = true;
				break;
			}
		}

		if (!$found) {
			$this->db->insert('warehouses', [
				'warehouse_name' => $name,
				'warehouse_number' => null,
				'country' => 0,
				'state' => 0,
				'city' => '',
				'zip' => '',
				'address' => '',
				'phone' => '',
				'created_by' => 0,
			]);
			$warehouse_id = $this->db->insert_id();
		}

		return $warehouse_id ? $warehouse_id : '';
	}

	function productsimport()
	{
		if ($this->Privileges_Model->check_privilege('products', 'create')) {
			$this->load->library('import');
			$data['products'] = $this->Products_Model->get_products_for_import();
			$data['error'] = '';
			$config['upload_path'] = './uploads/imports/';
			$config['allowed_types'] = 'csv';
			$config['max_size'] = '1000';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			// If upload failed, display error
			if (!$this->upload->do_upload('file')) {
				$data['error'] = $this->upload->display_errors();
				$this->session->set_flashdata('ntf4', lang('csvimporterror'));
				//redirect( 'products/index' );
			} else {
				$file_data = $this->upload->data();
				$file_path = './uploads/imports/' . $file_data['file_name'];
				if ($this->import->get_array($file_path)) {
					$appconfig = get_appconfig();
					/*product series increment*/
					$product_number = $appconfig['product_series'];
					$csv_array = $this->import->get_array($file_path);
					$num = 1;
					$csv_errors = array();
					foreach ($csv_array as $row) {
						$category_name = isset($row['category_name']) ? $row['category_name'] :null ;
						$warehouse_name = isset($row['warehouse_name'])? $row['warehouse_name'] :null ;
						$category_id = $category_name ? $this->get_category_id($category_name) : '';
						$warehouse_id = $warehouse_name ? $this->get_warehouse_id($warehouse_name) : '';
						if (($row['productname'] == '') || ($row['description'] == '') || ($row['purchase_price'] == '') || ($row['sale_price'] == '')) {
							$num++;
							$csv_errors[] = array(
								'line' => $num,
							);
							continue;
						} else {
							$insert_data = array(
								'code' => $row['code'],
								'productname' => $row['productname'],
								'description' => $row['description'],
								'purchase_price' => $row['purchase_price'],
								'sale_price' => $row['sale_price'],
								'stock' => $row['stock'],
								'vat' => $row['vat'],
								'status_id' => $row['status_id'],
								'categoryid' => $category_id,
								'warehouse_id' => $warehouse_id,
								'product_type' => $row['product_type'],
							);
							$num++;
							$this->Products_Model->insert_products_csv($insert_data);
							$appconfig = get_appconfig();
							if ($appconfig['product_series']) {
								$product_number = $product_number + 1;
								$this->Settings_Model->increment_series('product_series', $product_number);
							}
						}
					}
					if ($csv_errors) {
						$datas['message'] = lang('file') . ' ' . lang('csvimportsuccess') . ' ' . lang('butErrors');
					} else {
						$datas['message'] = lang('file') . ' ' . lang('csvimportsuccess');
					}
					$datas['success'] = true;
					$datas['errors'] = $csv_errors;
					echo json_encode($datas);
				} else {
					$datas['success'] = false;
					$datas['message'] = lang('errormessage');
					echo json_encode($datas);
				}
			}
		} else {
			$data['success'] = false;
			$datas['message'] = lang('you_dont_have_permission');
			echo json_encode($datas);
		}
	}

	function exportdata()
	{ 
		$export = array();
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$this->db->select('products.id as product_id, products.productname, products.description, products.code, products.purchase_price, products.sale_price, products.stock, products.vat, products.status_id, w.warehouse_name, productcategories.name as category, productcategories.id as category_id, productimage, products.product_type');
			$this->db->join('productcategories', 'products.categoryid = productcategories.id', 'left');
			$this->db->join('warehouses w', 'w.warehouse_id = products.warehouse_id', 'left');
			$q = $this->db->get_where('products', array(''))->result_array();
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$this->db->select('products.id as product_id, products.productname, products.description, products.code, products.purchase_price, products.sale_price, products.stock, products.vat, products.status_id, w.warehouse_name, productcategories.name as category, productcategories.id as category_id, productimage, products.product_type');
			$this->db->join('productcategories', 'products.categoryid = productcategories.id', 'left');
			$this->db->jon('warehouses w', 'w.warehouse_id = products.warehouse_id', 'left');
			$q = $this->db->get_where('products', array('product_created_by' => $this->session->usr_id))->result_array();
		}
		$appconfig = get_appconfig();
		foreach ($q as $data) {
			$export[] = array(
			'product'=> get_number('products', $data['product_id'], 'product', 'product'),
			'code' => $data['code'],
			'productname' => $data['productname'],
			'description' => $data['description'],
			'purchase_price' => $data['purchase_price'],
			'sale_price' => $data['sale_price'],
			'stock' => $data['stock'],
			//added product type.
			'product_type'=>$data['product_type'],
			'vat' => $data['vat'],
			'status_id' => $data['status_id'],
			'category_name' => $data['category'],
			'warehouse_name' => $data['warehouse_name'],
			);
		}
		$filename = lang('products');
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"$filename" . ".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		$report = fopen('php://output', 'w');
		$field = array_keys($export[0]);
		$lang = array();
		foreach ($field as $lg) {
			$lang[] = $lg;
		}
		fputcsv($report,  $lang);
		foreach ($export as $row) {
			fputcsv($report, $row);
		}
		fclose($report);
	}

	function product($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$product = $this->Products_Model->get_product_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$product = $this->Products_Model->get_product_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
		if ($product) {
			$data['title'] = lang('product');
			$data['product'] = $product;
			$this->load->view('products/product', $data);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
	}

	function remove($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$product = $this->Products_Model->get_product_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$product = $this->Products_Model->get_product_by_privileges($id, $this->session->usr_id);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if ($product) {
			if ($this->Privileges_Model->check_privilege('products', 'delete')) {
				if (isset($product['id'])) {
					$this->Products_Model->delete_products($id, get_number('products', $id, 'product', 'product'));
					$this->session->set_flashdata('ntf4', lang('product') . ' ' . lang('deletemessage'));
				} else {
					show_error('The products you are trying to delete does not exist.');
				}
			} else {
				$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			}
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
	}

	function get_product($id)
	{
		$product = array();
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$product = $this->Products_Model->get_product_by_privileges($id);
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$product = $this->Products_Model->get_product_by_privileges($id, $this->session->usr_id);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
		if ($product) {
			$total_product_sales = $this->db->from('items')->where('product_id = ' . $product['id'] . '')->get()->num_rows();
			$this->db->select_sum('total');
			$this->db->from('items');
			$this->db->where('product_id = ' . $product['id'] . '');
			$netearnings = $this->db->get()->row()->total;
			if (!empty($netearnings)) {
				$total = $netearnings;
			} else {
				$total = 0;
			}
			$this->db->select_sum('tax');
			$this->db->from('items');
			$this->db->where('product_id = ' . $product['id'] . '');
			$total_tax_products = $this->db->get()->row()->tax;
			if (!empty($netearnings)) {
				$total_tax = $total_tax_products;
			} else {
				$total_tax = 0;
			}
			$data_product = array(
				'id' => $product['id'],
				'code' => $product['code'],
				'productname' => $product['productname'],
				'description' => $product['description'],
				'productimage' => $product['productimage'],
				'purchase_price' => $product['purchase_price'],
				'sale_price' => $product['sale_price'],
				'stock' =>	(float)$product['stock'],
				'categoryid' => $product['categoryid'],
				'vat' => $product['vat'],
				'status_id' => $product['status_id'],
				'category_name' => $product['name'],
				'total_sales' => $total_product_sales,
				'net_earning' => $total - $total_tax,
				'product_number' => get_number('products', $product['id'], 'product', 'product'),
				'product_type' =>  product_type[$product['product_type']],
				'type' => $product['product_type'],
				'unit_id' => $product['unit_id'],
				'unit_measure' => $product['unit_measure'],
				'warehouse_name' => $product['warehouse_name'],
				'warehouse_id' => $product['warehouse_id'],
			);
			echo json_encode($data_product);
		} else {
			$this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
			redirect(base_url('products'));
		}
	}

	function get_products()
	{
		$products = array();
		if ($this->Privileges_Model->check_privilege('products', 'all')) {
			$products = $this->Products_Model->get_all_products_by_privileges();
		} else if ($this->Privileges_Model->check_privilege('products', 'own')) {
			$products = $this->Products_Model->get_all_products_by_privileges($this->session->usr_id);
		}
		$settings = $this->Settings_Model->get_settings_ciuis();
		$data_products = array();
		$appconfig = get_appconfig();
		foreach ($products as $product) {
			$data_products[] = array(
				'product_id' => $product['id'],
				'code' => $product['code'],
				'name' => $product['productname'],
				'description' => $product['description'],
				'price' => (float)$product['sale_price'],
				'tax' => $product['vat'],
				'purchase_price' => (float)$product['purchase_price'],
				'category_name' => $product['name'],
				'stock' => (float)$product['stock'],
				'product_number' => get_number('products', $product['id'], 'product', 'product'),
				'product_type' => product_type[$product['product_type']],
				'warehouse_name' => $product['warehouse_name'],
			);
		};
		echo json_encode($data_products);
	}

	function add_unit()
	{
		if ($this->Privileges_Model->check_privilege('products', 'create')) {
			if (isset($_POST)) {
				$name = $this->input->post('name');
				
				if (strlen($name) <= '2') {
					$params = array(
						'name' => $name
					);
					if ($this->Products_Model->isDuplicate($this->input->post('name'))) {
						$data['success'] = false;
						$data['message'] = lang('Uom_exist');
						
					}
					else{
					$this->db->insert('unit_of_measure', $params);
					$data['success'] = true;
					$data['message'] = lang('uom');
					}		
				} else {
					$data['success'] = false;
					$data['message'] =  lang('lessthentwochar');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	/*lower case function */
	function edit_unit($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'edit')) {
			$units = $this->Products_Model->get_units($id);

			if (isset($units['unit_id'])) {
				if (isset($_POST) && count($_POST) > 0) {
					$name = $this->input->post('name');
					if (strlen($name) <= '2') {
						$params = array(
							'name' => $name
						);
						$this->Products_Model->update_units($id, $params);
						$data['success'] = true;
						$data['message'] = lang('uom') . ' ' . lang('updatemessage');
					} else {
						
						$data['success'] = false;
						$data['message'] = "Unit of Measure should be less than 2 charcter";
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	/*lower case function*/
	function delete_unit($id)
	{
		if ($this->Privileges_Model->check_privilege('products', 'delete')) {
			$units = $this->Products_Model->get_units($id);
			if (isset($units['unit_id'])) {
				if ($this->Products_Model->check_units($id) == 0) {
					$this->Products_Model->remove_units($id);
					$data['success'] = true;
					$data['message'] = lang('uom') . ' ' . lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('uom') . ' ' . lang('is_linked') . ' ' . lang('with') . ' ' . lang('product') . ', ' . lang('so') . ' ' . lang('cannot_delete') . ' ' . lang('uom');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

}
