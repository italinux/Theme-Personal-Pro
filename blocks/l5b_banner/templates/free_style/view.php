<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   http://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) 2020                                                       |
| ------------------------------------------------------------------------- |
| @license: Concrete5.org Marketplace Commercial Add-Ons & Themes License   |
|           https://concrete5.org/help/legal/commercial_add-on_license       |
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
     <div data-animation="bgVideo" class="player" data-property="{videoURL: '<?php echo ${$cTempl . '_videoURL'}?>', quality: '<?php echo ${$cTempl . '_videoHQ'}?>',<?php echo $videoParams?>}"></div>
  <?php } ?>

  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="videoStatus <?php echo $displayVideoStatus?>"><?php echo t('Video is %s', t($videoStatus['text']))?>
      <span class="<?php echo $videoStatus['class']?>"></span>
    </div>
    <div class="row main">

      <div data-animation="content" class="content <?php echo $nopaque?>">
        <?php
          echo trim(${$cTempl . '_content'});
         ?>
      </div>

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

      <?php if ((trim($CTA['link']) != '') || (trim($CTA['hash']) != '')) {?>
          <a href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="<?php echo $CTA['class']?> CTA-arrow CTA-clean" target="<?php echo $CTA['target']?>">
            <i data-animation="top-arrow" class="fa fa-angle-down fa-4x infinite <?php echo $nopaque?>"></i>
          </a>
      <?php }?>
    </div>
  </div>
</section>
