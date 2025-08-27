<?php

use PhpMyAdmin\SqlParser\Parser;

defined('BASEPATH') or exit('No direct script access allowed');


$roles = $this->db->get_where('roles', array('role_type' => 'hr_manager'))->result_array();
if (!$roles) {
  $this->db->where('name', $type)->update('modules', array('status' => 0, 'updatedat' => date('Y-m-d H:i:s')));

  $this->load->helper('file');
  $uninstall_sql = FCPATH . 'modules/hr/uninstall/uninstall.sql';
  $module = FCPATH . 'modules/hr';
  $payroll_folder = FCPATH . 'uploads/files/payroll';
  $payslip_folder = FCPATH . 'uploads/files/payslip';


  if (file_exists($uninstall_sql)) {
    $file_content = file_get_contents($uninstall_sql);
    $parser = new Parser($file_content);
    if ($parser->errors) {
      $data['success'] = false;
      $data['message'] = 'Error in sql file';
    } else {
      $queries = $parser->statements;
      foreach ($queries as $query) {
        $this->db->db_debug = FALSE;
        $this->db->query($query->build() . ';');
        $error = $this->db->error();
        if ($error['code']) {
          if (ini_get('allow_url_fopen')) {
            $error_file = APPPATH . 'views/app-errors/errors-log.php';
            $fp = fopen($error_file, 'a');
            fwrite($fp, "<br>\nError[Type='HR Module Deactivating'][" . date("Y-m-d H:i:s") . "]):" . $error['message']);
            fclose($fp);
            $data['error'] = $error;
          }
          continue;
        }
      }
      $data['success'] = true;
      $data['message'] = lang('updated_installed');
    }
  }
  if (file_exists($payroll_folder)) {
    delete_files($payroll_folder, true);
    rmdir($payroll_folder);
  }
  if (file_exists($payslip_folder)) {
    delete_files($payslip_folder, true);
    rmdir($payslip_folder);
  }
  if (file_exists($module)) {
    delete_files($module, true);
    rmdir($module);
  }

  $data = ['success' => TRUE, 'message' => lang('module_disabled')];
} else {
  $data = ['success' => FALSE, 'message' => lang('cant_disable_module')];
}
