<?php
defined('C5_EXECUTE') or die("Access Denied.");

echo $cStyle;
?>
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> social-media">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? "<h2>" . h($title) . "</h2>" : null)?>
      <?php echo (trim($subtitle) == true ? "<h5>" . h($subtitle) . "</h5>" : null)?>
    </div>
    <div class="row main">

    <?php
      foreach($allData as $value) {
      ?>

      <div class="main-item col-lg-12 col-md-12 col-sm-12 col-sx-12">

        <div data-animation="<?php echo ($id == 0 ? 'top' : 'bottom')?>-<?php echo $value['id']?>" class="service-icon">
          <a class="<?php echo (empty($value['img']['src']) == true ? 'fa fa-' . $value['icon']['tag'] . ' fa-4x ' : null); echo $value['class']?> CTA-clean"
            <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'target="' . $value['target'] . '" ' : null)?>
            <?php echo (($value['link'] != '' || $value['hash'] != '') ? 'href="' . $value['link'] . $value['hash'] . '" ' : null)?>>
            <?php echo (empty($value['img']['src']) == true ? null : '<img class="img-responsive" src="' . $value['img']['src'] . '" alt="" />')?>
          </a>
        </div>
      </div>
      <?php
      }
    ?>
    </div>
  </div>
</section>
