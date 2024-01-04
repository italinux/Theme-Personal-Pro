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
| @copyright (c) 2023                                                       |
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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> social-media">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? "<h2>" . h($title) . "</h2>" : null)?>
      <?php echo (trim($subtitle) == true ? "<h4>" . h($subtitle) . "</h4>" : null)?>
    </div>
    <div class="row main">

    <?php
      foreach ($allData as $key => $value) {
      ?>

      <div class="main-item
        <?php echo 'col-xxl-' . $value['col-xxl'][0]?>
        <?php echo 'offset-xxl-' . $value['col-xxl']['offset']?>
        <?php echo 'col-xl-' . $value['col-xl'][0]?>
        <?php echo 'offset-xl-' . $value['col-xl']['offset']?>
        <?php echo 'col-lg-' . $value['col-lg'][0]?>
        <?php echo 'offset-lg-' . $value['col-lg']['offset']?>
        <?php echo 'col-md-' . $value['col-md'][0]?>
        <?php echo 'offset-md-' . $value['col-md']['offset']?>
        <?php echo 'col-sm-' . $value['col-sm'][0]?>
        <?php echo 'offset-sm-' . $value['col-sm']['offset']?>
        <?php echo 'col-' . $value['col-xs'][0]?>
        <?php echo 'offset-' . $value['col-xs']['offset']?>">

        <div data-animation="<?php echo ($key == 0 ? 'top' : 'bottom')?>-<?php echo $value['id']?>" class="service-icon <?php echo $nopaque?>">
          <?php
            // Set link attributes (target & href)
            $linkAttr = ($value['link'] != '' || $value['hash'] != '') ? 'target="' . $value['target'] . '" href="' . $value['link'] . $value['hash'] . '" ' : null;

            // Set icon attributes (font-awesome class)
            $iconAttr = 'fa fa-' . $value['icon']['tag'] . ' fa-4x';

            // Get type (image or icon)
            switch ($value['imageType']) {
            case 'fID':
            ?>
              <a class="<?php echo (empty($value['img']['src']) == true ? $iconAttr : null)?>
                        <?php echo $value['class']?> CTA-clean"
                        <?php echo $linkAttr?>>
                        <?php echo (empty($value['img']['src']) == true ? null : '<img class="img-responsive" src="' . $value['img']['src'] . '"
                                                                                                            width="' . $value['img']['width'] . '"
                                                                                                           height="' . $value['img']['height'] . '"  alt="" />')?></a>
            <?php
                break;
            case 'icon':
            ?>
              <a class="<?php echo $iconAttr?> <?php echo $value['class']?> CTA-clean" <?php echo $linkAttr?>></a>
            <?php
                break;
            }
          ?>
        </div>
      </div>
      <?php
      }
    ?>
    </div>
  </div>
</section>
