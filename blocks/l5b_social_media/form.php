<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   http://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) 2020                                                       |
| ------------------------------------------------------------------------- |
| @license: Concrete5.org Marketplace Commercial Add-Ons & Themes License   |
|           https://concrete5.org/help/legal/commercial_add-on_license       |
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
        <div class="col-lg-9 col-sm-8 col-xs-12 no-spaces">

          <div class="col-lg-12">
            <div class="form-group center">
              <?php echo $form->label('title', t('Title: %s', '<span>(' . t('social profiles') . ')</span>'))?>
              <div class="input-group center p40">
                <?php echo $form->text('title', $title, array('maxlength' => 50))?>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group center single-space-bottom">
              <?php echo $form->label('subtitle', t('Subtitle: %s', '<span>(' . t('join me ..') . ')</span>'))?>
              <div class="input-group center p50">
                <?php echo $form->text('subtitle', $subtitle, array('maxlength' => 50))?>
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
              // display Tabs control
              echo $hUI::tabs($itemsTotalTabs);

              for ($i=1; $i<(count($itemsTotalTabs)+1); $i++) {
            ?>
            <!-- Tabs -->
            <div class="ccm-tab-content no-space-bottom" id="ccm-tab-content-item_<?php echo $i?>" <?php echo ($i==1) ? ' style="display:block"' : null?>>
              <fieldset class="triple-space-bottom">
                <div class="col-lg-11">
                  <div class="form-group center single-space-top link-block-opts" style="max-width: 750px;">
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
                      <div class="col-lg-12 no-sides-paddings">
                        <div id="<?php echo 'o' . $i . '_linkTypes'?>" class="input-group single-space-bottom">
                          <div class="radio">
                            <label>
                              <?php echo $form->radio('o' . $i . '_linkType', 'url', ${"o" . $i . "_linkType"})?>
                              <span><?php echo t($linkTypes['url'])?></span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <?php echo $form->radio('o' . $i . '_linkType', 'pID', ${"o" . $i . "_linkType"})?>
                              <span><?php echo t($linkTypes['pID'])?></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row no-margins">
                      <div class="col-lg-6 no-sides-paddings">
                        <div id="o<?php echo $i?>_linkType_url" class="input-group center current-<?php echo ${"o" . $i . "_linkType"}?>">
                          <?php echo $form->text('o' . $i . '_url', ${"o" . $i . "_url"}, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                        </div>
                        <div id="o<?php echo $i?>_linkType_pID" class="input-group center current-<?php echo ${"o" . $i . "_linkType"}?>">
                          <?php echo $pageSelector->selectPage('o' . $i . '_pID', ${"o" . $i . "_pID"}, 'ccm_selectSitemapNode')?>
                        </div>
                      </div>
                      <div class="col-lg-3 no-sides-paddings">
                        <div class="input-group center">
                          <?php echo $form->text('o' . $i . '_hash', ${"o" . $i . "_hash"}, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                        </div>
                      </div>
                      <div class="col-lg-3 no-sides-paddings">
                        <div class="input-group center p90">
                          <?php echo $form->select('o' . $i . '_target', $linkTargets, ${"o" . $i . "_target"})?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group center single-space-top no-space-bottom">
                    <label class="control-label">
                      <?php echo t('Choose image')?>
                    </label>
                  </div>
                  <div class="form-group center light-title no-paddings no-space-bottom link-block-opts">
                    <div class="row no-margins">
                      <div class="col-lg-11 no-right-space">
                        <div id="<?php echo 'o' . $i . '_imageTypes'?>" class="input-group single-space-bottom no-right-space">
                          <div class="radio">
                            <label>
                              <?php echo $form->radio('o' . $i . '_imageType', 'icon', ${"o" . $i . "_imageType"})?>
                              <a><?php echo t($imageTypes['icon'])?></a>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <?php echo $form->radio('o' . $i . '_imageType', 'fID', ${"o" . $i . "_imageType"})?>
                              <a><?php echo t($imageTypes['fID'])?></a>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="o<?php echo $i?>_imageType_icon" class="input-group center current-<?php echo ${"o" . $i . "_imageType"}?>">
                    <div class="form-group center single-space-bottom no-right-space light-title">
                    <?php echo $form->label('o' . $i . '_icon', t("Choose an icon for this item"))?>
                      <div class="input-group single-space-top">
                        <select name="o<?php echo $i?>_icon" multiple="true" style="height:350px">
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

                  <div id="o<?php echo $i?>_imageType_fID" class="input-group center current-<?php echo ${"o" . $i . "_imageType"}?>">
                    <div class="form-group center single-space-bottom light-title">
                      <?php echo $form->label('o' . $i . '_fID', t('stick a single image here'))?>
                      <label><span>(<?php echo t('min size: %s', $customImageSizeInfo)?>)</span></label>
                      <div class="input-group center p50">
                        <?php echo $asset->image('ccm-b-image-o' . $i . '_fID', 'o' . $i . '_fID', t('Choose Image'), ${"o" . $i . "_fID"}, array())?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-1">
                  <div class="form-group center no-space-top no-space-bottom is-it-visible">
                    <div class="input-group">
                      <?php echo $form->hidden('o' . $i . '_isEnabled', (int) ${"o" . $i . "_isEnabled"}, array('maxlength' => 0))?>
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
        <div class="col-lg-3 col-sm-4 col-xs-12 no-spaces">
          <section class="style">
            <div>
              <div class="row main">
                <div class="title">
                  <?php echo t('Customise Style')?>
                </div>
                <div class="col-lg-12">
                  <div class="form-group center light-title no-margins no-sides-paddings double-space-bottom single-space-top">
                    <?php echo $form->label('layoutColumns', t('layout design'))?>
                    <div class="input-group center p80">
                      <!-- Select Layout Columns -->
                      <?php echo $form->select('layoutColumns', $layoutColumnsOptions, $layoutColumns)?>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 separator-top">
                  <div class="form-group center light-title no-margins no-sides-paddings single-space-bottom double-space-top">
                    <?php echo $form->label('bgColorRGBA', t('background colour %s', '<br /><span>(' . t('with or without transparency') . ')</span>'))?>
                    <div class="input-group">
                      <!-- Show a Color Palette in RGB Color Format with Transparency Slider (RGBA) -->
                      <?php $color->output('bgColorRGBA', $bgColorRGBA, $bgColorPalette)?>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 separator-bottom">
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
