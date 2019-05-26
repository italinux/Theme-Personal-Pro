<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: v1.2.8 (26 May 2019)
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
?>

<div class="<?php echo $btWrapperForm ?>">
  <section>
    <div>
      <div class="row main">
        <div class="col-lg-10 col-sm-8 col-xs-12 no-spaces">

          <div class="col-lg-12">
            <div class="form-group center">
              <?php echo $form->label('title', t('Title: %s', '<span>(' . t('social profiles') . ')</span>'))?>
              <div class="input-group center p40">
                <?php echo $form->text('title', $title, array('maxlength' => '50'))?>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group center single-space-bottom">
              <?php echo $form->label('subtitle', t('Subtitle: %s', '<span>(' . t('join me ..') . ')</span>'))?>
              <div class="input-group center p50">
                <?php echo $form->text('subtitle', $subtitle, array('maxlength' => '50'))?>
              </div>
            </div>
          </div>

<!-- START row-->
          <div class="col-lg-12 wrap-tab-<?php echo count($itemsTotalTabs)?>">

            <div class="double-space-bottom info-items-list-title">
              <h4><?php echo t('all your %s are listed below', t('social profiles'))?></h4>
            </div>

            <!-- START JS SCRIPT -->
              <?php $this->inc('elements/jscript.php')?>
            <!-- END JS SCRIPT -->

            <?php
              echo $hUI->tabs($itemsTotalTabs);

              for ($i=1; $i<(count($itemsTotalTabs)+1); $i++) {
            ?>
            <!-- Tabs -->
            <div class="ccm-tab-content no-space-bottom" id="ccm-tab-content-item_<?php echo $i?>" <?php echo ($i==1) ? ' style="display:block"' : null?>>
              <fieldset class="single-space-bottom">
                  <div class="col-lg-8">
                    <div class="form-group center single-space-top">
                      <label class="control-label"><?php echo t('Link to social profile')?>
                        <sup class="tooltip info">
                          <div>
                            <dl>
                              <dt><?php echo t('Here you define:')?></dt>
                              <dd><?php echo t('link to a %1$s URL %2$s or to a %1$s Page %2$s', '<strong>', '</strong>')?></dd>
                              <dd><?php echo t('add an %1$s anchor %2$s to scroll to a %1$s section %2$s of a page', '<strong>', '</strong>')?></dd>
                            </dl>

                            <?php echo t('documentation:')?>
                            <a class="goto" href="http://italinux.com/theme-personal-pro/docs/links" target="_blank"><span><?php echo t('click here')?></span></a>
                          </div>
                        </sup>
                      </label>

                      <div class="row no-margins single-space-top">
                        <div class="col-lg-8 form-group center light-title no-spaces">
                          <?php echo $form->label('o' . $i . '_url', t('Profile URL'))?>
                          <div class="input-group center">
                            <?php echo $form->text('o' . $i . '_url', ${"o" . $i . "_url"}, array('maxlength' => '255',  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('my'), t('profile'))))?>
                          </div>
                        </div>
                        <div class="col-lg-4 form-group center light-title no-spaces">
                          <?php echo $form->label('o' . $i . '_hash', t('anchor'))?>
                          <div class="input-group center">
                            <?php echo $form->text('o' . $i . '_hash', ${"o" . $i . "_hash"}, array('maxlength' => '80',  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="form-group no-margins">
                      <?php echo $form->label('o' . $i . '_icon', t('Choose the related icon:'))?>
                      <div class="input-group">
                        <select name="o<?php echo $i?>_icon" multiple="true" style="height:210px">
                          <?php
                            if (is_array($itemsIcons)) {
                              foreach ($itemsIcons as $key => $value) {
                                if ($key > 0) {
                                    echo ((is_int(($key) / 10)) == true ? '<option style="visibility:hidden"></option>' : null);
                                }
                              ?>
                          <option style="width:10%" value="<?php echo $value ?>" class="fa fa-<?php echo $value ?> fa-responsive" <?php echo ($value == ${"o" . $i . "_icon"}) == true ? 'selected="selected"' : null?>></option>
                              <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 double-space-top">
                    <div class="form-group center single-space-top single-space-bottom is-it-visible">
                      <?php echo $form->label('o' . $i . '_isEnabled', t('Visible?'))?>
                      <div class="input-group">
                        <div class="radio">
                          <label>
                            <?php echo $form->radio('o' . $i . '_isEnabled', 1, (int) ${"o" . $i . "_isEnabled"})?>
                            <span class="on"><?php echo t('Yes')?></span>
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <?php echo $form->radio('o' . $i . '_isEnabled', 0, (int) ${"o" . $i . "_isEnabled"})?>
                            <span class="off"><?php echo t('No')?></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group center no-sides-paddings double-space-top">
                      <?php echo $form->label('o' . $i . '_fID', t('Or stick a custom logo:') . '<br /><span>(' . t('min size:') . ' ' . $customImageSizeInfo .')<br />' . t('%1$sNB: %2$s%3$s ', '<strong class="nota-bene">', t('it has priority over the icon'), '</strong>') .'</span>')?>
                      <div class="input-group center single-space-top p90">
                        <?php echo $asset->image('ccm-b-image-o' . $i . '_fID', 'o' . $i . '_fID', t('Choose Image'), ${"o" . $i . "_fID"}, array())?>
                      </div>
                    </div>
                  </div>
              </fieldset>
            </div>
            <?php
              }
            ?>
          </div>

<!-- END row -->
        </div>
        <div class="col-lg-2 col-sm-4 col-xs-12 no-spaces">
          <section class="style">
            <div>
              <div class="row main">
                <div class="title">
                  <?php echo t('Customise Style')?>
                </div>
                <div class="col-lg-12">
                  <div class="form-group center light-title single-space-top no-sides-paddings single-space-bottom">
                    <?php echo $form->label('bgColorRGBA', t('background colour %s', '<br /><span>(' . t('with or without transparency') . ')</span>'))?>
                    <div class="input-group">
                      <!-- Show a Color Palette in RGB Color Format with Transparency Slider (RGBA) -->
                      <?php $color->output('bgColorRGBA', $bgColorRGBA, $bgColorPalette)?>
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
                  <div class="form-group center light-title single-space-top single-space-bottom">
                    <?php echo $form->label('bgFID', t('background image'))?>
                    <div class="input-group">
                      <?php echo $asset->image('ccm-b-image-bgFID', 'bgFID', t('Choose Image'), $bgFID, array())?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group center light-title single-space-bottom">
                    <?php echo $form->label('fgColorRGB', t('font colour'))?>
                    <div class="input-group">
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
