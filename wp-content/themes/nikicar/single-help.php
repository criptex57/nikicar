<?=get_header()?>
<?php $post = get_post();?>

<?php //?>
<?php //$post->post_date?>
<div class="help-single-container">
    <div class="help-single-container-block">
        <div class="help-single-title">
            <h2><?=$post->post_title?></h2>
            <a class="btn help-single-donate" target="_blank" href="<?=CFS()->get('help-single-monobank') ?>">Задонатити</a>
        </div>
        <?php foreach(wordSafeBreak($post->post_content) as $key => $body):?>
          <div class="help-single-body-desktop">
            <?=$body?>
          </div>
        <?php endforeach;?>
        <div class="help-single-body-mobile">
          <?=$post->post_content?>
        </div>
    </div>
    <div class="sim-slider">
        <ul class="sim-slider-list">
            <?php if(get_the_post_thumbnail_url($post->ID)):?>
                <li class="sim-slider-element"><img src="<?=get_the_post_thumbnail_url($post->ID)?>" alt="'.$key.'"></li>
            <?php endif;?>
            <?php if(CFS()->get('help-single-images')):?>
                <?php foreach(CFS()->get('help-single-images') as $key => $image):?>
                    <li class="sim-slider-element"><img src="<?=$image['help-single-image']?>" alt="'.$key.'"></li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
        <div class="sim-slider-dots"></div>
        <div class="sim-slider-arrow-left"></div>
        <div class="sim-slider-arrow-right"></div>
    </div>
    <?php if(CFS()->get('help-single-video-block')):?>
        <div class="help-single-video-container">
            <?php foreach(CFS()->get('help-single-video-block') as $key => $video):?>
                <div class="help-single-video-div">
                    <h2><?=$video['help-single-video-title']?></h2>
                    <?=$video['help-single-video']?>
                </div>

            <?php endforeach;?>
        </div>
    <?php endif;?>
</div>

<?=get_footer()?>