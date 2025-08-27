<md-tab label="<?php echo lang('payslips'); ?>">
  <md-content class="md-padding bg-white">
    <ul class="custom-ciuis-list-body" style="padding: 0px;">
      <li ng-repeat="template in templates | filter: { relation: 'hrm' }  " class="milestone-todos-list ciuis-custom-list-item ciuis-special-list-item paginationclass" style="min-width: 100% !important;">
        <a href="<?php echo base_url('emails/template/') ?>{{template.id}}">
          <ul class="all-milestone-todos">
            <li ng-show="template.status == '1'" class="milestone-todos-list-item col-md-12 done" style="color: unset;">
              <span class="pull-left col-md-6">
                <strong ng-bind="template.name"></strong><br>
              </span>
              <div class="col-md-6">
                <div class="col-md-8">
                  <span class="date-start-task">
                    <small class="text-muted text-uppercase"><?php echo lang('subject'); ?></small><br>
                    <strong ng-bind="template.subject"></strong>
                  </span>
                </div>
                <div class="col-md-4">
                  <span class="date-start-task">
                    <small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br>
                    <strong class="badge green"><?php echo lang('active'); ?></strong>
                  </span>
                </div>
              </div>
            </li>
            <li ng-show="template.status != '1'" class="milestone-todos-list-item col-md-12">
              <span class="pull-left col-md-6">
                <strong ng-bind="template.name"></strong><br>
              </span>
              <div class="col-md-6">
                <div class="col-md-8">
                  <span class="date-start-task">
                    <small class="text-muted text-uppercase"><?php echo lang('subject'); ?></small><br>
                    <strong ng-bind="template.subject"></strong>
                  </span>
                </div>
                <div class="col-md-4">
                  <span class="date-start-task">
                    <small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br>
                    <strong class="badge red"><?php echo lang('inactive'); ?></strong>
                  </span>
                </div>
              </div>
            </li>
          </ul>
        </a>
      </li>
    </ul>
  </md-content>
</md-tab>