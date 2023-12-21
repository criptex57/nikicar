<?=get_header()?>
<?php $post = get_post();?>
<div class="report-single-container">
    <div class="report-single-head">
        <div class="report-single-head-title">
            <div class="report-single-date"><?=date('d.m.y', strtotime($post->post_date))?></div>
            <h1 class="report-single-title"><?=$post->post_title?></h1>
        </div>
        <div class="report-single-head-preview">
            <img width="500" src="<?=get_the_post_thumbnail_url($post->ID)?>" alt="">
        </div>
    </div>
    <div class="report-single-body">
        <div class="report-single-text"><?=$post->post_content?></div>
    </div>
</div>
<div class="report-container">
    <h2>Дивіться також:</h2>
    <div class="report-content-loop">

        <?php foreach (get_posts(['post_type' => 'report', 'orderby' => 'rand', 'numberposts' => 3, 'post__not_in' => [$post->ID]]) as $help):?>
            <div class="report-content">
                <div class="report-content-text">
                    <div class="report-content-text-date"><?=date('d.m.y', strtotime($help->post_date))?></div>
                    <div class="report-content-text-title"><?=$help->post_title?></div>
                </div>
                <div class="report-content-image-cont">
                    <div class="report-content-image" style="background: url('<?=get_the_post_thumbnail_url($help->ID)?>') no-repeat; background-size: cover; background-position: center"></div>
                    <a class="btn" href="<?php echo '/'.$help->post_type.'/'.$help->post_name?>">Більше</a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?=get_footer()?>