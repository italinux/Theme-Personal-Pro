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
?>

<!DOCTYPE html>
<html lang="<?php echo Localization::activeLanguage()?>">

  <!--=== loading headers ===-->
  <?php $this->inc('inc/top.php')?>
  <body>
    <div class="main-wrapper <?php echo $c->getPageWrapperClass()?>">

      <!--=== preloader ===-->
      <div id="preloader" <?php echo (User::isLoggedIn() == true) ? 'style="display: none"' : null?>>
        <div class="spinner"></div>
      </div>

      <!--=== Areas ===-->
      <?php
        $totBlocks = array();

        foreach (array('Menu', 'Main', 'Footer') as $value) {
           $a = new Area($value);
           $totBlocks[] = ($a->getTotalBlocksInArea($c) > 0 ? true : false);
           $a->setAreaGridMaximumColumns(12);
           $a->display($c);
        }
      ?>

      <!--=== load Intro ===-->
      <?php
        if (!in_array(true, $totBlocks, true) && $c->isEditMode() == false) {
            $this->inc('inc/intro.php');
        }
      ?>

      <!--=== scroll to top (button) ===-->
      <?php
        if ($c->isEditMode() == false) {
        ?>
        <div id="scroll-top" class="scroll-up">
          <i class="fa fa-arrow-up"></i>
        </div>
        <?php
        }
      ?>

    </div>

    <!--=== bottom ===-->
    <?php $this->inc('inc/bottom.php')?>
  </body>
</html>
