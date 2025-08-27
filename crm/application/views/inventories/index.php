<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div id="pageContent">
  <div class="ciuis-body-content" ng-controller="Inventories_Controller">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
    <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9" ng-cloak>
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('inventory'); ?> <small>(<span ng-bind="inventories.length"></span>)</small><br>
            <!-- <small flex md-truncate><?php echo lang('productsdescription'); ?></small> -->
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
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.product_name" ng-change="updateColumns('product_name', table_columns.product_name);">
                  <?php echo lang('product').' '.lang('name') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.product_type" ng-change="updateColumns('product_type', table_columns.product_type);">
                  <?php echo lang('product').' '.lang('type') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.move_type" ng-change="updateColumns('move_type', table_columns.move_type);">
                  <?php echo lang('move_type') ?>
                </md-checkbox><br>
                 <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.category" ng-change="updateColumns('category', table_columns.category);">
                  <?php echo lang('category')?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.cost_price" ng-change="updateColumns('cost_price', table_columns.cost_price);">
                  <?php echo lang('cost').' '.lang('price') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.stock" ng-change="updateColumns('stock', table_columns.stock);">
                  <?php echo lang('instock'); ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.warehouse" ng-change="updateColumns('warehouse', table_columns.warehouse);">
                  <?php echo lang('warehouse') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.created_by" ng-change="updateColumns('created_by', table_columns.created_by);">
                  <?php echo lang('created').' '.lang('by'); ?>
                </md-checkbox><br>
              </md-contet>
            </md-menu-content>
          </md-menu>
          <?php if (check_privilege('inventories', 'create')) { ?> 
            <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
          <?php } ?>
          </md-menu>
        </div>
      </md-toolbar>
        <div ng-show="inventoryLoader" layout-align="center center" class="text-center" id="circular_loader">
          <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
          <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('inventories') . '...' ?></strong></small></span>
          </p>
        </div>
        <md-content ng-show="!inventoryLoader" class="md-pt-0 bg-white">
          <md-table-container ng-show="inventories.length > 0">
            <table md-table  md-progress="promise" ng-cloak>
              <thead md-head md-order="inventory_list.order">
                <tr md-row>
                  <th md-column md-order-by="inventory_number"><span><?php echo lang('inventory'); ?></span></th>
                  <th ng-show="table_columns.product_type"md-column md-order-by="product_type"><span><?php echo lang('product').' '.lang('type'); ?></span></th>
                  <th ng-show="table_columns.move_type" md-column md-order-by="move_type"><span><?php echo lang('move_type'); ?></span></th>
                  <th ng-show="table_columns.category" md-column md-order-by="category"><span><?php echo lang('category'); ?></span></th>
                  <th ng-show="table_columns.cost_price" md-column md-order-by="cost_price"><span><?php echo lang('cost').' '.lang('price') ?></span></th>
                  <th ng-show="table_columns.stock" md-column md-order-by="stock_qty"><span><?php echo lang('instock'); ?></span></th>
                  <th ng-show="table_columns.warehouse" md-column md-order-by="warehouse"><span><?php echo lang('warehouse'); ?></span></th>
                  <th ng-show="table_columns.created_by" md-column md-order-by="staffname"><span><?php echo lang('created').' '.lang('by'); ?></span></th>
                </tr>
              </thead>
              <tbody md-body>
                <tr class="select_row" md-row ng-repeat="inventory in inventories | orderBy: inventory_list.order | limitTo: inventory_list.limit : (inventory_list.page -1) * inventory_list.limit | filter: search | filter: FilteredData" class="cursor" ng-click="goToLink('inventories/inventory/'+inventory.inventory_id)">
                  <td md-cell>
                    <strong>
                      <a class="link" ng-href="<?php echo base_url('inventories/inventory/') ?>{{inventory.inventory_id}}"> <span ng-bind="inventory.inventory_number"></span></a>
                    </strong><br>
                    <small ng-show="table_columns.product_name" ng-bind="inventory.product_name"></small>
                  </td>
                  <td ng-show="table_columns.product_type" md-cell>
                    <span class="badge" ng-bind="inventory.product_type"></span>
                  </td>
                  <td ng-show="table_columns.move_type" md-cell>
                    <span class="badge" ng-bind="inventory.move_type"></span>
                  </td>
                  <td ng-show="table_columns.category" md-cell>
                    <span class="badge" ng-bind="inventory.category"></span>
                  </td>
                  <td ng-show="table_columns.cost_price" md-cell>
                    <span ng-bind="inventory.cost_price"></span>
                  </td>
                  <td ng-show="table_columns.stock" md-cell>
                    <span ng-bind="inventory.stock_qty"></span>
                  </td>
                  <td ng-show="table_columns.warehouse" md-cell>
                    <span ng-bind="inventory.warehouse"></span>
                  </td>
                  <td ng-show="table_columns.created_by" md-cell>
                    <span ng-bind="inventory.staffname"></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </md-table-container>
          <md-table-pagination ng-show="inventories.length > 0" md-limit="inventory_list.limit" md-limit-options="limitOptions" md-page="inventory_list.page" md-total="{{inventories.length}}" ></md-table-pagination>
          <md-content ng-show="!inventories.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
        </md-content>
      </div>
      <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar" ng-cloak>
        <div class="panel-default panel-table borderten lead-manager-head">
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
              <h2 flex md-truncate class="text-bold"><?php echo lang('inventory').' '.lang('warehouse'); ?>
              <md-button ng-href="<?=base_url('warehouses') ?>" class="md-icon-button pull-right" aria-label="New" ng-cloak>
                <md-icon><i class="ion-gear-a text-muted"></i></md-icon>
              </md-button>
            </h2>
          </div>
        </md-toolbar>
        <!--inventory_by_category-->
        <div class="tasks-status-stat" ng-cloak>
          <div class="widget-chart-container">
            <div class="widget-counter-group widget-counter-group-right">
              <div style="width: auto" class="pull-left"> <i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
                <div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
                  <h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('inventory_by_category') ?></b></h4>
                  <small><?php echo lang('inventory').' '.lang('stats') ?></small>
                </div>
              </div>
            </div>
            <div id="inven_container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
          </div>
        </div>
      </div>
    </div>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
          <md-truncate><?php echo lang('add').' '.lang('inventory') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-content layout-padding>
          <md-autocomplete flex required
            md-input-name="autocompleteField"
            md-min-length="0"
            md-no-cache="true"
            md-selected-item="selectedProduct"
            md-search-text="inventory.name"
            md-items="product in GetProduct(inventory.name)"
            md-item-text="product.name"   
            md-require-match=""
            md-floating-label="<?php echo lang('productname') ?>"
           >
            <md-item-template> <span class="blur" ng-bind="product.product_number"></span> <strong md-highlight-text="inventory.name">{{product.name}}</strong></md-item-template>
          </md-autocomplete>
          <input type="hidden" ng-model="selectedProduct.product_id">
          <input type="hidden" ng-model="selectedProduct.categoryid">
          <input type="hidden" ng-model="selectedProduct.product_type">
          <input type="hidden" ng-model="selectedProduct.product_type_value">
          <input type="hidden" ng-model="selectedProduct.warehouse_id">
          <input type="hidden" ng-model="selectedProduct.product_code">
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('productcategory'); ?></label>
              <input type="text" ng-model="selectedProduct.category_name" disabled>
            </md-input-container>
             <md-input-container class="md-block">
              <label><?php echo lang('product').' '.lang('type'); ?></label>
              <input type="text" ng-model="selectedProduct.product_type_value" disabled>
            </md-input-container>
          </div>
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('cost').' '.lang('price') ?></label>
              <input required type="number" ng-model="selectedProduct.purchase_price" id="amount" placeholder="0.00" disabled="" />
            </md-input-container>
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse'); ?></label>
              <input type="text" ng-model="selectedProduct.warehouse_name" disabled>
            </md-input-container>
           
          </div>
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('stock').' '.lang('quantity') ?> <strong>(<span ng-bind="selectedProduct.unit"></span>)</strong></label>
              <input type="number" ng-model="inventory.stock" ng-value="0" class="form-control" id="stock" placeholder="<?php echo lang('stock').' '.lang('quantity') ?>" />
            </md-input-container>
            <md-input-container class="md-block">
              <md-select placeholder="<?php echo lang('move_type')?>" ng-model="inventory.move_type" style="min-width: 180px;">
                <md-option ng-repeat="move in movements track by $index" ng-value="move.movement_id">{{move.movement_name}}</md-option>
              </md-select><br />
            </md-input-container>
          </div>
          <div layout-gt-xs="row" ng-show="inventory.move_type == 3">
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse').' '.lang('from'); ?></label>
              <input type="text" ng-model="selectedProduct.warehouse_name" disabled>
            </md-input-container>
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse').' '.lang('to'); ?></label>
              <md-select placeholder="<?php echo lang('warehouse').' '.lang('to'); ?>" ng-model="inventory.warehouse_to" style="min-width: 180px;">
                <md-option ng-if="selectedProduct.warehouse_id != name.warehouse_id" ng-value="name.warehouse_id" ng-repeat="name in warehouses">{{name.warehouse_name}}</md-option>
              </md-select><br />
            </md-input-container>
          </div>
          
        </md-content>
        <md-content layout-padding>
          <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="AddInventory()" class="md-raised md-primary pull-right block-button"><?php echo lang('add'); ?></md-button>
          </section>
        </md-content>
      </md-content>
    </md-sidenav>
  </div>
</div>
<script type="text/javascript">
  var lang = {};
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/inventory.js'); ?>"></script>
