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
      <div id="preloader" style="display: none">
        <div class="spinner"></div>
      </div>

      <!--=== message: not found ===-->
      <section class="page-block pre-hand page-error">
        <div class="container-fluid">
          <div class="row block-header">
            <h1>Oops!</h1>
            <h3><?php echo t('Page not found')?></h3>
          </div>
          <div class="row main">
            <div class="col-xs-12">
              <a class="btn btn-primary" href="<?php echo URL::to('/')?>"><?php echo t('go to homepage')?></a>
            </div>
          </div>
        </div>
      </section>

    </div>

    <!--=== bottom ===-->
    <?php $this->inc('inc/bottom.php')?>
  </body>
</html>
