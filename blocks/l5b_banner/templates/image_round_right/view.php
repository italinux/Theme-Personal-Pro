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
      <div class="col-sm-6 col-md-4 col-md-offset-1 banner-left">
        <div class="banner-text">
          <?php echo (trim(${$cTempl . '_title'}) == true ? '<h1 data-animation="title" class="' . $nopaque . '">' . h(${$cTempl . '_title'}) . "</h1>" : null)?>
          <?php echo (trim(${$cTempl . '_subtitle'}) == true ? '<h4 data-animation="subtitle" class="' . $nopaque . '">' . h(${$cTempl . '_subtitle'}) . "</h4>" : null)?>

          <div data-animation="content" class="content <?php echo $nopaque?>">
            <?php
              echo trim(${$cTempl . '_content'});
             ?>
          </div>

          <?php
            if ((trim($CTA['text']) != '') && ((trim($CTA['link']) != '') || (trim($CTA['hash']) != ''))) {?>
              <div data-animation="cta" class="double-space-bottom <?php echo $nopaque?>">
                <a  href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="btn btn-primary <?php echo $CTA['class']?>" target="<?php echo $CTA['target']?>">
                  <?php echo h($CTA['text'])?>
                </a>
              </div>
          <?php
            }
            ?>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 banner-right">
        <div data-animation="photo" class="banner-photo <?php echo $nopaque?>">
          <picture>
            <img class="img-responsive" width="<?php echo $imgWidth?>" height="<?php echo $imgHeight?>" src="<?php echo $image['path']?>" alt="" />
          </picture>
        </div>
      </div>
    </div>
  </div>
</section>
