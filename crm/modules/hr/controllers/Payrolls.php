<?php
require_once APPPATH . '/third_party/vendor/autoload.php';

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'modules/hr/core/HR_Controller.php';
class Payrolls extends HR_Controller
{

  function __construct()
  {
    parent::__construct();
    $path = $this->uri->segment(2);
    $this->load->model('Payrolls_Model');
    if (!$this->Privileges_Model->has_privilege($path)) {
      $this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
      redirect('hr/panel/');
      die;
    }
  }

  function index()
  {
    $data['title'] = lang('payrolls');
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $data['payrolls'] = $this->Payrolls_Model->get_all_payroll_by_privilege();
    } else {
      $data['payrolls'] = $this->Payrolls_Model->get_all_payroll_by_privilege($this->session->usr_id);
    }
    $data['settings'] = $this->Settings_Model->get_settings_ciuis();
    $this->load->view('hr/payrolls/index', $data);
  }

  /* Get Payroll Data */
  function get_payroll($id)
  {
    $payroll = array();
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
    if ($payroll) {

      $allowances = $this->Payrolls_Model->get_payroll_items('allowance', $id);
      $deductions = $this->Payrolls_Model->get_payroll_items('deduction', $id);
      $properties = array();
      $payroll_details = array(
        'allowances' => $allowances,
        'deductions' => $deductions,
        //'payroll' => $payroll,
        'payroll_id' => $payroll['payroll_id'],
        'payroll_token' => $payroll['payroll_token'],
        'payroll_relation_id' => $payroll['payroll_relation_id'],
        'payroll_staff_id' => $payroll['payroll_staff_id'],
        //'payroll_status' => $payroll['payroll_status'],
        'payroll_created' => $payroll['payroll_created'],
        'payroll_last_recurring' => $payroll['payroll_last_recurring'],
        'payroll_start_date' => $payroll['payroll_start_date'],
        'payroll_end_date' => $payroll['payroll_end_date'],
        'payroll_run_day' => $payroll['payroll_run_day'],
        'payroll_note' => $payroll['payroll_note'],
        'payroll_total_allowance' => $payroll['payroll_total_allowance'],
        'payroll_total_deduction' => $payroll['payroll_total_deduction'],
        'payroll_grand_total' => $payroll['payroll_grand_total'],
        'payroll_account' => $payroll['payroll_account'],
        'payroll_base_salary' => +$payroll['payroll_base_salary'],
        'payroll_recurring' => ($payroll['payroll_recurring'] == '1') ? true : false,
        'payroll_expense_category' => $payroll['payroll_expense_category'],
        'staff_email' => $payroll['email'],
        'staff_name' => $payroll['staffmembername'],
        'staff_phone' => $payroll['phone'],
        'payroll_relation_id' => $payroll['payroll_relation_id'],
        'payroll_number' => $payroll['payroll_number'],
        'pdf_status' => $payroll['payroll_pdf_status'],
        'recurring_id' => $payroll['recurring_id'],

      );
      echo json_encode($payroll_details);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
  }

  /* Display Payroll Details */
  function payroll($id)
  {
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
    if ($payroll) {
      $data['id'] = $id;
      $data['title'] = "Payroll Details";
      $data['payrolls'] = $payroll;
      $this->load->view('payrolls/payroll', $data);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
  }

  /* Create Payroll */
  function create()
  {
    $data['title'] = lang('new') . ' ' . lang('payroll');
    if ($this->Privileges_Model->check_privilege('payrolls', 'create')) {
      $data['title'] = lang('new') . ' ' . lang('payroll');
      if (isset($_POST) && count($_POST) > 0) {
        $hasError = false;
        //$allowances = $this->input->post('allowances', TRUE);

        $this->form_validation->set_rules('staff', 'lang:staff', 'required|trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('expense_categories', 'lang:expense_category', 'required|trim|numeric');
        $this->form_validation->set_rules('startdate', 'lang:start_date', 'required|trim');
        $this->form_validation->set_rules('enddate', 'lang:end_date', 'required|trim');
        $this->form_validation->set_rules('base_salary', 'lang:base_salary', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('account', 'lang:account', 'required|trim|numeric');
        $this->form_validation->set_rules('run_day', 'lang:run_day', 'required|trim');
        $this->form_validation->set_rules('payrollnote', 'lang:payrollnote', 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('total_allowance', 'lang:allowancetotal', 'required|trim|decimal|greater_than_equal_to[0]');
        $this->form_validation->set_rules('total_deduction', 'lang:deductiontotal', 'required|trim|decimal|greater_than_equal_to[0]');
        $this->form_validation->set_rules('total', 'lang:total', 'required|trim|decimal|greater_than[0]');
        // foreach($allowances as $key => $allowance){
        // $this->form_validation->set_rules('$allowance['.$key.']', 'allowances', 'trim|decimal|greater_than[0]');
        // //var_dump($allowance);die;
        // }
        if ($this->form_validation->run() == false) {
          $hasError = true;
          $datas['message'] = validation_errors();
        }

        if (strtotime($this->input->post('startdate')) > strtotime($this->input->post('enddate'))) {
          $hasError = true;
          $datas['message'] = lang('end_lessthat_start_date');
        }

        //  else if (((int)($this->input->post('totalItems'))) == 0) {
        // 	$hasError = true;
        // 	$datas['message'] = lang('invalid_items');
        // } else if ($total == 0) {
        // 	$hasError = true;
        // 	$datas['message'] = lang('invalid_total');
        // }
        if ($hasError) {
          $datas['success'] = false;
          echo json_encode($datas);
        }
        if (!$hasError) {
          $appconfig = get_appconfig();
          $params = array(
            'payroll_token' => md5(uniqid()),
            'payroll_relation_id' => $this->input->post('staff'),
            'payroll_staff_id' => $this->session->usr_id,
            'payroll_created' => date('Y-m-d H:i:s'),
            'payroll_last_recurring' => date('Y-m-d H:i:s'),
            'payroll_start_date' => $this->input->post('startdate'),
            'payroll_end_date' => $this->input->post('enddate'),
            'payroll_run_day' => $this->input->post('run_day'),
            'payroll_note' => $this->input->post('payrollnote'),
            'payroll_total_allowance' => $this->input->post('total_allowance'),
            'payroll_total_deduction' => $this->input->post('total_deduction'),
            'payroll_grand_total' => $this->input->post('total'),
            'payroll_account' => $this->input->post('account'),
            'payroll_base_salary' => $this->input->post('base_salary'),
            'payroll_recurring' => $this->input->post('recurring'),
            'payroll_expense_category' => $this->input->post('expense_categories'),
          );
          $payroll_id = $this->Payrolls_Model->payroll_add($params);

          if ($this->input->post('recurring') == 'true'  || $this->input->post('recurring') == '1') {
            $SHXparams = array(
              'relation_type' => 'payroll',
              'relation' => $payroll_id,
              'type' => 2,
              'period' => 1,
              'end_date' => $this->input->post('enddate'),
            );
            $recurring_payroll_id = $this->Payrolls_Model->recurring_add($SHXparams);
          }
          $datas['success'] = true;
          $datas['id'] = $payroll_id;
          $datas['message'] = lang('payroll') . ' ' . lang('createmessasge');
          if ($appconfig['payroll_series']) {
            $payroll_number = $appconfig['payroll_series'];
            $payroll_number = $payroll_number + 1;
            $this->Settings_Model->increment_series('payroll_series', $payroll_number);
          }
          echo json_encode($datas);
        }
      } else {
        $this->load->view('hr/payrolls/create', $data);
      }
    } else {
      $this->session->set_flashdata('ntf3', '' . $payroll_id . lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
  }

  /* Update Payroll */
  function update($id)
  {
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $datas['success'] = false;
      $datas['message'] = lang('you_dont_have_permission');
      echo json_encode($datas);
    }
    // if($payroll['status_id'] == '2') {
    // 	$this->session->set_flashdata( 'ntf4',lang('paid').' '.lang('payroll').' '.lang( 'cant_update' ) );
    // 	redirect('hrm/payroll/'. $id);
    // } else {
    if ($payroll) {
      if ($this->Privileges_Model->check_privilege('payrolls', 'edit')) {
        if ($this->session->userdata('other')) {
          $data['title'] = lang('update') . ' ' . lang('payroll');
          if (isset($payroll['payroll_id'])) {
            if (isset($_POST) && count($_POST) > 0) {
              $hasError = false;
              $this->form_validation->set_rules('staff', 'lang:staff', 'required|trim|alpha_numeric_spaces');
              $this->form_validation->set_rules('expense_categories', 'lang:expense_category', 'required|trim|numeric');
              $this->form_validation->set_rules('startdate', 'lang:start_date', 'required|trim');
              $this->form_validation->set_rules('enddate', 'lang:end_date', 'required|trim');
              $this->form_validation->set_rules('base_salary', 'lang:base_salary', 'required|trim|numeric|greater_than[0]');
              $this->form_validation->set_rules('account', 'lang:account', 'required|trim|numeric');
              $this->form_validation->set_rules('run_day', 'lang:run_day', 'required|trim');
              $this->form_validation->set_rules('payrollnote', 'lang:payrollnote', 'trim|alpha_numeric_spaces');
              $this->form_validation->set_rules('total_allowance', 'lang:allowancetotal', 'required|trim|decimal|greater_than_equal_to[0]');
              $this->form_validation->set_rules('total_deduction', 'lang:deductiontotal', 'required|trim|decimal|greater_than_equal_to[0]');
              $this->form_validation->set_rules('total', 'lang:total', 'required|trim|decimal|greater_than[0]');

              if ($this->form_validation->run() == false) {
                $hasError = true;
                $datas['message'] = validation_errors();
              }

              if (strtotime($this->input->post('startdate')) > strtotime($this->input->post('enddate'))) {
                $hasError = true;
                $datas['message'] = lang('end_lessthat_start_date');
              }

              if ($hasError) {
                $datas['success'] = false;
                echo json_encode($datas);
              }
              if (!$hasError) {
                $params = array(
                  'payroll_relation_id' => $this->input->post('staff'),
                  'payroll_staff_id' => $this->session->usr_id,
                  'payroll_last_recurring' => date('Y-m-d H:i:s'),
                  'payroll_start_date' => $this->input->post('startdate'),
                  'payroll_end_date' => $this->input->post('enddate'),
                  'payroll_run_day' => $this->input->post('run_day'),
                  'payroll_note' => $this->input->post('payrollnote'),
                  'payroll_total_allowance' => $this->input->post('total_allowance'),
                  'payroll_total_deduction' => $this->input->post('total_deduction'),
                  'payroll_grand_total' => $this->input->post('total'),
                  'payroll_account' => $this->input->post('account'),
                  'payroll_base_salary' => $this->input->post('base_salary'),
                  'payroll_recurring' => ($this->input->post('payroll_recurring') == 'true') ? '1' : '0',
                  'payroll_expense_category' => $this->input->post('expense_categories'),

                );
                $this->Payrolls_Model->update_payroll($id, $params);

                // START Recurring Payroll
                if ($this->input->post('payroll_recurring') == 'true') {
                  $SHXparams = array(
                    'end_date' => $this->input->post('enddate'),
                    'relation_type' => 'payroll',
                    'relation' => $id,
                    'status' => 1,
                    'type' => 2,
                    'period' => 1,
                  );
                  $recurring_payroll_id = $this->Payrolls_Model->recurring_update($id, $SHXparams);
                } else {
                  $SHXparams = array(
                    'end_date' => $this->input->post('enddate'),
                    'relation_type' => 'payroll',
                    'relation' => $id,
                    'status' => 0,
                    'type' => 2,
                    'period' => 1,
                  );
                  $recurring_payroll_id = $this->Payrolls_Model->recurring_update($id, $SHXparams);
                }
                // if (!is_numeric($this->input->post('recurring_id')) && ($this->input->post('payroll_recurring') == 'true')) { // NEW Recurring From Update
                //   $SHXparams = array(
                //     'relation_type' => 'payroll',
                //     'relation' => $id,
                //     'period' => 1,
                //     'end_date' => $this->input->post('enddate'),
                //     'type' => 2,
                //   );
                //   $recurring_payroll_id = $this->Payrolls_Model->recurring_add($SHXparams);
                // }
                //$this->Payrolls_Model->update_pdf_status($id, '0');
                $datas['success'] = true;
                $datas['id'] = $id;
                $datas['message'] = lang('payroll') . ' ' . lang('updatemessasge');
                echo json_encode($datas);
              }
              // END Recurring Invoice
            } else {
              $data['payrolls'] = $payroll;

              $this->load->view('hr/payrolls/update', $data);
            }
          } else
            $this->session->set_flashdata('ntf3', '' . $id . lang('error'));
        } else {
          $this->session->set_flashdata('ntf3', '' . $id . lang('you_dont_have_permission'));
          redirect('hr/payrolls');
        }
      } else {
        $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
        redirect('hr/payrolls/palroll/' . $id);
      }
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect('hr/payrolls');
    }
    //}
  }

  /* Convert payroll to payslip. Copy payroll items to payslip items */
  function convert_payroll($id)
  {
    if ($this->Privileges_Model->check_privilege('payslips', 'create')) {
      $payroll = $this->Payrolls_Model->get_payrolls($id);

      $days = 30;
      $base_salary = $payroll['payroll_base_salary'];
      $last_day_last_month = date('Y-m-d', strtotime('last day of last month'));
      $first_day_last_month = date('Y-m-d', strtotime('first day of last month'));

      $run_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime("first day of this month")) . ' + ' . ($payroll['payroll_run_day'] - 1) . 'days'));

      if (strtotime($last_day_last_month) > strtotime($payroll['payroll_end_date'])) {
        $last_day_last_month = $payroll['payroll_end_date'];
      }

      if (strtotime($payroll['payroll_end_date']) < strtotime(date('Y-m-d'))) {
        $data['success'] = false;
        $data['message'] = lang('enddateexceeded');
        echo json_encode($data);
      }

      if (strtotime(date('Y-m-d')) < strtotime($run_date)) {
        $data['success'] = false;
        $data['message'] = lang('wait_for_run_date');
        echo json_encode($data);
      }

      if (strtotime($payroll['payroll_start_date']) > strtotime($last_day_last_month)) {
        $diff = abs(strtotime($payroll['payroll_start_date']) - strtotime($last_day_last_month));
        $days = round($diff / (60 * 60 * 24));
        $base_salary = ($base_salary * $days) / 30;
      }

      $params = array(
        'payslip_token' => md5(uniqid()),
        'payslip_payroll_id' => $id,
        'payslip_relation_id' => $payroll['payroll_relation_id'],
        'payslip_staff_id' => $this->session->usr_id,
        'payslip_status' => $payroll['payroll_status'],
        'payslip_created' => date('Y-m-d H:i:s'),
        'payslip_last_recurring' => $payroll['payroll_last_recurring'],
        'payslip_start_date' => date('Y-m-d', strtotime(date('Y-m-d') . " -1 month")),
        'payslip_end_date' => date('Y-m-d'),
        'payslip_run_day' => $payroll['payroll_run_day'],
        'payslip_note' => $payroll['payroll_note'],
        'payslip_total_allowance' => $payroll['payroll_total_allowance'],
        'payslip_total_deduction' => $payroll['payroll_total_deduction'],
        'payslip_grand_total' => $payroll['payroll_grand_total'],
        'payslip_account' => $payroll['payroll_account'],
        'payslip_base_salary' => $base_salary,
        'payslip_recurring' => $payroll['payroll_recurring'],
        'payslip_expense_category' => $payroll['payroll_expense_category'],
      );
      $payslip = $this->Payslips_Model->add_payslip($params);
      if($this->Payslips_Model->status_of_adding == 'new') {
        $appconfig = get_appconfig();
        $number = $appconfig['payslip_series'] ? $appconfig['payslip_series'] : $payslip;
        $payslip_number = $appconfig['payslip_prefix'] . $number;
        $this->db->where('payslip_id', $payslip)->update('payslips', array('payslip_number' => $payslip_number));
        if ($appconfig['payslip_series']) {
          $payslip_number = $appconfig['payslip_series'];
          $payslip_number = $payslip_number + 1;
          $this->Settings_Model->increment_series('payslip_series', $payslip_number);
        }
      }
      $allowances = $this->Payrolls_Model->get_payroll_items('allowance', $id);
      if($this->Payslips_Model->status_of_adding == 'new') {
        $allowances_payslip_ids = [];
      } else {
        $allowances_payslip_ids = $this->Payslips_Model->get_payslip_items_ids('allowance', $payslip);
      }
      $allowance_total = 0;
      $deduction_total = 0;
      $i = 0;
      $allowances_payslip_ids_count = count($allowances_payslip_ids);
      foreach ($allowances as $allowance) {
        if ($allowance['payroll_item_time'] == '30') {
          $allowance_item_total = ($allowance['payroll_item_total'] * $days) / 30;
        } else {
          $allowance_item_total = $allowance['payroll_item_total'];
        }
        $data_item = [
          'payslip_item_type' => 'allowance',
          'relation_id' => $payslip,
          'payslip_item_name' => $allowance['payroll_item_name'],
          'payslip_item_description' => $allowance['payroll_item_description'],
          'payslip_item_time' => $allowance['payroll_item_time'],
          'payslip_item_quantity' => $allowance['payroll_item_quantity'],
          'payslip_item_price' => $allowance['payroll_item_price'],
          'payslip_item_total' => $allowance_item_total,
        ];
        if($this->Payslips_Model->status_of_adding == 'new' || $i >= $allowances_payslip_ids_count) {
          $this->db->insert('payslip_item', $data_item);
        } else {
          $this->db->update('payslip_item', $data_item, ['payslip_item_id' => $allowances_payslip_ids[$i]]);
        }
        $allowance_total += $allowance_item_total;
        $i++;
      }
      if($i < $allowances_payslip_ids_count) {
        foreach(array_slice($allowances_payslip_ids, $i) as $allowances_payslip_id) {
          $this->db->delete('payslip_item', ['payslip_item_id' => $allowances_payslip_id]);
        }
      }

      $deductions = $this->Payrolls_Model->get_payroll_items('deduction', $id);
      if($this->Payslips_Model->status_of_adding == 'new') {
        $deductions_payslip_ids = [];
      } else {
        $deductions_payslip_ids = $this->Payslips_Model->get_payslip_items_ids('deduction', $payslip);
      }
      $i = 0;
      $deductions_payslip_ids_count = count($deductions_payslip_ids);
      foreach ($deductions as $deduction) {
        if ($deduction['payroll_item_time'] == '30') {
          $deduction_item_total = ($deduction['payroll_item_total'] * $days) / 30;
        } else {
          $deduction_item_total = $deduction['payroll_item_total'];
        }
        $data_item = [
          'payslip_item_type' => 'deduction',
          'relation_id' => $payslip,
          'payslip_item_name' => $deduction['payroll_item_name'],
          'payslip_item_description' => $deduction['payroll_item_description'],
          'payslip_item_time' => $deduction['payroll_item_time'],
          'payslip_item_quantity' => $deduction['payroll_item_quantity'],
          'payslip_item_price' => $deduction['payroll_item_price'],
          'payslip_item_total' => $deduction_item_total,
        ];
        if($this->Payslips_Model->status_of_adding == 'new' || $i >= $deductions_payslip_ids_count) {
          $this->db->insert('payslip_item', $data_item);
        } else {
          $this->db->update('payslip_item', $data_item, ['payslip_item_id' => $deductions_payslip_ids[$i]]);
        }
        $deduction_total += $deduction_item_total;
        $i++;
      }
      if($i < $deductions_payslip_ids_count) {
        foreach(array_slice($deductions_payslip_ids, $i) as $deductions_payslip_id) {
          $this->db->delete('payslip_item', ['payslip_item_id' => $deductions_payslip_id]);
        }
      }
      $this->db->update(
        'payslips',
        array(
          'payslip_total_allowance' => $allowance_total,
          'payslip_total_deduction' => $deduction_total,
          'payslip_grand_total' => ($base_salary + $allowance_total - $deduction_total)
        ),
        array(
          'payslip_id' => $payslip
        )
      );

      $data['id'] = $payslip;
      $data['success'] = true;
      echo json_encode($data);
    } else {
      $data['success'] = false;
      $data['message'] = lang('you_dont_have_permission');
      echo json_encode($data);
    }
  }

  function remove($id)
  {
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
    if ($payroll) {
      if ($this->Privileges_Model->check_privilege('payrolls', 'delete')) {
        if (isset($payroll['id'])) {

          $this->Payrolls_Model->delete_payroll($id);
          $data['success'] = true;
          $data['message'] = lang('payroll') + ' ' + lang('deleted');
        } else {
          show_error('The payroll you are trying to delete does not exist.');
        }
      } else {
        $data['success'] = false;
        $data['message'] = lang('you_dont_have_permission');
      }
      echo json_encode($data);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
  }

  function remove_allowance($id)
  {
    $response = $this->db->delete('payroll_item', array('payroll_item_id' => $id, 'payroll_item_type' => 'allowance'));
  }

  function remove_deduction($id)
  {
    $response = $this->db->delete('payroll_item', array('payroll_item_id' => $id, 'payroll_item_type' => 'deduction'));
  }

  function payslips_for_payroll($id)
  {
    $payslips = $this->Payrolls_Model->payslips_for_payroll($id);
    $data = array();
    foreach ($payslips as $payslip) {
      $data[] = array(
        'payslip_id' => $payslip['payslip_id'],
        'payslip_number' => $payslip['payslip_number'],
        'payslip_grand_total' => $payslip['payslip_grand_total'],
        'payslip_payroll_id' => $payslip['payslip_payroll_id'],
        'payslip_created' => date(get_dateFormat(), strtotime($payslip['payslip_created'])),
      );
    }
    echo json_encode($data);
  }

  /* Print Pdf for Payroll  */
  function print_($id)
  {
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payrolls', 'own')) {
      $payroll = $this->Payrolls_Model->get_payroll_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
    if ($payroll) {
      ini_set('max_execution_time', 0);
      ini_set('memory_limit', '2048M');
      if (!is_dir('uploads/files/payroll/' . $id)) {
        mkdir('./uploads/files/payroll/' . $id, 0777, true);
      }
      $data['payroll'] = $payroll;
      $data['settings'] = $this->Settings_Model->get_settings_ciuis();
      $data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
      $data['country'] = get_country($data['settings']['country_id']);
      $data['allowances'] = $this->Payrolls_Model->get_payroll_items('allowance', $id);
      $data['deductions'] = $this->Payrolls_Model->get_payroll_items('deduction', $id);
      $this->load->view('hr/payrolls/pdf', $data);
      $file_name = $payroll['payroll_number'] . '.pdf';
      $html = $this->output->get_output();
      $this->dompdf = new DOMPDF();
      $this->dompdf->loadHtml($html);
      $this->dompdf->set_option('isRemoteEnabled', TRUE);
      $this->dompdf->setPaper('A4', 'portrait');
      $this->dompdf->render();
      $output = $this->dompdf->output();
      file_put_contents('uploads/files/payroll/' . $id . '/' . $file_name . '', $output);
      if ($output) {
        redirect(base_url('uploads/files/payroll/' . $id . '/' . $file_name . ''));
        //$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
      } else {
        redirect(base_url('hr/payrolls/pdf_falut/'));
      }
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payrolls'));
    }
  }

  function pdf_fault()
  {
    $result = array(
      'status' => false,
    );
    echo json_encode($result);
  }


  function download_pdf($id)
  {
  }

  function create_pdf($id)
  {
  }
}
