<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   https://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) current year                                               |
| ------------------------------------------------------------------------- |
| @license: Concrete5.org Marketplace Commercial Add-Ons & Themes License   |
|           https://concrete5.org/help/legal/commercial_add-on_license      |
|           or just: file://theme_lazy5basic/LICENSE.TXT                    |
|                                                                           |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/
defined('C5_EXECUTE') or die("Access Denied.");

echo $cStyle;
?>
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> pre-hand over-image <?php echo $cFgColorClass?> banner with-fade">

  <?php if (${$cTempl . '_isVideoEnabled'} == true) { ?>
     <div data-animation="bgVideo" class="player <?php echo $videopaque?>" data-property="{videoURL: '<?php echo ${$cTempl . '_videoURL'}?>', quality: '<?php echo ${$cTempl . '_videoHQ'}?>',<?php echo $videoParams?>}"></div>
  <?php } ?>

  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="videoStatus <?php echo $displayVideoStatus?>"><?php echo t('Video is %s', t($videoStatus['text']))?>
      <span class="<?php echo $videoStatus['class']?>"></span>
    </div>
    <div class="row main">
      <div class="col-md-4 offset-md-1 col-sm-6 banner-left">
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
                <a  href="<?php echo trim($CTA['link'])?><?php echo trim($CTA['hash'])?>" class="btn btn-primary <?php echo $CTA['class']?>" target="<?php echo $CTA['target']?>">
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
            <img class="img-responsive" width="<?php echo $image['width']?>" height="<?php echo $image['height']?>" src="<?php echo $image['path']?>" alt="" />
          </picture>
        </div>
      </div>
    </div>
  </div>
</section>
