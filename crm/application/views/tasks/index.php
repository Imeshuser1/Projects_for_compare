<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
  .topRow {
    margin-bottom: 30px;
  }

  .on-drag-enter {}

  .on-drag-hover:before {
    display: block;
    color: white;
    font-size: x-large;
    font-weight: 800;
  }
</style>
<div class="ciuis-body-content" ng-controller="Tasks_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
    <div class="panel-heading"> <strong><?php echo lang('tasksituation'); ?></strong> <span class="panel-subtitle"><?php echo lang('tasksituationsdesc'); ?></span> </div>
    <div class="row">
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'1'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'1'}).length * 100 / tasks.length }}%;"></span> </span>
        </div>
        <span style="color:#989898"><?php echo lang('open'); ?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'2'}).length * 100 / tasks.length }}%;"></span> </span>
        </div>
        <span style="color:#989898"><?php echo lang('inprogress'); ?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'3'}).length * 100 / tasks.length }}%;"></span> </span>
        </div>
        <span style="color:#989898"><?php echo lang('waiting'); ?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'4'}).length * 100 / tasks.length }}%;"></span> </span>
        </div>
        <span style="color:#989898"><?php echo lang('complete'); ?></span>
      </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
    <md-toolbar class="bg-white toolbar-white">
      <div class="md-toolbar-tools bg-white">
        <h2 flex md-truncate class="text-bold"><?php echo lang('tasks'); ?> <small>(<span ng-bind="tasks.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organizeyourtasks'); ?></small>
        </h2>
        <div class="ciuis-external-search-in-table" ng-if="!KanbanBoard">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by') . ' ' . lang('task') . ' ' . lang('name')   ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('search') . ' ' . lang('tasks') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-if="!KanbanBoard" ng-click="ShowKanban();updateColumns('list_view', false);" class="md-icon-button" aria-label="Show Kanban" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('showkanban'); ?></md-tooltip>
          <md-icon><i class="mdi mdi-view-week text-muted"></i></md-icon>
        </md-button>
        <md-button ng-if="KanbanBoard" ng-click="HideKanban();updateColumns('list_view', true);" class="md-icon-button" aria-label="Show List" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('showlist'); ?></md-tooltip>
          <md-icon><i class="mdi mdi-view-list text-muted"></i></md-icon>
        </md-button>
        <md-menu ng-if="!KanbanBoard" md-position-mode="target-right target">
          <md-button class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
            <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
            <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4" ng-cloak>
            <md-contet layout-padding>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.name" ng-change="updateColumns('name', table_columns.name);">
                <?php echo lang('task') . ' ' . lang('name') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.startdate" ng-change="updateColumns('startdate', table_columns.startdate);">
                <?php echo lang('startdate') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.duedate" ng-change="updateColumns('duedate', table_columns.duedate);">
                <?php echo lang('duedate') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.priority" ng-change="updateColumns('priority', table_columns.priority);">
                <?php echo lang('priority') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.status" ng-change="updateColumns('status', table_columns.status);">
                <?php echo lang('status') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.relation" ng-change="updateColumns('relation', table_columns.relation);">
                <?php echo lang('relation') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.assigned" ng-change="updateColumns('assigned', table_columns.assigned);">
                <?php echo lang('assigned') . ' ' . lang('by'); ?>
              </md-checkbox><br>
            </md-contet>
          </md-menu-content>
        </md-menu>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter') . ' ' . lang('tasks') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('tasks', 'create')) { ?>
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('new') . ' ' . lang('task') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content>
      <div ng-show="taskLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="25"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('tasks') . '...' ?></strong></small></span>
        </p>
      </div>
      <div ng-show="taskDropLoader" class="loader mx-auto text-center" layout-align="center center">
				<?php $rebrand = load_config();
				$preloader =  base_url('assets/img/' . $rebrand['preloader']); ?>
				<div class="inlineLoader" style="background-image: url(<?php echo $preloader ?>);"></div>
			</div>
      <md-content ng-show="!taskLoader" ng-if="KanbanBoard" class="" style="padding: 0px" ng-cloak>
        <md-content class="ciuis_lead_kanban_board col-md-3 text-center" style="padding: 0px;    overflow-y: hidden;" ng-cloak>
          <md-list class="ciuis_lead_status_card" flex ui-on-Drop="onDrop($event,$data,'3')">
            <md-subheader class="md-no-sticky bg-white md_whiteheader">
              <md-icon class="ion-android-alert text-danger"></md-icon><strong><?php echo lang('high') ?></strong>
            </md-subheader>
            <div class="items_list">
              <md-list-item class="md-3-line text-left" ui-draggable="true" drag="task" ng-repeat="task in tasks | filter:high | filter: { priority_id: '3' } | filter: FilteredData" on-drop-success="dropSuccessHandler($event,$index,'3')">
                <div class="md-list-item-text" layout="column">
                  <div layout="row" layout-wrap>
                    <div flex-gt-xs="80" flex-xs="80">
                      <h3 flex>
                        <a class="link" ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}">
                          {{ task.name | limitTo: 30 }}{{task.name.length > 28 ? '...' : ''}}
                        </a>
                      </h3>
                    </div>
                  </div>
                  <p class="small">
                    <span class="blur"><?php echo lang('status') ?>:</span>
                    <span>{{ task.status | limitTo: 30 }}{{task.status.length > 28 ? '...' : ''}}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('startdate') ?>:</span>
                    <span>{{ task.startdate }}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('duedate') ?>:</span>
                    <span>{{ task.duedate}}</span>
                  </p>
                  <p>
                    <span class="blur"> <?php echo lang('assigned') ?>: </span>
                    <span>
                      <md-tooltip md-direction="top">{{ task.assigned }}</md-tooltip>
                      <img ng-src="<?php echo base_url('uploads/images/{{task.staffavatar}}') ?>" class="md-avatar" alt="{{task.assigned}}" style="    ">
                    </span> &nbsp;&nbsp;&nbsp;
                  </p>
                </div>
              </md-list-item>
            </div>
          </md-list>
          <br><br><br>
        </md-content>
        <md-content class="ciuis_lead_kanban_board  col-md-3  text-center" style="padding: 0px;    overflow-y: hidden; overflow-x: unset;" ng-cloak>
          <md-list class="ciuis_lead_status_card" flex ui-on-Drop="onDrop($event,$data,'2')">
            <md-subheader class="md-no-sticky bg-white">
              <md-icon class="ion-android-alert text-warning"></md-icon><strong><?php echo lang('medium') ?></strong>
            </md-subheader>
            <div class="items_list">
              <md-list-item class="md-3-line text-left" ui-draggable="true" drag="task" on-drop-success="dropSuccessHandler($event,$index,'2')" ng-repeat="task in tasks | filter:medium | filter: { priority_id: '2'} | filter: FilteredData">
                <div class="md-list-item-text" layout="column">
                  <div layout="row" layout-wrap>
                    <div flex-gt-xs="80" flex-xs="80">
                      <h3 flex>
                        <a class="link" ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}">
                          {{ task.name | limitTo: 30 }}{{task.name.length > 28 ? '...' : ''}}
                        </a>
                      </h3>
                    </div>
                  </div>
                  <p class="small">
                    <span class="blur"><?php echo lang('status') ?>:</span>
                    <span>{{ task.status | limitTo: 30 }}{{task.status.length > 28 ? '...' : ''}}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('startdate') ?>:</span>
                    <span>{{ task.startdate }}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('duedate') ?>:</span>
                    <span>{{ task.duedate}}</span>
                  </p>
                  <p>
                    <span class="blur"> <?php echo lang('assigned') ?>: </span>
                    <span>
                      <md-tooltip md-direction="top">{{ task.assigned }}</md-tooltip>
                      <img ng-src="<?php echo base_url('uploads/images/{{task.staffavatar}}') ?>" class="md-avatar" alt="{{task.assigned}}" style="    ">
                    </span> &nbsp;&nbsp;&nbsp;
                  </p>
                </div>
              </md-list-item>
            </div>
          </md-list>
          <br><br><br>
        </md-content>
        <md-content class="ciuis_lead_kanban_board   col-md-3  text-center" style="padding: 0px;    overflow-y: hidden; overflow-x: unset;" ng-cloak>
          <md-list class="ciuis_lead_status_card" flex ui-on-Drop="onDrop($event,$data,'1')">
            <md-subheader class="md-no-sticky bg-white">
              <md-icon class="ion-android-alert text-success"></md-icon><strong><?php echo lang('low') ?></strong>
            </md-subheader>
            <div class="items_list">
              <md-list-item class="md-3-line text-left" ui-draggable="true" drag="task" on-drop-success="dropSuccessHandler($event,$index,'1')" ng-repeat="task in tasks | filter:low | filter: { priority_id: '1'} | filter: FilteredData">
                <div class="md-list-item-text" layout="column">
                  <div layout="row" layout-wrap>
                    <div flex-gt-xs="80" flex-xs="80">
                      <h3 flex>
                        <a class="link" ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}">
                          {{ task.name | limitTo: 30 }}{{task.name.length > 28 ? '...' : ''}}
                        </a>
                      </h3>
                    </div>
                  </div>
                  <p class="small">
                    <span class="blur"><?php echo lang('status') ?>:</span>
                    <span>{{ task.status | limitTo: 30 }}{{task.status.length > 28 ? '...' : ''}}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('startdate') ?>:</span>
                    <span>{{ task.startdate }}</span>
                  </p>
                  <p class="small">
                    <span class="blur"><?php echo lang('duedate') ?>:</span>
                    <span>{{ task.duedate}}</span>
                  </p>
                  <p>
                    <span class="blur"> <?php echo lang('assigned') ?>: </span>
                    <span>
                      <md-tooltip md-direction="top">{{ task.assigned }}</md-tooltip>
                      <img ng-src="<?php echo base_url('uploads/images/{{task.staffavatar}}') ?>" class="md-avatar" alt="{{task.assigned}}" style="    ">
                    </span> &nbsp;&nbsp;&nbsp;
                  </p>
                </div>
              </md-list-item>
            </div>
          </md-list>
          <br><br><br>
        </md-content>
      </md-content>
      <div ng-show="!taskLoader" ng-if="!KanbanBoard" class="bg-white" style="padding: unset;">
        <md-table-container ng-show="tasks.length > 0">
          <table md-table md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo lang('task'); ?></span></th>
                <th ng-show="table_columns.startdate" md-column md-order-by="startdate"><span><?php echo lang('startdate'); ?></span></th>
                <th ng-show="table_columns.duedate" md-column md-order-by="duedate"><span><?php echo lang('duedate'); ?></span></th>
                <th ng-show="table_columns.priority" md-column md-order-by="priority"><span><?php echo lang('priority'); ?></span></th>
                <th ng-show="table_columns.status" md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
                <th ng-show="table_columns.relation" md-column md-order-by="status"><span><?php echo lang('relation'); ?></span></th>
                <th ng-show="table_columns.assigned" md-column md-order-by="assigned"><span><?php echo lang('assigned') . ' ' . lang('by'); ?></span></th>
              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="task in tasks | orderBy: task_list.order | limitTo: task_list.limit : (task_list.page -1) * task_list.limit | filter: task_search | filter: FilteredData" class="cursor" ng-click="goToLink('tasks/task/'+task.id)">
                <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}"> <strong ng-bind="task.task_number"></strong></a> <br>
                    <small ng-show="table_columns.name" ng-bind="task.name"></small>
                  </strong>
                </td>
                <td ng-show="table_columns.startdate" md-cell>
                  <strong class="badge" ng-bind="task.startdate"></strong>
                </td>
                <td ng-show="table_columns.duedate" md-cell>
                  <strong class="badge" ng-bind="task.duedate"></strong>
                </td>
                <td ng-show="table_columns.priority" md-cell>
                  <strong ng-bind="task.priority"></strong>
                </td>
                <td ng-show="table_columns.status" md-cell>
                  <span>
                    <strong ng-bind="task.status"></strong>
                  </span>
                </td>
                <td ng-show="table_columns.relation" md-cell>
                  <span>
                    <strong class="text-bold"><a class="label label-info" href="<?php echo base_url('projects/project/{{task.relation}}') ?>"><?php echo lang('project') ?> <i class="ion-android-open"></i></a> </strong>
                  </span>
                </td>
                <td ng-show="table_columns.assigned" md-cell>
                  <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{task.assigned}}" class="assigned-staff-for-this-lead user-avatar">
                    <img ng-src="<?php echo base_url('uploads/images/{{task.staffavatar}}') ?>" alt="{{task.assigned}}">
                    <md-tooltip md-direction="left" ng-bind="task.assigned"></md-tooltip>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="limitOptions" md-page="task_list.page" md-total="{{tasks.length}}"></md-table-pagination>
        <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
      </div>
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
      <div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'relationtype' && prop != 'duedate' && prop != 'startdate' && prop != 'status' && prop != 'done' && prop != 'status_id' && prop != 'task_number' && prop != 'staffavatar' && prop != 'priority' && prop != 'assigned' && prop != 'relation' && prop != 'priority_id'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>


  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
        <md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable') . ' ' . lang('task') ?></strong>
          <md-tooltip ng-hide="savingInvoice == true" md-direction="bottom"><?php echo lang('task_as_billable') ?></md-tooltip>
        </md-switch>
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
        <md-input-container class="md-block" flex-gt-xs style="display: none;">
          <label><?php echo lang('relationtype'); ?></label>
          <md-select ng-init="relation_types = [{value: 'project',name: '<?php echo lang('project'); ?>'}, {value: 'ticket',name: '<?php echo lang('ticket'); ?>'}];" disabled placeholder="<?php echo lang('relationtype'); ?>" ng-model="Relation_Type" name="relationtype" style="min-width: 200px;">
            <md-option ng-value="relation_type.value" ng-repeat="relation_type in relation_types"><span class="text-uppercase">{{relation_type.name}}</span></md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
          <label><?php echo lang('project'); ?></label>
          <md-select required ng-model="RelatedProject" name="relation" style="min-width: 200px;">
            <md-option ng-value="project" ng-repeat="project in projects">{{project.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
          <label><?php echo lang('milestone'); ?></label>
          <md-select ng-model="SelectedMilestone" name="relation" style="min-width: 200px;">
            <md-option ng-value="milestone.id" ng-repeat="milestone in RelatedProject.milestones">{{milestone.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('task') . ' ' . lang('name') ?></label>
          <input required type="text" ng-model="task.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>" />
        </md-input-container>
        <md-input-container ng-show="isBillable === true" class="md-block">
          <label><?php echo lang('task') . ' ' . lang('hourlyrate') ?></label>
          <input required type="text" ng-model="task.hourlyrate" class="form-control" id="title" placeholder="0.00" />
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('task') . ' ' . lang('startdate') ?></label>
          <input mdc-datetime-picker="" date="true" format="{{DateTimeFormat}}" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" show-icon="true" ng-model="task.startdate" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('task') . ' ' . lang('duedate') ?></label>
          <input mdc-datetime-picker="" date="true" format="{{DateTimeFormat}}" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="task.startdate" show-icon="true" ng-model="task.duedate" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('assigned'); ?></label>
          <md-select required ng-model="task.assigned" name="assigned" style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('task') . ' ' . lang('priority'); ?></label>
          <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];task.priority_id = 2;" required placeholder="<?php echo lang('task') . ' ' . lang('priority'); ?>" ng-model="task.priority_id" name="priority" style="min-width: 200px;">
            <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
          </md-select>
        </md-input-container>
        <br>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('task') . ' ' . lang('description') ?></label>
          <textarea rows="2" required name="description" ng-model="task.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <md-switch style="display: none;" ng-model="isPublic" ng-init="isPublic = true" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
        <md-switch style="display: none;" ng-model="isVisible" ng-init="isVisible = true" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
      </md-content>
      <custom-fields-vertical></custom-fields-vertical>
      <md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddTask()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
            <span ng-hide="saving == true"><?php echo lang('create'); ?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br /><br /><br /><br />
        </section>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tasks.js'); ?>"></script>