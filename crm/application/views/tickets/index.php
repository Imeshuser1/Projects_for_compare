<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
  .topRow {
    margin-bottom : 30px;
  }
  .on-drag-enter {
  }
  .on-drag-hover:before {
    display: block;
    color: white;
    font-size: x-large;
    font-weight: 800;
  }
</style>
<div class="ciuis-body-content" ng-controller="Tickets_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12 md-p-0 lead-table" ng-show="!ticketsLoader" ng-if="KanbanBoard">
      <md-toolbar class="toolbar-white" style="margin-left: 4px;" ng-cloak>
        <div class="md-toolbar-tools">
          <h2 class="title-size" flex md-truncate class="text-bold"> <?php echo lang('tickets'); ?><small>(<span ng-bind="tickets.length"></span>)</small><br>
					<small flex md-truncate><?php echo lang('organizeyourtickets'); ?></small>
					</h2>
          <div class="ciuis-external-search-in-table" ng-cloak>
            <input ng-model="lead_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
            <md-button class="md-icon-button" aria-label="Search">
              <md-icon aria-label="Add Source"><i class="ion-search text-muted"></i></md-icon>
            </md-button>
          </div>
          <md-button ng-click="TicketsSettings()" class="md-icon-button" aria-label="Settings" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('settings') ?></md-tooltip>
            <md-icon aria-label="Add"><i class="ion-ios-gear text-muted"></i></md-icon>
          </md-button>
          <md-button ng-if="!KanbanBoard" ng-click="ShowKanban();updateColumns('list_view', true);" class="md-icon-button" aria-label="Show Kanban" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('showkanban'); ?></md-tooltip>
            <md-icon aria-label="Add Source"><i class="mdi mdi-view-week text-muted"></i></md-icon>
          </md-button>
          <md-button ng-if="KanbanBoard" ng-click="HideKanban();updateColumns('list_view', true);" class="md-icon-button" aria-label="Show List" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('showlist'); ?></md-tooltip>
            <md-icon aria-label="Add Source"><i class="mdi mdi-view-list text-muted"></i></md-icon>
          </md-button>
          <?php if (check_privilege('tickets', 'create')) { ?> 
            <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
              <md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
              <md-icon aria-label="Add Source"><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
          <?php } ?>
        </div>
      </md-toolbar>
      <div ng-show="ticketsLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span>
            <?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading'). ' '. lang('tickets').'...' ?></strong></small>
          </span>
        </p>
      </div>
      <md-content class="ciuis_lead_kanban_board" style="padding: 0px;    overflow-y: hidden;" ng-cloak>
        <md-list class="ciuis_lead_status_card" flex ng-repeat="ticket_status in ticketstatuses" ui-on-Drop="onDrop($event,$data,ticket_status.id)">
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
              <h4 flex md-truncate>{{ticket_status.name}}</h4>
            </div>
          </md-toolbar>
          <div class="items_list">
            <md-list-item class="md-3-line" ui-draggable="true" drag="ticket" on-drop-success="dropSuccessHandler($event,$index,ticket_status.id)" ng-repeat="ticket in tickets | filter:search | filter: { status_id: ticket_status.id}"> 
              <div class="md-list-item-text" layout="column">
                <div layout="row" layout-wrap>
                  <div flex-gt-xs="80" flex-xs="80">
                    <h3 flex>
                      <a class="link" ng-href="<?php echo base_url('tickets/ticket/') ?>{{ticket.id}}">
                        {{ ticket.ticket_number | limitTo: 30 }}{{ticket.ticket_number.length > 28 ? '...' : ''}}
                      </a>
                    </h3>
                  </div>
                </div>
                <p class="small">
                  <span class="blur"><?php echo lang('subject') ?>:</span> 
                  <span>{{ ticket.subject | limitTo: 30 }}{{ticket.subject.length > 28 ? '...' : ''}}</span>
                </p>
                <p class="small">
                  <span class="blur"><?php echo lang('customer') ?>:</span> 
                  <span>{{ ticket.customer_name | limitTo: 30 }}{{ticket.customer_name.length > 28 ? '...' : ''}}</span>
                </p>
                <p class="small" ng-show="ticket.priority">
                  <span class="blur"><?php echo lang('priority') ?>:</span> 
                  <span>{{ ticket.priority | limitTo: 30 }}{{ticket.priority.length > 28 ? '...' : ''}}</span>
                </p>
                <p>
                  <span class="blur"> <?php echo lang('assigned') ?>: </span> 
                  <span>
                    <md-tooltip md-direction="top">{{ ticket.assigned }}</md-tooltip>
                    <img ng-src="<?php echo base_url('uploads/images/{{ticket.avatar}}')?>" class="md-avatar" alt="{{ticket.assigned}}" style="    ">
                  </span> &nbsp;&nbsp;&nbsp;
                  <span>
                    <md-tooltip md-direction="top"><?php echo lang('lastreply') ?></md-tooltip>
                    <span ng-bind="ticket.lastreply"></span>
                  </span>
                </p>
                <div>
                  <div ng-repeat="tag in ticket.tagss" class="badge">
                    {{tag}}
                  </div>
                </div>
              </div>
            </md-list-item>
          </div>
        </md-list>
        <br><br><br>
      </md-content>
    </div>
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0" ng-if="!KanbanBoard">
    <div class="panel-default panel-table borderten lead-manager-head">
      <md-content style="border-bottom: 2px dashed #e8e8e8; padding-bottom: 20px;" layout-padding>
        <div class="col-md-3 col-xs-6 border-right text-uppercase">
          <div class="tasks-status-stat">
            <h4 class="text-bold ciuis-task-stat-title">
              <span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'1'}).length"></span>
              <span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
            </h4>
            <span class="ciuis-task-percent-bg">
              <span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'1'}).length * 100 / tickets.length }}%;"></span>
            </span>
          </div>
          <span style="color:#989898"><?php echo lang('open') ?></span>
        </div>
        <div class="col-md-3 col-xs-6 border-right text-uppercase">
          <div class="tasks-status-stat">
            <h4 class="text-bold ciuis-task-stat-title">
              <span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'2'}).length"></span>
              <span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
            </h4>
            <span class="ciuis-task-percent-bg">
              <span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'2'}).length * 100 / tickets.length }}%;"></span>
            </span>
          </div>
          <span style="color:#989898"><?php echo lang('inprogress') ?></span>
        </div>
        <div class="col-md-3 col-xs-6 border-right text-uppercase">
          <div class="tasks-status-stat">
            <h4 class="text-bold ciuis-task-stat-title">
              <span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'3'}).length"></span>
              <span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
            </h4>
            <span class="ciuis-task-percent-bg">
              <span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'3'}).length * 100 / tickets.length }}%;"></span>
            </span>
          </div>
          <span style="color:#989898"><?php echo lang('answered') ?></span>
        </div>
        <div class="col-md-3 col-xs-6 border-right text-uppercase">
          <div class="tasks-status-stat">
            <h4 class="text-bold ciuis-task-stat-title">
              <span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'4'}).length"></span>
              <span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
            </h4>
            <span class="ciuis-task-percent-bg">
              <span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'4'}).length * 100 / tickets.length }}%;"></span>
            </span>
          </div>
          <span style="color:#989898"><?php echo lang('closed') ?></span>
        </div>
      </md-content>
      <div class="ticket-contoller-left">
        <div id="tickets-left-column text-left">
          <div class="col-md-12 ticket-row-left text-left">
            <div class="tickets-vertical-menu">
              <a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo lang('alltickets') ?> <span class="ticket-num" ng-bind="tickets.length"></span></a>
              <a ng-click="TicketsFilter = {status_id: 1}" class="side-tickets-menu-item"><?php echo lang('open') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'1'}).length"></span></a>
              <a ng-click="TicketsFilter = {status_id: 2}" class="side-tickets-menu-item"><?php echo lang('inprogress') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'2'}).length"></span></a>
              <a ng-click="TicketsFilter = {status_id: 3}" class="side-tickets-menu-item"><?php echo lang('answered') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'3'}).length"></span></a>
              <a ng-click="TicketsFilter = {status_id: 4}" class="side-tickets-menu-item"><?php echo lang('closed') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'4'}).length"></span></a>
              <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo lang('filterbypriority') ?></h5>
              <a ng-click="TicketsFilter = {priority_id: 1}" class="side-tickets-menu-item"><?php echo lang('low') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'1'}).length"></span></a>
              <a ng-click="TicketsFilter = {priority_id: 2}" class="side-tickets-menu-item"><?php echo lang('medium') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'2'}).length"></span></a>
              <a ng-click="TicketsFilter = {priority_id: 3}" class="side-tickets-menu-item"><?php echo lang('high') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'3'}).length"></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table" ng-if="!KanbanBoard">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('tickets'); ?> <small>(<span ng-bind="tickets.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('tracktickets'); ?></small>
        </h2>
        <md-button ng-click="TicketsSettings()" class="md-icon-button" aria-label="Settings" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('settings') ?></md-tooltip>
            <md-icon aria-label="Add"><i class="ion-ios-gear text-muted"></i></md-icon>
          </md-button>
        <md-button ng-if="!KanbanBoard" ng-click="ShowKanban();updateColumns('list_view', false);" class="md-icon-button" aria-label="Show Kanban" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('showkanban'); ?></md-tooltip>
          <md-icon><i class="mdi mdi-view-week text-muted"></i></md-icon>
        </md-button>
        <md-button ng-if="KanbanBoard" ng-click="HideKanban();updateColumns('list_view', true);" class="md-icon-button" aria-label="Show List" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('showlist'); ?></md-tooltip>
          <md-icon aria-label="Add Source"><i class="mdi mdi-view-list text-muted"></i></md-icon>
        </md-button>
        <md-menu md-position-mode="target-right target" ng-show="!KanbanBoard">
          <md-button class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
            <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
            <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4" ng-cloak>
            <md-contet layout-padding>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.subject" ng-change="updateColumns('subject', table_columns.subject);">
                <?php echo lang('ticket') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.customer" ng-change="updateColumns('customer', table_columns.customer);">
                <?php echo lang('customer') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.contact" ng-change="updateColumns('contact', table_columns.contact);">
                <?php echo lang('contact') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.department" ng-change="updateColumns('department', table_columns.department);">
                <?php echo lang('department') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.priority" ng-change="updateColumns('priority', table_columns.priority);">
                <?php echo lang('priority') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.status" ng-change="updateColumns('status', table_columns.status);">
                <?php echo lang('status') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.assigned" ng-change="updateColumns('assigned', table_columns.assigned);">
                <?php echo lang('assigned').' '.lang('by'); ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.last_reply" ng-change="updateColumns('last_reply', table_columns.last_reply);">
                <?php echo lang('lastreply') ?>
              </md-checkbox><br>
            </md-contet>
          </md-menu-content>
        </md-menu>
        <?php if (check_privilege('tickets', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('newticket') ?></md-tooltip>
            <md-icon><i class="ion-plus-round text-muted"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <div ng-show="ticketsLoader" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span>
          <?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading'). ' '. lang('tickets').'...' ?></strong></small>
        </span>
      </p>
    </div>
    <md-content ng-show="!ticketsLoader" ng-if="!KanbanBoard" class="md-pt-0 bg-white" ng-cloak>
      <md-table-container ng-show="tickets.length > 0">
        <table md-table  md-progress="promise" ng-cloak>
          <thead md-head md-order="ticket_list.order">
            <tr md-row>
              <th md-column><span>#</span></th>
              <th ng-show="table_columns.subject" md-column md-order-by="subject"><span><?php echo lang('ticket'); ?></span></th>
              <th ng-show="table_columns.customer" md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
              <th ng-show="table_columns.contact" md-column md-order-by="contactname"><span><?php echo lang('contact'); ?></span></th>
              <th ng-show="table_columns.department" md-column md-order-by="department"><span><?php echo lang('department'); ?></span></th>
              <th ng-show="table_columns.priority" md-column md-order-by="priority_id"><span><?php echo lang('priority'); ?></span></th>
              <th ng-show="table_columns.status" md-column md-order-by="status_id"><span><?php echo lang('status'); ?></span></th>
              <th ng-show="table_columns.assigned" md-column md-order-by="subject"><span><?php echo lang('assigned').' '.lang('by'); ?></span></th>
              <th ng-show="table_columns.last_reply" md-column md-order-by="lastreply"><span><?php echo lang('lastreply'); ?></span></th>
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="ticket in tickets | orderBy: ticket_list.order | limitTo: ticket_list.limit : (ticket_list.page -1) * ticket_list.limit | filter: TicketsFilter | filter:search" class="cursor" ng-click="goToLink('tickets/ticket/'+ticket.id)">
              <td md-cell>
                <strong>
                  <a class="link" ng-href="<?php echo base_url('tickets/ticket/')?>{{ticket.id}}"> <strong ng-bind="ticket.ticket_number"></strong></a>
                </strong>
              </td>
              <td ng-show="table_columns.subject" md-cell>
                <strong ng-bind="ticket.subject"></strong><br>
                <small ng-bind="ticket.message"></small>
              </td>
              <td ng-show="table_columns.customer" md-cell>
                <strong ng-bind="ticket.customer_name"></strong>
              </td>
              <td ng-show="table_columns.contact" md-cell>
                <strong ng-bind="ticket.contactname"></strong><br>
                <small ng-bind="ticket.contactemail" class="blur"></small>
              </td>
              <td ng-show="table_columns.department" md-cell>
                <strong ng-bind="ticket.department"></strong>
              </td>
              <td ng-show="table_columns.priority" md-cell>
                <span ng-switch="ticket.priority_id">
                  <strong ng-switch-when="1"><?php echo lang( 'low' ); ?></strong>
                  <strong ng-switch-when="2"><?php echo lang( 'medium' ); ?></strong>
                  <strong ng-switch-when="3"><?php echo lang( 'high' ); ?></strong>
                </span>
              </td>
              <td ng-show="table_columns.status" md-cell>
                <span ng-switch="ticket.status_id">
                  <strong ng-switch-when="1"><?php echo lang( 'open' ); ?></strong>
                  <strong ng-switch-when="2"><?php echo lang( 'inprogress' ); ?></strong>
                  <strong ng-switch-when="3"><?php echo lang( 'answered' ); ?></strong>
                  <strong ng-switch-when="4"><?php echo lang( 'closed' ); ?></strong>
                </span>
              </td>
              <td ng-show="table_columns.assigned" md-cell>
                <strong ng-bind="ticket.assigned"></strong>
              </td>
              <td ng-show="table_columns.last_reply" md-cell>
                <span>
                  <span ng-show="ticket.lastreply == NULL" class="badge"><?php echo lang('n_a') ?></span><span ng-show="ticket.lastreply != NULL" class="badge" ng-bind="ticket.lastreply | date : 'MMM d, y h:mm:ss a'"></span>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="tickets.length > 0" md-limit="ticket_list.limit" md-limit-options="limitOptions" md-page="ticket_list.page" md-total="{{tickets.length}}" ></md-table-pagination>
        <md-content ng-show="!tickets.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
      </md-content>
    </div>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close">
         <i class="ion-android-arrow-forward"></i>
       </md-button>
       <md-truncate><?php echo lang('create') ?></md-truncate>
     </div>
   </md-toolbar>
   <md-content layout-padding="">
    <md-content layout-padding>
      <md-input-container class="md-block">
        <label><?php echo lang('subject') ?></label>
        <input required type="text" ng-model="ticket.subject" name="subject" class="form-control">
      </md-input-container>
      <md-input-container class="md-block" flex-gt-xs>
        <md-select ng-model="ticket.customer" data-md-container-class="selectdemoSelectHeader" ng-change="get_contacts(ticket.customer)">
          <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('customer')?></label>
            <input ng-submit="search_customers(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search').' '.lang('customers')?>" class="demo-header-searchbox md-text" ng-keyup="search_customers(search_input)">
          </md-select-header>
          <md-optgroup label="customers">
            <md-option ng-value="customer.id" ng-repeat="customer in all_customers">
              <span class="blur" ng-bind="customer.customer_number"></span> 
              <strong ng-bind="customer.name"></strong><br>
              <span class="blur">(<small ng-bind="customer.email"></small>)</span>
            </md-option>
          </md-optgroup>
        </md-select>
        <br/>
      </md-input-container>
      <md-input-container class="md-block" flex-gt-xs>
        <label><?php echo lang('contact'); ?></label>
        <md-select required ng-model="ticket.contact" name="contact" >
          <md-option ng-value="contact.id" ng-repeat="contact in contacts">{{contact.name + ' ' + contact.surname}}</md-option>
        </md-select><br>
      </md-input-container>
      <md-input-container class="md-block" flex-gt-xs>
        <label><?php echo lang('department'); ?></label>
        <md-select required ng-model="ticket.department" name="department">
          <md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
        </md-select><br>
      </md-input-container>
      <md-input-container class="md-block" flex-gt-xs>
        <label><?php echo lang('priority'); ?></label>
        <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="ticket.priority" name="priority">
          <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
        </md-select><br>
      </md-input-container>
      <md-input-container class="md-block">
        <label><?php echo lang('message') ?></label>
        <textarea required name="message" ng-model="ticket.message" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
      </md-input-container>
      <div class="file-upload">
        <div class="file-select">
          <div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span> <?php echo lang('attachment')?></div>
          <div class="file-select-name" id="noFile"><?php echo lang('nofile')?></div>
          <input type="file" name="attachment" id="chooseFile" file-model="ticket.attachment">
        </div>
      </div>
      <br>
      <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
        <md-button ng-click="createTicket()" class="md-raised md-primary btn-report block-button" ng-disabled="uploading == true">
          <span ng-hide="uploading == true"><?php echo lang('create');?></span>
          <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
        </md-button>
        <br/><br/><br/><br/>
      </section>
    </md-content>
  </md-content>
</md-sidenav>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="TicketsSettings" ng-cloak style="width: 450px;">
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
          <md-truncate><?php echo lang('settings') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-toolbar class="toolbar-white" style="background:#262626">
          <div class="md-toolbar-tools">
            <h4 class="text-bold text-muted" flex><?php echo lang('ticketsstatuses') ?></h4>
            <?php if (check_privilege('tickets', 'edit')) { ?> 
            <?php } if (check_privilege('tickets', 'create')) { ?> 
              <md-button aria-label="Add Status" class="md-icon-button" ng-click="NewStatus()">
                <md-tooltip md-direction="top"><?php echo lang('addstatus') ?></md-tooltip>
                <md-icon aria-label="Add Status"><i class="ion-plus-round text-success"></i></md-icon>
              </md-button>
            <?php } ?>
          </div>
        </md-toolbar>
        <md-list-item ng-repeat="status in ticketstatuses" class="noright" ng-click="EditStatus(status.id,status.name, $event)" aria-label="Edit Status"> <strong ng-bind="status.name"></strong>
          <?php if (check_privilege('tickets', 'delete')) { ?> 
            <md-icon ng-click='DeleteTicketStatus($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b">
              <md-tooltip md-direction="top"><?php echo lang('delete') ?></md-tooltip>
            </md-icon>
          <?php } ?>
        </md-list-item>
      </md-content>
    </md-sidenav>


</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/tickets.js') ?>"></script>