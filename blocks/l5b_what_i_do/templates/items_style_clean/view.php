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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> what-i-do">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? "<h2>" . h($title) . "</h2>" : null)?>
      <?php echo (trim($subtitle) == true ? "<h4>" . h($subtitle) . "</h4>" : null)?>
    </div>
    <div class="row main">

    <?php
      foreach($allData as $key => $value) {
      ?>

      <div class="main-item
        <?php echo 'col-lg-' . $value['col-lg'][0]?>
        <?php echo 'col-lg-offset-' . $value['col-lg']['offset']?>
        <?php echo 'col-md-' . $value['col-md'][0]?>
        <?php echo 'col-md-offset-' . $value['col-md']['offset']?>
        <?php echo 'col-sm-' . $value['col-sm'][0]?>
        <?php echo 'col-sm-offset-' . $value['col-sm']['offset']?>
        <?php echo 'col-sx-' . $value['col-sx'][0]?>
        <?php echo 'col-sx-offset-' . $value['col-sx']['offset']?>">

        <div class="wid-item-<?php echo $key?> service-item single-space-top double-space-bottom">
          <div data-animation="icon" class="service-icon">
            <a class="<?php echo (empty($value['img']['src']) == true ? 'fa fa-' . $value['icon']['tag'] . ' fa-4x ' : null); echo $value['class']?> CTA-clean"
              <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'target="' . $value['target'] . '" ' : null)?>
              <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'href="' . $value['link'] . $value['hash'] . '" ' : null)?>>
              <?php echo (empty($value['img']['src']) == true ? null : '<img class="img-responsive" src="' . $value['img']['src'] . '" alt="" />')?>
            </a>
          </div>

          <h3 data-animation="title">
            <?php echo h($value['title'])?>
          </h3>

          <div data-animation="content">
            <?php echo $value['content']?>
          </div>

        <!-- single CTA button -->
        <?php if ((trim($value['button']) != '') && ((trim($value['link']) != '') || (trim($value['hash']) != ''))) {?>
          <div data-animation="cta">
            <a href="<?php echo $value['link']?><?php echo $value['hash']?>" class="btn btn-primary <?php echo $value['class']?>" target="<?php echo $value['target']?>">
              <span>
                <?php echo h($value['button'])?>
              </span>
            </a>
          </div>
        <?php } ?>

        </div>
      </div>
      <?php
      }
    ?>
    </div>

<!-- global (unique) CTA button -->
<?php if ((trim($CTA['text']) != '') && ((trim($CTA['link']) != '') || (trim($CTA['hash']) != ''))) {?>
    <div class="row">
      <div data-animation="global-cta" class="global-cta col-xs-12">
        <a href="<?php echo $CTA['link']?><?php echo $CTA['hash']?>" class="btn btn-primary <?php echo $CTA['class']?>" target="<?php echo $CTA['target']?>">
          <span>
            <?php echo h($CTA['text'])?>
          </span>
        </a>
      </div>
    </div>
<?php } ?>

  </div>
</section>
