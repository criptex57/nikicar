<?php //Template Name: Сувеніри ?>
<?=get_header()?>
<div class="souvenir-container">
    <div class="souvenir-head">
        <div class="souvenir-title"><?= CFS()->get('report-souvenir-title')?></div>
        <div class="souvenir-desc"><?= CFS()->get('report-souvenir-desc')?></div>
    </div>
    <div class="souvenir-body">
	    <?php foreach (get_posts( ['post_type' => 'souvenir'] ) as $help):?>
            <div class="souvenir-item">
                <div class="souvenir-item-image">
                    <img src="<?=get_the_post_thumbnail_url($help->ID)?>" alt="">
                </div>
                <div class="souvenir-item-desc">
                    <div class="souvenir-item-name"><?=$help->post_title?></div>
                    <div class="souvenir-item-price"></div>
                    <a class="btn souvenir-item-btn" href="<?php echo '/'.$help->post_type.'/'.$help->post_name?>">Більше</a>
                </div>
            </div>
	    <?php endforeach;?>
    </div>
</div>
<?=get_footer()?>