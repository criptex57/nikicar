<?php //Template Name: Допомога ?>
<?=get_header()?>
<div class="report-container">
    <div class="report-head">
        <div class="report-head-title">
          <?= CFS()->get('report-page-title')?>
        </div>
        <div class="report-head-desc">
          <?= CFS()->get('report-page-desc')?>
        </div>
    </div>
    <div class="report-content-loop">
      <?php $i = 0;?>
      <?php foreach (get_posts( ['post_type' => 'report'] ) as $help):?>
          <div class="report-content <?=$i==2||$i==3?'report-move':''?>">
              <div class="report-content-text">
                <div class="report-content-text-date"><?=date('d.m.y', strtotime($help->post_date))?></div>
                <div class="report-content-text-title"><?=$help->post_title?></div>
              </div>
              <div class="report-content-image" style="background: url('<?=get_the_post_thumbnail_url($help->ID)?>') no-repeat; background-size: cover; background-position: center">
                  <a class="btn" href="<?php echo '/'.$help->post_type.'/'.$help->post_name?>">Більше</a>
              </div>
          </div>
      <?php $i = $i<4?++$i:0;?>
      <?php endforeach;?>
    </div>
</div>
<?=get_footer()?>