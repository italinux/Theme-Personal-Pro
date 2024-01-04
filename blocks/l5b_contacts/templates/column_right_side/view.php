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
| @copyright (c) current year
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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> contacts">
  <div class="container-fluid" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? '<h2>' . h($title) . '</h2>' : null)?>
      <?php echo (trim($subtitle) == true ? '<h4 data-animation="subtitle">' . h($subtitle) . '</h4>' : '<br />')?>
    </div>

    <div class="main">
      <div id="<?php echo $viewPoint?>-more" data-animation="others" class="row others">

      <?php
        if ((trim($telephone) == true) || (trim($email) == true) || (trim($fbPageUrl) == true)) {
        ?>
        <div class="col-12 no-space-bottom">

        <?php
          if (trim($telephone) == true) {
          ?>
          <div id="<?php echo $viewPoint?>-more-mobile" data-animation="other-mobile" class="single-space-bottom">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
              <h4 class="no-space-bottom"><?php echo $telephoneTitle?>:</h4>
            </div>
            <div class="col-xl-2 col-12">
              <h4 class="no-space-bottom">
                <i class="fa fa-phone fa-1x"></i>
              </h4>
            </div>
            <div class="no-sides-paddings contact-details">
              <p class="single-space-left">
                <?php echo trim($telephone)?>
              </p>
            </div>
          </div>
        <?php } ?>

        <?php
          if (trim($email) == true) {
          ?>
          <div id="<?php echo $viewPoint?>-more-email" data-animation="other-email" class="single-space-bottom">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
              <h4 class="no-space-bottom"><?php echo t('E-mail')?>:</h4>
            </div>
            <div class="col-xl-2 col-12">
              <h4 class="no-space-bottom">
                <i class="fa fa-paper-plane-o fa-1x"></i>
              </h4>
            </div>
            <div class="no-sides-paddings contact-details">
              <p class="single-space-left word-wrap-break">
                <a href="mailto:<?php echo strtolower($email)?>">
                  <?php echo $email?>
                </a>
              </p>
            </div>
          </div>
        <?php } ?>

        <?php
          if (trim($fbPageUrl) == true) {
          ?>
          <div data-animation="other-facebook" class="single-space-bottom">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
              <h4 class="no-space-bottom">Facebook:</h4>
            </div>
            <div class="col-xl-2 col-12">
              <h4 class="no-space-bottom">
                <i class="fa fa-facebook fa-1x"></i>
              </h4>
            </div>
            <div class="no-sides-paddings contact-details">
              <p class="single-space-left word-wrap-break">
                <a href="<?php echo $fbPageUrl?>" target="_blank">
                  <?php echo $fbPageUrl?>
                </a>
              </p>
            </div>
          </div>
        <?php } ?>

        </div>
      <?php } ?>

      <?php
        if (trim($openHours) == true) {
        ?>
        <div data-animation="other-opening" class="col-12">
          <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
            <h4 class="no-space-bottom"><?php echo t('Openings')?>:</h4>
          </div>
          <div class="col-xl-2 col-12">
            <h4 class="no-space-bottom">
              <i class="fa fa-clock-o fa-1x"></i>
            </h4>
          </div>
          <div class="no-sides-paddings contact-details">
            <p class="double-space-left">
              <?php
                echo trim($openHours);
               ?>
            </p>
          </div>
        </div>
      <?php } ?>

      <?php
        if (trim($address) == true) {
        ?>
        <div id="<?php echo $viewPoint?>-more-address" data-animation="other-address" class="col-md-4 col-12">
          <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
            <h4 class="no-space-bottom"><?php echo t('Address')?>:</h4>
          </div>
          <div class="col-xl-2 col-12">
            <h4 class="no-space-bottom">
              <i class="fa fa-map-marker fa-1x"></i>
            </h4>
          </div>
          <div class="no-sides-paddings contact-details">
            <p class="double-space-left">
              <?php
                echo trim($address);
               ?>
            </p>
          </div>
        </div>
      <?php } ?>

      </div>
    </div>
  </div>
</section>
