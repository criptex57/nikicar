<?=get_header()?>
<?php $post = get_post();?>
<div class="souvenir-self" id="souvenir-item"
     data-post-id="<?=$post->ID?>"
     data-post-title="<?=$post->post_title?>"
     data-post-slug="<?=$post->post_name?>"
     data-post-image="<?=get_the_post_thumbnail_url($post->ID)?>"
     data-post-price="<?=CFS()->get('souvenir-single-price')?>">
    <h1 class="souvenir-self-head-title"><?=$post->post_title?></h1>
    <div class="souvenir-self-container">
        <div class="souvenir-self-head">
            <div class="souvenir-self-head-images">
                <div class="souvenir-self-head-images-main">
                    <img class="lightbox-self-image souvenir-self-image" src="<?=get_the_post_thumbnail_url($post->ID)?>" alt="">
                </div>
			    <?php $photos = CFS()->get('souvenir-single-more-photo'); if($photos):?>
                    <div class="souvenir-self-head-images-oth">
					    <?php foreach ($photos as $photo):?>
                            <img class="lightbox-self-image souvenir-self-image" src="<?=$photo['souvenir-single-more-photo-item']?>" alt="">
					    <?php endforeach;?>
                    </div>
			    <?php endif;?>
            </div>
        </div>
        <div class="souvenir-self-body">
            <div class="souvenir-self-head-desc"><?=$post->post_content?></div>
	        <?php $variants = CFS()->get('souvenir-single-variant'); if($variants):?>
            <div class="souvenir-self-head-vari-title">Варіанти сувеніра:</div>
            <div class="souvenir-self-head-vari">
                <?php foreach ($variants as $key => $variant):?>
                    <div class="souvenir-self-head-vari-item" data-var-id="<?=$key?>">
                        <img class="souvenir-self-image" src="<?=$variant['souvenir-single-variant-photo']?>" alt="">
                        <div class="souvenir-self-head-vari-text"><?=$variant['souvenir-single-variant-text']?></div>
                    </div>
                <?php endforeach;?>
            </div>
	        <?php endif;?>
            <div class="souvenir-self-head-price-block">
                <div class="souvenir-self-head-price"><?=CFS()->get('souvenir-single-price')?> ГРН</div>
                <a class="btn souvenir-self-head-by" href="#" id="add-to-cart">ДОДАТИ У КОШИК</a>
            </div>
        </div>
    </div>
    <h2 class="souvenir-single-h2">Розгляньте також:</h2>
    <div class="souvenir-images single">

		<?php foreach (get_posts(['post_type' => 'souvenir', 'orderby' => 'rand', 'numberposts' => 4, 'post__not_in' => [$post->ID]]) as $souvenir):?>
            <div class="souvenir-block">
                <a href="<?php echo '/'.$souvenir->post_type.'/'.$souvenir->post_name?>" class="souvenir-block-btn">Більше</a>
                <a href="<?php echo '/'.$souvenir->post_type.'/'.$souvenir->post_name?>">
                    <img src="<?=get_the_post_thumbnail_url($souvenir->ID, [350,350])?>" alt="<?=$souvenir->post_name?>">
                </a>
            </div>
		<?php endforeach;?>
    </div>
</div>
<?=get_footer()?>