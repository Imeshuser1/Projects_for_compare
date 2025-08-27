<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Invoice_Controller">
  <div class="main-content container-fluid col-md-9">
    <!-- <div ng-show="invoiceLoader" layout-align="center center" class="text-center" id="circular_loader">
          <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
            <p style="font-size: 15px;margin-bottom: 5%;">
             <span>
                <?php echo lang('please_wait') ?> <br>
               <small><strong><?php echo lang('loading') . ' ' . lang('invoice') . '...' ?></strong></small>
             </span>
           </p>
         </div> -->
    <md-toolbar ng-show="!invoiceLoader" class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate ng-bind="invoice.properties.invoice_number"></h2>
        <md-button ng-click="Discussions()" class="md-icon-button" aria-label="Discussions" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('discussions') ?></md-tooltip>
          <md-icon><i class="mdi ion-chatboxes text-muted"></i></md-icon>
        </md-button> <!-- ng-href="<?php //echo base_url('invoices/send_email/{{invoice.id}}')
                                    ?>" -->
        <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
          <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="sendingEmail == true" md-direction="bottom" ng-bind="lang.send"></md-tooltip>
          <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
        </md-button>

        <md-button ng-show="invoice.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-show="invoice.pdf_status == '1'" ng-href="<?php echo base_url('invoices/download_pdf/' . $invoices['id']) ?>" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-href="<?php echo base_url('invoices/print_/{{invoice.id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak>
          <md-tooltip md-direction="bottom" ng-bind="lang.print"></md-tooltip>
          <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('invoices', 'edit') || check_privilege('invoices', 'delete')) { ?>
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <?php if (check_privilege('invoices', 'edit')) { ?>
                <md-menu-item>
                  <md-button ng-click="MarkAsDraft()">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasdraft"></p>
                      <md-icon md-menu-align-target class="ion-document" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAsCancelled()">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markascancelled"></p>
                      <md-icon md-menu-align-target class="mdi mdi-close-circle-o" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="UpdateInvoice(invoice.id)">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.update"></p>
                      <md-icon md-menu-align-target class="mdi mdi-edit" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php }
              if (check_privilege('invoices', 'delete')) { ?>
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
    <md-content ng-show="!invoiceLoader" class="bg-white invoice">
      <div class="invoice-header col-md-12">
        <div class="invoice-from col-md-4 col-xs-12"> <small class="text-uppercase" ng-bind="lang.from"></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="settings.company"></strong><br>
            <span ng-bind="settings.address"></span><br>
            <span ng-bind="settings.phone"></span><br>
          </address>
        </div>
        <div class="invoice-to col-md-4 col-xs-12"> <small class="text-uppercase" ng-bind="lang.to"></small>
          <address class="m-t-5 m-b-5">
            <strong ng-bind="invoice.properties.customer"></strong><br> 
			      <span ng-bind="invoice.billing_street"></span><br>
				      <span ng-bind="invoice.billing_city"></span> / <span ng-bind="invoice.billing_state"></span> <span ng-bind="invoice.billing_zip"></span><br>
				      <strong ng-bind="invoice.billing_country"></strong>
			    </address>
        </div>
        <div class="invoice-date col-md-4 col-xs-12">
          <div class="date m-t-5" ng-bind="invoice.created_edit | date : 'MMM d, y'"></div>
          <div class="invoice-detail"> <span ng-bind="invoice.serie + invoice.no"></span><br>
          </div>
        </div>
      </div>
      <div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
        <div class="table-responsive">
          <table class="table table-invoice">
            <thead>
              <tr>
                <th ng-bind="lang.product"></th>
                <th ng-bind="lang.quantity"></th>
                <th ng-bind="lang.unit"></th>
                <th ng-bind="lang.price"></th>
                <th><?php echo $appconfig['tax_label'] ?></th>
                <th ng-bind="lang.discount"></th>
                <th ng-bind="lang.total"></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in invoice.items">
                <td><span ng-bind="item.name"></span><br>
                  <pre class="pre_view" ng-cloak>{{item.description}}</pre>
                </td>
                <td ng-bind="item.quantity"></td>
                <td ng-bind="item.unit"></td>
                <td ng-bind-html="item.price | currencyFormat:cur_code:null:true:cur_lct"></td>
                <td ng-bind="item.tax + '%'"></td>
                <td ng-bind="item.discount + '%'"></td>
                <td ng-bind-html="item.total | currencyFormat:cur_code:null:true:cur_lct"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="invoice-price">
          <div class="invoice-price-left">
            <div class="invoice-price-row">
              <div class="sub-price"> <small ng-bind="lang.subtotal"></small> <span ng-bind-html="invoice.sub_total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
              <div class="sub-price"> <i class="ion-plus-round"></i> </div>
              <div class="sub-price"> <small><?php echo $appconfig['tax_label'] ?></small> <span ng-bind-html="invoice.total_tax | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
              <div class="sub-price"> <i class="ion-minus-round"></i> </div>
              <div class="sub-price"> <small ng-bind="lang.discount"></small> <span ng-bind-html="invoice.total_discount | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
            </div>
          </div>
          <div class="invoice-price-right"> <small ng-bind="lang.total"></small> <span ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
        </div>
      </div>
    </md-content>
  </div>
  <div ng-show="!invoiceLoader" class="main-content container-fluid col-md-3 md-pl-0 left-area">
    <md-content class="bg-white">
      <md-tabs ng-show="!settings.loader" md-dynamic-height md-border-bottom md-center-tabs>
        <md-tab label="<?php echo lang('details'); ?>">
          <md-content class="bg-white">
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <h2 flex md-truncate class="pull-left" ng-show="invoice.balance != 0 && invoice.status_id != 4"><strong><span ng-bind="lang.balance"></span> : <span ng-bind-html="invoice.balance | currencyFormat:cur_code:null:true:cur_lct"></span></strong></h2>
                <h2 flex md-truncate class="pull-left text-success" ng-hide="invoice.balance != 0"><strong ng-bind="lang.paidinv"></strong></h2>
                <h2 flex md-truncate class="pull-left text-danger text-uppercase" ng-show="invoice.status_id == 4"><strong ng-bind="lang.cancelled"></strong></h2>
                <md-button ng-hide="invoice.partial_is != true" class="md-icon-button" aria-label="Partial">
                  <md-tooltip md-direction="bottom" ng-bind="lang.partial"></md-tooltip>
                  <md-icon><i class="ion-pie-graph text-muted"></i></md-icon>
                </md-button>
                <md-button ng-hide="invoice.balance != 0" class="md-icon-button" aria-label="Paid">
                  <md-tooltip md-direction="bottom" ng-bind="lang.paid"></md-tooltip>
                  <md-icon><i class="ion-checkmark-circled text-success"></i></md-icon>
                </md-button>
              </div>
            </md-toolbar>
            <div layout="row" layout-wrap>
              <div flex-gt-xs="50" flex-xs="50" class="invoice-button-left" ng-click="MarkAsDraft()">
                <?php echo lang('save_as_draft') ?>
              </div>
              <div flex-gt-xs="50" flex-xs="50" class="invoice-button-right" ng-disabled="sendingEmailToAll == true" ng-click="sendEmailToAll(customer_contacts)">
                <span ng-show="sendingEmailToAll == false">
                  <md-icon>
                    <i class="ion-email text-white"></i>
                  </md-icon>
                  <?php echo lang('email_to_contacts') ?>
                </span>
                <md-progress-circular class="white" ng-show="sendingEmailToAll == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
              </div>
            </div>
            <div class="list-items">
              <div class="list">
                <md-checkbox md-no-ink aria-label="Checkbox 1" class="md-primary" ng-model="include_myself">
                  <?php echo lang('include_myself') ?> (<span><?php echo $this->session->userdata('email') ?></span>)
                </md-checkbox>
                <md-icon class="pull-right cursor" ng-click="checkCustomerContacts(customer_contacts)"><i class="ion-edit pull-right"></i></md-icon>
              </div>
              <div class="list" ng-if="customer_contacts.length > 0" ng-repeat="contact in customer_contacts">
                <md-icon><i class="ico-ciuis-staffdetail" style="font-size: 22px"></i> </md-icon>
                <span ng-bind="contact.name"></span> (<span ng-bind="contact.email"></span>)
              </div>
            </div>
            <md-list flex>
              <md-list-item>
                <md-icon class="ion-ios-bell"></md-icon>
                <p ng-bind="invoice.duedate_text"></p>
              </md-list-item>
              <md-divider></md-divider>
              <md-list-item>
                <md-icon class="ion-android-mail"></md-icon>
                <p ng-bind="invoice.mail_status"></p>
              </md-list-item>
              <md-divider></md-divider>
              <md-list-item>
                <md-icon class="ion-person"></md-icon>
                <p><strong ng-bind="invoice.properties.invoice_staff"></strong></p>
              </md-list-item>
            </md-list>
            <md-subheader ng-if="custom_fields.length > 0"><?php echo lang('custom_fields'); ?></md-subheader>
            <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
              <md-icon class="{{field.icon}} material-icons"></md-icon>
              <strong flex md-truncate>{{field.name}}</strong>
              <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
              <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
              <p ng-if="field.type === 'date'" class="text-right" flex md-truncate ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
              <p ng-if="field.type === 'select'" class="text-right" flex md-truncate ng-bind="custom_fields[$index].selected_opt.name"></p>
              <md-divider ng-if="custom_fields"></md-divider>
            </md-list-item>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('payments'); ?>">
          <md-content class="bg-white">
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <h2 flex md-truncate class="text-bold"><?php echo lang('payments'); ?><br>
                  <small flex md-truncate><?php echo lang('paymentsside'); ?></small>
                </h2>
                
                <?php if (!$this->session->userdata('other')) { ?>
                  <md-button ng-show="invoice.balance != 0 && invoice.status_id != 4" ng-click="RecordPayment()" class="md-icon-button" aria-label="Record Payment">
                    <md-tooltip md-direction="left"><?php echo lang('recordpayment') ?></md-tooltip>
                    <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
                  </md-button>
                <?php } ?>
              </div>
            </md-toolbar>
            <md-content class="bg-white">
              <md-content ng-show="!invoice.payments.length" class="md-padding no-item-payment bg-white"></md-content>
              <md-list flex>
                <md-list-item class="md-2-line" ng-repeat="payment in invoice.payments">
                  <md-icon class="ion-arrow-down-a text-muted"></md-icon>
                  <div class="md-list-item-text">
                    <h3 ng-bind="payment.name"></h3>
                    <p ng-bind-html="payment.amount | currencyFormat:cur_code:null:true:cur_lct"></p>
                  </div>

                  <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" aria-label="call" ng-if="invoice.status_id == 2 || invoice.status_id == 3" ng-href="<?php echo base_url('expenses/receipt/{{payment.expense_id}}');?>">
                    <md-icon class="ion-ios-search-strong"></md-icon>
                  </md-button>
                  <div >
                  
                  <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="getInvoiceCurrentStatus(payment.id, payment.expense_id)" aria-label="call" ng-if="invoice.status_id == 3"  data-toggle="modal" data-target="#exampleModal" >
                    <md-icon class="ion-edit"></md-icon>
                  </md-button>

                  <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="deletePayment(payment.id)" aria-label="call" ng-if="invoice.status_id == 3">
                    <md-icon class="ion-trash-b"></md-icon>
                  </md-button>
                  
                  </div>
                  <md-divider></md-divider>
                </md-list-item>
              </md-list>
            </md-content>

            
                </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('files'); ?>" ng-click="getInvoiceFiles()">
          <md-content class="md-padding bg-white">
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <md-button class="md-icon-button" aria-label="" ng-disabled="true">
                  <md-icon><i class="ion-document text-muted"></i></md-icon>
                </md-button>
                <h2 flex md-truncate><?php echo lang('files') ?></h2>
                <?php if (!$this->session->userdata('other')) { ?>
                  <md-button ng-click="UploadFile()" class="md-icon-button md-primary" aria-label="Add File">
                    <md-tooltip md-direction="bottom"><?php echo lang('upload_new_file') ?></md-tooltip>
                    <md-icon class="ion-android-add-circle text-success"></md-icon>
                  </md-button>
                <?php } ?>
              </div>
            </md-toolbar>
            <md-content class="bg-white">
              <md-list flex>
                <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
                  <div class="md-list-item-text image-preview">
                    <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
                      <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
                      <img src="{{file.path}}">
                    </a>
                    <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('invoices/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/zip_icon.png'); ?>">
                    </a>
                    <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('invoices/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/file_icon.png'); ?>">
                    </a>
                    <a ng-if="file.type == 'pdf'" class="cursor" ng-href="<?php echo base_url('invoices/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/pdf_icon.png'); ?>">
                    </a>
                  </div>
                  <div class="md-list-item-text">
                    <a class="cursor" ng-href="<?php echo base_url('invoices/download_file/{{file.id}}'); ?>">
                      <h3 class="link" ng-bind="file.file_name"></h3>
                    </a>
                  </div>
                  <?php if (!$this->session->userdata('other')) { ?>
                    <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click='DeleteFile(file.id)' aria-label="call">
                      <md-icon class="ion-trash-b"></md-icon>
                    </md-button>
                  <?php } ?>
                  <md-divider></md-divider>
                </md-list-item>
                <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
              </md-list>
              <div ng-show="files.length > 6" class="pagination-div">
                <ul class="pagination">
                  <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
                  <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
                  <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
                </ul>
              </div>
            </md-content>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form name="EditInvoiceRecordPayment" id="EditInvoiceRecordPayment">

                <md-input-container class="md-block">
                    <label><?php echo lang('amount') ?></label>
                    <input required type="number" class="getVal" name="amount" ng-model="amount"/>
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('description') ?></label>
                    <textarea required name="not" ng-model="not" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control getVal"></textarea>
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('account'); ?></label>
                    
                    <md-select required placeholder="<?php echo lang('account'); ?>" ng-model="account" name="account" class="getVal" style="min-width: 200px;">
                    <md-option ng-value="account.id"  ng-repeat="account in accounts">{{account.name}}</md-option>
                    </md-select>

                </md-input-container>
                <section layout="row" layout-sm="column" layout-align="center right" layout-wrap>  
                </section>

                <input type="hidden" class="getVal" ng-model="paymentid">
                <input type="hidden" class="getVal">
            </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-model="closeButton" id="closeButton">Close</button>
                <button type="button" ng-click="saveEditPayment(invoice.id, 'EditInvoiceRecordPayment')" class="btn md-raised md-primary pull-right template-button">Save changes</button>
            </div>
            </div>
        </div>
        </div>

  <!--  <div ng-show="!invoiceLoader" class="main-content container-fluid col-md-3 md-pl-0" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="pull-left" ng-show="invoice.balance != 0 && invoice.status_id != 4"><strong><span ng-bind="lang.balance"></span> : <span ng-bind-html="invoice.balance | currencyFormat:cur_code:null:true:cur_lct"></span></strong></h2>
        <h2 flex md-truncate class="pull-left text-success" ng-hide="invoice.balance != 0"><strong ng-bind="lang.paidinv"></strong></h2>
        <h2 flex md-truncate class="pull-left text-danger text-uppercase" ng-show="invoice.status_id == 4"><strong ng-bind="lang.cancelled"></strong></h2>
        <md-button ng-hide="invoice.partial_is != true" class="md-icon-button" aria-label="Partial">
          <md-tooltip md-direction="bottom" ng-bind="lang.partial"></md-tooltip>
          <md-icon><i class="ion-pie-graph text-muted"></i></md-icon>
        </md-button>
        <md-button ng-hide="invoice.balance != 0" class="md-icon-button" aria-label="Paid" >
          <md-tooltip md-direction="bottom" ng-bind="lang.paid"></md-tooltip>
          <md-icon><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-content class="bg-white" style="border-bottom:1px solid #e0e0e0;">
      <md-list flex>
        <md-list-item>
          <md-icon class="ion-ios-bell"></md-icon>
          <p ng-bind="invoice.duedate_text"></p>
        </md-list-item>
        <md-divider></md-divider>
        <md-list-item>
          <md-icon class="ion-android-mail"></md-icon>
          <p ng-bind="invoice.mail_status"></p>
        </md-list-item>
        <md-divider></md-divider>
        <md-list-item>
          <md-icon class="ion-person"></md-icon>
          <p><strong ng-bind="invoice.properties.invoice_staff"></strong></p>
        </md-list-item>
      </md-list>
      <md-subheader ng-if="custom_fields.length > 0"><?php echo lang('custom_fields'); ?></md-subheader>
      <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
        <md-icon class="{{field.icon}} material-icons"></md-icon>
        <strong flex md-truncate>{{field.name}}</strong>
        <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
        <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
        <p ng-if="field.type === 'date'" class="text-right" flex md-truncate ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
        <p ng-if="field.type === 'select'" class="text-right" flex md-truncate ng-bind="custom_fields[$index].selected_opt.name"></p>
        <md-divider ng-if="custom_fields"></md-divider>
      </md-list-item>
    </md-content>
    <?php if (check_privilege('invoices', 'edit')) { ?>
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('payments'); ?><br>
            <small flex md-truncate><?php echo lang('paymentsside'); ?></small>
          </h2>
          <md-button ng-show="invoice.balance != 0 && invoice.status_id != 4" ng-click="RecordPayment()" class="md-icon-button" aria-label="Record Payment">
            <md-tooltip md-direction="left"><?php echo lang('recordpayment') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon> 
          </md-button>
        </div>
      </md-toolbar>
      <md-content class="bg-white">
        <md-content ng-show="!invoice.payments.length" class="md-padding no-item-payment bg-white"></md-content>
        <md-list flex>
          <md-list-item class="md-2-line" ng-repeat="payment in invoice.payments">
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
    <?php } ?>  
  </div> -->
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
            <input mdc-datetime-picker="" date="true" format="{{DateTimeFormat}}" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" show-icon="true" ng-model="date" class=" dtp-no-msclear dtp-input md-input">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('amount') ?></label>
            <input required type="number" name="amount" ng-model="amount" min="0"/>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('description') ?></label>
            <textarea required name="not" ng-model="not" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('account'); ?></label>
            <md-select placeholder="<?php echo lang('account'); ?>" ng-model="account" name="account" style="min-width: 200px;">
              <md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
            </md-select>
          </md-input-container>
          <section layout="row" layout-sm="column" layout-align="center right" layout-wrap>
            <md-button ng-click="AddPayment(InvoiceRecordPayment)" class="md-raised md-primary pull-right template-button" ng-disabled="doing == true">
              <span ng-hide="doing == true"><?php echo lang('save'); ?></span>
              <md-progress-circular class="white" ng-show="doing == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
            <!-- <md-button ng-click="AddPayment()" class="md-raised md-primary pull-right" ng-bind="lang.save"></md-button> -->
          </section>
        </md-content>
      </form>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Discussions" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('discussions'); ?></h2>
        <md-button ng-click="NewDiscussion()" class="md-icon-button" aria-label="Record Payment">
          <md-tooltip md-direction="left"><?php echo lang('new_disscussion'); ?></md-tooltip>
          <md-icon><i class="ion-plus-round text-muted"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex>
        <md-list-item class="md-2-line" ng-repeat="discussion in discussions" ng-click="Discussion_Detail($index)" aria-label="Discussion Detail">
        <div ng-show="discussion.is_read == 0" class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
          <div data-letter-avatar="--" class="ticket-area-av-im2 md-avatar"></div>
          <div class="md-list-item-text" ng-class="{'md-offset': phone.options.offset }">
            <h3 ng-bind="discussion.subject"></h3>
            <p ng-bind="discussion.contact"></p>
          </div>
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewDiscussion" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('new_disscussion'); ?></h2>
        <md-switch ng-model="ShowCustomer" aria-label="Type"><strong class="text-muted"><?php echo lang('show_customer'); ?></strong></md-switch>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('subject') ?></label>
          <input required type="text" ng-model="new_discussion.subject"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required ng-model="new_discussion.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('contact'); ?></label>
            <md-select placeholder="<?php echo lang('contact'); ?>" ng-model="new_discussion.contact" name="contact" style="min-width: 200px;">
              <md-option ng-value="contact" ng-repeat="contact in customer_contacts">{{contact.name}}</md-option>
            </md-select>
          </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="CreateDiscussion()" class="btn btn-warning btn-xl ion-ios-paperplane"> <?php echo lang('create')?></button>
        </div>
      </md-content>
    </md-content>
  </md-sidenav>
  <div style="visibility: hidden">
    <div ng-repeat="discussion in discussions" class="md-dialog-container" id="Discussion_Detail-{{discussion.id}}">
      <md-dialog aria-label="Discussion_Detail">
        <md-toolbar class="toolbar-white">
          <div class="md-toolbar-tools">
            <h2>{{discussion.subject}} by {{discussion.contact}}</h2>
            <span flex></span>
            <md-button class="md-icon-button" ng-click="CloseModal()">
              <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
            </md-button>
          </div>
        </md-toolbar>
        <md-dialog-content style="max-width:800px;max-height:810px; ">
          <md-content class="md-padding bg-white">
            <md-list flex>
              <md-list-item>
                <md-icon class="mdi mdi-calendar"></md-icon>
                <p><?php echo lang('date') ?></p>
                <p class="md-secondary" ng-bind="discussion.datecreated | date : 'MMM d, y'"></p>
              </md-list-item>
              <md-divider></md-divider>
              <md-content class="bg-white" layout-padding>
                <p class="md-secondary" ng-bind="discussion.description"></p>
              </md-content>
              <md-divider></md-divider>
            </md-list>
            <md-content class="bg-white" layout-padding>
              <section class="ciuis-notes show-notes">
                <article ng-repeat="comment in discussion.comments" class="ciuis-note-detail">
                  <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" /> </div>
                  <div class="ciuis-note-detail-body">
                    <div class="text">
                      <p ng-bind="comment.content"></p>
                    </div>
                    <p class="attribution"><?php echo lang('repliedby'); ?> <strong><span ng-bind="comment.full_name"></span></strong> at <span ng-bind="comment.created"></span></p>
                  </div>
                </article>
              </section>
              <md-input-container class="md-block">
                <label><?php echo lang('message') ?></label>
                <textarea required ng-model="discussion.newcontent" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control comment-description"></textarea>
              </md-input-container>
            </md-content>
          </md-content>
        </md-dialog-content>
        <md-dialog-actions layout="row">
          <md-button ng-click="AddComment($index)" style="margin-right:20px;"> <?php echo lang('reply') ?> </md-button>
        </md-dialog-actions>
      </md-dialog>
    </div>
  </div>
  <script>
    var INVOICEID = <?php echo $invoices['id']; ?>;
    var INVOICECUSTOMER = <?php echo $invoices['customer_id']; ?>;
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
<script type="text/javascript" src="<?php echo base_url('assets/js/invoices.js') ?>"></script>