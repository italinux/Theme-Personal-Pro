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
            <div class="col-lg-5 no-sides-paddings">
              <div class="form-group center single-space-top">
                <?php echo $form->label('title', t('Title: %s', '<span>(' . t('what I do') . ')</span>'))?>
                <div class="input-group center p70">
                  <?php echo $form->text('title', $title, array('maxlength' => '50'))?>
                </div>
              </div>
              <div class="form-group center double-space-top double-space-bottom">
                <?php echo $form->label('subtitle', t('Subtitle: %s', '<span>(' . t('I like doing ..') . ')</span>'))?>
                <div class="input-group center p80">
                  <?php echo $form->text('subtitle', $subtitle, array('maxlength' => '50'))?>
                </div>
              </div>
            </div>
            <div class="col-lg-7 no-sides-paddings">
              <div class="form-group center">
                <?php echo $form->label('CTA_text', t('Global Text Button: %s', '<span>(' . t('click here') . ')</span>'))?>
                <div class="input-group align-center p40">
                  <?php echo $form->text('CTA_text', $CTA_text, array('maxlength' => '30', 'placeholder' => t('click here')))?>
                </div>
              </div>
              <div class="form-group center double-space-bottom link-block-opts">
                <label class="control-label no-margins"><?php echo t('Global Link')?>
                  <sup class="tooltip info">
                    <div>
                      <dl>
                        <dt><?php echo t('Here you define:')?></dt>
                        <dd><?php echo t('link to a %1$s URL %2$s or to a %1$s Page %2$s', '<strong>', '</strong>')?></dd>
                        <dd><?php echo t('add an %1$s anchor %2$s to scroll to a %1$s section %2$s of a page', '<strong>', '</strong>')?></dd>
                        <dd><?php echo t('open up to a %1$s new page %2$s or on the %1$s same page %2$s', '<strong>', '</strong>')?></dd>
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

                <div class="row no-margins">
                  <div class="col-lg-6 no-sides-paddings">
                    <div id="CTA_linkType_url" class="input-group center current-<?php echo $CTA_linkType?>">
                      <?php echo $form->text('CTA_url', $CTA_url, array('maxlength' => '255',  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                    </div>
                    <div id="CTA_linkType_pID" class="input-group center current-<?php echo $CTA_linkType?>">
                      <?php echo $pageSelector->selectPage('CTA_pID', $CTA_pID, 'ccm_selectSitemapNode')?>
                    </div>
                  </div>
                  <div class="col-lg-3 no-sides-paddings">
                    <div class="input-group center">
                      <?php echo $form->text('CTA_hash', $CTA_hash, array('maxlength' => '80',  'placeholder' => '#' . t('anchor-name')))?>
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

<!-- START row-->
          <div class="col-lg-12 wrap-tab-<?php echo count($itemsTotalTabs)?>">

            <div class="double-space-bottom info-items-list-title">
              <h4><?php echo t('all your %s are listed below', t('items'))?></h4>
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
              <fieldset>
                  <div class="col-lg-7">
                    <div class="form-group no-sides-spaces single-space-top">
                      <?php echo $form->label('o' . $i . '_icon', t("Choose this item's icon"))?>
                      <div class="input-group single-space-top">
                        <select name="o<?php echo $i?>_icon" multiple="true" style="height:300px">
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

                    <div class="form-group center single-space-top no-space-bottom">
                      <strong><?php echo t('Otherwise')?></strong>
                    </div>
                    <div class="form-group center single-space-bottom light-title">
                      <?php echo $form->label('o' . $i . '_fID', t('stick a single image here'))?>
                      <label><span>(<?php echo t('min size:') . ' ' . $customImageSizeInfo?>)</span></label>
                      <label><span class="nota-bene"><?php echo t('%1$sNB: %2$s%3$s ', '<strong>', t('it has priority over the icon'), '</strong>')?></span></label>
                      <div class="input-group center p50">
                        <?php echo $asset->image('ccm-b-image-o' . $i . '_fID', 'o' . $i . '_fID', t('Choose Image'), ${"o" . $i . "_fID"}, array())?>
                      </div>
                    </div>
                    <div class="form-group center triple-space-top separator-top">
                      <?php echo $form->label('o' . $i . '_button', t('Text Button: %s', '<span>(' . t('check it out') . ')</span>'))?>
                      <div class="input-group align-center p50">
                        <?php echo $form->text('o' . $i . '_button', ${"o" . $i . "_button"}, array('maxlength' => '30', 'placeholder' => t('check it out')))?>
                      </div>
                    </div>
                    <div class="form-group center no-sides-spaces single-space-top link-block-opts">
                      <label class="control-label"><?php echo t('Link to Page or URL')?>
                        <sup class="tooltip info">
                          <div>
                            <dl>
                              <dt><?php echo t('Here you define:')?></dt>
                              <dd><?php echo t('link to a %1$s URL %2$s or to a %1$s Page %2$s', '<strong>', '</strong>')?></dd>
                              <dd><?php echo t('add an %1$s anchor %2$s to scroll to a %1$s section %2$s of a page', '<strong>', '</strong>')?></dd>
                              <dd><?php echo t('open up to a %1$s new page %2$s or on the %1$s same page %2$s', '<strong>', '</strong>')?></dd>
                            </dl>

                            <span><?php echo t('Leave it empty to hide it')?></span>
                            <br /><br /><?php echo t('documentation:')?>
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
                            <?php echo $form->text('o' . $i . '_url', ${"o" . $i . "_url"}, array('maxlength' => '255',  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                          </div>
                          <div id="o<?php echo $i?>_linkType_pID" class="input-group center current-<?php echo ${"o" . $i . "_linkType"}?>">
                            <?php echo $pageSelector->selectPage('o' . $i . '_pID', ${"o" . $i . "_pID"}, 'ccm_selectSitemapNode')?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->text('o' . $i . '_hash', ${"o" . $i . "_hash"}, array('maxlength' => '80',  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center p90">
                            <?php echo $form->select('o' . $i . '_target', $linkTargets, ${"o" . $i . "_target"})?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-5">
                    <div class="form-group center single-margin-top single-space-bottom is-it-visible" style="width: 50%">
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
                    <div class="form-group center single-space-bottom">
                      <?php echo $form->label('o' . $i . '_title', t('item Title: %s', '<br /><span>(' . t('hiking, travelling') . ')</span>'))?>
                      <div class="input-group align-center p70">
                        <?php echo $form->text('o' . $i . '_title', ${"o" . $i . "_title"}, array('maxlength' => '255'))?>
                      </div>
                    </div>
                    <div class="form-group center no-paddings">
                      <?php echo $form->label('o' . $i . '_content', t('Content: %s', '<span>(blah blah .. )</span>'))?>
                      <div class="input-group">
                          <?php echo $editor->outputStandardEditor('o' . $i . '_content', ${"o" . $i . "_content"})?>
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
