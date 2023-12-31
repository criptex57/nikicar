<?=get_header()?>
<div class="sim-slider">
  <ul class="sim-slider-list">
      <?php foreach (CFS()->get('slider') as $key => $image) {
        echo '<li class="sim-slider-element"><img src="'.$image['slider_image'].'" alt="'.$key.'"></li>';
      }?>
  </ul>
  <h1 class="sim-slider-text-block">
    <b><?=CFS()->get('slider_text')?></b>
  </h1>

  <div class="sim-slider-dots"></div>
  <div class="sim-slider-arrow-left"></div>
  <div class="sim-slider-arrow-right"></div>
</div>
<div class="inquire">
  <div class="inquire-text">
    <h2 class="inquire-text-title"><b><?=CFS()->get('inquire-text-title')?></b></h2>
    <div class="inquire-text-cont"><?=CFS()->get('inquire-text-cont')?></div>
  </div>
  <div class="inquire-anim" id="anim-cont">
    <div class="inquire-partial" id="anim-part">
        <a id="anim-link" href="/help"><b>Більше<span class="help-button"></span></b></a>
    </div>
  </div>
</div>
<div class="souvenir">
  <div class="souvenir-text">
    <h2 class="souvenir-text-title"><b><?=CFS()->get('souvenir-text-title')?></b></h2>
    <div class="souvenir-text-cont"><?=CFS()->get('souvenir-text-cont')?></div>
  </div>
  <div class="souvenir-images">
    <?php foreach (get_posts('post_type=souvenir&orderby=rand&numberposts=4') as $souvenir):?>
        <div class="souvenir-block">
            <a href="<?php echo '/'.$souvenir->post_type.'/'.$souvenir->post_name?>" class="souvenir-block-btn">Більше</a>
            <a href="<?php echo '/'.$souvenir->post_type.'/'.$souvenir->post_name?>">
                <img src="<?=get_the_post_thumbnail_url($souvenir->ID, [350,350])?>" alt="<?=$souvenir->post_name?>">
            </a>
        </div>
    <?php endforeach;?>
  </div>
</div>
<div class="contacts" id="contacts">
  <div class="contacts-image">
    <div></div>
  </div>
  <div class="contacts-phone">
    <h2 class="contacts-title"><b>КОНТАКТИ</b></h2>
    <div class="contacts-data">
      <div><i class="ico-phone"></i><span><?=CFS()->get('phone')?></span></div>
      <div><i class="ico-mail"></i><span><?=CFS()->get('email')?></span></div>
    </div>
  </div>
  <div class="contacts-icons">
    <a target="_blank" href="<?=CFS()->get('telegram')?>"><i class="cont-ico ico-telegram"></i></a>
    <a target="_blank" href="<?=CFS()->get('facebook')?>"><i class="cont-ico ico-facebook"></i></a>
    <!--<a target="_blank" href="<?=CFS()->get('instagram')?>"><i class="cont-ico ico-instagram"></i></a>-->
  </div>
</div>
<?=get_footer()?>