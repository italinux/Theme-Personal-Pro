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
|           http://concrete5.org/help/legal/commercial_add-on_license       |
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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> about-me">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row main">

      <div class="col-xs-12 about-me-left">
        <div data-animation="photo" class="about-me-photo">
          <div class="loader"></div>
          <?php
            if ($image['default']) {
            ?>
            <div class="msg-default <?php echo $playNow?>">
              <h5><?php echo t('No image selected')?></h5>
              <h4><?php echo t('this is default')?></h4>
            </div>
            <?php
            }
          ?>
          <img class="img-responsive <?php echo $playNow?>" width="<?php echo $imgWidth?>" height="<?php echo $imgHeight?>" src="<?php echo $image['path']?>" alt="" />
        </div>
      </div>
      <div class="col-xs-12 about-me-right">
        <div data-animation="text" class="about-me-text">

          <!-- title -->
          <?php echo (trim($title) == true ? "<h2>" . h($title) . "</h2>" : null)?>

          <!-- content -->
          <?php echo trim($content)?>
        </div>

      <!-- global (unique) CTA button -->
      <?php if ((trim($CTA['text']) != '') && ((trim($CTA['link']) != '') || (trim($CTA['hash']) != ''))) {?>
        <div data-animation="global-cta" class="global-cta">
          <a href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="btn btn-primary <?php echo $CTA['class']?>" target="<?php echo $CTA['target']?>">
            <span>
              <?php echo h($CTA['text'])?>
            </span>
          </a>
        </div>
      <?php } ?>

      </div>
    </div>
  </div>
</section>
