<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{

  public $inactive;

  function __construct()
  {
    parent::__construct();
    $this->load->model('Settings_Model');
    define('LANG', $this->Settings_Model->get_crm_lang());
    $this->lang->load(LANG . '_default', LANG);
    $this->lang->load(LANG, LANG);
    $settings = $this->Settings_Model->get_settings('ciuis');
    $timezone = $settings['default_timezone'];
    date_default_timezone_set($timezone);
    $this->load->model('hr/Login_Model');
    $this->load->model('Staff_Model');
    $this->load->model('Emails_Model');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
  }

  function index()
  {
    if (isset($this->session->HRLoginOK) && $this->session->HRLoginOK === true) {
      redirect('hr/panel/index');
    } else {
      redirect('hr/login/auth');
    }
  }

  function auth() {
		$data = new stdClass();
		$this->load->helper( 'form' );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'email', 'Email', 'required' );
		$this->form_validation->set_rules( 'password', 'Password', 'required' );
		if ( $this->form_validation->run() == false ) {
			$this->load->view( 'hr/login/login' );
		} else {
			$email = $this->input->post( 'email' );
			$password = $this->input->post( 'password' );
			if ( $this->Login_Model->validate_user( $email, $password ) ) {
				redirect( 'hr/panel/index' );
			} else {
				$data->error = lang( 'wrongmessage' );
				$this->load->view( 'hr/login/login', $data );
			}
		}
  }

  function logout()
  {
    $this->session->sess_destroy();
		$this->index();
  }







}
