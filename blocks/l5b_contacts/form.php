<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: v1.2.4 (07 April 2019)
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

$bType = BlockType::getByHandle('form');

$c = Page::getCurrentPage();
?>
<div class="<?php echo $btWrapperForm ?>">
  <section>
    <div>
      <div class="row main">
        <div id="contacts-modal" class="col-lg-4 col-lg-offset-0 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0 wrap-tab-5">

          <?php 
            echo $hUI->tabs(array(
                array('item_1', t('Add'), true),
                array('item_2', t('Edit')),
                array('item_3', t('Preview')),
                array('item_4', t('Options')),
                array('item_5', t('Captcha')),
            ));
          ?>
          <input type="hidden" name="miniSurveyServices" value="<?php echo $hUrl->getBlockTypeToolsURL($bType)?>/services" />
          <input type="hidden" id="ccm-ignoreQuestionIDs" name="ignoreQuestionIDs" value="" />
          <input type="hidden" id="ccm-pendingDeleteIDs" name="pendingDeleteIDs" value="" />
          <input type="hidden" id="qsID" name="qsID" type="text" value="<?php echo intval($miniSurveyInfo['questionSetId'])?>" />
          <input type="hidden" id="oldQsID" name="oldQsID" type="text" value="<?php echo intval($miniSurveyInfo['questionSetId'])?>" />
          <input type="hidden" id="msqID" name="msqID" type="text" value="<?php echo intval($msqID)?>" />
      
<!-- Tab Options -->
          <div class="ccm-tab-content" id="ccm-tab-content-item_4">
            <fieldset>
              <legend><?php echo t('Options')?></legend>
              <div class="form-group">
                <?php echo $form->label('surveyName', t('Form Name'))?>
                <?php echo $form->text('surveyName', $surveyName, array('maxlength' => '155'))?>
              </div>
              <div class="form-group">
                  <?php echo $form->label('submitText', t('Submit Text'))?>
                  <?php echo $form->text('submitText', $submitText, array('maxlength' => '50'))?>
              </div>

              <div class="form-group">
                  <?php echo $form->label('thankyouMsg', t('Message to display when completed'))?>
                  <?php echo $form->textarea('thankyouMsg', $thankYouMessage, array('rows' => 3, 'maxlength' => '255'))?>
              </div>

              <div class="form-group">
                <?php echo $form->label('recipientEmail', t('Notify me by email when people submit this form'))?>
                <div class="input-group">
                  <span class="input-group-addon" style="z-index: 2000">
                  <?php echo $form->checkbox('notifyMeOnSubmission', 1, $miniSurveyInfo['notifyMeOnSubmission'] == 1, array('onclick' => "$('input[name=recipientEmail]').focus()"))?>
                  </span><?php echo $form->text('recipientEmail', $miniSurveyInfo['recipientEmail'], array('style' => 'z-index:2000;', 'maxlength' => '155'))?>
                </div>
                <span class="help-block"><?php echo t('(Seperate multiple emails with a comma)')?></span>
              </div>
            </fieldset>
          </div>

<!-- Tab Captha -->
          <div class="ccm-tab-content" id="ccm-tab-content-item_5">
            <fieldset>
              <legend><?php echo t('Captcha')?></legend>

              <div class="form-group">
                <label class="control-label"><?php echo t('Solving a <a href="%s" target="_blank">CAPTCHA</a> Required to Post?', t('http://en.wikipedia.org/wiki/Captcha'))?></label>
                <div class="radio">
                  <label>
                    <?php echo $form->radio('displayCaptcha', 1, (int) $miniSurveyInfo['displayCaptcha'])?>
                    <span><?php echo t('Yes')?></span>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <?php echo $form->radio('displayCaptcha', 0, (int) $miniSurveyInfo['displayCaptcha'])?>
                    <span><?php echo t('No')?></span>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="ccm-form-redirect"><?php echo t('Redirect to another page after form submission?')?></label>
                <div id="ccm-form-redirect-page">
                  <?php
                    if ($miniSurveyInfo['redirectCID']) {
                        print $pageSelector->selectPage('redirectCID', $miniSurveyInfo['redirectCID']);
                    } else {
                        print $pageSelector->selectPage('redirectCID');
                    }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="ccm-form-fileset"><?php echo t('Add uploaded files to a set?')?></label>
                <div id="ccm-form-fileset">
                  <?php
                    $sets = FileSet::getMySets();

                    $o = array(0 => t('None'));

                    if (is_array($sets)) {
                        foreach ($sets as $set) {
                            $o[$set->getFileSetID()] = $set->getFileSetName();
                        }
                    }
                    print $form->select('addFilesToSet', $o, $miniSurveyInfo['addFilesToSet']);
                  ?>
                </div>
              </div>
            </fieldset>
          </div>

<!-- Tab Add -->
          <div class="ccm-tab-content" id="ccm-tab-content-item_1">
            <fieldset id="newQuestionBox">
              <legend><?php echo t('New Question')?></legend>                
              
              <div id="questionAddedMsg" class="alert alert-success" style="display:none">
                <?php echo t('Question added. To view it click the preview tab.')?>
              </div>

              <div class="form-group">
                <?php echo $form->label('question', t('Question'))?>
                <?php echo $form->text('question', array('maxlength' => '255'))?>
              </div>

              <div class="form-group">
                <?php echo $form->label('answerType', t('Answer Type'))?>
                <select class="form-control" name="answerType" id="answerType">
                  <option value="field"><?php echo t('Text Field')?></option>
                  <option value="text"><?php echo t('Text Area')?></option>
                  <option value="radios"><?php echo t('Radio Buttons')?></option>
                  <option value="select"><?php echo t('Select Box')?></option>
                  <option value="checkboxlist"><?php echo t('Checkbox List')?></option>
                  <option value="fileupload"><?php echo t('File Upload')?></option>
                  <option value="email"><?php echo t('Email Address')?></option>
                  <option value="telephone"><?php echo t('Telephone')?></option>
                  <option value="url"><?php echo t('Web Address')?></option>
                  <option value="date"><?php echo t('Date Field')?></option>
                  <option value="datetime"><?php echo t('DateTime Field')?></option>
                </select>
              </div>  
              <div id="answerOptionsArea">
                <div class="form-group">
                  <?php echo $form->label('answerOptions', t('Answer Options'))?>
                  <?php echo $form->textarea('answerOptions', array('rows' => 3, 'maxlength' => '255'))?>
                  <span class="help-block"><?php echo t('Put each answer options on a new line')?></span>
                </div>
              </div>

              <div id="answerSettings" style="overflow:hidden">
                <div class="form-group" style="width:50%; float:left">
                  <?php echo $form->label('width', t('Text Area Width'))?>
                  <?php echo $form->text('width', 40, array('maxlength' => '4'))?>
                </div>
                <div class="form-group" style="width:50%; float:right">
                  <?php echo $form->label('height', t('Text Area Height'))?>
                  <?php echo $form->text('height', 10, array('maxlength' => '3'))?>
                </div>
              </div>

              <div id="answerDateDefault">
                <div class="form-group">
                  <?php echo $form->label('defaultDate', t('Default Value'))?>
                  <?php echo $form->select(
                          'defaultDate',
                          array(
                              '' => t('Blank'),
                              'now' => t('Current Date/Time'),
                          ),
                          'blank'
                        )?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label"><?php echo t('Required')?>:</label>
                <div class="radio"><label><?php echo $form->radio('required', 1)?> <?php echo t('Yes')?></label></div>
                <div class="radio"><label><?php echo $form->radio('required', 0)?> <?php echo t('No')?></label></div>
              </div>

              <div class="form-group">
                <div id="emailSettings">
                  <?php print $form->label('send_notification_from', t('Reply to this email address'));?>
                  <span class="send_notification_from"><?php print $form->checkbox('send_notification_from', 1); ?></span>
                </div>
              </div>

              <div class="form-group">
                <?php echo $hUI->button(t('Add Question'), '#', '', 'btn-success', array('id' => 'addQuestion'))?>
              </div>      
            </fieldset> 
            <input type="hidden" id="position" name="position" value="1000" />
          </div> 

<!-- Tab Edit -->
          <div class="ccm-tab-content" id="ccm-tab-content-item_2">
            <div class="alert alert-success" id="questionEditedMsg" style="display:none">
              <?php echo t('Your question has been saved.')?>
            </div>
            <div id="editQuestionForm" style="display:none">
              <fieldset>
                <legend id="editQuestionTitle"><?php echo t('Edit Question')?></legend>
                <div class="form-group">
                  <?php echo $form->label('questionEdit', t('Question'))?><?php echo $form->text('questionEdit', array('maxlength' => '155'))?>
                </div>
                <div class="form-group">
                  <?php echo $form->label('answerTypeEdit', t('Answer Type'))?>
                  <select class="form-control" id="answerTypeEdit" name="answerTypeEdit">
                    <option value="field"><?php echo t('Text Field')?></option>
                    <option value="text"><?php echo t('Text Area')?></option>
                    <option value="radios"><?php echo t('Radio Buttons')?></option>
                    <option value="select"><?php echo t('Select Box')?></option>
                    <option value="checkboxlist"><?php echo t('Checkbox List')?></option>
                    <option value="fileupload"><?php echo t('File Upload')?></option>
                    <option value="email"><?php echo t('Email Address')?></option>
                    <option value="telephone"><?php echo t('Telephone')?></option>
                    <option value="url"><?php echo t('Web Address')?></option>
                    <option value="date"><?php echo t('Date Field')?></option>
                    <option value="datetime"><?php echo t('DateTime Field')?></option>
                  </select>
                </div>
                <div id="answerOptionsAreaEdit">
                  <div class="form-group">
                    <?php echo $form->label('answerOptionsEdit', t('Answer Options'))?>
                    <?php echo $form->textarea('answerOptionsEdit', array('rows' => 3, 'maxlength' => '255'))?>
                    <span class="help-block"><?php echo t('Put each answer options on a new line')?></span>
                  </div>
                </div>
                <div id="answerSettingsEdit">
                  <div class="form-group">
                    <?php echo $form->label('widthEdit', t('Text Area Width'))?><?php echo $form->text('widthEdit', 40, array('maxlength' => '4'))?>
                  </div>
                  <div class="form-group">
                    <?php echo $form->label('heightEdit', t('Text Area Height'))?><?php echo $form->text('heightEdit', 10, array('maxlength' => '4'))?>
                  </div>
                </div>
                <div id="answerDateDefaultEdit">
                  <div class="form-group">
                    <?php echo $form->label('defaultDateEdit', t('Default Value'))?>
                      <?php echo $form->select(
                              'defaultDateEdit',
                              array(
                                  '' => t('Blank'),
                                  'now' => t('Current Date/Time'),
                              ),
                              'blank');
                      ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label"><?php echo t('Required')?></label>
                  <div class="radio">
                    <label><?php echo $form->radio('requiredEdit', 1)?> <?php echo t('Yes')?></label>
                  </div>
                  <div class="radio">
                    <label><?php echo $form->radio('requiredEdit', 0)?> <?php echo t('No')?></label>
                  </div>
                </div>
                <div class="form-group">
                  <div id="emailSettingsEdit">
                    <?php print $form->label('send_notification_from_edit', t('Reply to this email address'))?>
                    <span class="send_notification_from_edit"><?php print $form->checkbox('send_notification_from_edit', 1); ?></span>
                  </div>
                </div>
              </fieldset>
              <input id="positionEdit" name="position" type="hidden" value="1000">
              <div>
                <?php echo $hUI->button(t('Cancel'), 'javascript:void(0)', 'left', 'btn-danger', array('id' => 'cancelEditQuestion'))?>
                <?php echo $hUI->button(t('Save Changes'), 'javascript:void(0)', 'right', 'btn-success', array('id' => 'editQuestion'))?>
              </div>
            </div>
            <div id="miniSurvey">
              <fieldset>
                <legend><?php echo t('Edit Survey')?></legend>
                <div id="miniSurveyWrap"></div>
              </fieldset>
            </div>
          </div>
                  
          <div class="ccm-tab-content" id="ccm-tab-content-item_3">
            <fieldset>
              <legend><?php echo t('Preview Survey')?></legend>
              <div id="miniSurveyPreviewWrap"></div>
            </fieldset>
          </div>

          <style type="text/css">
              div.ui-dialog {
                  overflow: visible !important;
              }
              div.miniSurveyQuestion {
                  float: left;
                  width: 80%;
              }
              div.miniSurveyOptions {
                  float: left;
                  width: 20%;
                  text-align: right;
              }
          </style>

          <script type="text/javascript">
          //safari was loading the auto.js too late. This ensures it's initialized
              function initFormBlockWhenReady(){
                  if (miniSurvey && typeof(miniSurvey.init)=='function') {
                    miniSurvey.cID=parseInt(<?php echo $c->getCollectionID()?>);
                    miniSurvey.arHandle="<?php echo urlencode(Request::request('arHandle'))?>";
                    miniSurvey.bID=itl_lazy_contacts_form.thisbID;
                    miniSurvey.btID=itl_lazy_contacts_form.thisbtID;
                    miniSurvey.qsID=parseInt(<?php echo $miniSurveyInfo['questionSetId']?>);        
                    miniSurvey.init();
                    miniSurvey.refreshSurvey();
                  } else setTimeout('initFormBlockWhenReady()', 100);
              }
              initFormBlockWhenReady();
          </script>

        </div>
        <div class="col-lg-6 col-lg-offset-0 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
              <div class="form-group center single-space-top">
                <?php echo $form->label('title', t('Title: %s', '<span>(' . t('contact me') . ')</span>'))?>
                <div class="input-group center">
                  <?php echo $form->text('title', $title, array('maxlength' => '50'))?>
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
                                'maxlength' => '255',
                            ));
                        ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <?php echo $form->label('telephone', t('Telephone: %s', '<span>(+33 (0)1 22 33 44 55)</span>'))?>
                  <div class="input-group">
                    <?php echo $form->text('telephone', trim($telephone), array('maxlength' => '155'))?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
              <div class="form-group center single-space-top">
                <?php echo $form->label('subtitle', t('Subtitle: %s', '<span>(' . t('yeah, go ahead!') . ')</span>'))?>
                <div class="input-group center">
                  <?php echo $form->text('subtitle', $subtitle, array('maxlength' => '50'))?>
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
                                'maxlength' => '255',
                            ));
                        ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group center single-space-top">
                  <?php echo $form->label('email', t('Email: %s', '<span>(' . t('my') . '@email.' . t('here') . ')</span>'))?>
                  <div class="input-group">
                    <?php echo $form->text('email', trim($email), array('maxlength' => '55'))?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group center double-space-top">
              <?php echo $form->label('fbPageUrl', t('%1$s Page %2$s: %3$s', 'Facebook', 'url', '<span>(<u>http://fb.com/facelog.fr</u>)</span>'))?>
              <div class="input-group center p80">
                <?php echo $form->text('fbPageUrl', trim($fbPageUrl), array('maxlength' => '255'))?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-lg-offset-0 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0 no-paddings">
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
