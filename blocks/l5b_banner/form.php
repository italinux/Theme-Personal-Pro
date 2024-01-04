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
        <div class="no-spaces col-lg-9 col-sm-7 col-xs-12">
          <div class="col-lg-12 single-space-bottom" style="text-align: center">
            <h3 class="no-paddings"><?php echo t('Banner templates')?></h3>
            <p><a href="<?php echo $templatesHowToURL?>" target="_blank" class="btn goto"><span class="highlight"><?php echo t('How to choose a %s', t('template'))?></span></a></p>
          </div>

          <!-- START Tabs row -->
          <div class="col-lg-12 wrap-tab-<?php echo count($templateDefaultTab)?> no-grab">

            <div class="double-space-bottom info-items-list-title">
              <h4><?php echo t('all templates available are listed below')?></h4>
            </div>

            <?php
              echo $hUI->tabs(array(
                  array('item_1', t('Free Style'), $templateDefaultTab['fs'], true),
                  array('item_2', t('Clean Style'), $templateDefaultTab['cs'], true),
                  array('item_3', t('I am What I do'), $templateDefaultTab['iam_wid'], true),
                  array('item_4', t('Image on the Right'), $templateDefaultTab['img_sd'], true),
              ));
            ?>

            <!-- Start Tab: Clean Style -->
            <?php $cTempl = 'fs'?>

            <div class="ccm-tab-content <?php echo ($templateDefaultTab[$cTempl] === true) ? 'active' : null?>" id="item_1">
              <fieldset>
                <div class="row">
                  <div class="col-lg-12">
                    <section class="video <?php echo $cTempl?>">
                      <div>
                        <div class="row main single-space-top">
                          <div class="col-lg-6">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoURL', t('Background Video Url: %s', '<span>(YouTube)</span>'))?>
                              <div class="input-group">
                                <?php echo $form->text($cTempl . '_videoURL', ${$cTempl . '_videoURL'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-lg-offset-0 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoHQ', t('Quality'))?>
                              <div class="input-group">
                                <?php echo $form->select($cTempl . '_videoHQ', $optionsVideoHQ, ${$cTempl . '_videoHQ'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group center no-sides-spaces double-margin-botom">
                              <?php echo $form->label($cTempl . '_isVideoEnabled', t('Video Enabled?'))?>
                              <div class="input-group center display-inline">
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 1, (int) ${$cTempl . '_isVideoEnabled'})?>
                                    <span class="on"><?php echo t('Yes')?></span>
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 0, (int) ${$cTempl . '_isVideoEnabled'})?>
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
                  <div class="col-lg-10 col-lg-offset-1 col-sm-12">
                    <div class="form-group center double-space-top">
                      <?php echo $form->label($cTempl . '_content', t('Content: %s', '<span>(blah blah .. )</span>'))?>
                      <div class="input-group center">
                        <?php echo $editor->outputStandardEditor($cTempl . '_content', ${$cTempl . '_content'})?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-top">
                      <?php echo $form->label($cTempl . '_CTA_text', t('Text Button: %s', '<span>(' . t('find out more') . ')</span>'))?>
                      <div class="input-group align-center p30">
                        <?php echo $form->text($cTempl . '_CTA_text', ${$cTempl . '_CTA_text'}, array('maxlength' => 30, 'placeholder' => t('find out more')))?>
                      </div>
                    </div>
                    <div class="form-group center double-space-bottom single-space-top link-block-opts">
                      <label class="control-label no-margins"><?php echo t('Action Link')?>
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
                        <div class="col-lg-12">
                          <div id="<?php echo $cTempl?>_CTA_linkTypes" class="input-group single-space-bottom">
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'url', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['url'])?></span>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'pID', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['pID'])?></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row no-margins single-sides-spaces">
                        <div class="col-lg-6 no-sides-paddings">
                          <div id="<?php echo $cTempl?>_CTA_linkType_url" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $form->text($cTempl . '_CTA_url', ${$cTempl . '_CTA_url'}, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                          </div>
                          <div id="<?php echo $cTempl?>_CTA_linkType_pID" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $pageSelector->selectPage($cTempl . '_CTA_pID', ${$cTempl . '_CTA_pID'}, array())?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->text($cTempl . '_CTA_hash', ${$cTempl . '_CTA_hash'}, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->select($cTempl . '_CTA_target', $linkTargets, ${$cTempl . '_CTA_target'})?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <!-- End Tab: Free Style -->

            <!-- Start Tab: Clean Style -->
            <?php $cTempl = 'cs'?>

            <div class="ccm-tab-content <?php echo ($templateDefaultTab[$cTempl] === true) ? 'active' : null?>" id="item_2">
              <fieldset>
                <div class="row">
                  <div class="col-lg-12">
                    <section class="video <?php echo $cTempl?>">
                      <div>
                        <div class="row main single-space-top">
                          <div class="col-lg-6">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoURL', t('Background Video Url: %s', '<span>(YouTube)</span>'))?>
                              <div class="input-group">
                                <?php echo $form->text($cTempl . '_videoURL', ${$cTempl . '_videoURL'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-lg-offset-0 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoHQ', t('Quality'))?>
                              <div class="input-group">
                                <?php echo $form->select($cTempl . '_videoHQ', $optionsVideoHQ, ${$cTempl . '_videoHQ'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group center no-sides-spaces double-margin-botom">
                              <?php echo $form->label($cTempl . '_isVideoEnabled', t('Video Enabled?'))?>
                              <div class="input-group center display-inline">
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 1, (int) ${$cTempl . '_isVideoEnabled'})?>
                                    <span class="on"><?php echo t('Yes')?></span>
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 0, (int) ${$cTempl . '_isVideoEnabled'})?>
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
                  <div class="col-lg-12">
                    <div class="form-group center double-space-top">
                      <?php echo $form->label($cTempl . '_title', t('Title: %s', '<span>(' . t('cool name') . ')</span>'))?>
                      <div class="input-group center p40">
                        <?php echo $form->text($cTempl . '_title', ${$cTempl . '_title'}, array('maxlength' => 50, 'placeholder' => t('cool name')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-bottom">
                      <?php echo $form->label($cTempl . '_subtitle', t('Subtitle: %s', '<span>(' . t('a catchy slogan') . ')</span>'))?>
                      <div class="input-group center p50">
                        <?php echo $form->text($cTempl . '_subtitle', ${$cTempl . '_subtitle'}, array('maxlength' => 50, 'placeholder' => t('a catchy slogan')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-top">
                      <?php echo $form->label($cTempl . '_CTA_text', t('Text Button: %s', '<span>(' . t('find out more') . ')</span>'))?>
                      <div class="input-group align-center p30">
                        <?php echo $form->text($cTempl . '_CTA_text', ${$cTempl . '_CTA_text'}, array('maxlength' => 30, 'placeholder' => t('find out more')))?>
                      </div>
                    </div>
                    <div class="form-group center double-space-bottom single-space-top link-block-opts">
                      <label class="control-label no-margins"><?php echo t('Action Link')?>
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
                        <div class="col-lg-12">
                          <div id="<?php echo $cTempl?>_CTA_linkTypes" class="input-group single-space-bottom">
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'url', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['url'])?></span>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'pID', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['pID'])?></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row no-margins single-sides-spaces">
                        <div class="col-lg-6 no-sides-paddings">
                          <div id="<?php echo $cTempl?>_CTA_linkType_url" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $form->text($cTempl . '_CTA_url', ${$cTempl . '_CTA_url'}, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                          </div>
                          <div id="<?php echo $cTempl?>_CTA_linkType_pID" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $pageSelector->selectPage($cTempl . '_CTA_pID', ${$cTempl . '_CTA_pID'}, array())?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->text($cTempl . '_CTA_hash', ${$cTempl . '_CTA_hash'}, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->select($cTempl . '_CTA_target', $linkTargets, ${$cTempl . '_CTA_target'})?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <!-- End Tab: Clean Style -->

            <!-- Start Tab: I am What I do -->
            <?php $cTempl = 'iam_wid'?>

            <div class="ccm-tab-content <?php echo ($templateDefaultTab[$cTempl] === true) ? 'active' : null?>" id="item_3">
              <fieldset>
                <div class="row">
                  <div class="col-lg-12">
                    <section class="video <?php echo $cTempl?>">
                      <div>
                        <div class="row main single-space-top">
                          <div class="col-lg-6">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoURL', t('Background Video Url: %s', '<span>(YouTube)</span>'))?>
                              <div class="input-group">
                                <?php echo $form->text($cTempl . '_videoURL', ${$cTempl . '_videoURL'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-lg-offset-0 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoHQ', t('Quality'))?>
                              <div class="input-group">
                                <?php echo $form->select($cTempl . '_videoHQ', $optionsVideoHQ, ${$cTempl . '_videoHQ'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group center no-sides-spaces double-margin-botom">
                              <?php echo $form->label($cTempl . '_isVideoEnabled', t('Video Enabled?'))?>
                              <div class="input-group center display-inline">
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 1, (int) ${$cTempl . '_isVideoEnabled'})?>
                                    <span class="on"><?php echo t('Yes')?></span>
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 0, (int) ${$cTempl . '_isVideoEnabled'})?>
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
                  <div class="col-lg-12">
                    <div class="form-group center double-space-top">
                      <?php echo $form->label($cTempl . '_iam', t('I am: %s', '<span>(' . t('my name is') . ')</span>'))?>
                      <div class="input-group center p25">
                        <?php echo $form->text($cTempl . '_iam', ${$cTempl . '_iam'}, array('maxlength' => 25, 'placeholder' => t('I am')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center">
                      <?php echo $form->label($cTempl . '_title', t('Title: %s', '<span>(' . t('cool name') . ')</span>'))?>
                      <div class="input-group center p40">
                        <?php echo $form->text($cTempl . '_title', ${$cTempl . '_title'}, array('maxlength' => 50, 'placeholder' => t('cool name')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-top">
                      <?php echo $form->label($cTempl . '_ido', t('I do: %s', '<span>(' . t('I like') . ')</span>'))?>
                      <div class="input-group center p25">
                        <?php echo $form->text($cTempl . '_ido', ${$cTempl . '_ido'}, array('maxlength' => 25, 'placeholder' => t('I do')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center">
                      <?php echo $form->label($cTempl . '_subtitle', t('Subtitle: %s', '<span>(' . t('playing guitar') . ')</span>'))?>
                      <div class="input-group center p50">
                        <?php echo $form->text($cTempl . '_subtitle', ${$cTempl . '_subtitle'}, array('maxlength' => 50, 'placeholder' => t('playing guitar')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-top">
                      <?php echo $form->label($cTempl . '_CTA_text', t('Text Button: %s', '<span>(' . t('find out more') . ')</span>'))?>
                      <div class="input-group align-center p30">
                        <?php echo $form->text($cTempl . '_CTA_text', ${$cTempl . '_CTA_text'}, array('maxlength' => 30, 'placeholder' => t('find out more')))?>
                      </div>
                    </div>
                    <div class="form-group center double-space-bottom single-space-top link-block-opts">
                      <label class="control-label no-margins"><?php echo t('Action Link')?>
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
                        <div class="col-lg-12">
                          <div id="<?php echo $cTempl?>_CTA_linkTypes" class="input-group single-space-bottom">
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'url', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['url'])?></span>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'pID', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['pID'])?></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row no-margins single-sides-spaces">
                        <div class="col-lg-6 no-sides-paddings">
                          <div id="<?php echo $cTempl?>_CTA_linkType_url" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $form->text($cTempl . '_CTA_url', ${$cTempl . '_CTA_url'}, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                          </div>
                          <div id="<?php echo $cTempl?>_CTA_linkType_pID" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $pageSelector->selectPage($cTempl . '_CTA_pID', ${$cTempl . '_CTA_pID'}, array())?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->text($cTempl . '_CTA_hash', ${$cTempl . '_CTA_hash'}, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->select($cTempl . '_CTA_target', $linkTargets, ${$cTempl . '_CTA_target'})?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <!-- End Tab: I am What I do -->

            <!-- Start Tab: Image Shape dimension -->
            <?php $cTempl = 'img_sd'?>

            <div class="ccm-tab-content <?php echo ($templateDefaultTab[$cTempl] === true) ? 'active' : null?>" id="item_4">
              <fieldset>
                <div class="row">
                  <div class="col-lg-12">
                    <section class="video <?php echo $cTempl?>">
                      <div>
                        <div class="row main single-space-top">
                          <div class="col-lg-6">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoURL', t('Background Video Url: %s', '<span>(YouTube)</span>'))?>
                              <div class="input-group">
                                <?php echo $form->text($cTempl . '_videoURL', ${$cTempl . '_videoURL'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-lg-offset-0 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                            <div class="form-group center double-margin-botom">
                              <?php echo $form->label($cTempl . '_videoHQ', t('Quality'))?>
                              <div class="input-group">
                                <?php echo $form->select($cTempl . '_videoHQ', $optionsVideoHQ, ${$cTempl . '_videoHQ'})?>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group center no-sides-spaces double-margin-botom">
                              <?php echo $form->label($cTempl . '_isVideoEnabled', t('Video Enabled?'))?>
                              <div class="input-group center display-inline">
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 1, (int) ${$cTempl . '_isVideoEnabled'})?>
                                    <span class="on"><?php echo t('Yes')?></span>
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_isVideoEnabled', 0, (int) ${$cTempl . '_isVideoEnabled'})?>
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
                  <div class="col-lg-12">
                    <div class="form-group center double-space-top">
                      <?php echo $form->label($cTempl . '_title', t('Title: %s', '<span>(' . t('cool name') . ')</span>'))?>
                      <div class="input-group center p40">
                        <?php echo $form->text($cTempl . '_title', ${$cTempl . '_title'}, array('maxlength' => 50, 'placeholder' => t('cool name')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-bottom">
                      <?php echo $form->label($cTempl . '_subtitle', t('Subtitle: %s', '<span>(' . t('a catchy slogan') . ')</span>'))?>
                      <div class="input-group center p50">
                        <?php echo $form->text($cTempl . '_subtitle', ${$cTempl . '_subtitle'}, array('maxlength' => 50, 'placeholder' => t('a catchy slogan')))?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-7 no-right-space">
                        <div class="form-group center single-space-top no-right-space">
                          <?php echo $form->label($cTempl . '_content', t('Content: %s', '<span>(blah blah .. )</span>'))?>
                          <div class="input-group">
                            <?php echo $editor->outputStandardEditor($cTempl . '_content', ${$cTempl . '_content'})?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-5 col-lg-offset-0 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                        <div class="form-group center double-space-top no-space-bottom">
                          <label class="control-label">
                            <?php echo t('Choose image')?>
                          </label>
                        </div>
                        <div class="form-group center light-title no-paddings single-margin-bottom link-block-opts">
                          <div class="row no-margins">
                            <div class="col-lg-11 no-sides-spaces">
                              <div id="<?php echo $cTempl . '_imageTypes'?>" class="input-group single-space-bottom no-right-space">
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_imageType', 'fID', ${$cTempl . '_imageType'})?>
                                    <a><?php echo t($imageTypes['fID'])?></a>
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <?php echo $form->radio($cTempl . '_imageType', 'sID', ${$cTempl . '_imageType'})?>
                                    <a><?php echo t($imageTypes['sID'])?></a>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row no-margins">
                            <div class="col-lg-12 no-sides-paddings">
                              <div id="<?php echo $cTempl . '_imageType_fID'?>" class="input-group center current-<?php echo ${$cTempl . '_imageType'}?>">
                                <div class="form-group center single-margin-bottom light-title">
                                  <?php echo $form->label($cTempl . '_fID', t('stick a single image here'))?>
                                  <div class="input-group center single-space-top single-space-bottom p90">
                                    <?php echo $asset->image('ccm-b-image-' . $cTempl . '_fID', $cTempl . '_fID', t('Choose Image'), ${$cTempl . '_imageObject'}, array())?>
                                  </div>
                                </div>
                              </div>
                              <div id="<?php echo $cTempl . '_imageType_sID'?>" class="input-group center current-<?php echo ${$cTempl . '_imageType'}?>">
                                <div class="form-group center single-margin-bottom light-title">
                                  <?php
                                    if (empty($fileSetOptions) == false) {
                                      echo $form->label($cTempl . '_sID', t('random image from: %s', t('File Sets')));
                                    ?>
                                    <div class="input-group center single-space-top single-space-bottom p90">
                                      <?php echo $form->select($cTempl . '_sID', $fileSetOptions, ${$cTempl . '_sID'})?>
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
                            <div class="col-lg-12 no-paddings">
                              <div class="form-group center single-space-top no-space-bottom">
                                <label class="control-label single-margin-bottom"><?php echo t('Image Size')?>
                                  <br />
                                  <span><?php echo t('minimum: %s', '(' . $imageSizeLimit . 'x' . $imageSizeLimit . ')')?></span>
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="row no-margins">
                            <div class="col-lg-5 col-lg-offset-1">
                              <div class="input-group center float-left p70">
                                <?php echo $form->text($cTempl . '_imageWidth', ${$cTempl . "_imageWidth"}, array('maxlength' => 3,  'placeholder' => $imageWidthPlaceholder))?>
                              </div>
                              <div class="input-group align-left p30">
                                <span style="font-size: 1.4em">px</span>
                              </div>
                            </div>
                            <div class="col-lg-5">
                              <div class="input-group center float-left p70">
                                <?php echo $form->text($cTempl . '_imageHeight', ${$cTempl . "_imageHeight"}, array('maxlength' => 3,  'placeholder' => $imageHeightPlaceholder))?>
                              </div>
                              <div class="input-group align-left p30">
                                <span style="font-size: 1.4em">px</span>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group center single-space-top">
                      <?php echo $form->label($cTempl . '_CTA_text', t('Text Button: %s', '<span>(' . t('find out more') . ')</span>'))?>
                      <div class="input-group align-center p30">
                        <?php echo $form->text($cTempl . '_CTA_text', ${$cTempl . '_CTA_text'}, array('maxlength' => 30, 'placeholder' => t('find out more')))?>
                      </div>
                    </div>
                    <div class="form-group center double-space-bottom single-space-top link-block-opts">
                      <label class="control-label no-margins"><?php echo t('Action Link')?>
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
                        <div class="col-lg-12">
                          <div id="<?php echo $cTempl?>_CTA_linkTypes" class="input-group single-space-bottom">
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'url', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['url'])?></span>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <?php echo $form->radio($cTempl . '_CTA_linkType', 'pID', ${$cTempl . '_CTA_linkType'})?>
                                <span><?php echo t($linkTypes['pID'])?></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row no-margins single-sides-spaces">
                        <div class="col-lg-6 no-sides-paddings">
                          <div id="<?php echo $cTempl?>_CTA_linkType_url" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $form->text($cTempl . '_CTA_url', ${$cTempl . '_CTA_url'}, array('maxlength' => 255,  'placeholder' => t('http://blah-blah.com/%1$s-%2$s', t('web'), t('page'))))?>
                          </div>
                          <div id="<?php echo $cTempl?>_CTA_linkType_pID" class="input-group center current-<?php echo ${$cTempl . '_CTA_linkType'}?>">
                            <?php echo $pageSelector->selectPage($cTempl . '_CTA_pID', ${$cTempl . '_CTA_pID'}, array())?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->text($cTempl . '_CTA_hash', ${$cTempl . '_CTA_hash'}, array('maxlength' => 80,  'placeholder' => '#' . t('anchor-name')))?>
                          </div>
                        </div>
                        <div class="col-lg-3 no-sides-paddings">
                          <div class="input-group center">
                            <?php echo $form->select($cTempl . '_CTA_target', $linkTargets, ${$cTempl . '_CTA_target'})?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <!-- End Tab: Image Shape dimension -->
          </div>
          <!-- End Tabs row -->

        </div>
        <div class="col-lg-3 col-sm-5 col-xs-12">
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

                <div class="col-lg-12 separator-top separator-bottom single-space-bottom no-sides-spaces">
                  <div class="form-group center double-space-top light-title no-space-bottom">
                    <label class="control-label">
                      <?php echo t('background image')?>
                    </label>
                  </div>
                  <div class="form-group center light-title no-spaces link-block-opts">
                    <div class="row no-margins">
                      <div class="col-lg-12 no-spaces">
                        <div id="bg_imageTypes" class="input-group single-space-bottom no-margins">
                          <div class="single-sides-spaces radio">
                            <label>
                              <?php echo $form->radio('bg_imageType', 'fID', $bg_imageType)?>
                              <a><?php echo t($imageTypes['fID'])?></a>
                            </label>
                          </div>
                          <div class="single-sides-spaces radio">
                            <label>
                              <?php echo $form->radio('bg_imageType', 'sID', $bg_imageType)?>
                              <a><?php echo t($imageTypes['sID'])?></a>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row no-margins">
                      <div class="col-lg-12 no-sides-paddings">
                        <div id="bg_imageType_fID" class="input-group center current-<?php echo $bg_imageType?>">
                          <div class="form-group center single-margin-bottom light-title">
                            <?php echo $form->label('bgFID', t('stick a single image here'))?>
                            <div class="input-group center no-space-top single-space-bottom p70">
                              <?php echo $asset->image('ccm-b-image-bgFID', 'bgFID', t('Choose Image'), $bgImageObject, array())?>
                            </div>
                          </div>
                        </div>
                        <div id="bg_imageType_sID" class="input-group center current-<?php echo $bg_imageType?>">
                          <div class="form-group center single-margin-bottom light-title">
                            <?php
                              if (empty($fileSetOptions) == false) {
                                echo $form->label('bgSID', t('random image from: %s', t('File Sets')));
                              ?>
                              <div class="input-group center no-space-top single-space-bottom p70">
                                <?php echo $form->select('bgSID', $fileSetOptions, $bgSID)?>
                              </div>
                              <?php
                              }
                            ?>
                            <a href="<?php echo $fileSetHowToURL?>" target="_blank" class="btn goto"><span class="highlight"><?php echo t('How to add a %s', t('File Set'))?></span></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group center light-title no-margins no-sides-paddings single-space-top single-space-bottom max-width-300px">
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
                <div class="col-lg-8 col-lg-offset-2">
                  <div class="form-group center light-title single-space-bottom no-sides-paddings">
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

<!-- Current Template mark -->
<script type="text/javascript">
  $(document).ready(function() {
    $("ul.nav-tabs > li.active").prepend("<span class='current highlight'><?php echo t('current template')?></span><span class='fa fa-angle-down'></span>");
  });
</script>
