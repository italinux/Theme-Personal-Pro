<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: v1.2.4 (31 March 2019)
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   http://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) 2019                                                       |
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
<section id="<?php echo $sID?>" class="<?php echo $cTemplate?> page-block pre-hand over-image <?php echo $cFgColorClass?> contacts">
  <div class="container-fluid <?php echo $disabled?>" id="<?php echo $viewPoint?>">
    <div class="row block-header <?php echo (trim($title) || trim($subtitle) ? null : "hide")?>">
      <?php echo (trim($title) == true ? '<h2>' . h($title) . '</h2>' : null)?>
      <?php echo (trim($subtitle) == true ? '<h5 data-animation="subtitle">' . h($subtitle) . '</h5>' : '<br />')?>
    </div>

    <div class="row main">
      <div class="col-md-12">
        <div class="row double-space-bottom">

          <div class="form-wrapper">
            <form name="contacts" enctype="multipart/form-data" class="form-stacked miniSurveyView" id="miniSurveyView" method="post" action="<?php echo $view->action('submit_form').'#formblock'.$bID?>">
              <?php
                // Print Success OR Errors
                if ($formSuccess == true) {
                    $cls = 'success';
                    $msg = t($thankYouMessage);
                } else {
                  $cls = null;
                  if ($errors) {
                      $cls = 'danger';
                      $msg = t($errorHeader);
                      $msg .= join(array_map(function ($el) { return "<div class='error'>" . t($el) . "</div>"; }, $errorMsg));
                  }
                }
              ?>
              <?php echo (!empty($cls) ? "<div class='alert alert-$cls'> $msg </div>" : null)?>

              <div class="form-fields <?php echo $disabled?>">
              <?php
                // Print form Inputs
                foreach ($allFormInputs as $key => $thisInput):
                ?>
                <div class="form-group field field-<?php echo $thisInput['type']?> <?php echo (isset($errorDetails[$thisInput['msqID']]) ? 'has-error' : null)?>">
                  <label class="control-label" <?php echo $thisInput['labelFor']?>>
                    <?php echo t(trim($thisInput['question']))?>:&nbsp;
                    <?php
                      if ($thisInput['required']) {
                      ?>
                      <span class="text-muted required">
                        &#42;
                      </span>
                      <?php
                      }
                    ?>
                  </label>
                  <?php echo ($key==0 ? sprintf($thisInput['input'], t('this is just a sample field')) : sprintf($thisInput['input'], t('to add the real input fields')))?>
                </div>
                <?php
                endforeach;
                ?>
              </div>

              <?php
                // Print Captcha
                if (is_object($captcha)):
                ?>
                <div class="form-group captcha">
                  <?php echo $captcha->label()?>
                  <?php $captcha->display()?>
                  <div class="single-space-top single-space-bottom">
                    <?php $captcha->showInput()?>
                  </div>
                </div>
                <?php
                endif;
                ?>

              <div class="form-actions <?php echo $disabled?>">
                <input type="submit" name="Submit" class="btn btn-primary" value="<?php echo t($submitText)?>" <?php echo (empty($disabled) == true ? null : 'disabled="disabled"')?> />
              </div>
              <input name="qsID" type="hidden" value="<?php echo $qsID?>" />
              <input name="pURI" type="hidden" value="<?php echo $pURI?>" />
            </form>
          </div>

        </div>
      </div>
      <div id="<?php echo $viewPoint?>-more" data-animation="others" class="others col-md-12">

      <?php 
        if (trim($telephone) == true) {
        ?>
        <div id="<?php echo $viewPoint?>-more-mobile" data-animation="other-mobile" class="col-md-12 col-sm-12">
          <div class="col-sx-12">
            <div class="col-md-12">
              <h4><?php echo t('Mobile')?>:</h4>
            </div>
            <div class="col-md-12">
              <h4>
                <i class="fa fa-phone fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="col-sm-12 no-sides-paddings contact-details">
            <p class="single-space-left">
              <?php echo h($telephone)?>
            </p>
          </div>
        </div>
      <?php } ?>

      <?php
        if (trim($address) == true) {
        ?>
        <div id="<?php echo $viewPoint?>-more-address" data-animation="other-address" class="col-md-12 col-sm-12">
          <div class="col-sx-12">
            <div class="col-md-12">
              <h4><?php echo t('Address')?>:</h4>
            </div>
            <div class="col-md-12">
              <h4>
                <i class="fa fa-map-marker fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="col-sm-12 no-sides-paddings contact-details">
            <p class="double-space-left">
              <?php
                echo trim($address);
               ?>
            </p>
          </div>
        </div>
      <?php } ?>

      <?php
        if (trim($openHours) == true) {
        ?>
        <div data-animation="other-opening" class="col-md-12 col-sm-12">
          <div class="col-sx-12">
            <div class="col-md-12">
              <h4><?php echo t('Opening')?>:</h4>
            </div>
            <div class="col-md-12">
              <h4>
                <i class="fa fa-clock-o fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="col-sm-12 no-sides-paddings contact-details">
            <p class="double-space-left">
              <?php
                echo trim($openHours);
               ?>
            </p>
          </div>
        </div>
      <?php } ?>

      <?php
        if (trim($fbPageUrl) == true) {
        ?>
        <div data-animation="other-facebook" class="col-md-12 col-sm-12">
          <div class="col-sx-12">
            <div class="col-md-12">
              <h4>Facebook:</h4>
            </div>
            <div class="col-md-12">
              <h4>
                <i class="fa fa-facebook fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="col-sm-12 no-sides-paddings contact-details">
            <p class="single-space-left word-wrap-break">
              <a <?php echo (empty($disabled) == true ? 'href="' . $fbPageUrl . '"' : null)?> target="_blank">
                <?php echo $fbPageUrl?>
              </a>
            </p>
          </div>
        </div>
      <?php } ?>
        
      <?php
        if (trim($email) == true) {
        ?>
        <div id="<?php echo $viewPoint?>-more-email" data-animation="other-email" class="col-md-12 col-sm-12">
          <div class="col-sx-12">
            <div class="col-md-12">
              <h4><?php echo t('E-mail')?>:</h4>
            </div>
            <div class="col-md-12">
              <h4>
                <i class="fa fa-paper-plane-o fa-1x"></i>
              </h4>
            </div>
          </div>
          <div class="col-sm-12 no-sides-paddings contact-details">
            <p class="single-space-left word-wrap-break">
              <a <?php echo (empty($disabled) == true ? 'href="mailto:' . strtolower($email) . '"' : null)?>>
                <?php echo $email?>
              </a>
            </p>
          </div>
        </div>
      <?php } ?>

      </div>
    </div>
  </div>
</section>
