<?php //Template Name: Про нас ?>
<?=get_header()?>
<div class="about-us-first-block-container">
    <div class="about-us-first-block-container-top">
        <div class="about-us-first-block-description">
            <h1><?=CFS()->get('aboutus-title')?></h1>
            <div class="about-us-first-block-text">
                <?=CFS()->get('aboutus-desc')?>
            </div>
        </div>
        <div class="about-us-first-block-logo">
            <div class="about-us-first-block-image">
                <div style='background: url("<?=CFS()->get('aboutus-image');?>") no-repeat; background-position: center; background-size: contain;'><a href="/help">Підтримати</a></div>
            </div>
        </div>
    </div>
    <div class="about-us-first-block-icons-cont">
        <?php foreach (CFS()->get('aboutus-typeactivity') as $key => $image) { ?>
            <div class="about-us-first-block-icons-item">
                <div class="about-us-first-block-icons-ico">
                    <img src="<?=$image['aboutus-typeactivity-image']?>" alt="">
                </div>
                <div class="about-us-first-block-icons-text">
                    <h3><?=$image['aboutus-typeactivity-title']?></h3>
                    <p><?=$image['aboutus-typeactivity-desc']?></p>
                </div>
            </div>
        <?php }?>
    </div>
</div>
<div class="about-us-members">
    <h2>НАШІ АКТИВІСТИ</h2>
    <div class="about-us-members-container">
      <?php foreach (CFS()->get('volunteers') as $key => $image) { ?>
          <div class="about-us-members-item">
              <div class="about-us-members-photo">
                  <img src="<?=$image['volunteers-image']?>" width="320px" alt="">
              </div>
              <div class="about-us-members-name"><?=$image['volunteers-name']?></div>
              <div class="about-us-members-desc"><?=$image['volunteers-desc']?></div>
          </div>
      <?php }?>
    </div>
</div>
<?=get_footer()?>