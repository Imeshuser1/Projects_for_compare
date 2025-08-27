<?php include_once(FCPATH . 'modules/hr/views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div id="pageContent">
  <div class="ciuis-body-content" ng-controller="Payslips_Controller">
    <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
      <div class="panel-default">
        <div class="ciuis-invoice-summary"></div>
      </div>
      <?php if ($this->session->userdata('other')) { ?>
        <div class="panel-default">
          <div class="ciuis-invoice-summary"></div>
        </div>
      <?php } ?>
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('payslip'); ?> <small>(<span ng-bind="payslips.length"></span>)</small><br><small flex md-truncate><?php echo lang('organizeyourpayslips'); ?></small></h2>
          <!-- <div class="ciuis-external-search-in-table">
            <input ng-model="payslip_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by') . ' ' . lang('customer') ?>">
            <md-button class="md-icon-button" aria-label="Search" ng-cloak>
              <md-icon><i class="ion-search text-muted"></i></md-icon>
            </md-button>
          </div> -->
          <!-- <md-menu md-position-mode="target-right target">
            <md-button class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
              <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
              <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4" ng-cloak>
              <md-contet layout-padding>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.staff" ng-change="updateColumns('staff', table_columns.staff);">
                  <?php echo lang('staff') . ' ' . lang('name') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.start_date" ng-change="updateColumns('start_date', table_columns.start_date);">
                  <?php echo lang('start') . ' ' . lang('date') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.end_date" ng-change="updateColumns('end_date', table_columns.end_date);">
                  <?php echo lang('end') . ' ' . lang('date') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.base_salary" ng-change="updateColumns('base_salary', table_columns.base_salary);">
                  <?php echo lang('base') . ' ' . lang('salary') ?>
                </md-checkbox><br>


              </md-contet>
            </md-menu-content>
          </md-menu> -->
          <!-- <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
            <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
          </md-button> -->
        </div>
      </md-toolbar>
      <div ng-show="payslipLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span>
            <?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('payslips') . '...' ?></strong></small>
          </span>
        </p>
      </div>
      <md-content ng-show="!payslipLoader" class="bg-white" ng-cloak>
        <md-table-container ng-show="payslips.length > 0">
          <table md-table md-progress="promise">
            <thead md-head md-order="payslip_list.order">
              <tr md-row>
                <th md-column><span><?php echo lang('payslip'); ?></span></th>
                <th md-column md-order-by="payslip_staff_name"><span><?php echo lang('staff') . ' ' . lang('name'); ?></span></th>
                <th md-column md-order-by="payslip_start_date_stamp"><span><?php echo lang('start_date'); ?></span></th>
                <th md-column md-order-by="payslip_end_date_stamp"><span><?php echo lang('end_date'); ?></span></th>
                <th md-column md-order-by="payslip_base_salary_float"><span><?php echo lang('base_salary'); ?></span></th>
              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="payslip in payslips | orderBy: payslip_list.order | limitTo: payslip_list.limit : (payslip_list.page -1) * payslip_list.limit | filter: payslip_search | filter: FilteredData" class="cursor">
                <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('hr/payslips/payslip/') ?>{{payslip.payslip_id}}"> <span ng-bind="payslip.payslip_number"></span></a>
                  </strong><br>
                </td>
                <td md-cell>
                  <strong><span ng-bind="payslip.payslip_staff_name"></span></strong>
                </td>
                <td md-cell>
                  <strong><span ng-bind="payslip.payslip_start_date"></span></strong>
                </td>
                <td md-cell>
                  <strong><span ng-bind="payslip.payslip_end_date"></span></strong>
                </td>
                <td md-cell>
                  <strong><span ng-bind="payslip.payslip_base_salary"></span></strong>
                </td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="payslips.length > 0" md-limit="payslip_list.limit" md-limit-options="limitOptions" md-page="payslip_list.page" md-total="{{payslips.length}}"></md-table-pagination>
        <md-content ng-show="!payslips.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
      </md-content>
    </div>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
      <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close">
            <i class="ion-android-arrow-forward"></i>
          </md-button>
          <md-truncate><?php echo lang('filter') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content layout-padding="">
        <div ng-repeat="(prop, ignoredValue) in payslips[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'prefix' && prop != 'longid' && prop != 'created' && prop != 'duedate' && prop != 'customer' && prop != 'total' && prop != 'status' && prop != 'color' && prop != 'customer_id' && prop != 'staff_id' && prop != 'recurring_status' && prop != 'staff'">
          <div class="filter col-md-12">
            <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
            <hr>
            <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>'">
              <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
            </div>
            <div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
              <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
                <md-option value="all"><?php echo lang('all') ?></md-option>
                <md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
              </md-select>
            </div>
          </div>
        </div>
      </md-content>
    </md-sidenav>
  </div>
  <ciuis-sidebar></ciuis-sidebar>
  <?php include_once(FCPATH . 'modules/hr/views/inc/footer.php'); ?>
  <script src="<?php echo base_url('modules/hr/assets/js/Hrm.js'); ?>"></script>
  <script src="<?php echo base_url('modules/hr/assets/js/payslips.js'); ?>"></script>
</div>