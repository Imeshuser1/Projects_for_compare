<?php
	class Warehouses_Model extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function get_warehouses_by_privileges($staff_id='') {
			$this->db->select('warehouses.*, staff.staffname');
			$this->db->join('staff', 'staff.id = warehouses.created_by');
			$this->db->order_by('warehouse_id', 'desc');
			if($staff_id) {
				return $this->db->get_where( 'warehouses', array( 'staff_id' => $staff_id) )->result_array();
			} else {
				return $this->db->get_where( 'warehouses', array( ) )->result_array();
			}
		}


	function get_categories($staff_id='') {
		$this->db->select('warehouses.warehouse_name as name, COUNT(products.id) as y');
		$this->db->join( 'warehouses', 'products.warehouse_id = warehouses.warehouse_id');
		$this->db->group_by('warehouses.warehouse_name'); 
		return $this->db->get_where( 'products', array( '' ) )->result_array();
	}

		function get_warehouse_by_privileges($id, $staff_id='') {
			$this->db->order_by('warehouse_id', 'desc');
			if($staff_id) {
				return $this->db->get_where( 'warehouses', array( 'warehouse_id' => $id, 'staff_id' => $staff_id) )->row_array();
			} else {
				return $this->db->get_where( 'warehouses', array('warehouse_id' => $id,) )->row_array();
			}
		}

		function create($params) {
			$this->db->insert('warehouses', $params);
			$warehouse = $this->db->insert_id();
			$appconfig = get_appconfig();
			$number = $appconfig['warehouse_series'] ? $appconfig['warehouse_series'] : $warehouse;
			$warehouse_number = $appconfig['warehouse_prefix'].$number;
			$this->db->where('warehouse_id', $warehouse)->update( 'warehouses', array('warehouse_number' => $warehouse_number ) );

		//LOG
			$staffname = $this->session->staffname;
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="warehouses/warehouse/' . $warehouse . '">' . $warehouse_number . '</a>.' ),
				'staff_id' => $loggedinuserid,
			) );
			return $warehouse_number;
		}

		function update($id, $params) {
			$this->db->where('warehouse_id', $id)->update('warehouses', $params);
		}

		function count_product($id) {
			$this->db->join('warehouses wh', 'wh.warehouse_id = pi.warehouse_id');
			$this->db->where('pi.warehouse_id', $id);
			return $this->db->get('products pi')->num_rows();
		}
	}
?>