<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
require_once FCPATH . 'modules/hr/core/HR_Controller.php';
class Panel extends HR_Controller {
  function index() {
    $rebrand = load_config();
    $data['title'] = $rebrand['title'];
    $this->load->view('hr/panel/index', $data);
  }
}