<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Payrolls_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white" ng-cloak>
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Payroll" ng-disabled="true">
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('new') . ' ' . lang('payroll') ?></h2>
        <!-- <md-switch ng-model="payroll_status" aria-label="Status"><strong
            class="text-muted"><?php echo lang('paid') ?></strong></md-switch> -->
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
    <div class="row" style="margin: auto;">
      <md-card class="col-md-6" style="margin-left: 0;margin-right: 0;">
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline"><?php echo lang('allowance'); ?></span>
          </md-card-title-text>
        </md-card-title>
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
                <input class="min_input_width" ng-value="allowance.quantity * allowance.price">
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

      <md-card class="col-md-6" style="margin-left: 0;margin-right: 0;">
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline"><?php echo lang('deduction'); ?></span>
          </md-card-title-text>
        </md-card-title>
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
                <input class="min_input_width" ng-value="deduction.quantity * deduction.price">
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
  <!-- <div class="main-content container-fluid lg-pl-0 col-xs-12 col-md-12 col-lg-3" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('billing_and_shipping_details') ?></h2>
      </div>
    </md-toolbar>
    <md-subheader class="md-primary bg-white text-uppercase text-bold"><?php echo lang('billing_address') ?></md-subheader>
    <md-divider></md-divider>
    <md-content layout-padding class="bg-white" ng-cloak>
      <address class="m-t-5 m-b-5">
        <strong ng-bind="invoice.billing_street"></strong><br>
        <span ng-bind="invoice.billing_city"></span> / <span ng-bind="invoice.billing_state"></span> <span ng-bind="invoice.billing_zip"></span><br>
        <strong ng-bind="invoice.billing_country"></strong>
        <bind-expression ng-init="customer.billing_street = '------'" expression="customer.billing_street" ng-model="invoice.billing_street" />
        <bind-expression ng-init="customer.billing_city = ',---- '" expression="customer.billing_city" ng-model="invoice.billing_city" />
        <bind-expression ng-init="customer.billing_state = ',----'" expression="customer.billing_state" ng-model="invoice.billing_state" />
        <bind-expression ng-init="customer.billing_zip = '----'" expression="customer.billing_zip" ng-model="invoice.billing_zip" />
        <bind-expression ng-init="customer.billing_country = '----'" expression="customer.billing_country" ng-model="invoice.billing_country" />
      </address>
      <md-content ng-if='EditBilling == true' layout-padding class="bg-white" ng-cloak>
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="invoice.billing_street" md-maxlength="500" rows="2" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="invoice.billing_country_id" ng-change="getBillingStates(invoice.billing_country_id)" name="billing_country"  style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
           <br/>
        </md-input-container>
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="invoice.billing_state_id" name="billing_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in billingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="invoice.billing_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="invoice.billing_zip">
        </md-input-container>

        <bind-expression ng-init="invoice.billing_country = '----'" expression="customer.billing_country" ng-model="invoice.billing_country" />
      </md-content>
      <md-switch ng-model="NeedShippingAddress" aria-label="Status"><strong class="text-muted"><?php echo lang('need_shipping_address') ?></strong></md-switch>
      <md-button ng-show='EditBilling == false' ng-click="EditBilling = true" ng-init="EditBilling=false" class="md-icon-button pull-right" aria-label="Edit">
        <md-icon><i class="mdi mdi-edit text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('edit') ?></md-tooltip>
      </md-button>
      <md-button ng-show='EditBilling == true' ng-click="EditBilling = false" class="md-icon-button pull-right" aria-label="Hide Billing Form">
        <md-icon><i class="mdi mdi-minus-circle-outline text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('hide') ?></md-tooltip>
      </md-button>
      <md-button ng-click='CopyBillingFromCustomer()' class="md-icon-button pull-right" aria-label="Billing Copy">
        <md-icon><i class="mdi mdi-copy text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('copy_from_customer') ?></md-tooltip>
      </md-button>
    </md-content>
    <md-divider></md-divider>
    <md-subheader ng-show='NeedShippingAddress == true' class="md-primary bg-white text-uppercase text-bold"><?php echo lang('shipping_address') ?></md-subheader>
    <md-divider ng-show='NeedShippingAddress == true'></md-divider>
    <md-content  ng-show='NeedShippingAddress == true' layout-padding class="bg-white" ng-cloak>
      <address ng-hide='EditShipping == true' class="m-t-5 m-b-5">
      <strong ng-bind="invoice.shipping_street"></strong><br>
      <span ng-bind="invoice.shipping_city"></span> / <span ng-bind="invoice.shipping_state"></span> <span ng-bind="invoice.shipping_zip"></span><br>
      <strong ng-bind="invoice.shipping_country"></strong>
      <bind-expression ng-init="customer.shipping_street = '------'" expression="customer.shipping_street" ng-model="invoice.shipping_street" />
      <bind-expression ng-init="customer.shipping_city = ',---- '" expression="customer.shipping_city" ng-model="invoice.shipping_city" />
      <bind-expression ng-init="customer.shipping_state = ',----'" expression="customer.shipping_state" ng-model="invoice.shipping_state" />
      <bind-expression ng-init="customer.shipping_zip = '----'" expression="customer.shipping_zip" ng-model="invoice.shipping_zip" />
      <bind-expression ng-init="customer.shipping_country = '----'" expression="customer.shipping_country" ng-model="invoice.shipping_country" />
      </address>
      <md-content ng-show='EditShipping == true' layout-padding class="bg-white" ng-cloak>
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="invoice.shipping_street" md-maxlength="500" rows="2" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="invoice.shipping_country_id"  ng-change="getShippingStates(invoice.shipping_country_id)" name="shipping_country" style="min-width: 200px;">
            <md-option ng-value="{{country.id}}" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
          <br />
        </md-input-container>        
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="invoice.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="invoice.shipping_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="invoice.shipping_zip">
        </md-input-container>

        <bind-expression ng-init="invoice.shipping_country = '----'" expression="customer.shipping_country" ng-model="invoice.shipping_country" />
      </md-content>
      <md-button ng-show='EditShipping == false' ng-click="EditShipping = true" ng-init="EditShipping=false" class="md-icon-button pull-right" aria-label="Edit">
        <md-icon><i class="mdi mdi-edit text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('edit'); ?></md-tooltip>
      </md-button>
      <md-button ng-show='EditShipping == true' ng-click="EditShipping = false" class="md-icon-button pull-right" aria-label="Hide Form">
        <md-icon><i class="mdi mdi-minus-circle-outline text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('hide'); ?></md-tooltip>
      </md-button>
      <md-button ng-click='CopyShippingFromCustomer()'  class="md-icon-button pull-right" aria-label="Cop Shipping">
        <md-icon><i class="mdi mdi-copy text-muted"></i></md-icon>
        <md-tooltip md-direction="left"><?php echo lang('copy_from_customer'); ?></md-tooltip>
      </md-button>
    </md-content>
    <md-content class="bg-white">
      <custom-fields-vertical></custom-fields-vertical>
    </md-content>
    <md-divider></md-divider>
  </div> -->
</div>
<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/payrolls.js'); ?>"></script>