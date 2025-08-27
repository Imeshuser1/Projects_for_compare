<?php include_once(FCPATH . 'modules/hr/views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Payroll_Controller">
  <div class="main-content container-fluid col-md-9">
    <!-- <div ng-show="invoiceLoader" layout-align="center center" class="text-center" id="circular_loader">
          <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
            <p style="font-size: 15px;margin-bottom: 5%;">
             <span>
                <?php echo lang('please_wait') ?> <br>
               <small><strong><?php echo lang('loading') . ' ' . lang('payroll') . '...' ?></strong></small>
             </span>
           </p>
         </div> -->
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate ng-bind="payroll.payroll_number"></h2>
        <!-- ng-href="<?php //echo base_url('invoices/send_email/{{invoice.id}}')
                      ?>" -->
        <md-button ng-click="convert_payroll( <?php echo $payrolls['payroll_id']; ?> )" class="md-icon-button" aria-label="Convert to Payslip" ng-cloak  ng-disabled="!payroll.payroll_id">
          <md-progress-circular ng-show="convertingPayroll == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip column-definition="" ng-hide="convertingPayroll == true" md-direction="bottom" ng-cloak><?= lang('convert'); ?></md-tooltip>
          <md-icon ng-hide="convertingPayroll == true"><i class="ion-loop text-success"></i></md-icon>
        </md-button>
        <!-- <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
          <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip column-definition="" ng-hide="sendingEmail == true" md-direction="bottom" ng-cloak><?= lang('send'); ?></md-tooltip>
          <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
        </md-button> -->
        <!--
        <md-button ng-show="payroll.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip column-definition="" md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-show="payroll.pdf_status == '1'" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip column-definition="" md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button> -->
        <md-button ng-href="<?php echo base_url('hr/payrolls/print_/{{payroll.payroll_id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak ng-disabled="!payroll.payroll_id">
          <md-tooltip column-definition="" md-direction="bottom" ng-cloak><?= lang('print'); ?></md-tooltip>
          <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('payrolls', 'edit') || check_privilege('payrolls', 'delete')) { ?>
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <?php if (check_privilege('payrolls', 'edit')) { ?>
                <md-menu-item>
                  <md-button ng-click="UpdatePayroll(payroll.payroll_id)">
                    <div layout="row" flex>
                      <p flex><?= lang('update'); ?></p>
                      <md-icon md-menu-align-target class="mdi mdi-edit" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php }
              if (check_privilege('payrolls', 'delete')) { ?>
                <md-menu-item>
                  <md-button ng-click="Delete()">
                    <div layout="row" flex>
                      <p flex><?= lang('delete'); ?></p>
                      <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } ?>
            </md-menu-content>
          </md-menu>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white invoice">
      <div class="invoice-header col-md-12">
        <div class="invoice-from col-md-4 col-xs-12"> <small class="text-uppercase" ng-bind="lang.staff"></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payroll.staff_name"></strong><br>
            <span ng-bind="payroll.staff_email"></span><br>
            <span ng-bind="payroll.staff_phone"></span><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase"><?= lang('start_date'); ?></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payroll.payroll_start_date"></strong><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase"><?= lang('end_date'); ?></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payroll.payroll_end_date"></strong><br>
          </address>
        </div>
      </div>


    </md-content>
    <md-content class="payroll-flex">
      <md-card class="col-md-6" style="margin-left: 0;margin-right: 0;">
        <div>
          <md-card-title>
            <md-card-title-text>
              <span class="md-headline"><?php echo lang('allowance'); ?></span>
            </md-card-title-text>
          </md-card-title>
        </div>
        <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
          <div class="table-responsive">
            <table class="table table-invoice">
              <thead>
                <tr>
                  <th><?= lang('name'); ?></th>
                  <th><?= lang('time'); ?></th>
                  <th><?= lang('quantity'); ?></th>
                  <th><?= lang('price'); ?></th>
                  <th><?= lang('total'); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="allowance in payroll.allowances">
                  <td><span ng-bind="allowance.payroll_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{allowance.payroll_item_description}}</pre>
                  </td>
                  <td><span ng-bind="allowance.payroll_item_time_des"></span></td>
                  <td ng-bind="allowance.payroll_item_quantity"></td>
                  <td ng-bind-html="allowance.payroll_item_price | currencyFormat:cur_code:null:true:cur_lct"></td>
                  <td ng-bind-html="allowance.payroll_item_total | currencyFormat:cur_code:null:true:cur_lct"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </md-card>
      <md-card class="col-md-6" style="margin-left: 0;margin-right: 0;">
        <div>
          <md-card-title>
            <md-card-title-text>
              <span class="md-headline"><?php echo lang('deduction'); ?></span>
            </md-card-title-text>
          </md-card-title>
        </div>
        <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
          <div class="table-responsive">
            <table class="table table-invoice">
              <thead>
                <tr>
                  <th><?= lang('name'); ?></th>
                  <th><?= lang('time'); ?></th>
                  <th><?= lang('quantity'); ?></th>
                  <th><?= lang('price'); ?></th>
                  <th><?= lang('total'); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="deduction in payroll.deductions">
                  <td><span ng-bind="deduction.payroll_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{deduction.payroll_item_description}}</pre>
                  </td>
                  <td><span ng-bind="deduction.payroll_item_time_des"></span></td>
                  <td ng-bind="deduction.payroll_item_quantity"></td>
                  <td ng-bind-html="deduction.payroll_item_price | currencyFormat:cur_code:null:true:cur_lct"></td>
                  <td ng-bind-html="deduction.payroll_item_total | currencyFormat:cur_code:null:true:cur_lct"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </md-card>
    </md-content>
    <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
      <md-content class="row">
        <md-card>
          <div class="invoice-price">
            <div class="invoice-price-left">
              <div class="invoice-price-row">
                <div class="sub-price"> <small><?= lang('base_salary'); ?></small> <span ng-bind-html="payroll.payroll_base_salary | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-plus-round"></i> </div>
                <div class="sub-price"> <small><?= lang('total') . ' ' . lang('allowance'); ?></small> <span ng-bind-html="payroll.payroll_total_allowance | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-minus-round"></i> </div>
                <div class="sub-price"> <small><?= lang('total') . ' ' . lang('deduction'); ?></small> <span ng-bind-html="payroll.payroll_total_deduction | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
              </div>
            </div>
            <div class="invoice-price-right"> <small><?= lang('grandtotal'); ?></small> <span ng-bind-html="payroll.payroll_grand_total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
          </div>
        </md-card>
      </md-content>
    </div>
  </div>
  <div class="main-content container-fluid col-md-3 md-pl-0 left-area">
    <md-content class="bg-white">
      <md-content class="bg-white">
        <md-toolbar class="toolbar-white">
          <div class="md-toolbar-tools">
            <h2 flex md-truncate class="pull-left"><strong><span><?= lang('base_salary') . ' : ' ?></span><span ng-bind-html="payroll.payroll_base_salary | currencyFormat:cur_code:null:true:cur_lct"></span></strong></h2>
          </div>
        </md-toolbar>
        <md-toolbar class="toolbar-white">
          <div class="md-toolbar-tools">
            <h2 flex md-truncate class="pull-left"><strong><span><?= lang('payslips') . ' ' . lang('generated'); ?></span></strong></h2>
          </div>
        </md-toolbar>
        <!-- <div class="list-items">
          <div class="list" ng-if="payslips.length > 0" ng-repeat="payslip in payslips">
            <md-icon><i class="ico-ciuis-staffdetail" style="font-size: 22px"></i> </md-icon>
            <a ng-click="show_payslip(payslip.payslip_id)"><span ng-bind="payslip.payslip_id"></span></a> (<span ng-bind="payslip.payslip_created"></span>)
          </div>
        </div> -->
        <md-table-container ng-cloak ng-show="payslips.length > 0">
          <table md-table>
            <thead md-head>
              <tr md-row>
                <th md-column><span><?= lang('payslip'); ?></span></th>
                <th md-column><span><?= lang('total_s'); ?></span></th>
                <th md-column><span><?= lang('createddate'); ?></span></th>
              </tr>
            </thead>
            <tbody md-body ng-cloak>
              <tr class="select_row cursor payslip_row" ng-show="payslips.length > 0" ng-repeat="payslip in payslips">
                <td md-cell><a href="<?= base_url('hr/payslips/payslip/'); ?>{{payslip.payslip_id}}"><strong ng-bind="payslip.payslip_number"></strong></a></td>
                <td md-cell><span ng-bind-html="payslip.payslip_grand_total | currencyFormat:cur_code:null:true:cur_lct"></span></td>
                <td md-cell><span ng-bind="payslip.payslip_created"></span></td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
      </md-content>
    </md-content>
  </div>
  <script>
    var PAYROLLID = <?php echo $payrolls['payroll_id']; ?>;
  </script>



</div>
<?php include_once(FCPATH . 'modules/hr/views/inc/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('modules/hr/assets/js/Hrm.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('modules/hr/assets/js/payrolls.js') ?>"></script>