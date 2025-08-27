<?php include_once(FCPATH . 'modules/hr/views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Payrolls_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white" ng-cloak>
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Payroll" ng-disabled="true">
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('new') . ' ' . lang('payroll') ?></h2>
        <md-switch ng-model="payroll_recurring" aria-label="Recurring"> <strong class="text-muted"><?php echo lang('recurring') ?></strong> </md-switch>
        <md-button ng-href="<?php echo base_url('payrolls') ?>" class="md-icon-button" aria-label="Save">
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-danger"></i></md-icon>
        </md-button>
        <md-button type="submit" ng-click="saveAll()" class="md-icon-button" aria-label="Save">
          <md-progress-circular ng-show="savingPayroll == true" md-mode="indeterminate" md-diameter="20">
          </md-progress-circular>
          <md-tooltip ng-hide="savingPayroll == true" md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
          <md-icon ng-hide="savingPayroll == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <!-- <div  layout-align="center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
         <span>
            <?php echo lang('please_wait') ?> <br>
           <small><strong><?php echo lang('loading') . '...' ?></strong></small>
         </span>
       </p>
    </div> -->
    <md-content class="bg-white" layout-padding ng-cloak>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('staff'); ?></label>
          <md-select ng-model="member" data-md-container-class="selectdemoSelectHeader">
            <md-option ng-value="member" ng-repeat="member in staff">{{member.name}}
            </md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('expense') . ' ' . lang('category'); ?></label>
          <md-select placeholder="<?php echo lang('expense') . ' ' . lang('category'); ?>" ng-model="expense_category" name="expense_categories" style="min-width: 200px;">
            <md-option ng-value="expense_category.id" ng-repeat="expense_category in expense_categories">
              {{expense_category.name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container>
          <label><?php echo lang('start') . ' ' . lang('date') ?></label>
          <md-datepicker name="startdate" ng-model="startdate" md-open-on-focus></md-datepicker>
        </md-input-container>
      </div>
      <div layout-gt-xs="row">

        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('base') . ' ' . lang('salary') ?></label>
          <input type="number" ng-model="base_salary" name="base_salary">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('paidcashornank'); ?></label>
          <md-select placeholder="<?php echo lang('choiseaccount'); ?>" ng-model="account" name="account" style="min-width: 200px;">
            <md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
          </md-select>
          <div ng-messages="userForm.customer" role="alert" multiple>
            <div ng-message="required" class="my-message"><?php echo lang('you_must_supply_a_customer') ?></div>
          </div>
        </md-input-container>
        <md-input-container>
          <label><?php echo lang('run') . ' ' . lang('day') ?></label>
          <md-select ng-model="run_day" placeholder="<?php echo lang('dayofmonth') ?>">
            <md-option ng-value="run_day" ng-repeat="run_day in run_days">{{run_day}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container>
          <label><?php echo lang('end') . ' ' . lang('date') ?></label>
          <md-datepicker name="enddate" ng-model="enddate" md-open-on-focus></md-datepicker>
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('payrollnote') ?></label>
          <input ng-model="payrollnote" name="payrollnote">
        </md-input-container>
      </div>

    </md-content>
    <div class="row payroll-flex" style="margin: auto;">
      <md-card class="col-md-6 payroll-col" style="margin-left: 0;margin-right: 0;">
        <div>
          <md-card-title>
            <md-card-title-text>
              <span class="md-headline"><?php echo lang('allowance'); ?></span>
            </md-card-title-text>
          </md-card-title>
        </div>
        <md-content class="bg-white" layout-padding ng-cloak>
          <md-list-item ng-repeat="allowance in payroll.allowances">
            <div layout-gt-sm="row">
              <md-input-container class="md-block">
                <label><?php echo lang('name'); ?></label>
                <input class="min_input_width" ng-model="allowance.name">
              </md-input-container>
              <md-input-container>
                <label><?php echo lang('description'); ?></label>
                <textarea class="min_input_width" ng-model="allowance.description" placeholder="<?php echo lang('description'); ?>"></textarea>
              </md-input-container>
              <md-input-container>
                <label><?php echo lang('type'); ?></label>
                <md-select ng-model="allowance.time">
                  <md-option ng-value="30"><?= lang('daily');?></md-option>
                  <md-option ng-value="1"><?= lang('monthly');?></md-option>
                </md-select>
              </md-input-container>
              <md-input-container class="md-block" flex-gt-sm>
                <label><?php echo lang('quantity'); ?></label>
                <input class="min_input_width" ng-model="allowance.quantity">
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('price'); ?></label>
                <input class="min_input_width" ng-model="allowance.price">
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('total'); ?></label>
                <input class="min_input_width" ng-value="allowance.quantity * allowance.price * allowance.time">
              </md-input-container>
            </div>
            <md-icon aria-label="Remove Line" ng-click="remove_allowance($index)" class="md-secondary ion-trash-b text-muted">
            </md-icon>
          </md-list-item>
          <md-content class="bg-white" layout-padding ng-cloak>
            <div class="col-md-6">
              <md-button ng-click="add_allowance()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
                <md-icon class="ion-plus-round text-muted"></md-icon>
              </md-button>
            </div>
            <div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
              <div class="col-md-7">
                <div class="text-right text-uppercase text-muted"><?php echo lang('allowancetotal') ?></div>
                <div ng-show="allowancetotal() > 0" class="text-right text-uppercase text-muted"></div>
              </div>
              <div class="col-md-5">
                <div class="text-right" ng-bind-html="allowancetotal() | currencyFormat:cur_code:null:true:cur_lct">
                </div>
              </div>
            </div>
          </md-content>
        </md-content>
      </md-card>

      <md-card class="col-md-6 payroll-col" style="margin-left: 0;margin-right: 0;">
        <div>
          <md-card-title>
            <md-card-title-text>
              <span class="md-headline"><?php echo lang('deduction'); ?></span>
            </md-card-title-text>
          </md-card-title>
        </div>
        <md-content class="bg-white" layout-padding ng-cloak>
          <md-list-item ng-repeat="deduction in payroll.deductions">
            <div layout-gt-sm="row">
              <md-input-container class="md-block">
                <label><?php echo lang('name'); ?></label>
                <input class="min_input_width" ng-model="deduction.name">
              </md-input-container>
              <md-input-container>
                <label><?php echo lang('description'); ?></label>
                <textarea class="min_input_width" ng-model="deduction.description" placeholder="<?php echo lang('description'); ?>"></textarea>
              </md-input-container>
              <md-input-container>
                <label><?php echo lang('type'); ?></label>
                <md-select ng-model="deduction.time">
                  <md-option ng-value="30"><?= lang('daily');?></md-option>
                  <md-option ng-value="1"><?= lang('monthly');?></md-option>
                </md-select>
              </md-input-container>
              <md-input-container class="md-block" flex-gt-sm>
                <label><?php echo lang('quantity'); ?></label>
                <input class="min_input_width" ng-model="deduction.quantity">
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('price'); ?></label>
                <input class="min_input_width" ng-model="deduction.price">
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('total'); ?></label>
                <input class="min_input_width" ng-value="deduction.quantity * deduction.price * deduction.time">
              </md-input-container>
            </div>
            <md-icon aria-label="Remove Line" ng-click="remove_deduction($index)" class="md-secondary ion-trash-b text-muted">
            </md-icon>
          </md-list-item>
          <md-content class="bg-white" layout-padding ng-cloak>
            <div class="col-md-6">
              <md-button ng-click="add_deduction()" class="md-fab pull-left md-hue-2" ng-disabled="false" aria-label="Add Line">
                <md-icon class="ion-plus-round text-muted"></md-icon>
              </md-button>
            </div>
            <div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
              <div class="col-md-7">
                <div class="text-right text-uppercase text-muted"><?php echo lang('deductiontotal') ?></div>
                <div ng-show="deductiontotal() > 0" class="text-right text-uppercase text-muted"></div>
              </div>
              <div class="col-md-5">
                <div class="text-right" ng-bind-html="deductiontotal() | currencyFormat:cur_code:null:true:cur_lct">
                </div>
              </div>
            </div>
          </md-content>
        </md-content>
      </md-card>
    </div>
    <md-content>
      <md-card class="margin: 0px 0px 0px 0px!important;">
        <md-content class="bg-white" layout-padding ng-cloak>
          <div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
            <div class="col-md-7">
              <div class="text-right text-uppercase text-black"><?php echo lang('grandtotal') ?></div>
            </div>
            <div class="col-md-5">
              <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
            </div>
          </div>
        </md-content>
      </md-card>
    </md-content>
  </div>

</div>
<?php include_once(FCPATH . 'modules/hr/views/inc/footer.php'); ?>
<script src="<?php echo base_url('modules/hr/assets/js/Hrm.js'); ?>"></script>
<script src="<?php echo base_url('modules/hr/assets/js/payrolls.js'); ?>"></script>