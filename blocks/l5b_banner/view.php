<?php
defined('C5_EXECUTE') or die("Access Denied.");

echo $cStyle;
?>
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> pre-hand over-image <?php echo $cFgColorClass?> banner with-fade">

  <?php if (${$cTempl . '_isVideoEnabled'} == true) { ?>
     <div data-animation="bgVideo" class="player" data-property="{videoURL: '<?php echo ${$cTempl . '_videoURL'}?>', quality: '<?php echo ${$cTempl . '_videoHQ'}?>',<?php echo $videoParams?>}"></div>
  <?php } ?>

  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="videoStatus <?php echo $displayVideoStatus?>"><?php echo t('Video is %s', t($videoStatus['text']))?>
      <span class="<?php echo $videoStatus['class']?>"></span>
    </div>
    <div class="row main">

      <?php echo (trim(${$cTempl . '_title'}) == true ? '<h1 data-animation="title" class="' . $nopaque . '">' . ${$cTempl . '_title'} . "</h1>" : null)?>
      <?php echo (trim(${$cTempl . '_subtitle'}) == true ? '<h4 data-animation="subtitle" class="' . $nopaque . '">' . h(${$cTempl . '_subtitle'}) . "</h4>" : null)?>

      <?php
        if (trim($CTA['text']) != '') {
        ?>
        <h5 data-animation="cta" class="no-margin-bottom double-space-top <?php echo $nopaque?>">
          <?php if (trim($CTA['link']) != '' || trim($CTA['hash']) != '') {?>
            <a href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="<?php echo $CTA['class']?> CTA-arrow-top CTA-clean" target="<?php echo $CTA['target']?>">
          <?php }
                echo h($CTA['text']);
                if (trim($CTA['link']) != '' || trim($CTA['hash']) != '') {?>
            </a>
          <?php }?>
        </h5>
      <?php }?>

      <?php if ((trim($CTA['text']) != '') && ((trim($CTA['link']) != '') || (trim($CTA['hash']) != ''))) {?>
          <a href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="<?php echo $CTA['class']?> CTA-arrow CTA-clean" target="<?php echo $CTA['target']?>">
            <i data-animation="top-arrow" class="fa fa-angle-down fa-4x infinite <?php echo $nopaque?>"></i>
          </a>
      <?php }?>
    </div>
  </div>
</section>
