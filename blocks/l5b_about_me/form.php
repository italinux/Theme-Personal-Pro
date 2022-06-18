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
?>

<div class="<?php echo $btWrapperForm ?>">
  <section>
    <div>
      <div class="row main">
        <div class="col-lg-10 col-sm-9 col-xs-12">
          <div class="row">
            <div class="form-group center single-margin-top">
              <?php echo $form->label('title', t('Title: %s', '<span>(' . t('hi everyone') . ')</span>'))?>
              <div class="input-group align-center p40">
                <?php echo $form->text('title', $title, array('maxlength' => 50))?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 col-lg-offset-0 col-sm-8 col-sm-offset-2 double-space-top no-sides-paddings">
              <div class="form-group center single-margin-bottom">
                <label class="control-label">
                  <?php echo t('Choose image')?>
                </label>
              </div>
              <div class="form-group center light-title no-paddings single-margin-bottom link-block-opts">
                <div class="row no-margins">
                  <div class="col-lg-12">
                    <div id="_imageTypes" class="input-group single-space-bottom">
                      <div class="radio">
                        <label>
                          <?php echo $form->radio('imageType', 'fID', $imageType)?>
                          <a><?php echo t($imageTypes['fID'])?></a>
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <?php echo $form->radio('imageType', 'sID', $imageType)?>
                          <a><?php echo t($imageTypes['sID'])?></a>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row no-margins">
                  <div class="col-lg-12 no-sides-paddings">
                    <div id="imageType_fID" class="input-group center current-<?php echo $imageType?>">
                      <div class="form-group center single-margin-bottom light-title">
                        <?php echo $form->label('o1_fID', t('stick a single image here'))?>
                        <div class="input-group center no-space-top single-space-bottom p60">
                          <?php echo $asset->image('ccm-b-image-o1_fID', 'o1_fID', t('Choose Image'), $o1_fID, array())?>
                        </div>
                      </div>
                    </div>
                    <div id="imageType_sID" class="input-group center current-<?php echo $imageType?>">
                      <div class="form-group center single-margin-bottom light-title">
                        <?php
                          if (empty($fileSetOptions) == false) {
                            echo $form->label('o1_sID', t('random image from: %s', t('File Sets')));
                          ?>
                          <div class="input-group center no-space-top single-space-bottom p60">
                            <?php echo $form->select('o1_sID', $fileSetOptions, $o1_sID)?>
                          </div>
                          <?php
                          }
                        ?>
                        <a href="<?php echo $fileSetHowToURL?>" target="_blank" class="btn goto"><span class="highlight"><?php echo t('How to add a %s', t('File Set'))?></span></a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row no-margins">
                  <div class="col-lg-7 col-lg-offset-1 col-lg-push-1 no-paddings">
                    <div class="form-group center single-space-top no-space-bottom">
                      <label class="control-label single-margin-bottom"><?php echo t('Image Size')?>
                        <br />
                        <span><?php echo t('minimum: %s', '(' . $imageSizeLimit . 'x' . $imageSizeLimit . ')')?></span>
                      </label>
                    </div>
                    <div class="row no-margins">
                      <div class="col-lg-6 no-sides-paddings">
                        <div class="input-group center float-left p60">
                          <?php echo $form->text('imageWidth', $imageWidth, array('maxlength' => 3,  'placeholder' => $imageWidthPlaceholder))?>
                        </div>
                        <div class="input-group align-left p40">
                          <span style="font-size: 1.4em">px</span>
                        </div>
                      </div>
                      <div class="col-lg-6 no-sides-paddings">
                        <div class="input-group center float-left p60">
                          <?php echo $form->text('imageHeight', $imageHeight, array('maxlength' => 3,  'placeholder' => $imageHeightPlaceholder))?>
                        </div>
                        <div class="input-group align-left p40">
                          <span style="font-size: 1.4em">px</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 no-right-padding">
                    <div class="form-group center single-space-top no-space-bottom">
                      <label class="control-label single-space-top no-space-bottom" style="margin-top: 10px"><?php echo t('stretched?')?></label>
                    </div>
                    <div class="input-group center single-space-top display-inline">
                    <?php echo $form->checkbox('isImageStretched', 1, (int) $isImageStretched)?>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="col-lg-7 col-sm-12">
              <div class="form-group single-space-top">
                <?php echo $form->label('content', t('Content: %s', '<span>(blah blah blah ..)</span>'))?>
                <div class="input-group">
                  <?php echo $editor->outputStandardEditor('content', $content)?>
                </div>
              </div>
              <div class="form-group center single-space-top">
                <?php echo $form->label('CTA_text', t('Global Text Button: %s', '<span>(' . t('click here') . ')</span>'))?>
                <div class="input-group align-center p40">
                  <?php echo $form->text('CTA_text', $CTA_text, array('maxlength' => 30, 'placeholder' => t('click here')))?>
                </div>
              </div>
              <div class="form-group center no-sides-paddings single-space-top double-space-bottom link-block-opts">
                <label class="control-label no-margins"><?php echo t('Global Link')?>
                  <sup class="tooltip info">
                    <div>
                      <dl>
                        <dt><?php echo t('Here you define:')?></dt>
                        <dd><?php echo t('link to a %1$s URL %2$s or to a %1$s Page %2$s', '<strong>', '</strong>')?></dd>
                        <dd><?php echo t('add an %1$s anchor %2$s to scroll to a %1$s section %2$s of a page', '<strong>', '</strong>')?></dd>
                        <dd><?php echo t('open up to a %1$s new window %2$s or on the %1$s same window %2$s', '<strong>', '</strong>')?></dd>
                      </dl>

                      <span><?php echo t('Leave it empty to hide it')?></span>
                      <br /><br /><?php echo t('documentation:')?>
                      <a class="goto" href="http://italinux.com/theme-personal-pro/docs/links" target="_blank"><span><?php echo t('click here')?></span></a>
                    </div>
                  </sup>
                </label>

                <div class="row no-margins">
                  <div class="col-lg-12 no-sides-paddings">
                    <div id="CTA_linkTypes" class="input-group single-space-bottom">
                      <div class="radio">
                        <label>
                          <?php echo $form->radio('CTA_linkType', 'url', $CTA_linkType)?>
                          <span><?php echo t($linkTypes['url'])?></span>
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <?php echo $form->radio('CTA_linkType', 'pID', $CTA_linkType)?>
                          <span><?php echo t($linkTypes['pID'])?></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row no-margins double-space-bottom">
                  <div class="col-lg-6 no-sides-paddings">
                    <div id="CTA_linkType_url" class="input-group center current-<?php echo $CTA_linkType?>">
                      <?php echo $form->text('CTA_url', $CTA_url, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                    </div>
                    <div id="CTA_linkType_pID" class="input-group center current-<?php echo $CTA_linkType?>">
                      <?php echo $pageSelector->selectPage('CTA_pID', $CTA_pID, array())?>
                    </div>
                  </div>
                  <div class="col-lg-3 no-sides-paddings">
                    <div class="input-group center">
                      <?php echo $form->text('CTA_hash', $CTA_hash, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                    </div>
                  </div>
                  <div class="col-lg-3 no-sides-paddings">
                    <div class="input-group center">
                      <?php echo $form->select('CTA_target', $linkTargets, $CTA_target)?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-sm-3 col-xs-12 no-spaces">
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
