<?php //Template Name: Допомога ?>
<?=get_header()?>
<div class="help-container">
    <div class="help-title"><?=CFS()->get('help-page-title')?></div>
    <div class="help-about">
      <?=CFS()->get('help-page-desc')?>
    </div>
    <div class="help-content">
        <?php foreach (get_posts( ['post_type' => 'help'] ) as $help){?>
            <?php if(get_the_post_thumbnail_url($help->ID)){?>
                <div class="help-item">
                    <img src="<?=get_the_post_thumbnail_url($help->ID)?>" alt="">
                    <div class="help-item-text-container">
                        <div class="help-date">
                          <i class="help-date-ico"></i>
                          <?= date('d/m', strtotime(CFS()->get('help_from', $help->ID)))?> - <?= date('d/m', strtotime(CFS()->get('help_to', $help->ID)))?>
                        </div>
                        <div class="help-item-title"><?=$help->post_title?></div>
                        <div class="help-item-desc"><?=CFS()->get('help_desc', $help->ID)?></div>
                        <a href="<?= '/'.$help->post_type.'/'.$help->post_name?>">Більше</a>
                    </div>
                </div>
            <?php }?>
        <?php }?>
    </div>
</div>
<?=get_footer()?>