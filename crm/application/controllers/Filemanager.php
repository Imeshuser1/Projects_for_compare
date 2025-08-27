<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filemanager extends CIUIS_Controller
{

	function __construct()
	{
		parent::__construct();
		$path = $this->uri->segment(1);
		if (!$this->Privileges_Model->has_privilege($path)) {
			$this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
			redirect('panel');
			die;
		}
	}

	function index()
	{
		$data['title'] = 'File Manager';
		$data['logs'] = $this->Logs_Model->get_all_logs();
		$data['settings'] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view('filemanager/index', $data);
	}

	public function get_permission()
	{
		echo json_encode([
			'own' => $this->Privileges_Model->check_privilege('filemanager', 'own'),
			'all' => $this->Privileges_Model->check_privilege('filemanager', 'all'),
			'create' => $this->Privileges_Model->check_privilege('filemanager', 'create'),
			'edit' => $this->Privileges_Model->check_privilege('filemanager', 'edit'),
			'delete' => $this->Privileges_Model->check_privilege('filemanager', 'delete'),
		]);
	}
}
