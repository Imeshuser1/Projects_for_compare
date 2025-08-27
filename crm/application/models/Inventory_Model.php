<?php

class Inventory_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_warehouses() {
		$this->db->order_by( 'warehouse_id', 'desc' );
		return $this->db->get_where( 'warehouses', array( '' ) )->result_array();
	}

	function get_warehouse( $id ) {
		return $this->db->get_where( 'warehouses', array( 'warehouse_id' => $id ) )->row_array();
	}

	function update_warehouse( $id, $params ) {
		$this->db->where( 'warehouse_id', $id );
		return $this->db->update( 'warehouses', $params );
	}
/*warehouse id missing*/
	function check_warehouse($id) {
		$data = $this->db->get_where( 'products', array( 'warehouse_id' => $id ) )->num_rows();
		return $data;
	}

	function remove_warehouse( $id ) {
		$response = $this->db->delete( 'warehouses', array( 'warehouse_id' => $id ) );
	}

	function get_movement_type() {
		return $this->db->get( 'product_movement' )->result_array();
	}

	function search_products($q) {
		$this->db->select('productcategories.name, productcategories.id as categoryid, products.id as id, products.productname, products.purchase_price, products.stock, products.product_type, products.unit_id, unit_of_measure.name as unit_measure, products.warehouse_id, warehouses.warehouse_name, products.code');
		$this->db->join( 'productcategories', 'productcategories.id = products.categoryid', 'left' );
		$this->db->join( 'unit_of_measure', 'unit_of_measure.unit_id = products.unit_id', 'left' );
		$this->db->join('warehouses', 'warehouses.warehouse_id = products.warehouse_id');		
		$this->db->where('products.product_type = 0 OR products.product_type = 2');
		$this->db->where('(
			productname LIKE "%' . $q . '%"
			OR product_number LIKE "%' . $q . '%"		
		)');		
		$this->db->order_by('products.id', 'desc');		
		return $this->db->get('products')->result_array();		
	}

	function inventory_add( $params ) {
		$this->db->insert( 'product_inv', $params );
		$inventory = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['inventory_series'] ? $appconfig['inventory_series'] : $inventory;
		$inventory_number = $appconfig['inventory_prefix'].$number;
		$this->db->where('inventory_id', $inventory)->update( 'product_inv', array('inventory_number' => $inventory_number ) );
		
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="inventories/inventory/' . $inventory . '">' . $inventory_number . '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		return $inventory_number;
	}

	function updateInventory( $id, $params ) {
		$this->db->where( 'inventory_id', $id );
		$this->db->update( 'product_inv', $params );
	}

	function get_all_inventories() { 
		$this->db->select('inventory_id, inventory_number, productname, product_inv.product_type, name, warehouse_name, stock_qty, cost_price, move_type, staffname, movement_name');
		$this->db->join( 'products', 'product_inv.product_id = products.id', 'left' );
		$this->db->join( 'productcategories', 'product_inv.category_id = productcategories.id', 'left' );
		$this->db->join( 'warehouses', 'product_inv.warehouse = warehouses.warehouse_id', 'left' );
		$this->db->join( 'staff', 'product_inv.inventory_created_by = staff.id', 'left' );
		$this->db->join( 'product_movement', 'product_movement.movement_id = product_inv.move_type', 'left' );
		$this->db->order_by( 'product_inv.inventory_id', 'desc' );
		return $this->db->get_where( 'product_inv', array( '') )->result_array();
	}

	function get_inventory_detail_by_privilegs( $id, $staff_id='' ) {
		$this->db->select('inventory_id, inventory_number, productname, product_inv.product_type, name, warehouse_name, stock_qty, cost_price, move_type, staffname, products.warehouse_id, product_inv.category_id, product_inv.product_id, movement_name');
		$this->db->join( 'products', 'product_inv.product_id = products.id', 'left' );
		$this->db->join( 'productcategories', 'product_inv.category_id = productcategories.id', 'left' );
		$this->db->join( 'warehouses', 'product_inv.warehouse = warehouses.warehouse_id', 'left' );
		$this->db->join( 'product_movement', 'product_movement.movement_id = product_inv.move_type', 'left' );
		$this->db->join( 'staff', 'product_inv.inventory_created_by = staff.id', 'left' );
		if($staff_id) {
			return $this->db->get_where( 'product_inv', array( 'product_inv.inventory_id' => $id, 'product_inv.inventory_created_by' => $this->session->usr_id ) )->row_array();
		} else {
			return $this->db->get_where( 'product_inv', array( 'product_inv.inventory_id' => $id ) )->row_array();
		}
	}

	function delete_inventory($id, $number) {
		$response = $this->db->delete( 'product_inv', array( 'inventory_id' => $id ) );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'inventory' ) .' '. $number . '' ),
			'staff_id' => $this->session->usr_id
		) );
	}

	function increment_stock($product, $warehouse, $stock) {
		$total_stock = $product['stock'] + $stock;
		$this->db->where('id', $product['id'])->update('products', array('stock' => $total_stock, 'warehouse_id' => $warehouse));
	}

	function decrement_stock($product, $warehouse, $stock) {
		$total_stock = $product['stock'] - $stock;
		$this->db->where('id', $product['id'])->update('products', array('stock' => $total_stock, 'warehouse_id' => $warehouse));
	}

	function transfer_stock($product, $warehouse_from, $warehouse_to, $stock) {
		$total_stock = $product['stock'] - $stock;
		$this->db->where('id', $product['id'])->update('products', array('stock' => $total_stock, 'warehouse_id' => $warehouse_from));
		$product_code = $this->input->post('product_code');
		$check = $this->check_product($product_code, $warehouse_to);
		if($check) {
			$total_stock = $check['stock'] + $stock;
			$this->db->where('id', $check['id'])->update('products', array('stock' => $total_stock, 'warehouse_id' => $warehouse_to));
		} else {
			$params = array(
				'code' => $product['code'],
				'productname' => $product['productname'],
				'unit_id' => $product['unit_id'],
				'categoryid' => $product['categoryid'],
				'warehouse_id' => $warehouse_to,
				'product_type' => $product['product_type'],
				'description' => $product['description'],
				'purchase_price' => $product['purchase_price'],
				'sale_price' => $product['sale_price'],
				'stock' => $stock,
				'vat' => $product['vat'],
				'product_created_by' => $this->session->usr_id,	
			);
			$this->Products_Model->add_products($params);
		}
	}

	function check_product($code, $to) {
		$this->db->limit('1');
		return $this->db->get_where('products', array('code' => $code, 'warehouse_id' => $to))->row_array();
	}
	function inventory_categories_names($staff_id = '')
	{

		$this->db->select('productcategories.name as name, COUNT(productcategories.name) as count');
		$this->db->join('product_inv', 'product_inv.category_id = productcategories.id', 'full');
		if ($staff_id) {
			$this->db->where('inventory_created_by', $staff_id);
		}
		$this->db->group_by('productcategories.name');
		$this->db->from('productcategories');
		return $this->db->get()->result_array();
	}

}