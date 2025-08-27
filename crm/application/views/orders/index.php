<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Orders_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
    <div class="panel-heading"> <strong><?php echo lang('order_situation') ?></strong> <span class="panel-subtitle"><?php echo lang('order_situations_desc') ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'1'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'1'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'2'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'3'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'4'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('revised')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'5'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'5'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('declined')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'6'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'6'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('accepted')?></span>
      </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('orders'); ?> <small>(<span ng-bind="orders.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organize_your_orders'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="order_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-menu md-position-mode="target-right target">
          <md-button class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
            <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
            <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4" ng-cloak>
            <md-contet layout-padding>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.subject" ng-change="updateColumns('subject', table_columns.subject);">
                <?php echo lang('subject') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.customer" ng-change="updateColumns('customer', table_columns.customer);">
                <?php echo lang('customer').' / '.lang('lead') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.date" ng-change="updateColumns('date', table_columns.date);">
                <?php echo lang('date') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.opentill" ng-change="updateColumns('opentill', table_columns.opentill);">
                <?php echo lang('opentill') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.assigned" ng-change="updateColumns('assigned', table_columns.assigned);">
                <?php echo lang('assigned').' '.lang('by'); ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.status" ng-change="updateColumns('status', table_columns.status);">
                <?php echo lang('status') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.total" ng-change="updateColumns('total', table_columns.total);">
                <?php echo lang('amount') ?>
              </md-checkbox><br>
            </md-contet>
          </md-menu-content>
        </md-menu>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('orders', 'create')) { ?>
          <md-button ng-href="<?php echo base_url('orders/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!orderLoader" class="bg-white" ng-cloak>
      <md-table-container ng-show="orders.length > 0">
        <table md-table md-progress="promise">
          <thead md-head md-order="order_list.order">
            <tr md-row>
              <th md-column><span><?php echo lang('order'); ?></span></th>
              <th ng-show="table_columns.customer" md-column md-order-by="customer"><span><?php echo lang('customer') . ' / ' . lang('lead') ?></span>
              </th>
              <th ng-show="table_columns.date" md-column md-order-by="date"><span><?php echo lang('date'); ?></span></th>
              <th ng-show="table_columns.opentill" md-column md-order-by="opentill"><span><?php echo lang('opentill'); ?></span></th>
              <th ng-show="table_columns.status" md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
              <th ng-show="table_columns.total" md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
               <th ng-show="table_columns.assigned" md-column md-order-by="staff"><span><?php echo lang('assigned').' '.lang('by'); ?></span></th>
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="order in orders | orderBy: order_list.order | limitTo: order_list.limit : (order_list.page -1) * order_list.limit | filter: order_search | filter: FilteredData" class="cursor" ng-click="goToLink('orders/order/'+order.id)">
              <td md-cell>
                <strong>
                  <a class="link" ng-href="<?php echo base_url('orders/order/') ?>{{order.id}}"> <span ng-bind="order.longid"></span></a>
                </strong><br>
                <small ng-show="table_columns.subject" ng-bind="order.subject"></small>
              </td>
              <td ng-show="table_columns.customer" md-cell>
                <strong><span ng-bind="order.customer"></span></strong><br>
                <span class="blur" ng-bind="order.customer_email"></span>
              </td>
              <td ng-show="table_columns.date" md-cell>
                <strong><span class="badge" ng-bind="order.date"></span></strong>
              </td>
              <td ng-show="table_columns.opentill" md-cell>
                <strong><span class="badge" ng-bind="order.opentill"></span></strong>
              </td>
              <td ng-show="table_columns.status" md-cell>
                <span class="label {{order.class}} label-default" ng-bind="order.status"></span>
              </td>
              <td ng-show="table_columns.total" md-cell>
                <strong ng-bind-html="order.total | currencyFormat:cur_code:null:true:cur_lct"></strong>
              </td>
              <td ng-show="table_columns.assigned" md-cell>
                <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{order.staff}}" class="assigned-staff-for-this-lead user-avatar">
                  <img ng-src="<?php echo base_url('uploads/images/{{order.staffavatar}}')?>" alt="{{order.staff}}">   
                  <md-tooltip md-direction="left" ng-bind="order.staff"></md-tooltip>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="orders.length > 0" md-limit="order_list.limit" md-limit-options="limitOptions" md-page="order_list.page" md-total="{{orders.length}}"></md-table-pagination>
      <md-content ng-show="!orders.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
    </md-content>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in orders[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill' && prop != 'status' && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type' && prop != 'customer_email'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
              <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" >
              <md-option value="all" ng-click="updateDropdown('all')" ><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in byCustomer" ng-click="updateDropdown(opt.CustomerID)" value="{{opt['CustomerID']}}">{{opt['CustomerName']}}</md-option>
            </md-select>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbyassigned') ?>'">
            <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'">
              <md-option value="all" ng-click="updateDropdown('all')"><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in byAssignee " ng-click="updateDropdown(opt.assgineeID, false)" value="{{opt['assgineeID']}}">{{opt['assgineeName']}}</md-option>
            </md-select>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
