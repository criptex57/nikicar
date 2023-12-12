<?=get_header()?>
<?php $post = get_post();?>
    <div class="report-single-container">
        <div class="report-single-head">
            <div class="report-single-head-title">
                <div class="report-single-title"><?=$post->post_title?></div>
                <div class="report-single-date"><?=date('d.m.y', strtotime($post->post_date))?></div>
            </div>
            <div class="report-single-head-preview">
                <img width="500" src="<?=get_the_post_thumbnail_url($post->ID)?>" alt="">
            </div>
        </div>
        <div class="report-single-body">
            <div class="report-single-text"><?=$post->post_content?></div>
        </div>
    </div>
<?=get_footer()?>