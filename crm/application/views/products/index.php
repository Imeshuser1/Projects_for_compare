<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content" ng-controller="Products_Controller">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
    <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('products'); ?> <small>(<span ng-bind="products.length"></span>)</small><br>
            <small flex md-truncate><?php echo lang('productsdescription'); ?></small>
          </h2>
          <div class="ciuis-external-search-in-table">
            <input ng-model="search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword') ?>">
            <md-button class="md-icon-button" aria-label="Search" ng-cloak>
              <md-icon><i class="ion-search text-muted"></i></md-icon>
            </md-button>
          </div>
          <md-button ng-click="addUnit()" class="md-icon-button" aria-label="unit" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('uom') ?></md-tooltip>
            <md-icon aria-label="Add"><i class="ion-ios-gear text-muted"></i></md-icon>
          </md-button>
          <md-menu md-position-mode="target-right target">
            <md-button class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
              <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
              <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4" ng-cloak>
              <md-contet layout-padding>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.code" ng-change="updateColumns('code', table_columns.code);">
                  <?php echo lang('product').' '.lang('code') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.name" ng-change="updateColumns('name', table_columns.name);">
                  <?php echo lang('product').' '.lang('name') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.category" ng-change="updateColumns('category', table_columns.category);">
                  <?php echo lang('category') ?>
                </md-checkbox><br>
                 <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.product_type" ng-change="updateColumns('product_type', table_columns.product_type);">
                  <?php echo lang('product').' '.lang('type') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.purchase_price" ng-change="updateColumns('purchase_price', table_columns.purchase_price);">
                  <?php echo lang('purchaseprice') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.sales_price" ng-change="updateColumns('sales_price', table_columns.sales_price);">
                  <?php echo lang('salesprice'); ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.vat" ng-change="updateColumns('vat', table_columns.vat);">
                  <?php echo $appconfig['tax_label']; ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.stock" ng-change="updateColumns('stock', table_columns.stock);">
                  <?php echo lang('instock') ?>
                </md-checkbox><br>
                <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.warehouse" ng-change="updateColumns('warehouse', table_columns.warehouse);">
                  <?php echo lang('warehouse') ?>
                </md-checkbox><br>
              </md-contet>
            </md-menu-content>
          </md-menu>
          <?php if (check_privilege('products', 'create')) { ?> 
            <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
          <?php } ?>
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <?php if (check_privilege('products', 'create')) { ?> 
                <md-menu-item>
                  <md-button ng-click="ImportProductsNav()">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.importproducts"></p>
                      <md-icon md-menu-align-target class="ion-upload text-muted" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } ?>
              <?php echo form_open_multipart('products/exportdata', array("class" => "form-horizontal")); ?>
              <md-menu-item>
                <md-button type="submit">
                  <div layout="row" flex>
                    <p flex ng-bind="lang.exportproducts"></p>
                    <md-icon md-menu-align-target class="ion-android-download text-muted" style="margin: auto 3px auto 0;"></md-icon>
                  </div>
                </md-button>
              </md-menu-item>
              <?php echo form_close(); ?>
            </md-menu-content>
          </md-menu>
        </div>
      </md-toolbar>
      <div ng-show="productFile" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('products') . '...' ?></strong></small></span>
          </p>
        </div>
        <md-content ng-show="!productFile" class="md-pt-0 bg-white">
          <md-table-container ng-show="products.length > 0">
            <table md-table  md-progress="promise" ng-cloak>
              <thead md-head md-order="product_list.order">
                <tr md-row>
                  <th md-column md-order-by="name"><span><?php echo lang('product'); ?></span></th>
                  <th ng-show="table_columns.code" md-column md-order-by="code"><span><?php echo lang('product').' '.lang('code'); ?></span></th>
                  <th ng-show ="table_columns.warehouse" md-column md-order-by="warehouse_name"><span><?php echo lang('warehouse'); ?></span></th>
                  <th ng-show="table_columns.category" md-column md-order-by="category_name"><span><?php echo lang('category'); ?></span></th>
                  <th ng-show="table_columns.product_type" md-column md-order-by="product_type"><span><?php echo lang('product').' '.lang('type'); ?></span></th>
                  <th ng-show="table_columns.purchase_price" md-column md-order-by="purchase_price"><span><?php echo lang('purchaseprice'); ?></span></th>
                  <th ng-show="table_columns.sales_price" md-column md-order-by="price"><span><?php echo lang('salesprice'); ?></span></th>
                  <th ng-show="table_columns.vat" md-column md-order-by="tax"><span><?php echo $appconfig['tax_label']; ?></span></th>
                  <th ng-show="table_columns.stock" md-column md-order-by="stock"><span><?php echo lang('instock'); ?></span></th>
                </tr>
              </thead>
              <tbody md-body>
                <tr class="select_row" md-row ng-repeat="product in products | orderBy: product_list.order | limitTo: product_list.limit : (product_list.page -1) * product_list.limit | filter: search | filter: FilteredData" class="cursor" ng-click="goToLink('products/product/'+product.product_id)">
                  <td md-cell>
                    <a class="link" ng-href="<?= base_url('products/product/'); ?>{{product.product_id}}"> <strong ng-bind="product.product_number"></strong></a><br> 
                    <small ng-show="table_columns.name" ng-bind="product.name"></small>
                  </td>
                  <td ng-show="table_columns.code" md-cell>
                    <span ng-bind="product.code"></span>
                  </td>
                  <td ng-show="table_columns.warehouse" md-cell>
                    <strong  class="badge" ng-bind="product.warehouse_name"></strong>
                  </td>
                  <td ng-show="table_columns.category" md-cell>
                    <span class="badge" ng-bind="product.category_name"></span>
                  </td>
                  <td ng-show="table_columns.product_type" md-cell>
                    <span class="badge" ng-bind="product.product_type"></span>
                  </td>
                  <td ng-show="table_columns.purchase_price" md-cell>
                    <strong ng-bind-html="product.purchase_price | currencyFormat:cur_code:null:true:cur_lct"></strong>
                  </td>
                  <td ng-show="table_columns.sales_price" md-cell>
                    <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong>
                  </td>
                  <td ng-show="table_columns.vat" md-cell>
                    <strong ng-bind="product.tax+'%'"></strong>
                  </td>
                  <td ng-show="table_columns.stock" md-cell>
                    <strong ng-bind="product.stock"></strong>
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
              <h2 flex md-truncate class="text-bold"><?php echo lang('productcategory'); ?>
              <md-button ng-click="CreateCategory()" class="md-icon-button pull-right" aria-label="New" ng-cloak>
                <md-icon><i class="ion-gear-a text-muted"></i></md-icon>
              </md-button>
            </h2>
          </div>
        </md-toolbar>
        <div class="tasks-status-stat" ng-cloak>
          <div class="widget-chart-container">
            <div class="widget-counter-group widget-counter-group-right">
              <div style="width: auto" class="pull-left"> <i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
                <div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
                  <h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('productbycategory') ?></b></h4>
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
          <md-truncate><?php echo lang('addproduct') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-content layout-padding>
          <md-input-container class="md-block">
            <label><?php echo lang('productname') ?></label>
            <input required type="text" ng-model="product.productname" class="form-control" id="name" placeholder="<?php echo lang('productname'); ?>" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('uom'); ?></label>
            <md-select placeholder="<?php echo lang('uom'); ?>" ng-model="product.unit" style="min-width: 200px;">
              <md-select-header>
                <md-toolbar class="toolbar-white">
                  <div class="md-toolbar-tools">
                    <h4 flex md-truncate><?php echo lang('uom') ?></h4>
                    <md-button class="md-icon-button" ng-click="NewUnit()" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </div>
                </md-toolbar>
              </md-select-header>
              <md-option ng-value="unit.unit_id" ng-repeat="unit in units">{{unit.name}}</md-option>
            </md-select>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('productcategory'); ?></label>
            <md-select placeholder="<?php echo lang('productcategory'); ?>" ng-model="product.categoryid" style="min-width: 200px;">
              <md-select-header>
                <md-toolbar class="toolbar-white">
                  <div class="md-toolbar-tools">
                    <h4 flex md-truncate><?php echo lang('categories') ?></h4>
                    <md-button class="md-icon-button" ng-click="NewCategory()" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </div>
                </md-toolbar>
              </md-select-header>
              <md-option ng-value="name.id" ng-repeat="name in category">{{name.name}}</md-option>
            </md-select>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('product').' '.lang('type'); ?></label>
            <md-select placeholder="<?php echo lang('product').' '.lang('type'); ?>" ng-model="product.type" style="min-width: 200px;">
              <md-option ng-value="0"><?php echo lang('physical_item').' <small>('.lang('inv_manage').' )</small>' ?></md-option>
              <md-option ng-value="1"><?php echo lang('service_item').' <small>('.lang('non_inv_manage').' )</small>'?></md-option>
              <md-option ng-value="2"><?php echo lang('digital_item').' <small>('.lang('inv_manage').' )</small>'?></md-option>
              <md-option ng-value="3"><?php echo lang('physical_item').' <small>('.lang('non_inv_manage').' )</small>' ?></md-option>
              <md-option ng-value="4"><?php echo lang('digital_item').' <small>('.lang('non_inv_manage').' )</small>'?></md-option>
            </md-select><br/>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('warehouse'); ?></label>
            <md-select placeholder="<?php echo lang('warehouse'); ?>" ng-model="product.warehouse" style="min-width: 200px;">
              <md-select-header>
                <md-toolbar class="toolbar-white">
                  <div class="md-toolbar-tools">
                    <h4 flex md-truncate><?php echo lang('warehouse') ?></h4>
                    <md-button class="md-icon-button" ng-href="<?= base_url('warehouses') ?>" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </div>
                </md-toolbar>
              </md-select-header>
              <md-option ng-value="name.warehouse_id" ng-repeat="name in warehouses">{{name.warehouse_name}}</md-option>
            </md-select>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('purchaseprice') ?></label>
            <input required type="number" ng-model="product.purchase_price" class="form-control" id="amount" placeholder="0.00" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('salesprice') ?></label>
            <input required type="number" ng-model="product.sale_price" class="form-control" id="amount" placeholder="0.00" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('productcode') ?></label>
            <input type="text" ng-model="product.code" class="form-control" id="productcode" placeholder="<?php echo lang('productcode'); ?>" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo $appconfig['tax_label'] ?></label>
            <input type="number" ng-model="product.vat" ng-value="0" class="form-control" id="tax" placeholder="<?php echo $appconfig['tax_label']; ?>" />
          </md-input-container>
          <md-input-container class="md-block" ng-show="product.type == 0 || product.type == 2">
            <label><?php echo lang('instock') ?></label>
            <input type="number" ng-model="product.stock" ng-value="0" class="form-control" id="stock" placeholder="<?php echo lang('instock'); ?>" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('description') ?></label>
            <textarea required name="description" ng-model="product.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
          </md-input-container>
        </md-content>
        <custom-fields-vertical></custom-fields-vertical>
        <md-content layout-padding>
          <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="AddProduct()" class="md-raised md-primary pull-right block-button"><?php echo lang('add'); ?></md-button>
          </section>
        </md-content>
      </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateCategory" ng-cloak style="width: 450px;">
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
          <md-truncate><?php echo lang('categories') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-toolbar class="toolbar-white" style="background:#262626">
          <div class="md-toolbar-tools">
            <h4 class="text-bold text-muted" flex><?php echo lang('productCategories') ?></h4>
            <?php if (check_privilege('products', 'create')) { ?> 
              <md-button aria-label="Add Status" class="md-icon-button" ng-click="NewCategory()">
                <md-tooltip md-direction="bottom"><?php echo lang('addProductCategory') ?></md-tooltip>
                <md-icon><i class="ion-plus-round text-success"></i></md-icon>
              </md-button>
            <?php } ?>
          </div>
        </md-toolbar>
        <md-list-item ng-repeat="name in category" class="noright" ng-click="EditCategory(name.id,name.name, $event)" aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
          <?php if (check_privilege('products', 'edit')) { ?> 
            <md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit category"></md-icon>
          <?php } if (check_privilege('products', 'delete')) { ?> 
              <md-icon ng-click='DeleteProductCategory($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b"></md-icon>
          <?php } ?>
        </md-list-item>
      </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ImportProductsNav" ng-cloak style="width: 450px;">
      <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
          <md-truncate><?php echo lang('importproducts') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <?php echo form_open_multipart('products/productsimport'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">
              <?php echo lang('choosecsvfile'); ?>
            </label>
            <div class="file-upload">
              <div class="file-select">
                <div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span>
                  <?php echo lang('attachment') ?>
                </div>
                <div class="file-select-name" id="noFile">
                  <?php echo lang('notchoise') ?>
                </div>
                <input type="file" name="userfile" id="chooseFile" required="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" file-model="product_file">
              </div>
            </div>
          </div>
          <br>
        </div>
        <div class="modal-footer">
          <a href="<?php echo base_url('uploads/samples/productimport.csv') ?>" class="btn btn-success pull-left"><?php echo lang('downloadsample'); ?></a>
          <button type="button" ng-click="importProduct()" class="btn btn-default"><?php echo lang('save'); ?></button>
        </div>
        <?php echo form_close(); ?>
        <div ng-show="importerror">
          <md-content>
            <ul>
              <li ng-repeat="error in errors">
                <p><?php echo lang('row') . ' ' ?>{{error.line}}<?php echo ' ' . lang('importSkipError') ?></p>
              </li>

            </ul>
          </md-content>
        </div>

      </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="addUnit" ng-cloak style="width: 450px;">
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
          <md-truncate><?php echo lang('uom') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-toolbar class="toolbar-white" style="background:#262626">
          <div class="md-toolbar-tools">
            <h4 class="text-bold text-muted" flex><?php echo lang('uom') ?></h4>
            <?php if (check_privilege('products', 'create')) { ?> 
              <md-button aria-label="Add Status" class="md-icon-button" ng-click="NewUnit()">
                <md-tooltip md-direction="top"><?php echo lang('add').' '.lang('unit') ?></md-tooltip>
                <md-icon aria-label="Add Units"><i class="ion-plus-round text-success"></i></md-icon>
              </md-button>
            <?php } ?>
          </div>
        </md-toolbar>
        <md-list-item ng-repeat="unit in units" class="noright" ng-click="EditUnit(unit.unit_id, unit.name, $event)" aria-label="Edit Unit"> <strong ng-bind="unit.name"></strong>
          <?php if (check_privilege('products', 'edit')) { ?> 
            <md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit Unit"></md-icon>
          <?php } if (check_privilege('products', 'delete')) { ?> 
            <md-icon ng-click='DeleteUnit(unit.unit_id)' aria-label="Remove Unit" class="md-secondary md-hue-3 ion-trash-b">
              <md-tooltip md-direction="top"><?php echo lang('delete') ?></md-tooltip>
            </md-icon>
          <?php } ?>
        </md-list-item>
      </md-content>
    </md-sidenav>
  </div>
<script type="text/javascript">
  var lang = {};
  lang.product = '<?php echo lang('product')?>';
  lang.categories = '<?php echo lang('categories')?>';
  lang.addProductCategory = '<?php echo lang('addProductCategory')?>';
  lang.type_categoryname = '<?php echo lang('type_categoryname')?>';
  lang.categoryname = '<?php echo lang('categoryname')?>';
  lang.cancel = '<?php echo lang('cancel')?>';
  lang.add = '<?php echo lang('add')?>';
  lang.categoryname = '<?php echo lang('categoryname')?>';
  lang.edit = '<?php echo lang('edit')?>';
  lang.attention = '<?php echo lang('attention')?>';
  lang.save = '<?php echo lang('save')?>';
  lang.confirm_product_category_delete = '<?php echo lang('confirm_product_category_delete')?>';
  lang.doIt = '<?php echo lang('doIt')?>';
  lang.delete = '<?php echo lang('delete')?>';
  lang.productattentiondetail = '<?php echo lang('productattentiondetail')?>';

</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/products.js'); ?>"></script>
