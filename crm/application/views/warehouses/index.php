<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div id="pageContent">
  <div class="ciuis-body-content" ng-controller="Warehouses_Controller">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
    <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('warehouses'); ?> <small>(<span ng-bind="warehouses.length"></span>)</small><br>
            <small flex md-truncate><?php echo lang('manage_warehouses'); ?></small>
          </h2>
          <div class="ciuis-external-search-in-table">
            <input ng-model="search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword') ?>">
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
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.name" ng-change="updateColumns('name', table_columns.warehouse_name);">
                  <?php echo lang('warehouse').' '.lang('name') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.city" ng-change="updateColumns('city', table_columns.name);">
                  <?php echo lang('city') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.state" ng-change="updateColumns('state', table_columns.category);">
                  <?php echo lang('state') ?>
                </md-checkbox><br>
                 <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.address" ng-change="updateColumns('address', table_columns.product_type);">
                  <?php echo lang('address')?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.total_product" ng-change="updateColumns('total_product', table_columns.purchase_price);">
                  <?php echo lang('total').' '.lang('product') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.created" ng-change="updateColumns('created', table_columns.created);">
                  <?php echo lang('created').' '.lang('by'); ?>
                </md-checkbox><br>
              </md-contet>
            </md-menu-content>
          </md-menu>
          <?php if (check_privilege('warehouses', 'create')) { ?> 
            <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
          <?php } ?>
        </div>
      </md-toolbar>
      <div ng-show="warehouseLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('warehouses') . '...' ?></strong></small>
          </span>
        </p>
      </div>
        <md-content ng-show="!warehouseLoader" class="md-pt-0 bg-white">
          <md-table-container ng-show="warehouses.length > 0">
            <table md-table  md-progress="promise" ng-cloak>
              <thead md-head md-order="warehouse_list.order">
                <tr md-row>
                  <th md-column md-order-by="warehouse_number"><span><?= lang('warehouse') ?></span></th>
                  <th ng-show="table_columns.name" md-column md-order-by="warehouse_name"><span><?php echo lang('warehouse').' '.lang('name'); ?></span></th>
                  <th ng-show="table_columns.city" md-column md-order-by="city"><span><?php echo lang('city'); ?></span></th>
                  <th ng-show="table_columns.state" md-column md-order-by="state"><span><?php echo lang('state'); ?></span></th>
                  <th ng-show="table_columns.address" md-column md-order-by="address"><span><?php echo lang('address') ?></span></th>
                  <th ng-show="table_columns.total_product" md-column md-order-by="total_product"><span><?php echo lang('total').' '.lang('product') ?></span></th>
                  <th ng-show="table_columns.created" md-column md-order-by="staffname"><span><?php echo lang('created').' '.lang('by'); ?></span></th>
                  <!-- <th md-column md-order-by="purchase_price"><span><?php echo lang('purchaseprice'); ?></span></th>
                  <th md-column md-order-by="price"><span><?php echo lang('salesprice'); ?></span></th>
                  <th md-column md-order-by="tax"><span><?php echo $appconfig['tax_label']; ?></span></th>
                  <th md-column md-order-by="stock"><span><?php echo lang('instock'); ?></span></th> -->
                </tr>
              </thead>
              <tbody md-body>
                <tr class="select_row" md-row ng-repeat="warehouse in warehouses | orderBy: warehouse_list.order | limitTo: warehouse_list.limit : (warehouse_list.page -1) * warehouse_list.limit | filter: search" class="cursor"  ng-click="goToLink('warehouses/warehouse/'+warehouse.warehouse_id)">
                  <td md-cell>
                    <a class="link" ng-href="<?= base_url('warehouses/warehouse/') ?>{{warehouse.warehouse_id}}"> <strong ng-bind="warehouse.warehouse_number"></strong></a>
                  </td>
                  <td ng-show="table_columns.name" md-cell>
                    <span ng-bind="warehouse.warehouse_name"></span>
                  </td>
                  <td ng-show="table_columns.city" md-cell>
                    <span ng-bind="warehouse.city"></span>
                  </td>
                  <td ng-show="table_columns.state" md-cell>
                    <span ng-bind="warehouse.state"></span>
                  </td>
                  <td ng-show="table_columns.address" md-cell>
                    <span ng-bind="warehouse.address"></span><br>
                    <strong><small ng-bind="warehouse.phone"></small></strong>
                  </td>
                  <td ng-show="table_columns.total_product" md-cell>
                    <span ng-bind="warehouse.total_product"></span>
                  </td>
                  <td ng-show="table_columns.created" md-cell>
                    <strong><span ng-bind="warehouse.staffname"></span></strong>
                  </td>
                </tr>
              </tbody>
            </table>
          </md-table-container>
          <md-table-pagination ng-show="products.length > 0" md-limit="product_list.limit" md-limit-options="limitOptions" md-page="product_list.page" md-total="{{products.length}}" ></md-table-pagination>
          <md-content ng-show="!products.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
        </md-content>
      </div>
      <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar">
        <div class="panel-default panel-table borderten lead-manager-head">
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
              <h2 flex md-truncate class="text-bold"><?php echo lang('warehouses'); ?>
            
            </h2>
          </div>
        </md-toolbar>
        <div class="tasks-status-stat" ng-cloak>
          <div class="widget-chart-container">
            <div class="widget-counter-group widget-counter-group-right">
              <div style="width: auto" class="pull-left"> <i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
                <div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
                  <h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('product_by_warehouse') ?></b></h4>
                  <small><?php echo lang('productcategorystats') ?></small>
                </div>
              </div>
            </div>
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
          </div>
        </div>
      </div>
    </div>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
          <md-truncate><?php echo lang('add').' '.lang('warehouse') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-content layout-padding>
          <md-input-container class="md-block">
            <label><?= lang('warehouse').' '.lang('name') ?></label>
            <input required type="text" ng-model="warehouse.name" class="form-control" id="name" placeholder="<?= lang('warehouse').' '.lang('name') ?>" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('phone'); ?></label>
            <input name="phone" ng-model="warehouse.phone" placeholder="<?= lang('phone') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('country'); ?></label>
            <md-select placeholder="<?= lang('country'); ?>" ng-model="warehouse.country_id" ng-change="getStates(warehouse.country_id)" name="country_id" style="min-width: 200px;">
              <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
            </md-select>
          </md-input-container>
          <br>
          <md-input-container class="md-block">
            <label><?= lang('state'); ?></label>
            <md-select placeholder="<?= lang('states'); ?>" ng-model="warehouse.state_id" name="state_id" style="min-width: 200px;">
              <md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
            </md-select><br />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('city'); ?></label>
            <input name="city" ng-model="warehouse.city"  placeholder="<?= lang('city') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('zipcode'); ?></label>
            <input name="zipcode" ng-model="warehouse.zipcode"  placeholder="<?= lang('zipcode') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('address') ?></label>
            <textarea ng-model="warehouse.address" name="address" md-maxlength="500" rows="3" placeholder="<?= lang('address') ?>"></textarea>
          </md-input-container>
        <md-content layout-padding>
          <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="add_warehouse()" class="md-raised md-primary btn-report block-button"><?= lang('add'); ?></md-button>
          </section>
        </md-content>
      </md-content>
    </md-sidenav>


   
  </div>
</div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/warehouses.js'); ?>"></script>
