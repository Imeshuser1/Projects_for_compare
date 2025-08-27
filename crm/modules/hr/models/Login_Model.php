<?php 
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Login_Model extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }


  var $details;

  function validate_user( $email, $password)
  {
    $this->db->from('staff');
    $this->db->where('email', $email);
    $this->db->where('password', md5($password));
    $login = $this->db->get()->result();
    if( is_array( $login ) && count( $login ) > 0)
    {
			$this->details = $login[ 0 ];
      //$this->session->sess_destroy();
      $this->set_session();
      return true;
    }
    return false;
  }

  function set_session() {
		$this->session->set_userdata( array(
			'usr_id' => $this->details->id,
			'staffname' => $this->details->staffname,
			'email' => $this->details->email,
			'root' => $this->details->root,
			'language' => $this->details->language,
			'admin' => $this->details->admin,
			'staffmember' => $this->details->staffmember,
			'staffavatar' => $this->details->staffavatar,
			'staff_timezone' => $this->details->timezone,
			'other' => $this->details->other,
      'LoginOK' => true,
			'HRLoginOK' => true,
			'remote_check'=>true,
    ) );
		// if (empty($apl_core_notifications=aplCheckSettings())) {
		// 	if (!empty(aplGetLicenseData()) && is_array(aplGetLicenseData())) {
		// 		$verifyRemoteCheck = aplVerifyLicense();
		// 		if ($verifyRemoteCheck['notification_case'] != 'notification_license_ok') {
		// 			$this->session->set_userdata(array('remote_check' => false, 'LoginOK' => false, 'admin' => ''));
		// 		} else {
		// 			$this->session->set_userdata(array('remote_check' => true, 'LoginOK' => true));
		// 		}
		// 	} else {
		// 		$this->session->set_userdata(array('remote_check' => false, 'LoginOK' => false, 'admin' => ''));
		// 	}
		// } else {
		// 	$this->session->set_userdata(array('remote_check' => false, 'LoginOK' => false, 'admin' => ''));
    // }
    
  }
  

  function if_admin() {
		if ( !$this->session->userdata( 'admin' ) ) {
			return 'display:none';
		}
	}
  




}

