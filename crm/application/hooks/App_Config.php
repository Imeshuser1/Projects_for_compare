<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Remote_Check {
	private $CI;
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	function index() {
		if (!empty($this->CI->session->userdata('remote_check'))) {
			if (!$this->CI->session->userdata('remote_check')) {
				include_once(APPPATH . 'third_party/script/config.php');
				include_once(APPPATH . 'third_party/script/lb_helper.php');
				$lb = new LicenseBoxExternalAPI();
				$connection = $lb->check_connection();
				if ($connection['status']) {
					$verification = $lb->verify_license(true);
					if (!$verification['status']) {
						$this->CI->session->set_userdata( 'ntf4', $verifyRemoteCheck['notification_text']);
						$this->CI->session->set_userdata( 'error', $verifyRemoteCheck['notification_text']);
						unsetSession();
						redirect(base_url('login/license'));
					} else {
						unsetSession();
					}
				} else {
					unsetSession();
				}
			}
		} else {
			unsetSession();
		}
	}
}