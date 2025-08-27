<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div id="pageContent">
	<div class="ciuis-body-content" ng-controller="Payrolls_Controller">
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
					<h2 flex md-truncate class="text-bold"><?php echo lang('payroll'); ?> <small>(<span ng-bind="payrolls.length"></span>)</small><br><small flex md-truncate><?php echo lang('organizeyourpayrole'); ?></small></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="payroll_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('customer')?>"> 
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
								<md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.staff" ng-change="updateColumns('staff', table_columns.staff);">
									<?php echo lang('staff').' '.lang('name') ?>
								</md-checkbox><br>
								<md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.start_date" ng-change="updateColumns('start_date', table_columns.start_date);">
									<?php echo lang('start').' '.lang('date') ?>
								</md-checkbox><br>
								<md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.end_date" ng-change="updateColumns('end_date', table_columns.end_date);">
									<?php echo lang('end').' '.lang('date')?>
								</md-checkbox><br>
								<md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.base_salary" ng-change="updateColumns('base_salary', table_columns.base_salary);">
									<?php echo lang('base').' '.lang('salary') ?>
								</md-checkbox><br>


							</md-contet>
						</md-menu-content>
					</md-menu>
					<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
						<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
					</md-button>
					<?php if (check_privilege('hrm', 'create')) { ?>
						<md-button ng-href="<?php echo base_url('hrm/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
							<md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
							<md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
						</md-button>
					<?php } ?>
				</div>
			</md-toolbar>
			<div ng-show="payrollLoader" layout-align="center center" class="text-center" id="circular_loader">
				<md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
				<p style="font-size: 15px;margin-bottom: 5%;">
					<span>
						<?php echo lang('please_wait') ?> <br>
						<small><strong><?php echo lang('loading'). ' '. lang('payrolls').'...' ?></strong></small>
					</span>
				</p>
			</div>
			<md-content ng-show="!payrollLoader" class="bg-white" ng-cloak> 
				<md-table-container ng-show="payrolls.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="payroll_list.order">
							<tr md-row>
								<th md-column><span><?php echo lang('payroll'); ?></span></th>
								<th ng-show="table_columns.staff" md-column md-order-by="staff"><span><?php echo lang('staff').' '.lang('name'); ?></span></th>
								<th ng-show="table_columns.start_date" md-column md-order-by="start_date"><span><?php echo lang('start_date'); ?></span></th>
								<th ng-show="table_columns.end_date" md-column md-order-by="end_date"><span><?php echo lang('end_date'); ?></span></th>
								<th ng-show="table_columns.base_salary" md-column md-order-by="base_salary"><span><?php echo lang('base_salary'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="payroll in payrolls | orderBy: payroll_list.order | limitTo: payroll_list.limit : (payroll_list.page -1) * payroll_list.limit | filter: payroll_search | filter: FilteredData" class="cursor" ng-click="goToLink('payrolls/payroll/'+payroll.payroll_id)">
								<td md-cell>
									<strong>
										<a class="link" ng-href="<?php echo base_url('hrm/payroll/') ?>{{payroll.payroll_id}}"> <span ng-bind="payroll.payroll_id"></span></a>
									</strong><br>
                </td>
                <td ng-show="table_columns.staff" md-cell>
                  <a class="link" ng-href="<?php echo base_url('hrm/payroll/') ?>{{payroll.payroll_id}}">
                    <strong><span ng-bind="payroll.payroll_staff_name"></span></strong>
                  </a>
                </td>
								<td ng-show="table_columns.start_date" md-cell>
									<strong><span ng-bind="payroll.payroll_start_date"></span></strong>
								</td>
								<td ng-show="table_columns.end_date" md-cell>
									<strong><span ng-bind="payroll.payroll_end_date"></span></strong>
								</td>
								<td ng-show="table_columns.base_salary" md-cell>
									<strong><span ng-bind="payroll.payroll_base_salary"></span></strong>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="payrolls.length > 0" md-limit="payroll_list.limit" md-limit-options="limitOptions" md-page="payroll_list.page" md-total="{{payrolls.length}}" ></md-table-pagination>
				<md-content ng-show="!payrolls.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
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
				<div ng-repeat="(prop, ignoredValue) in payrolls[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'prefix' && prop != 'longid' && prop != 'created' && prop != 'duedate' && prop != 'customer' && prop != 'total' && prop != 'status' && prop != 'color' && prop != 'customer_id' && prop != 'staff_id' && prop != 'recurring_status' && prop != 'staff'">
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
	<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
	<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/payrolls.js'); ?>"></script>
</div>
