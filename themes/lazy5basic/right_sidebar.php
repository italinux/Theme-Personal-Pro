<?php
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-10">
            <?php
              $totBlocks = array();

              foreach ($theme->getAreasNames() as $value) {
                 $a = new Area($value);
                 $totBlocks[] = ($a->getTotalBlocksInArea($c) > 0 ? true : false);
                 $a->setAreaGridMaximumColumns(12);
                 $a->display($c);
              }
            ?>
          </div>
          <div class="col-sm-2">
            <?php
              $a = new Area('Sidebar Header');
              $a->display($c);

              $a = new Area('Sidebar Content');
              $a->display($c);

              $a = new Area('Sidebar Footer');
              $a->display($c);
            ?>
          </div>
        </div>
      </div>

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
