<?=get_header()?>
<div class="sim-slider">
  <ul class="sim-slider-list">
      <?php foreach (CFS()->get('slider') as $key => $image) {
        echo '<li class="sim-slider-element"><img src="'.$image['slider_image'].'" alt="'.$key.'"></li>';
      }?>
  </ul>
  <div class="sim-slider-text-block">
    <b><?=CFS()->get('slider_text')?></b>
  </div>

  <div class="sim-slider-dots"></div>
  <div class="sim-slider-arrow-left"></div>
  <div class="sim-slider-arrow-right"></div>
</div>
<div class="inquire">
  <div class="inquire-text">
    <div class="inquire-text-title"><b><?=CFS()->get('inquire-text-title')?></b></div>
    <div class="inquire-text-cont"><b><?=CFS()->get('inquire-text-cont')?></div>
  </div>
  <div class="inquire-anim" id="anim-cont">
    <div class="inquire-partial" id="anim-part">
      <a id="anim-link" href="#"><b>Більше 〉</b></a>
    </div>
  </div>
</div>
<div class="souvenir">
  <div class="souvenir-text">
    <div class="souvenir-text-title"><b><b><?=CFS()->get('souvenir-text-title')?></b></div>
    <div class="souvenir-text-cont"><b><?=CFS()->get('souvenir-text-cont')?></div>
  </div>
  <div class="souvenir-images">
    <div class="souvenir-block"><a href="#"><img src="/wp-content/themes/nikicar/assets/img/souvenir_1.png" alt=""></a></div>
    <div class="souvenir-block"><a href="#"><img src="/wp-content/themes/nikicar/assets/img/souvenir_2.png" alt=""></a></div>
    <div class="souvenir-block"><a href="#"><img src="/wp-content/themes/nikicar/assets/img/souvenir_3.png" alt=""></a></div>
    <div class="souvenir-block"><a href="#"><img src="/wp-content/themes/nikicar/assets/img/souvenir_4.png" alt=""></a></div>
  </div>
</div>
<div class="contacts">
  <div class="contacts-image">
    <div></div>
  </div>
  <div class="contacts-phone">
    <div class="contacts-title"><b>КОНТАКТИ</b></div>
    <div class="contacts-data">
      <div><i class="ico-phone"></i><span><?=CFS()->get('phone')?></span></div>
      <div><i class="ico-mail"></i><span><?=CFS()->get('email')?></span></div>
    </div>
  </div>
  <div class="contacts-icons">
    <a href="<?=CFS()->get('telegram')?>"><i class="cont-ico ico-telegram"></i></a>
    <a href="<?=CFS()->get('instagram')?>"><i class="cont-ico ico-instagram"></i></a>
    <a href="<?=CFS()->get('facebook')?>"><i class="cont-ico ico-facebook"></i></a>
  </div>
</div>
<?=get_footer()?>