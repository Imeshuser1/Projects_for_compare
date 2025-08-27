<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HR_Controller extends CI_Controller
{
	function __construct()
	{
    parent::__construct();

		if (isset($this->session->HRLoginOK) && $this->session->HRLoginOK === true) {
			$this->load->model('Settings_Model');
			define('LANG', $this->Settings_Model->get_crm_lang());
			$this->lang->load(LANG . '_default', LANG);
			$this->lang->load(LANG, LANG);
			$this->load->library(array('session'));
			$this->load->helper(array('url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->config->set_item('language', LANG);
			// $this->inactive = $this->config->item('inactive');
			// $this->roles = $this->config->item('roles');
			$this->load->model('Report_Model');
			// $this->load->model('Logs_Model');
			$this->load->model('Notifications_Model');

			$this->load->model('hr/Login_Model');
			$this->load->model('Privileges_Model');
			$this->load->model('Staff_Model');
			$this->load->model('Emails_Model');
			$this->load->model('hr/Payrolls_Model');
			$this->load->model('hr/Payslips_Model');
			define('if_admin', $this->Login_Model->if_admin());
			define('currency', $this->Settings_Model->get_currency());
			define('timezone', $this->Settings_Model->default_timezone());
			date_default_timezone_set(timezone);
		} else {
			redirect('hr/login');
		}
	}
}
