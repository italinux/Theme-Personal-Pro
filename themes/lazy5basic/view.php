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

      <!--=== content ===-->
      <section class="page-block">
        <div class="container-fluid">
          <div class="row main">
            <div class="col-xs-12">
              <?php echo $innerContent?>
            </div>
          </div>
        </div>
      </section>

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
