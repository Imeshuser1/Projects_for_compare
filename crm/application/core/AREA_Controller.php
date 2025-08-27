<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AREA_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (isset($this->session->logged_in) && $this->session->logged_in === true) {
			$this->load->model('Settings_Model');
			define('LANG', $this->Settings_Model->get_crm_lang());
			$this->lang->load(LANG . '_default', LANG);
			$this->lang->load(LANG, LANG);
			$this->load->library(array('session'));
			$this->load->helper(array('url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->inactive = $this->config->item('inactive');
			$this->roles = $this->config->item('roles');
			$this->load->model('Area_Model');
			$this->load->model('Customers_Model');
			$this->load->model('Staff_Model');
			$this->load->model('Products_Model');
			$this->load->model('Tickets_Model');
			$this->load->model('Settings_Model');
			$this->load->model('Invoices_Model');
			$this->load->model('Report_Model');
			$this->load->model('Logs_Model');
			$this->load->model('Sales_Model');
			$this->load->model('Notifications_Model');
			$this->load->model('Contacts_Model');
			$this->load->model('Appointments_Model');
			$this->load->model('Projects_Model');
			$this->load->model('Tasks_Model');
			$this->load->model('Accounts_Model');
			$this->load->model('Payments_Model');
			$this->load->model('Expenses_Model');
			$this->load->model('Proposals_Model');
			$this->load->model('Privileges_Model');
			$this->load->model('Emails_Model');
			$data['contacts'] = $this->Contacts_Model->get_all_contacts();
			define('currency', $this->Settings_Model->get_currency());
			define('timezone', $this->Settings_Model->default_timezone());
			define( 'setting', $this->Settings_Model->get_settings_ciuis_origin());
			define( 'rebrand', load_config());
			define( 'week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
			date_default_timezone_set(timezone);
		} else {
			redirect('area/login');
		}
	}
}
