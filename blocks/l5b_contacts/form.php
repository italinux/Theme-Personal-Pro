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
?>
<div class="<?php echo $btWrapperForm ?>">
  <section>
    <div>
      <div class="row main">
        <div class="col-lg-9 col-lg-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-0">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
              <div class="form-group center single-space-top">
                <?php echo $form->label('title', t('Title: %s', '<span>(' . t('contact me') . ')</span>'))?>
                <div class="input-group center">
                  <?php echo $form->text('title', $title, array('maxlength' => 50))?>
                </div>
              </div>
            </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <?php echo $form->label('address', t('Your Address:'))?>
                  <div class="input-group">
                    <?php echo $form->textarea(
                            'address',
                            trim($address), array(
                                'rows' => 4,
                                'maxlength' => 255,
                            ));
                        ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <div class="input-group center">
                    <?php echo $form->select('telephoneType', $telephoneTypes, $telephoneType)?>
                    <?php echo $form->textarea(
                            'telephone',
                            trim($telephone), array(
                                'rows' => 3,
                                'maxlength' => 255,
                            ));
                        ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
              <div class="form-group center single-space-top">
                <?php echo $form->label('subtitle', t('Subtitle: %s', '<span>(' . t('yeah, go ahead!') . ')</span>'))?>
                <div class="input-group center">
                  <?php echo $form->text('subtitle', $subtitle, array('maxlength' => 50))?>
                </div>
              </div>
            </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <?php echo $form->label('opening', t('Opening Hours:'))?>
                  <div class="input-group">
                    <?php echo $form->textarea(
                            'openHours',
                            trim($openHours), array(
                                'rows' => 4,
                                'maxlength' => 500,
                            ));
                        ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <?php echo $form->label('email', t('Email: %s', '<span>(' . t('my') . '@email.' . t('here') . ')</span>'))?>
                  <div class="input-group">
                    <?php echo $form->text('email', trim($email), array('maxlength' => 55))?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group center double-space-top">
              <?php echo $form->label('fbPageUrl', t('%1$s Page %2$s: %3$s', 'Facebook', 'url', '<span>(<u>http://fb.com/martin.smith</u>)</span>'))?>
              <div class="input-group center p80">
                <?php echo $form->text('fbPageUrl', trim($fbPageUrl), array('maxlength' => 255))?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-lg-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-0 no-paddings">
          <section class="style">
            <div>
              <div class="row main">
                <div class="title">
                  <?php echo t('Customise Style')?>
                </div>
                <div class="col-lg-12">
                  <div class="form-group center light-title no-margins no-sides-paddings double-space-bottom single-space-top">
                    <?php echo $form->label('bgColorRGBA', t('background colour %s', '<br /><span>(' . t('with or without transparency') . ')</span>'))?>
                    <div class="input-group center p50">
                      <!-- Show a Color Palette in RGB Color Format with Transparency Slider (RGBA) -->
                      <?php $color->output('bgColorRGBA', $bgColorRGBA, $bgColorPalette)?>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 separator-top separator-bottom">
                  <div class="form-group center light-title double-space-top">
                    <?php echo $form->label('bgFID', t('background image'))?>
                    <div class="input-group">
                      <?php echo $asset->image('ccm-b-image-bgFID', 'bgFID', t('Choose Image'), $bgFID, array())?>
                    </div>
                  </div>
                  <div class="form-group center light-title no-margins no-sides-paddings single-space-bottom">
                    <?php echo $form->label('bgColorOpacity', t('adjust top opacity'))?>
                    <div class="input-group">
                      <!-- Adjust Background Color (top) Opacity: Over Image -->
                      <?php
                        if (is_array($bgColorOpacityOptions)) {
                          foreach ($bgColorOpacityOptions as $key => $value) {
                        ?>
                      <div class="col-xs-3 no-paddings">
                        <div class="radio">
                          <span style="color:#333"><?php echo t($key)?></span>
                          <br />
                          <label>
                            <?php echo $form->radio('bgColorOpacity', $value, (float) $bgColorOpacity)?>
                          </label>
                        </div>
                      </div>
                      <?php
                          }
                        }
                        ?>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group center light-title single-space-bottom double-space-top">
                    <?php echo $form->label('fgColorRGB', t('font colour'))?>
                    <div class="input-group center p50">
                      <!-- Show a Color Palette in RGB Color Format -->
                      <?php $color->output('fgColorRGB', $fgColorRGB, $fgColorPalette)?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group center light-title single-space-bottom">
                    <?php echo $form->label('isAnimated', t('with Animation'))?>
                    <div class="input-group">
                      <div class="radio col-sm-6 col-sm-offset-0 col-xs-3 col-xs-offset-3">
                        <label>
                          <?php echo $form->radio('isAnimated', 1, (int) $isAnimated)?>
                          <span class"on"><?php echo t('Yes')?></span>
                        </label>
                      </div>
                      <div class="radio col-sm-6 col-xs-3">
                        <label>
                          <?php echo $form->radio('isAnimated', 0, (int) $isAnimated)?>
                          <span class="off"><?php echo t('No')?></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>
