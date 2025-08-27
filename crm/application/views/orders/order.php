<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Order_Controller">
  <div class="main-content container-fluid col-md-9 borderten">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-proposals text-warning"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo $orders['order_number'] . ' ' ?><?php echo $orders['subject']; ?></h2>
        <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
          <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="sendingEmail == true" md-direction="bottom" ng-bind="lang.send"></md-tooltip>
          <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
        </md-button>
        <md-button ng-show="order.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-show="order.pdf_status == '1'" ng-href="<?php echo base_url('orders/download_pdf/' . $orders['id']) ?>" class="md-icon-button" aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
        </md-button>
        <md-button ng-href="<?php echo base_url('orders/print_/{{order.id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('print') ?></md-tooltip>
          <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('invoices', 'create')) { ?>
          <md-menu ng-if="!order.invoice_id" md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
              <md-icon><i class="ion-loop text-success"></i></md-icon>
            </md-button>
            <md-menu-content width="4" ng-cloak>
              <md-contet class="text-center" layout-padding> <img height="80%" src="https://cdn4.iconfinder.com/data/icons/business-399/512/invoice-128.png" alt="">
                <p style="max-width: 250px"> <strong ng-show="order.relation_type == true"><?php echo lang('leadproposalconvertalert') ?></strong> <strong ng-show="order.relation_type != true"><?php echo lang('convert_order_to_invoice'); ?></strong> </p>
                <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                  <md-button ng-click="Convert()" class="ion-filemd-primary pull-right" aria-label="Convert" ng-cloak><span ng-bind="lang.convert"></span></md-button>
                </section>
              </md-contet>
            </md-menu-content>
          </md-menu>
        <?php } ?>
        <md-button ng-if="order.invoice_id" ng-href="<?php echo base_url('invoices/invoice/{{order.invoice_id}}') ?>" class="md-icon-button" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('invoice') ?></md-tooltip>
          <md-icon><i class="ion-document-text text-success"></i></md-icon>
        </md-button>
        <?php if (check_privilege('orders', 'edit') || check_privilege('orders', 'delete')) { ?>
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <?php if (check_privilege('orders', 'edit')) { ?>
                <md-menu-item>
                  <md-button ng-click="ViewOrder()" ng-bind="lang.view_order" aria-label="View Order"></md-button>
                </md-menu-item>
                <!-- <md-menu-item>
                  <md-button ng-click="NewMilestone()" ng-bind="lang.sentexpirationreminder" aria-label="sentexpirationreminder"></md-button>
                </md-menu-item>-->
                <md-menu-item>
                  <md-button ng-click="MarkAs(1,'Draft')" ng-bind="lang.markasdraft" aria-label="Draft"></md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs(2,'Sent')" ng-bind="lang.markassent" aria-label="Sent"></md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs(3,'Open')" ng-bind="lang.markasopen" aria-label="Open"></md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs(4,'Revised')" ng-bind="lang.markasrevised" aria-label="Revised"></md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs(5,'Declined')" ng-bind="lang.markasdeclined" aria-label="Complete"></md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs(6,'Accepted')" ng-bind="lang.markasaccepted" aria-label="Accepted"></md-button>
                </md-menu-item>
                <md-divider></md-divider>
                <md-menu-item>
                  <md-button ng-click="Update()" aria-label="Update">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.edit"></p>
                      <md-icon md-menu-align-target class="ion-edit" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-divider></md-divider>
              <?php }
              if (check_privilege('orders', 'delete')) { ?>
                <md-menu-item>
                  <md-button ng-click="Delete()" aria-label="Delete">
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
    <md-content class="bg-white">
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="<?php echo lang('orders'); ?>">
          <md-content class="md-padding bg-white">
            <div class="proposal">
              <main>
                <div id="details" class="clearfix">
                  <div id="company">
                    <h2 class="name"><?php echo $settings['company'] ?></h2>
                    <div><?php echo $settings['address'] ?></div>
                    <div><?php echo lang('phone') ?>:</b><?php echo $settings['phone'] ?></div>
                    <div><a href="mailto:<?php echo $settings['email'] ?>"><?php echo $settings['email'] ?></a></div>
                  </div>
                  <div id="client">
                    <div class="to"><span><?php echo lang('order') . ' ' . lang('to'); ?>:</span></div>
                    <h2 class="name">
                      <?php if ($orders['relation_type'] == 'customer') {
                        if ($orders['customercompany'] == "") {
                          echo $orders['namesurname'];
                        } else echo $orders['customercompany'];
                      } ?>
                      <?php if ($orders['relation_type'] == 'lead') {
                        echo $orders['leadname'];
                      } ?>
                    </h2>
                    <div class="address">
                      <address class="m-t-5 m-b-5">
                        <strong ng-bind="order.billing_street"></strong><br>
                        <span ng-bind="order.billing_city"></span> / <span ng-bind="order.billing_state"></span> <span ng-bind="order.billing_zip"></span><br>
                        <strong ng-bind="order.billing_country"></strong>
                        <!-- <srong ng-bind="invoice.billing_country_id"></srong> -->
                      </address>
                    </div>
                    <div class="email"><a href="mailto:<?php echo $orders['toemail']; ?>"><?php echo $orders['toemail']; ?></a></div>
                  </div>
                  <div id="invoice">
                    <h1 ng-bind="order.long_id"></h1>
                    <div class="date"><?php echo lang('dateofissuance') ?>: <span ng-bind="order.date"></span></div>
                    <div class="date text-bold"><?php echo lang('opentill') ?>: <span ng-bind="order.opentill"></span></div>
                    <span class="text-uppercase" ng-bind="order.status_name"></span>
                  </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr>
                      <th class="desc"><?php echo lang('description') ?></th>
                      <th class="qty text-right"><?php echo lang('quantity') ?></th>
                      <th class="qty text-right"><?php echo lang('unit') ?></th>
                      <th class="unit text-right"><?php echo lang('price') ?></th>
                      <th class="discount text-right"><?php echo lang('discount') ?></th>
                      <th class="tax text-right"><?php echo $appconfig['tax_label'] ?></th>
                      <th class="total text-right"><?php echo lang('total') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="item in order.items">
                      <td class="desc">
                        <h3 ng-bind="item.name"><br>
                        </h3>
                        <pre class="pre_view" ng-cloak>{{item.description}}</pre>
                      </td>
                      <td class="qty" ng-bind="item.quantity"></td>
                      <td class="qty" ng-bind="item.unit"></td>
                      <td class="unit"><span ng-bind-html="item.price | currencyFormat:cur_code:null:true:cur_lct"></span></td>
                      <td class="discount" ng-bind="item.discount+'%'"></td>
                      <td class="tax" ng-bind="item.tax+'%'"></td>
                      <td class="total"><span ng-bind-html="item.total | currencyFormat:cur_code:null:true:cur_lct"></span></td>
                    </tr>
                  </tbody>
                </table>
                <div class="col-md-12 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
                  <div class="col-md-10">
                    <div class="text-right text-uppercase text-muted"><?php echo lang('sub_total'); ?>:</div>
                    <div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount'); ?>:</div>
                    <div ng-show="totaltax() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total') . ' ' . $appconfig['tax_label']; ?>:</div>
                    <div class="text-right text-uppercase text-black"><?php echo lang('grand_total'); ?>:</div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div ng-show="totaltax() > 0" class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
                  </div>
                </div>
              </main>
            </div>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('notes'); ?>">
          <md-content class="md-padding bg-white">
            <section class="ciuis-notes show-notes">
              <article ng-repeat="note in notes" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50" /> </div>
                <div class="ciuis-note-detail-body">
                  <div class="text">
                    <p> <span ng-bind="note.description"></span> <a ng-click='DeleteNote($index)' style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a> </p>
                  </div>
                  <p class="attribution"> by <strong><a href="<?php echo base_url('staff/staffmember/'); ?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span> </p>
                </div>
              </article>
            </section>
            <section class="md-pb-30">
              <md-input-container class="md-block">
                <label><?php echo lang('description') ?></label>
                <textarea required name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <div class="form-group pull-right">
                <button ng-click="AddNote()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
                  <?php echo lang('addnote') ?>
                </button>
              </div>
            </section>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('comments'); ?>">
          <md-content class="md-padding bg-white">
            <section class="ciuis-notes show-notes">
              <article ng-repeat="comment in order.comments" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" /> </div>
                <div class="ciuis-note-detail-body">
                  <div class="text">
                    <p ng-bind="comment.content"></p>
                  </div>
                  <p class="attribution"><strong><?php echo lang('customer_comment') ?></strong> <?php echo lang('at') ?> <span ng-bind="comment.created"></span></p>
                </div>
              </article>
            </section>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('reminders'); ?>">
          <md-list ng-cloak>
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <h2><?php echo lang('reminders') ?></h2>
                <span flex></span>
                <md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip" aria-label="Add Reminder">
                  <md-tooltip md-direction="left"><?php echo lang('addreminder') ?></md-tooltip>
                  <md-icon><i class="ion-plus-round text-success"></i></md-icon>
                </md-button>
              </div>
            </md-toolbar>
            <md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)" class="noright"> <img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
              <p>{{ reminder.description }}</p>
              <md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3">
                <md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
                <i class="ion-ios-calendar-outline"></i>
              </md-icon>
              <md-icon ng-click="DeleteReminder($index)" aria-label="Send Email" class="md-secondary md-hue-3">
                <md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
                <i class="ion-ios-trash-outline"></i>
              </md-icon>
            </md-list-item>
          </md-list>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
  <div ng-show="!orderLoader" class="main-content container-fluid col-md-3 md-pl-0 left-area">
    <md-content class="bg-white">
      <md-tabs ng-show="!settings.loader" md-dynamic-height md-border-bottom md-center-tabs>
        <md-tab label="<?php echo lang('details'); ?>">
          <md-content class="bg-white">
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <h2 flex md-truncate class="pull-left"><strong><span ng-bind="lang.status"></span> : <span ng-bind="order.status_name"></span></strong></h2>
              </div>
            </md-toolbar>
            <div layout="row" layout-wrap>
              <div flex-gt-xs="50" flex-xs="50" class="invoice-button-left" ng-click="MarkAs(1,'Draft')">
                <?php echo lang('save') . ' ' . lang('order') . ' ' . lang('as') . ' ' . lang('draft') ?>
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
                <md-icon class="ion-android-mail"></md-icon>
                <p ng-bind="order.mail_status"></p>
              </md-list-item>
              <md-divider></md-divider>
              <md-list-item>
                <md-icon class="ion-person"></md-icon>
                <p><strong ng-bind="order.staff_name"></strong></p>
              </md-list-item>
            </md-list>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('billing') . ' ' . lang('delivery'); ?>">
          <md-content class="bg-white">
            <!--  <md-toolbar class="toolbar-white">
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
                  <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="doSecondaryAction($event)" aria-label="call">
                    <md-icon class="ion-ios-search-strong"></md-icon>
                  </md-button>
                  <md-divider></md-divider>
                </md-list-item>
              </md-list>
            </md-content> -->
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
                    <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/zip_icon.png'); ?>">
                    </a>
                    <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/file_icon.png'); ?>">
                    </a>
                    <a ng-if="file.type == 'pdf'" class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}'); ?>">
                      <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
                      <img src="<?php echo base_url('assets/img/pdf_icon.png'); ?>">
                    </a>
                  </div>
                  <div class="md-list-item-text">
                    <a class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}'); ?>">
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
  <!--  <ciuis-sidebar></ciuis-sidebar> -->
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addreminder') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('datetobenotified') ?></label>
          <input mdc-datetime-picker="" date="true" format="{{DateTimeFormat}}" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('setreminderto'); ?></label>
          <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id" style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="reminder_description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
        </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
            <?php echo lang('addreminder') ?>
          </button>
        </div>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<script type="text/ng-template" id="generate-order.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding class="text-center">
		<md-content class="bg-white" layout-padding>
			<h2 class="md-title" ng-hide="PDFCreating == true"><?php echo lang('generate_order_pdf') ?></h2>
			<h2 class="md-title" ng-if="PDFCreating == true"><?php echo lang('report_generating') ?></h2>
			<span ng-hide="PDFCreating == false"><?php echo lang('generate_pdf_msg') ?></span><br><br>
			<span ng-if="PDFCreating == false"><?php echo lang('generate_pdf_last_msg') ?></span><br><br>
			<img ng-if="PDFCreating == true" ng-src="<?php echo base_url('assets/img/loading_time.gif') ?>" alt="">
			<a ng-if="PDFCreating == false" href="<?php echo base_url('orders/download_pdf/' . $orders['id'] . '') ?>"><img  width="30%"ng-src="<?php echo base_url('assets/img/download_pdf.png') ?>" alt=""></a>
		</md-content>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button class="text-success" ng-if="PDFCreating == false" href="<?php echo base_url('orders/download_pdf/' . $orders['id'] . '') ?>"><?php echo lang('download') ?></md-button>
    <md-button class="text-success" ng-hide="PDFCreating == false" ng-click="CreatePDF()"><?php echo lang('create') ?>!</md-button>
    <md-button ng-click="CloseModal()"><?php echo lang('cancel') ?></md-button>
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
                <md-option ng-repeat="contact in order.customer_contacts" ng-value="contact">{{contact.name}}</md-option>
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
        <md-button ng-click="uploadOrderFile()" class="template-button" ng-disabled="uploading == true">
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
        <md-button ng-href="<?php echo base_url('orders/download_file/') ?>{{file.id}}"><?php echo lang('download') ?>!</md-button>
        <md-button ng-click="CloseModal()"><?php echo lang('cancel') ?>!</md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
<script>
  var ORDERID = "<?php echo $orders['id']; ?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt') ?>";
  lang.cancel = "<?php echo lang('cancel') ?>";
  lang.attention = "<?php echo lang('attention') ?>";
  lang.delete_order = "<?php echo lang('delete_meesage') . ' ' . lang('order') ?>";
  lang.convert_title = "<?php echo lang('information') ?>";
  lang.convert_text = "<?php echo lang('convertmsg') . ' ' . lang('order') . ' ' . lang('to') . ' ' . lang('invoice') ?>";
  lang.convert = "<?php echo lang('convert') ?>";
</script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>