<?php include_once(APPPATH . 'views/inc/header.php'); ?>
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
        <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
          <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip column-definition="" ng-hide="sendingEmail == true" md-direction="bottom" ng-bind="lang.send"></md-tooltip>
          <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
        </md-button>

       <!--  <md-button ng-show="payslip.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-show="payslip.pdf_status == '1'" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button> -->
        <md-button ng-href="<?php echo base_url('hrm/print_payslip_/{{payslip.payslip_id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak>
          <md-tooltip column-definition="" md-direction="bottom" ng-bind="lang.print"></md-tooltip>
          <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('hrm', 'edit') || check_privilege('hrm', 'delete')) { ?>
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <?php if (check_privilege('hrm', 'delete')) { ?>
                <md-menu-item>
                  <md-button ng-click="Delete()">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.delete"></p>
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
            <strong ng-bind="payslip.staff_name"></strong><br>
            <span ng-bind="payslip.staff_email"></span><br>
            <span ng-bind="payslip.staff_phone"></span><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase" ng-bind="lang.start +' '+ lang.date"></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payslip.payslip_start_date"></strong><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase" ng-bind="lang.end +' '+ lang.date"></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="payslip.payslip_end_date"></strong><br>
          </address>
        </div>
      </div>


    </md-content>
    <md-content>
      <md-card class="col-md-6" style="margin-left: 0;margin-right: 0;">
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline"><?php echo lang('allowance'); ?></span>
          </md-card-title-text>
        </md-card-title>
        <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
          <div class="table-responsive">
            <table class="table table-invoice">
              <thead>
                <tr>
                  <th ng-bind="lang.name"></th>
                  <th ng-bind="lang.quantity"></th>
                  <th ng-bind="lang.price"></th>
                  <th ng-bind="lang.total"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="allowance in payslip.allowances">
                  <td><span ng-bind="allowance.payslip_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{allowance.payslip_item_description}}</pre>
                  </td>
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
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline"><?php echo lang('deduction'); ?></span>
          </md-card-title-text>
        </md-card-title>
        <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
          <div class="table-responsive">
            <table class="table table-invoice">
              <thead>
                <tr>
                  <th ng-bind="lang.name"></th>
                  <th ng-bind="lang.quantity"></th>
                  <th ng-bind="lang.price"></th>
                  <th ng-bind="lang.total"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="deduction in payslip.deductions">
                  <td><span ng-bind="deduction.payslip_item_name"></span><br>
                    <pre class="pre_view" ng-cloak>{{deduction.payslip_item_description}}</pre>
                  </td>
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
                <div class="sub-price"> <small ng-bind="lang.base +' '+ lang.salary"><?=lang('base_salary');?></small> <span ng-bind-html="payslip.payslip_base_salary | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-plus-round"></i> </div>
                <div class="sub-price"> <small ng-bind="lang.total+' '+lang.allowance"></small> <span ng-bind-html="payslip.payslip_total_allowance | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                <div class="sub-price"> <i class="ion-minus-round"></i> </div>
                <div class="sub-price"> <small ng-bind="lang.total+' '+lang.deduction"></small> <span ng-bind-html="payslip.payslip_total_deduction | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
              </div>
            </div>
            <div class="invoice-price-right"> <small ng-bind="lang.grandtotal"></small> <span ng-bind-html="payslip.payslip_grand_total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
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
            <?php if (!$this->session->userdata('other')) { ?>
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
  <script type="text/ng-template" id="generate-invoice.html">
    <md-dialog aria-label="options dialog">
      <md-dialog-content layout-padding class="text-center">
        <md-content class="bg-white" layout-padding>
         <h2 class="md-title" ng-hide="PDFCreating == true"><?php echo lang('generate_pdf') ?></h2>
         <h2 class="md-title" ng-if="PDFCreating == true"><?php echo lang('report_generating') ?></h2>
         <span ng-hide="PDFCreating == false"><?php echo lang('generate_pdf_msg') ?></span><br><br>
         <span ng-if="PDFCreating == false"><?php echo lang('generate_pdf_last_msg') ?></span><br><br>
         <img ng-if="PDFCreating == true" ng-src="<?php echo base_url('assets/img/loading_time.gif') ?>" alt="">
         <a ng-if="PDFCreating == false" href="<?php echo base_url('invoices/download_pdf/' . $invoices['id'] . '') ?>"><img  width="30%" ng-src="<?php echo base_url('assets/img/download_pdf.png') ?>" alt=""></a>
        </md-content>
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button class="text-success" ng-if="PDFCreating == false" href="<?php echo base_url('invoices/download_pdf/' . $invoices['id'] . '') ?>">
          <?php echo lang('download') ?>
        </md-button>
        <md-button class="text-success" ng-hide="PDFCreating == false" ng-click="CreatePDF()"><?php echo lang('create') ?></md-button>
        <md-button class="text-danger" ng-click="CloseModal()"><?php echo lang('cancel') ?></md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
  <script type="text/ng-template" id="view_contacts.html">
    <md-dialog aria-label="options dialog">
      <md-dialog-content layout-padding class="text-center">
        <md-content class="bg-white" layout-padding>
          <md-input-container style="min-width: 300px;">
            <label><?php echo lang('customer') . ' ' . lang('contacts') ?></label>
            <md-select ng-model="customer_contacts" data-md-container-class="selectdemoSelectHeader" multiple style="min-width: 300px;">
              <md-optgroup>
                <md-option ng-repeat="contact in invoice.customer_contacts" ng-value="contact">{{contact.name}}</md-option>
              </md-optgroup>
            </md-select>
          </md-input-container>
        </md-content>
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button ng-click="CloseModal()"><?php echo lang('cancel') ?>!</md-button>
        <md-button ng-click="CloseModal()"><?php echo lang('done') ?>!</md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
  <script type="text/ng-template" id="addfile-template.html">
    <md-dialog aria-label="options dialog">
      <md-dialog-content layout-padding>
        <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
        <input type="file" required name="file_name" file-model="invoice_file">
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
        <md-button ng-click="uploadInvoiceFile()" class="template-button" ng-disabled="uploading == true">
          <span ng-hide="uploading == true"><?php echo lang('upload'); ?></span>
          <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
        </md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
  <script type="text/ng-template" id="view_image.html">
    <md-dialog aria-label="options dialog">
      <md-dialog-content layout-padding>
        <?php $path = '{{file.path}}';
        if ($path) { ?>
          <img src="<?php echo $path ?>">
        <?php } ?>
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <?php if (!$this->session->userdata('other')) { ?>
          <md-button ng-click='DeleteFiles(file.id)'><?php echo lang('delete') ?>!</md-button>
        <?php } ?>
        <md-button ng-href="<?php echo base_url('invoices/download_file/') ?>{{file.id}}"><?php echo lang('download') ?>!</md-button>
        <md-button ng-click="CloseModal()"><?php echo lang('cancel') ?>!</md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/payrolls.js') ?>"></script>