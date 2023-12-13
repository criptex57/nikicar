<?php //Template Name: Сувеніри ?>
<?=get_header()?>
<div class="souvenir-container">
    <div class="souvenir-head">
        <div class="souvenir-title"><?= CFS()->get('souvenir-title')?></div>
        <div class="souvenir-desc"><?= CFS()->get('souvenir-desc')?></div>
    </div>
    <div class="souvenir-body">
	    <?php foreach (get_posts( ['post_type' => 'souvenir'] ) as $souvenir):?>
            <div class="souvenir-item">
                <div class="souvenir-item-image">
                    <img src="<?=get_the_post_thumbnail_url($souvenir->ID)?>" alt="">
                </div>
                <div class="souvenir-item-desc">
                    <div class="souvenir-item-name"><?=$souvenir->post_title?></div>
                    <div class="souvenir-item-price"><?=CFS()->get('souvenir-single-price', $souvenir->ID)?> ГРН</div>
                    <a class="souvenir-item-btn" href="<?php echo '/'.$souvenir->post_type.'/'.$souvenir->post_name?>">Більше</a>
                </div>
            </div>
	    <?php endforeach;?>
    </div>
</div>
<?=get_footer()?>