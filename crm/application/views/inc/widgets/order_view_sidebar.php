
<aside class="page-aside" style="right: 0px; padding-bottom: 61px; z-index: 999; border-radius: 0px; overflow: scroll; overflow-x: hidden; background: rgb(255, 255, 255); border-left: 3px solid rgb(238, 238, 238);">
  <div class="ciuis-body-scroller nano ps-container ps-theme-default" data-ps-id="ac74da58-8e1c-6b15-4582-65d6b23ba5fc">
    <div class="panel-default panel-table borderten lead-manager-head" style="overflow: scroll;">
      <div class="panel-heading">
        <div id="details" class="clearfix" style="font-size: 12px;">
          <div id="order">
            <h1><?php echo $orders['order_number'] ?></h1>
            <div class="date text-bold"><?php echo lang('dateofissuance')?>:
              <?php echo date(get_dateFormat(), strtotime($orders['date']))?>
            </div>
            <div class="date text-bold"><?php echo lang('opentill')?>:
              <?php echo date(get_dateFormat(), strtotime($orders['opentill']))?>
            </div>
          </div>
          <div id="company">
            <h2 class="crm-company-name"><?php echo $settings['company'] ?></h2>
            <div><?php echo $settings['address'] ?></div>
            <div><?php echo lang('phone')?>:</b><?php echo $settings['phone'] ?></div>
            <div><a href="mailto:<?php echo $settings['email'] ?>"><?php echo $settings['email'] ?></a></div>
          </div>
          <div id="client">
            <div class="orderto"><b><?php echo lang('orderto'); ?>:</b></div>
            <h2 class="toname"><?php if($orders['relation_type'] == 'customer'){if($orders['customercompany']===NULL){echo $orders['namesurname'];} else echo $orders['customercompany'];} ?><?php if($orders['relation_type'] == 'lead'){echo $orders['leadname'];} ?></h2>
            <div class="address"><?php echo $orders['toaddress']; ?></div>
            <div class="email"><a href="mailto:<?php echo $orders['toemail']; ?>"><?php echo $orders['toemail']; ?></a></div>
          </div>
        </div>
        <hr>
        <div class="btn-group col-md-12 md-pr-0 md-pl-0 md-pb-10">
          <?php if($orders['status_id'] == 1 || $orders['status_id'] == 2 || $orders['status_id'] == 3 || $orders['status_id'] == 4   || $orders['status_id'] == 5 ) { ?>
            <div id="actionButton">
              <button data-order="<?php echo $orders['id']; ?>" class="btn accept-order btn-default btn-big col-md-4"><i class="icon ion-checkmark-round"></i> <?php echo lang('accept')?></button>
              <button data-order="<?php echo $orders['id']; ?>" class="btn decline-order btn-default btn-big col-md-4"><i class="icon ion-close-round"></i> <?php echo lang('decline')?> </button>
            </div>
            <?php } ?>
          <a target="_blank" href="<?php echo base_url('share/pdf_order/'.$orders['token'].''); ?>" class="btn btn-default btn-big col-md-4"><i class="icon ion-document"></i> <?php echo lang('pdf')?> </a></div>
        <!-- <?php //foreach($comments as $comment){?>
        
        <div class="comment-block">
          <div class="comment-dialog">
            <p class="text"><?php echo $comment['content'] ?></p>
          </div>
        </div> 
        <?php //}?> -->
        <!-- <div style="<?php if($orders['comment']!=1){echo 'display:none;';}?>"> <?php echo form_open_multipart('share/customercomment',array("class"=>"")); ?>
          <div class="form-group">
            <textarea required="" name="content" class="form-control"><?php $this->input->post('content')?></textarea>
            <input type="hidden" name="relation" value="<?php echo $orders['id'] ?>">
          </div>
          <button type="submit" class="btn btn-lg btn-default col-md-12"><?php echo lang('addcomment');?></button>
          <?php echo form_close(); ?> </div>
      </div> -->
    </div>
  </div>
</aside>