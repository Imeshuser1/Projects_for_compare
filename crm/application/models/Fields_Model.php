<?php

class Fields_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function create_new_field( $params ) {
		$this->db->insert( 'custom_fields', $params );
		return $this->db->insert_id();
	}

	function update_custom_field( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'custom_fields', $params );
	}

	function custom_fields() {
		$this->db->order_by( 'order', 'asc' );
		return $this->db->get( 'custom_fields' )->result_array();
	}

	function custom_field_data_by_id( $id ) {
		return $this->db->get_where( 'custom_fields', array( 'id' => $id ) )->row_array();
	}

	function custom_fields_by_type( $type ) {
		$this->db->select( '*' );
		$this->db->order_by( 'order', 'asc' );
		return $this->db->get_where( 'custom_fields', array( 'custom_fields.relation' => $type ) )->result_array();
	}

	function custom_fields_data_by_type( $type, $id, $field_id ) {
		return $this->db->get_where( 'custom_fields_data', array( 'relation_type' => $type, 'relation' => $id, 'field_id' => $field_id, ) )->row_array();
	}

	function custom_field_data_add_or_update_by_type( $fields, $type, $id ) {
		$response = $this->db->delete( 'custom_fields_data', array( 'relation_type' => $type, 'relation' => $id ) );
		if ( $fields ) {
			$i = 0;
			foreach ( $fields[ 'custom_fields' ] as $field ) {
				$this->db->insert( 'custom_fields_data', array(
					'field_id' => $field[ 'id' ],
					'relation_type' => $type,
					'relation' => $id,
					'data' => $field[ 'data' ],
				) );
				$i++;
			};
		}
	}

	function get_custom_fields_data_by_type( $type, $id ) {
		$fields = $this->custom_fields_by_type( $type );
		$data_custom_fields = array();
		foreach ( $fields as $field ) {
			$data = $this->custom_fields_data_by_type( $type, $id, $field[ 'id' ] );
			if ( $data ) {
				switch ( $field[ 'type' ] ) {
					case 'input':
						$data_last = $data[ 'data' ];
						$selected_opt = 0;
						break;
					case 'date':
						$data_last = $data[ 'data' ];
						$selected_opt = 0;
						break;
					case 'number':
						$data_last = $data[ 'data' ];
						$selected_opt = 0;
						break;
					case 'textarea':
						$data_last = $data[ 'data' ];
						$selected_opt = 0;
						break;
					case 'select':
						$data_last = json_decode( $field[ 'data' ] );
						$selected_opt =  json_decode($data[ 'data' ], true) ;
						break;
				}
				if ( $field[ 'icon' ] != null ) {
					$icon = $field[ 'icon' ];
				} else {
					$icon = 'mdi mdi-info-outline';
				}
			} else {
				$data_last = json_decode( $field[ 'data' ] );
				$selected_opt = null;
			}
			if ( $field[ 'icon' ] != null ) {
				$icon = $field[ 'icon' ];
			} else {
				$icon = 'mdi mdi-info-outline';
			}
			$data_custom_fields[] = array(
				'id' => $field[ 'id' ],
				'name' => $field[ 'name' ],
				'type' => $field[ 'type' ],
				'order' => $field[ 'order' ],
				'data' => $data_last,
				'selected_opt' => $selected_opt,
				'relation' => $field[ 'relation' ],
				'icon' => $icon,
				'permission' => $field[ 'permission' ] === 'true' ? true : false,
				'active' => $field[ 'active' ] === 'true' ? true : false,
			);
		};
		return $data_custom_fields;
	}

}