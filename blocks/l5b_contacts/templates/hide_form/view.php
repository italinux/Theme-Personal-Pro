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
| @copyright (c) 2021                                                       |
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
      <?php echo (trim($subtitle) == true ? '<h5 data-animation="subtitle">' . h($subtitle) . '</h5>' : '<br />')?>
    </div>

    <div class="row main">
      <div id="<?php echo $viewPoint?>-more" data-animation="others" class="others col-sx-12">

      <?php 
        if ((trim($telephone) == true) || (trim($email) == true) || (trim($fbPageUrl) == true)) {
        ?>
        <div class="col-lg-3 col-lg-offset-1 col-md-4 col-md-offset-0 col-sx-12">

        <?php
          if (trim($telephone) == true) {
          ?>
          <div id="<?php echo $viewPoint?>-more-mobile" data-animation="other-mobile" class="col-sx-12">
            <div class="col-lg-8">
              <h4><?php echo $telephoneTitle?>:</h4>
            </div>
            <div class="col-lg-4">
              <h4>
                <i class="fa fa-phone fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="no-sides-paddings single-space-bottom contact-details">
            <p class="single-space-left">
              <?php echo trim($telephone)?>
            </p>
          </div>
        <?php } ?>

        <?php
          if (trim($email) == true) {
          ?>
          <div id="<?php echo $viewPoint?>-more-email" data-animation="other-email" class="col-sx-12">
            <div class="col-lg-8">
              <h4><?php echo t('E-mail')?>:</h4>
            </div>
            <div class="col-lg-4">
              <h4>
                <i class="fa fa-paper-plane-o fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="no-sides-paddings single-space-bottom contact-details">
            <p class="single-space-left word-wrap-break">
              <a href="mailto:<?php echo strtolower($email)?>">
                <?php echo $email?>
              </a>
            </p>
          </div>
        <?php } ?>

        <?php
          if (trim($fbPageUrl) == true) {
          ?>
          <div data-animation="other-facebook" class="col-sx-12">
            <div>
              <div class="col-lg-8">
                <h4>Facebook:</h4>
              </div>
              <div class="col-lg-4">
                <h4>
                  <i class="fa fa-facebook fa-1x"></i>
                </h4>
              </div>
            </div>
            <div class="no-sides-paddings single-space-bottom contact-details">
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
        <div data-animation="other-opening" class="col-md-4 col-sx-12" style="text-align: center">
          <div>
            <div class="col-lg-8">
              <h4><?php echo t('Openings')?>:</h4>
            </div>
            <div class="col-lg-4">
              <h4>
                <i class="fa fa-clock-o fa-1x"></i>
              </h4>
            </div>
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
        <div id="<?php echo $viewPoint?>-more-address" data-animation="other-address" class="col-lg-3 col-lg-offset-1 col-md-4 col-md-offset-0 col-sx-12">
          <div>
            <div class="col-lg-8">
              <h4><?php echo t('Address')?>:</h4>
            </div>
            <div class="col-lg-4">
              <h4>
                <i class="fa fa-map-marker fa-1x"></i>
              </h4>
            </div>
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
