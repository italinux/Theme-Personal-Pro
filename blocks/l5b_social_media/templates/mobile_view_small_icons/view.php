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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> social-media">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? "<h2>" . h($title) . "</h2>" : null)?>
      <?php echo (trim($subtitle) == true ? "<h4>" . h($subtitle) . "</h4>" : null)?>
    </div>
    <div class="row main">

    <?php
      foreach ($allData as $value) {
      ?>

      <div class="main-item col-lg-12 col-md-12 col-sm-12 col-sx-12">

        <div data-animation="<?php echo ($id == 0 ? 'top' : 'bottom')?>-<?php echo $value['id']?>" class="service-icon">
          <a class="<?php echo (empty($value['img']['src']) == true ? 'fa fa-' . $value['icon']['tag'] . ' fa-3x ' : null); echo $value['class']?> CTA-clean"
            <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'target="' . $value['target'] . '" ' : null)?>
            <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'href="' . $value['link'] . $value['hash'] . '" ' : null)?>>
            <?php echo (empty($value['img']['src']) == true ? null : '<img class="img-responsive" src="' . $value['img']['src'] . '"
                                                                                                width="' . $value['img']['width'] . '"
                                                                                               height="' . $value['img']['height'] . '"  alt="" />')?>
          </a>
        </div>
      </div>
      <?php
      }
    ?>
    </div>
  </div>
</section>
