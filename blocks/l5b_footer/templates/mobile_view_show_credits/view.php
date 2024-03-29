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
<footer id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> footer">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? "<h5>" . (empty($isQuoted) ? $title : '<q>' . h($title) . '</q>') . "</h5>" : null)?>
      <?php echo (trim($subtitle) == true ? "<h6 data-animation='credits' class='$nopaque'>" . h($subtitle) . "</h6>" : null)?>
    </div>

    <div class="row main">
      <div class="credits download">
        <?php echo h($credits1st['text'])?>
        <?php echo (trim($credits1st['link']) == false ? $credits1st['name'] : "<a class='" . $credits1st['class'] . "' target='" . $credits1st['target'] . "' href='" . $credits1st['link'] . "'><span>" . h($credits1st['name']) . "</span></a>")?>
      </div>

  <?php if ((trim($credits2nd['text']) != '') || (trim($credits2nd['name']) != '')) {?>
      <div class="credits">
        <?php echo h($credits2nd['text'])?>
        <?php echo (trim($credits2nd['link']) == false ? $credits2nd['name'] : "<a class='" . $credits2nd['class'] . "' target='" . $credits2nd['target'] . "' href='" . $credits2nd['link'] . "'><span>" . h($credits2nd['name']) . "</span></a>")?>
      </div>
  <?php } ?>

    </div>
  </div>
</footer>
