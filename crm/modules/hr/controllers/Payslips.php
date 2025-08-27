<?php
require_once APPPATH . '/third_party/vendor/autoload.php';

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'modules/hr/core/HR_Controller.php';
class Payslips extends HR_Controller
{

  function __construct()
  {
    parent::__construct();
    $path = $this->uri->segment(2);
    $this->load->model('Payslips_Model');
    if (!$this->Privileges_Model->has_privilege($path)) {
      $this->session->set_flashdata('ntf3', '' . lang('you_dont_have_permission'));
      redirect('hr/panel/');
      die;
    }
  }


  function index()
  {
    $data['title'] = lang('payslips');
    if ($this->Privileges_Model->check_privilege('payrolls', 'all')) {
      $data['payslips'] = $this->Payslips_Model->get_all_payslip_by_privilege();
    } else {
      $data['payslips'] = $this->Payslips_Model->get_all_payslip_by_privilege($this->session->usr_id);
    }
    $data['settings'] = $this->Settings_Model->get_settings_ciuis();
    $this->load->view('hr/payslips/index', $data);
  }

  function payslip($id)
  {
    if ($this->Privileges_Model->check_privilege('payslips', 'all')) {
      $payroll = $this->Payslips_Model->get_payslip_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payslips', 'own')) {
      $payroll = $this->Payslips_Model->get_payslip_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
    if ($payroll) {
      $data['id'] = $id;
      $data['title'] = "Payslip Details";
      $data['payslips'] = $payroll;
      $this->load->view('hr/payslips/payslip', $data);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
  }

  /* Get Payslip Data */
  function get_payslip($id)
  {
    $payslip = array();
    if ($this->Privileges_Model->check_privilege('payslips', 'all')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payslips', 'own')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
    if ($payslip) {

      $allowances = $this->Payslips_Model->get_payslip_items('allowance', $id);
      $deductions = $this->Payslips_Model->get_payslip_items('deduction', $id);
      $paid_amount = $this->Payslips_Model->get_paid_payslip($id);
      $net_balance = $payslip['payslip_grand_total'] - $paid_amount->row()->amount;
      $payments = $this->db->select('*, accounts.name as accountname, payments.id as id')->join('accounts', 'payments.account_id = accounts.id', 'left')->get_where('payments', array('payslip_id' => $id))->result_array();
      $payslip_details = array(
        'allowances' => $allowances,
        'deductions' => $deductions,
        //'payroll' => $payroll,
        'payslip_id' => $payslip['payslip_id'],
        'payslip_number' => $payslip['payslip_number'],
        'payslip_token' => $payslip['payslip_token'],
        'payslip_relation_id' => $payslip['payslip_relation_id'],
        'payslip_staff_id' => $payslip['payslip_staff_id'],
        'payslip_status' => $payslip['payslip_status'],
        'payslip_created' => $payslip['payslip_created'],
        'payslip_last_recurring' => $payslip['payslip_last_recurring'],
        'payslip_start_date' => $payslip['payslip_start_date'],
        'payslip_end_date' => $payslip['payslip_end_date'],
        'payslip_run_day' => $payslip['payslip_run_day'],
        'payslip_note' => $payslip['payslip_note'],
        'payslip_total_allowance' => $payslip['payslip_total_allowance'],
        'payslip_total_deduction' => $payslip['payslip_total_deduction'],
        'payslip_grand_total' => $payslip['payslip_grand_total'],
        'payslip_account' => $payslip['payslip_account'],
        'payslip_base_salary' => +$payslip['payslip_base_salary'],
        'payslip_recurring' => $payslip['payslip_recurring'],
        'payslip_expense_category' => $payslip['payslip_expense_category'],
        'staff_email' => $payslip['email'],
        'staff_name' => $payslip['staffmembername'],
        'staff_phone' => $payslip['phone'],
        'payroll_relation_id' => $payslip['payslip_relation_id'],
        'payments' => $payments,
        'balance' => $net_balance,
        'payslip_number' => $payslip['payslip_number'],
        'pdf_status' => $payslip['payslip_pdf_status']

      );
      echo json_encode($payslip_details);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
  }

  /* Record Payment for Payslip*/
  function record_payment()
  {
    if ($this->Privileges_Model->check_privilege('payslips', 'edit')) {
      $amount = $this->input->post('amount');
      $paysliptotal = $this->input->post('paysliptotal');
      if (isset($_POST) && count($_POST) > 0) {
        $appconfig = get_appconfig();
        $amount = $amount;
        $not = $this->input->post('not');
        $account = $this->input->post('account');
        $payslip_id =  $this->input->post('payslip');
        $hasError = false;
        if ($amount == '') {
          $hasError = true;
          $data['message'] = lang('invalidmessage') . ' ' . lang('amount');
        } else if ($not == '') {
          $hasError = true;
          $data['message'] = lang('invalidmessage') . ' ' . lang('description');
        } else if ($account == '') {
          $hasError = true;
          $data['message'] = lang('invalidmessage') . ' ' . lang('account') . ' ' . lang('type');
        } else if ($amount > $paysliptotal) {
          $hasError = true;
          $data['message'] = lang('paymentamounthigh') . ' ' . lang('payslip');
        }
        if ($hasError) {
          $data['success'] = false;
          echo json_encode($data);
        }
        if (!$hasError) {
          $created = date('Y-m-d H:i:s');
          $params = array(
            'hash' => ciuis_Hash(),
            'relation_type' => 'payslip',
            'relation' => $payslip_id,
            'title' => lang('payslip'),
            'description' => $not,
            'category_id' => $this->input->post('category'),
            'account_id' => $account,
            'staff_id' => $this->input->post('relation'),
            'created' => $created,
            'date' => $created,
            'amount' => $amount,
            'internal' => '1',
            'last_recurring' => $created,
            'expense_created_by' => $this->session->usr_id,

          );
          $payments = $this->Payslips_Model->addpayment($params);
          // $template = $this->Emails_Model->get_template('invoice', 'invoice_payment');
          // if ($template['status'] == 1) {
          // 	$invoice = $this->Invoices_Model->get_invoice_detail( $invoice_id );
          // 	$appconfig = get_appconfig();
          // 	$inv_number = get_number('invoices', $invoice_id, 'invoice', 'inv') ;
          // 	$name = $invoice['customercompany'] ? $invoice['customercompany'] : $invoice['individualindividual'];
          // 	$link = base_url( 'share/invoice/' . $invoice[ 'token' ] . '' );
          // 	$message_vars = array(
          // 		'{invoice_number}' => $inv_number,
          // 		'{invoice_link}' => $link,
          // 		'{payment_total}' => $amount,
          // 		'{payment_date}' => $this->input->post( 'date' ),
          // 		'{email_signature}' => $this->session->userdata( 'email' ),
          // 		'{name}' => $this->session->userdata( 'staffname' ),
          // 		'{customer}' => $name
          // 	);
          // 	$subject = strtr($template['subject'], $message_vars);
          // 	$message = strtr($template['message'], $message_vars);
          // 	$param = array(
          // 		'from_name' => $template['from_name'],
          // 		'email' => $invoice['email'],
          // 		'subject' => $subject,
          // 		'message' => $message,
          // 		'created' => date( "Y.m.d H:i:s" ),
          // 	);
          // 	if ($invoice['email']) {
          // 		$this->db->insert( 'email_queue', $param );
          // 	}
          // }
          $data['success'] = true;
          $data['id'] = $payslip_id;
          $data['message'] = lang('paymentaddedsuccessfully');
          if ($appconfig['expense_series']) {
            $expense_number = $appconfig['expense_series'];
            $expense_number = $expense_number + 1;
            $this->Settings_Model->increment_series('expense_series', $expense_number);
          }
          echo json_encode($data);
        }
      }
    } else {
      $data['success'] = false;
      $data['message'] = lang('you_dont_have_permission');
      echo json_encode($data);
    }
  }

  /* Delete Payslip*/
  function delete_payslip($id)
  {
    if ($this->Privileges_Model->check_privilege('payslips', 'all')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payslips', 'own')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
    if ($payslip) {
      if ($this->Privileges_Model->check_privilege('payslips', 'delete')) {
        if (isset($payslip['id'])) {
          if ($payslip == 0) {
            // $this->load->helper('file');
            // $folder = './uploads/files/hrm/'.$id;
            // if(file_exists($folder)){
            // 	delete_files($folder, true);
            // 	rmdir($folder);
            // }
            $this->Payslips_Model->delete_payslip($id);
            $data['success'] = true;
            $data['message'] = lang('payslipdeleted');
          } else {
            $data['success'] = false;
            $data['message'] = lang('cant_delete_payslip');
          }
        } else {
          show_error('The payslip you are trying to delete does not exist.');
        }
      } else {
        $data['success'] = false;
        $data['message'] = lang('you_dont_have_permission');
      }
      echo json_encode($data);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
  }

  /* Send payslip details as email to related staff  */
  function send_payslip_email($payslip_id)
  {
    $data = array();
    $template = $this->Emails_Model->get_template('hrm', 'payslip_generated_staff_message');
    if ($template['status'] == 1) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($payslip_id);
      $message_vars = array(
        '{staff}' => $payslip['staffmembername'],
        '{payslip_id}' => $payslip['payslip_number'],
        '{payslip_link}' => ' ',
        '{name}' => $this->session->userdata( 'staffname' ),
        '{email_signature}' => $this->session->userdata( 'email' ),
      );
      $subject = strtr($template['subject'], $message_vars);
      $message = strtr($template['message'], $message_vars);
      $param = array(
        //'from_name' => $template['from_name'],
        'email' => $payslip['email'],
        'subject' => $subject,
        'message' => $message,
        'created' => date("Y.m.d H:i:s"),
      );
      if ($payslip['email']) {
        $this->db->insert('email_queue', $param);
        $data['success'] = true;
        $data['message'] = lang('email_sent_success');
        echo json_encode($data);
      } else {
        $data['success'] = false;
        $data['message'] = lang('errormessage');
        echo json_encode($data);
      }
    } else {
      $data['success'] = false;
      $data['message'] = lang('errormessage');
      echo json_encode($data);
    }
  }

  /* Print Pdf for Payslip  */
  function print_($id)
  {
    $payslip = array();
    if ($this->Privileges_Model->check_privilege('payslips', 'all')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id);
    } else if ($this->Privileges_Model->check_privilege('payslips', 'own')) {
      $payslip = $this->Payslips_Model->get_payslip_detail_by_privilege($id, $this->session->usr_id);
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
    if ($payslip) {
      ini_set('max_execution_time', 0);
      ini_set('memory_limit', '2048M');
      if (!is_dir('uploads/files/payslip/' . $id)) {
        mkdir('./uploads/files/payslip/' . $id, 0777, true);
      }
      $data['payslip'] = $payslip;
      $data['settings'] = $this->Settings_Model->get_settings_ciuis();
      $data['state'] = get_state_name($data['settings']['state'], $data['settings']['state_id']);
      $data['country'] = get_country($data['settings']['country_id']);
      $data['allowances'] = $this->Payslips_Model->get_payslip_items('allowance', $id);
      $data['deductions'] = $this->Payslips_Model->get_payslip_items('deduction', $id);
      $this->load->view('hr/payslips/pdf', $data);
      $file_name = $payslip['payslip_number'] . '.pdf';
      $html = $this->output->get_output();
      $this->dompdf = new DOMPDF();
      $this->dompdf->loadHtml($html);
      $this->dompdf->set_option('isRemoteEnabled', TRUE);
      $this->dompdf->setPaper('A4', 'portrait');
      $this->dompdf->render();
      $output = $this->dompdf->output();
      file_put_contents('uploads/files/payslip/' . $id . '/' . $file_name . '', $output);
      if ($output) {
        redirect(base_url('uploads/files/payslip/' . $id . '/' . $file_name . ''));
        //$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
      } else {
        redirect(base_url('payslips/pdf_falut/'));
      }
    } else {
      $this->session->set_flashdata('ntf3', lang('you_dont_have_permission'));
      redirect(base_url('hr/payslips'));
    }
  }

  function pdf_fault()
  {
    $result = array(
      'status' => false,
    );
    echo json_encode($result);
  }
}
