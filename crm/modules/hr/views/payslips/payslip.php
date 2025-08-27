<?php include_once(FCPATH . 'modules/hr/views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Payslip_Controller">
  <div class="main-content container-fluid col-md-9">
    <!-- <div ng-show="invoiceLoader" layout-align="center center" class="text-center" id="circular_loader">
          <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
            <p style="font-size: 15px;margin-bottom: 5%;">
             <span>
                <?php echo lang('please_wait') ?> <br>
               <small><strong><?php echo lang('loading') . ' ' . lang('payslip') . '...' ?></strong></small>
             </span>
           </p>
         </div> -->
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate ng-bind="payslip.payslip_number"></h2>
        <!-- ng-href="<?php //echo base_url('invoices/send_email/{{invoice.id}}')
                      ?>" -->
        <md-button ng-click="send()" class="md-icon-button" aria-label="Email" ng-cloak>
          <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip column-definition="" ng-hide="sendingEmail == true" md-direction="bottom"><?= lang('send'); ?></md-tooltip>
          <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
        </md-button>
        <md-button ng-href="<?php echo base_url('hr/payslips/print_/{{payslip.payslip_id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak  ng-disabled="!payslip.payslip_id">
          <md-tooltip column-definition="" md-direction="bottom"><?= lang('print'); ?></md-tooltip>
          <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('payslips', 'edit') || check_privilege('payslips', 'delete')) { ?>
          <?php if (check_privilege('payslips', 'delete')) { ?>
            <md-button ng-click="Delete()" class="md-icon-button" aria-label="Delete" ng-cloak>
              <md-tooltip column-definition="" md-direction="bottom"><?= lang('delete'); ?></md-tooltip>
              <md-icon style="margin: auto 3px auto 0;"><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>
          <?php } ?>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white invoice">
      <div class="invoice-header col-md-12">
        <div class="invoice-from col-md-4 col-xs-12"> <small class="text-uppercase"><?= lang('staff'); ?></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payslip.staff_name"></strong><br>
            <span ng-bind="payslip.staff_email"></span><br>
            <span ng-bind="payslip.staff_phone"></span><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase"><?= lang('payslip') . ' ' . lang('date'); ?></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payslip.payslip_start_date"></strong><br>
          </address>
        </div>
        <!-- <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase"><?= lang('end_date'); ?></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payslip.payslip_end_date"></strong><br>
          </address>
        </div> -->
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
                <tr ng-repeat="allowance in payslip.allowances">
                  <td><span ng-bind="allowance.payslip_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{allowance.payslip_item_description}}</pre>
                  </td>
                  <td><span ng-bind="allowance.payslip_item_time_des"></span></td>
                  <td ng-bind="allowance.payslip_item_quantity"></td>
                  <td ng-bind-html="allowance.payslip_item_price | currencyFormat:cur_code:null:true:cur_lct"></td>
                  <td ng-bind-html="allowance.payslip_item_total | currencyFormat:cur_code:null:true:cur_lct"></td>
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
                <tr ng-repeat="deduction in payslip.deductions">
                  <td><span ng-bind="deduction.payslip_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{deduction.payslip_item_description}}</pre>
                  </td>
                  <td><span ng-bind="deduction.payslip_item_time_des"></span></td>
                  <td ng-bind="deduction.payslip_item_quantity"></td>
                  <td ng-bind-html="deduction.payslip_item_price | currencyFormat:cur_code:null:true:cur_lct"></td>
                  <td ng-bind-html="deduction.payslip_item_total | currencyFormat:cur_code:null:true:cur_lct"></td>
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
                <div class="sub-price"> <small><?= lang('base_salary'); ?></small> <span ng-bind-html="payslip.payslip_base_salary | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-plus-round"></i> </div>
                <div class="sub-price"> <small><?= lang('total') . ' ' . lang('allowance'); ?></small> <span ng-bind-html="payslip.payslip_total_allowance | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-minus-round"></i> </div>
                <div class="sub-price"> <small><?= lang('total') . ' ' . lang('deduction'); ?></small> <span ng-bind-html="payslip.payslip_total_deduction | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
              </div>
            </div>
            <div class="invoice-price-right"> <small><?= lang('grandtotal'); ?></small> <span ng-bind-html="payslip.payslip_grand_total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
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
            <h2 flex md-truncate class="text-bold"><?php echo lang('payments'); ?><br>
              <small flex md-truncate><?php echo lang('paymentspayslip'); ?></small>
            </h2>
            <?php if (check_privilege('payslips', 'edit')) { ?>
              <md-button ng-cloak ng-show="payslip.balance != 0 && payslip.status_id != 1" ng-click="RecordPayment()" class="md-icon-button" aria-label="Record Payment">
                <md-tooltip md-direction="left"><?php echo lang('recordpayment') ?></md-tooltip>
                <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
              </md-button>
            <?php } ?>
          </div>
        </md-toolbar>
        <md-content class="bg-white">
          <div>
            <h2 flex class="pull-left md-toolbar-tools"><span><?= lang('balance'); ?></span> : <span ng-bind-html="payslip.balance | currencyFormat:cur_code:null:true:cur_lct"></span></h2>
          </div>
        </md-content>
        <md-content class="bg-white">
          <md-content ng-show="!payslip.payments.length" class="md-padding no-item-payment bg-white"></md-content>
          <md-list flex>
            <md-list-item class="md-2-line" ng-repeat="payment in payslip.payments">
              <md-icon class="ion-arrow-down-a text-muted"></md-icon>
              <div class="md-list-item-text">
                <h3 ng-bind="payment.name"></h3>
                <p ng-bind-html="payment.amount | currencyFormat:cur_code:null:true:cur_lct"></p>
              </div>
              <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="doSecondaryAction($event)" aria-label="call">
                <md-icon class="ion-ios-search-strong"></md-icon>
              </md-button>
              <md-divider></md-divider>
            </md-list-item>
          </md-list>
        </md-content>
      </md-content>
    </md-content>
  </div>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="RecordPayment" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward" ng-cloak></i> </md-button>
        <md-truncate><?php echo lang('recordpayment') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <form name="InvoiceRecordPayment">
        <md-content layout-padding>
          <md-input-container class="md-block">
            <label><?php echo lang('datepayment') ?></label>
            <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" show-icon="true" ng-model="date" class=" dtp-no-msclear dtp-input md-input">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('amount') ?></label>
            <input required type="number" name="amount" ng-model="amount" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('description') ?></label>
            <textarea required name="not" ng-model="not" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
          </md-input-container>
          <section layout="row" layout-sm="column" layout-align="center right" layout-wrap>
            <md-button ng-click="AddPayment()" class="md-raised md-primary pull-right template-button" ng-disabled="doing == true">
              <span ng-hide="doing == true"><?php echo lang('save'); ?></span>
              <md-progress-circular class="white" ng-show="doing == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
            <!-- <md-button ng-click="AddPayment()" class="md-raised md-primary pull-right" ng-bind="lang.save"></md-button> -->
          </section>
        </md-content>
      </form>
    </md-content>
  </md-sidenav>
  <script>
    var PAYSLIPID = <?php echo $payslips['payslip_id']; ?>;
  </script>
</div>
<?php include_once(FCPATH . 'modules/hr/views/inc/footer.php'); ?>
<script src="<?php echo base_url('modules/hr/assets/js/Hrm.js'); ?>"></script>
<script src="<?php echo base_url('modules/hr/assets/js/payslips.js'); ?>"></script>