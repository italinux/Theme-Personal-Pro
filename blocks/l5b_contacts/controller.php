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
| @copyright (c) 2020                                                       |
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
namespace Concrete\Package\ThemeLazy5basic\Block\L5bContacts;

use Concrete\Package\ThemeLazy5basic\Src\Utils\Utils as BlockUtils;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\User\User;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\Http\Request;
use Concrete\Core\File\Importer as FileImporter;
use Concrete\Core\File\File;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\Localization\Localization;
use Concrete\Block\Form\MiniSurvey;
use Concrete\Core\File\Version;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

    protected $btTable = "btLazy5basicContacts";
    public $btFormTable = "btForm";
    public $btFormQuestionsTablename = 'btFormQuestions';
    public $btFormAnswerSetTablename = 'btFormAnswerSet';
    public $btFormAnswersTablename = 'btFormAnswers';

    protected $btExportTables = array('btLazy5basicContacts');
 

    protected static $btHandlerId = "contacts";
    protected $btDefaultSet = 'lazy5basic';

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.5';

    // Style Upload Background Image size in KBytes (1KB = 1024b)
    protected static $btStyleUploadImageSize = 500;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1680;
    protected static $btStyleUploadThumbHeight = 945;

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 1;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1380";
    protected $btInterfaceHeight = "900";

    protected $btWrapperClass = 'ccm-ui';
    protected $btWrapperForm = 'lazy-ui';

    // Support for Inline Editing
    protected $btSupportsInlineEdit = false;
    protected $btSupportsInlineAdd = false;

    // Bootstrap theme Grid Support
    protected $btIgnorePageThemeGridFrameworkContainer = false;

    // Cache block's database calls
    protected $btCacheBlockRecord = false;

    // Cache block's actual view output
    protected $btCacheBlockOutput = false;

    // Serve cached version even if the result of a post request
    protected $btCacheBlockOutputOnPost = false;

    // Server cached version even if user is logged in
    protected $btCacheBlockOutputForRegisteredUsers = false;

    /**
    * When block caching is enabled and output caching is enabled for a block,
    * this is the value in seconds before cache being refreshed. Default (0) is no limit.
    */
    protected $btCacheBlockOutputLifetime = 0;

    protected static function get_btStyles()
    {
        return array(
            'bgColorRGBA' => t('Background Colour'),
            'bgColorOpacity' => t('Adjust Background Opacity'),
            'bgFID' => t('Background Image'),
            'fgColorRGB' => t('Foreground Colour'),
            'isAnimated' => t('Animation / Transition'),
        );
    }

    protected static function get_btFields()
    {
        return array(
            'title' => array(
                'label' => t('Title'),
            ),
            'subtitle' => array(
                'label' => t('Subtitle'),
            ),
            'telephoneType' => array(
                'label' => t('Telephone type'),
            ),
            'telephone' => array(
                'label' => t('Telephone number'),
            ),
            'address' => array(
                'label' => t('Address'),
            ),
            'openHours' => array(
                'label' => t('Opening Hours'),
            ),
            'fbPageUrl' => array(
                'label' => t('Facebook Page url'),
            ),
            'email' => array(
                'label' => t('Email'),
            ),
        );
    }

    protected static function get_btFormExtraValues()
    {
        return array(
            'surveyName' => array(
                'label' => t('Form Name & Subject email too'),
            ),
            'thankYouMessage' => array(
                'label' => t('Success message: form is sent'),
            ),
            'submitText' => array(
                'label' => t('Text on submit button'),
            ),
            'bgColorOpacityOptions' => array(
                'label' => t('Options adjust background opacity'),
            ),
            'telephoneTypes' => array(
                'label' => t('Telephone types list'),
            ),
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block info Methods
    */
    public function getBlockTypeName()
    {

        return t('L5b Contacts');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b Contacts to your website');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Main Methods
    */
    public function getTitle() 
    {
        $cName  = 'title';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('contact me');
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getTitlePreview()
    {
        
        $config = self::$btHandlerId . '.preview.title';
        $dValue = t('please add fields');

        return BlockUtils::getDefaultValue($config, $dValue);
    }

    public function getSubtitle()
    {
        $cName  = 'subtitle';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('yeah, go ahead!');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getSubtitlePreview()
    {
        $config = self::$btHandlerId . '.preview.subtitle';
        $dValue = t('in your contact form here');

        return BlockUtils::getDefaultValue($config, $dValue);
    }

    public function getTelephoneType()
    {
        $cName  = 'telephoneType';
        $config = self::$btHandlerId . '.telephone.type';
        $dValue = 'telephone';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getTelephone()
    {
        $cName  = 'telephone';
        $config = self::$btHandlerId . '.telephone.number';
        $dValue = '+0 (1)2 34 56 78';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getAddress()
    {
        $cName  = 'address';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('%s Example', '10 rue de') . "\n";
        $dValue.= t('%s Paris', '75006') . "\n";
        $dValue.= t('France');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getOpenHours()
    {
        $cName  = 'openHours';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('Monday %1$s Friday: %2$s', '-', '9am - 6pm') . "\n";
        $dValue.= t('Saturday: %s', '9am - 2pm') . "\n";
        $dValue.= t('Sunday: Closed');
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFbPageUrl()
    {
        $cName  = 'fbPageUrl';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = null;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getEmail()
    {
        $cName  = 'email';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('%1$s@email.%2$s', t('your'), t('here'));

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Window Overlay Methods
    */
    public function getTelephoneTypes()
    {
        return array( 'mobile' => t('Mobile'),
                   'telephone' => t('Telephone'),
                    );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block additional View Method
    */
    public function getTelephoneTitle()
    {
        $types = $this->getTelephoneTypes();
          $key = $this->getTelephoneType();

        return $types[$key];
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Form Messages
    */
    public function getThankYouMessage()
    {
        $surveyBlockInfo = $this->getSurveyBlockInfo();

        $cName  = 'thankyouMsg';
        $config = self::$btHandlerId . '.' . 'form.text.thankyou';
        $dValue = t('success! thank you');

        return ($surveyBlockInfo['thankyouMsg'] ? $surveyBlockInfo['thankyouMsg'] : BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getSubmitText()
    {
        $surveyBlockInfo = $this->getSurveyBlockInfo();

        $cName  = 'submitText';
        $config = self::$btHandlerId . '.' . 'form.text.submit';
        $dValue = t('submit');

        return ($surveyBlockInfo['submitText'] ? $surveyBlockInfo['submitText'] : BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Survey (Form) obj
    */
    protected function getMiniSurvey()
    {
        // get / set miniSurvey
        $miniSurvey = (is_object($this->miniSurvey) == true ? $this->miniSurvey : new MiniSurvey());

        $miniSurvey->frontEndMode = true;

        return $miniSurvey;
    }

    protected function getSurveyBlockInfo()
    {
        // get Survey block info
        return $this->getMiniSurvey()->getMiniSurveyBlockInfoByQuestionId(intval($this->questionSetId), intval($this->bID));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Site Name
    */
    protected function getSiteName()
    {

        return (Config::get('concrete.site') == false ? BlockUtils::getThisApp()->make('site')->getSite()->getConfigRepository()->get('name') : Config::get('concrete.site'));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Form Name
    */
    protected function getSurveyName()
    {
        $surveyBlockInfo = $this->getSurveyBlockInfo();

        // Setup Survey (Form) Name Prefix
        $formNamePrefix = ucfirst($this->getSiteName()) . ' [' . strtoupper(Localization::activeLanguage()) . ']';

        // Retrieve Survey (Form) Name
        $surveyName = trim($surveyBlockInfo['surveyName']);

        // Detect PageName (Subjest)
        $pageName = ((Localization::activeLanguage() == Page::getCurrentPage()->getCollectionName()) ? t('Home') : Page::getCurrentPage()->getCollectionName());

        return (empty($surveyName) == false ? $surveyName : sprintf('%s %s %s', $formNamePrefix, t('Contacts'), t('Page: %s', $pageName)));
    }

    public function getJavaScriptStrings()
    {
        return array(
            'delete-question' => t('Are you sure you want to delete this question?'),
            'form-name' => t('Your form must have a name'),
            'complete-required' => t('Please complete all required fields'),
            'ajax-error' => t('AJAX Error'),
            'form-min-1' => t('Please add at least one question to your form'),
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block RegisterViewAssets
    */
    public function registerViewAssets($outputContent = '')
    {

        // Import this Block CSS view
        $this->requireAsset('css', self::$btHandlerId . '-view');

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * load assets if animation required:
        */
        // Import JQuery UI
        // $this->requireAsset('javascript', 'jquery/ui');
        // $this->requireAsset('css', 'jquery/ui');

        if ($this->getIsAnimated() === true && Page::getCurrentPage()->isEditMode() == false && Request::request('qsID') == false) {
            // Import Animations CSS & JS Configuration
            $this->requireAsset('jst.animate.conf');
        }

        // CSS Captcha
        if ($this->displayCaptcha) {
            $this->requireAsset('css', 'core/frontend/captcha');
        }

        // Import JS Submit & AutoScrolling to form Result
        $this->requireAsset('javascript', 'jst.contacts-main');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block View/Validate/Save Methods
    */
    public function view()
    {

        // Set style values
        $this->set('sID', $this->getSectionId());
        $this->set('viewPoint', self::getViewPointId());
        $this->set('cTemplate', $this->getCustomTemplateName());
        $this->set('cFgColorClass', $this->getCustomFgColorClassName());

        // Set main values
        // Sanitize some of the main values
        $this->set('telephoneTitle', $this->getTelephoneTitle());

        $this->set('telephone', str_replace(PHP_EOL, "<br />", $this->getTelephone()));
        $this->set('address', str_replace(PHP_EOL, "<br />", $this->getAddress()));
        $this->set('openHours', str_replace(PHP_EOL, "<br />", $this->getOpenHours()));

        // Import Custom Css3 inline
        $this->set('cStyle', $this->getCustomStyle());

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * All Form Survey related variables
        */
        $bID = intval($this->bID);
        $qsID = intval($this->questionSetId);

        $miniSurvey = $this->getMiniSurvey();
        $surveyBlockInfo = $this->getSurveyBlockInfo();

        // Retrieve all form inputs
        $this->set('allFormInputs', count($this->getAllFormInputs($miniSurvey)) > 0 ? $this->getAllFormInputs($miniSurvey) : $this->getAllFakeFormInputs());

        // Ctrl form has been sent succesfully
        $this->set('formSuccess', (Request::request('surveySuccess') && Request::request('qsid') == $qsID));

        // Retrieve default Messages
        $this->set('thankYouMessage', ($surveyBlockInfo['thankyouMsg'] ? $surveyBlockInfo['thankyouMsg'] : $this->getThankYouMessage()));
        $this->set('submitText', ($surveyBlockInfo['submitText'] ? $surveyBlockInfo['submitText'] : $this->getSubmitText()));

        // Retrieve captcha
        $this->set('captcha', ($surveyBlockInfo['displayCaptcha'] ? BlockUtils::getThisApp()->make('captcha') : false));

        $this->set('bID', $bID);
        $this->set('qsID', $qsID);
    }

    public function on_start()
    {
        $al = AssetList::getInstance();

        $pf = Array(
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => true,
            'combine' => true
        );

        $cf = Array(
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false
        );

        // Register Assets this Block
        // Submit & AutoScrolling to form Result
        $al->register('javascript', 'jst.contacts-main', 'blocks/' . $this->getBlockHandle() . '/jscript/contacts-main.js', $pf, $this->getPackageHandle());

        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/' . $this->getBlockHandle() . '/jscript/lazy-animate.conf.js', $cf, $this->getPackageHandle());
        $al->register('javascript-inline', $this->getJSelectorId() . '.animate-init',  '$("section#' . $this->getSectionId()  . '").lazyAnimate(' . $this->getSelectorBlock() . ');', $cf, $this->getPackageHandle());

        $al->registerGroup(
            'jst.animate.conf', array(
               array(
                   'javascript',
                   $this->getJSelectorId() . '.animate-conf'
               ),
               array(
                   'javascript-inline',
                   $this->getJSelectorId() . '.animate-init'
               ),
            )
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style main
    * Stream
    */
    protected function getCustomStyle()
    {
        $o=null;

        if (BlockUtils::isValidColor($this->bgColorRGBA) ||
            BlockUtils::isValidImage($this->getBgFID()) ||
            BlockUtils::isValidColor($this->fgColorRGB) ||
            $this->isCustomOverImageOpacity($this->bgColorOpacity)) {

            ob_start();
            ?>

            <style>
              <?php
                if (BlockUtils::isValidColor($this->bgColorRGBA) ||
                    $this->isCustomOverImageOpacity($this->bgColorOpacity)) {
                ?>
                  section<?php echo $this->getStyleSelector()?>.over-image::before {
                    <?php
                      if (BlockUtils::isValidColor($this->bgColorRGBA)) { ?>
                          background-color: <?php echo $this->getOverImageBgColor()?> !important;
                    <?php } ?>
                    <?php
                      if ($this->isCustomOverImageOpacity($this->bgColorOpacity)) { ?>
                          opacity: <?php echo $this->bgColorOpacity?> !important;
                    <?php } ?>
                  }
              <?php } ?>

              <?php
                if (BlockUtils::isValidImage($this->getBgFID()) ||
                    BlockUtils::isValidColor($this->bgColorRGBA) ||
                    BlockUtils::isValidColor($this->fgColorRGB)) {
                ?>
                  section<?php echo $this->getStyleSelector()?>.over-image {
                    <?php
                      if (BlockUtils::isValidImage($this->getBgFID())) { ?>
                          background-image: url('<?php echo parse_url($this->getCustomStyleImagePath(), PHP_URL_PATH)?>') !important;
                    <?php } ?>

                    <?php
                      if (BlockUtils::isValidColor($this->bgColorRGBA)) { ?>
                          background-color: <?php echo $this->bgColorRGBA?> !important;
                    <?php } ?>

                    <?php
                      if (BlockUtils::isValidColor($this->fgColorRGB)) { ?>
                          color: <?php echo $this->fgColorRGB ?> !important;
                    <?php } ?>
                  }
               <?php } ?>
            </style>

            <?php
            $o = ob_get_contents();

            ob_end_clean();

            $o = BlockUtils::getCustomStyleSanitised($o);
        }

        return $o;
    }
 
    public function validate($args)
    {
        $e = BlockUtils::getThisApp()->make('error');

        // Validate Styles
        foreach (array_keys(self::get_btStyles()) as $key) {

            switch ($key) {
            case (lcfirst(substr($key, -3)) == 'fID'):

                if (!empty($args[$key])) {
                    $f = BlockUtils::getFileObject($args[$key]);

                    if (is_object($f)) {
                        switch ($f->getMimeType()) {
                        case 'image/jpeg':
                        case 'image/jpg':
                        case 'image/png':
                            break;
                        default:
                            $e->add(t('File type required: JPG or PNG'));
                            break;
                        }

                        switch (strtolower($f->getExtension())) {
                        case 'jpeg':
                        case 'jpg':
                        case 'png':
                            break;
                        default:
                            $e->add(t('File extension required: JPG or PNG'));
                            break;
                        }

                        $uploadImageSize = BlockUtils::getUploadImageSize(self::$btStyleUploadImageSize);

                        if ($f->getFullSize() > $uploadImageSize) {
                            $e->add(t('File size exceeded: Max %s', BlockUtils::getHumanReadUploadImageSize($uploadImageSize)));
                        }

                        if ($f->isError()) {
                            $e->add(t('File image is invalid'));
                        }
                    } else {
                        $e->add(t('File image is invalid'));
                    }
                }
                break;
            }
        }

        // Validate Fields
        foreach (self::get_btFields() as $value) {

            // Field is Empty
            if (isset($value['allowEmpty']) && ($value['allowEmpty'] === false)) {

                if (empty($args[$key])) {
                    $e->add(t('Cannot be empty: %s', $value['label']));
                }
            }
        }

        return $e;
    }

    protected function importAdditionalData($b, $blockNode)
    {
        if (isset($blockNode->data)) {
            foreach ($blockNode->data as $data) {

                if ($data['table'] != $this->getBlockTypeDatabaseTable()) {
                    $table = (string) $data['table'];
                    if (isset($data->record)) {

                        foreach ($data->record as $record) {
                            $aar = new \Concrete\Core\Legacy\BlockRecord($table);
                            $aar->bID = $b->getBlockID();

                            foreach ($record->children() as $node) {
                                $nodeName = $node->getName();
                                $aar->{$nodeName} = (string) $node;
                            }

                            if ($table == 'btFormQuestions') {
                                $db = BlockUtils::getThisApp()->make('database')->connection();
                                $aar->questionSetId = $db->fetchColumn("SELECT questionSetId FROM {$this->btFormTable} WHERE bID = ?", array($b->getBlockID()));
                            }

                            $aar->Replace();
                        }
                    }
                }
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get all the defaults (fake) form inputs
    */
    protected function getAllFakeFormInputs()
    {

        $disabled='disabled="disabled"';

        $allFakeFormInputs = array(
            0=>array(
                'question' => 'name',
                'inputType' => 'text',
                'required' => 0,
                'input' => '<input type="text" name="q1" maxlength="155" placeholder=" %s ..." class="form-control" ' . $disabled . '/>',
                'type' => 'text',
                'labelFor' => 'for="q1"'),
            1=>array(
                'question' => 'email',
                'inputType' => 'email',
                'required' => 1,
                'input' => '<input type="email" name="q2" maxlength="55" placeholder=" blah blah blah .." class="form-control" ' . $disabled . '/>',
                'type' => 'email',
                'labelFor' => 'for="q2"'),
            2=>array(
                'question' => 'type a message',
                'inputType' => 'textarea',
                'required' => 0,
                'input' => '<textarea name="q3" maxlength="255" cols="40" rows="10" placeholder="[login / edit] %s." class="form-control" ' . $disabled . '/></textarea>',
                'type' => 'textarea',
                'labelFor' => 'for="q3"'),
            );

        $this->set('disabled', 'disabled');

        $this->set('title', $this->getTitlePreview());
        $this->set('subtitle', $this->getSubtitlePreview());

        return (array) $allFakeFormInputs;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get all form inputs registered
    */
    protected function getAllFormInputs(MiniSurvey $miniSurvey)
    {
        
        $allFormInputs = array();
        $rec = $miniSurvey->loadQuestions($this->questionSetId, $this->bID);

        while ($row = $rec->fetchRow()) {
            $thisInput = $row;
            $thisInput['input'] = $miniSurvey->loadInputType($row, false);

            // Make type names common-sensical
            switch ($row['inputType']) {
            case 'text':
              $thisInput['type'] = 'textarea';
              $thisInput['input'] = str_replace('style="width:95%"', '', $thisInput['input']);
              break;
            case 'field':
              $thisInput['type'] = 'text';
              break;
            default:
              $thisInput['type'] = $row['inputType'];
            }

            $thisInput['labelFor'] = 'for="Question' . $row['msqID'] . '"';
            $allFormInputs[] = $thisInput;
        }

        $this->set('disabled', false);

        return (array) $allFormInputs;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Form add or edit submit
    * (run after the duplicate method on first block edit of new page version).
    */
    public function saveForm($data = array())
    {
        if (!$data || count($data) == 0) {
            $data = Request::post();
        }

        $data += array(
            'qsID' => null,
            'oldQsID' => null,
            'questions' => array(),
        );

        $db = BlockUtils::getThisApp()->make('database')->connection();

        if (intval($this->bID) > 0) {
            $q = "SELECT COUNT(*) AS total FROM {$this->btFormTable} WHERE bID = " . intval($this->bID);
            $total = $db->fetchColumn($q);
        } else {
            $total = 0;
        }

        if (!$data['oldQsID']) {
            $data['oldQsID'] = $data['qsID'];
        }

        $data['bID'] = intval($this->bID);

        if (!empty($data['redirectCID'])) {
            $data['redirect'] = 1;
        } else {
            $data['redirect'] = 0;
            $data['redirectCID'] = 0;
        }

        if (empty($data['addFilesToSet'])) {
            $data['addFilesToSet'] = 0;
        }

        if (!isset($data['surveyName'])) {
            $data['surveyName'] = '';
        }

        if (!isset($data['submitText'])) {
            $data['submitText'] = $this->getSubmitText();
        }

        if (!isset($data['notifyMeOnSubmission'])) {
            $data['notifyMeOnSubmission'] = 0;
        }

        if (!isset($data['thankyouMsg'])) {
            $data['thankyouMsg'] = $this->getThankYouMessage();
        }

        if (!isset($data['displayCaptcha'])) {
            $data['displayCaptcha'] = 0;
        }

        $v = array(
              $data['qsID'],
              $data['surveyName'],
              $data['submitText'],
              intval($data['notifyMeOnSubmission']),
              $data['recipientEmail'],
              $data['thankyouMsg'],
              intval($data['displayCaptcha']),
              intval($data['redirectCID']),
              intval($data['addFilesToSet']),
              intval($this->bID)
             );

        //is it new?
        if (intval($total) == 0) {
            $q = "INSERT INTO {$this->btFormTable} (questionSetId,
                                                    surveyName,
                                                    submitText,
                                                    notifyMeOnSubmission,
                                                    recipientEmail,
                                                    thankyouMsg,
                                                    displayCaptcha,
                                                    redirectCID,
                                                    addFilesToSet,
                                                    bID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } else {
            $v[] = $data['qsID'];
            $q = "UPDATE {$this->btFormTable} SET questionSetId = ?,
                                                  surveyName = ?,
                                                  submitText = ?,
                                                  notifyMeOnSubmission = ?,
                                                  recipientEmail = ?,
                                                  thankyouMsg = ?,
                                                  displayCaptcha = ?,
                                                  redirectCID = ?,
                                                  addFilesToSet = ? WHERE bID = ? AND questionSetId= ?";
        }

        $db->executeQuery($q, $v);

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Add Questions (for programmatically creating forms, such as during the site install)
        */
        if (count($data['questions']) > 0) {
            $miniSurvey = new MiniSurvey();
            foreach ($data['questions'] as $questionData) {
                $miniSurvey->addEditQuestion($questionData, 0);
            }
        }

        $this->questionVersioning($data);

        return true;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Ties the new or edited questions to the new block number.
    * New and edited questions are temporarily given bID=0, until the block is saved... painfully complicated.
    *
    * @param array $data
    */
    protected function questionVersioning($data = array())
    {
        $data += array(
            'ignoreQuestionIDs' => '',
            'pendingDeleteIDs' => '',
        );

        $db = BlockUtils::getThisApp()->make('database')->connection();

        //if this block is being edited a second time, remove edited questions with the current bID that are pending replacement
        //if( intval($oldBID) == intval($this->bID) ){

        $vals = array(intval($data['oldQsID']));
        $pendingQuestions = $db->fetchAll('SELECT msqID FROM btFormQuestions WHERE bID=0 && questionSetId=?', $vals);

            foreach ($pendingQuestions as $pendingQuestion) {
                $vals = array(intval($this->bID), intval($pendingQuestion['msqID']));
                $db->executeQuery('DELETE FROM btFormQuestions WHERE bID=? AND msqID=?', $vals);
            }
        //}

        //assign any new questions the new block id
        $vals = array(intval($data['bID']), intval($data['qsID']), intval($data['oldQsID']));
        $db->executeQuery('UPDATE btFormQuestions SET bID=?, questionSetId=? WHERE bID=0 && questionSetId=?', $vals);

        //These are deleted or edited questions.  (edited questions have already been created with the new bID).
        $ignoreQuestionIDsDirty = explode(',', $data['ignoreQuestionIDs']);
        $ignoreQuestionIDs = array(0);

            foreach ($ignoreQuestionIDsDirty as $msqID) {
                $ignoreQuestionIDs[] = intval($msqID);
            }

        //remove any questions that are pending deletion, that already have this current bID
        $pendingDeleteQIDsDirty = explode(',', $data['pendingDeleteIDs']);
        $pendingDeleteQIDs = array();

            foreach ($pendingDeleteQIDsDirty as $msqID) {
                $pendingDeleteQIDs[] = intval($msqID);
            }

        $vals = array($this->bID, intval($data['qsID']));
        $pendingDeleteQIDs = implode(',', $pendingDeleteQIDs);
        $db->executeQuery('DELETE FROM btFormQuestions WHERE bID=? AND questionSetId=? AND msqID IN (' . $pendingDeleteQIDs . ')', $vals);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * IMPORTANT!
    * THIS NEXT METHOD IS AS A DODGY WORKAROUND.
    * IT WILL REQUIRE REFACORING AT SOME POINT IN THE NEAR FUTURE
    */
    private function setNewQuestionID($key, $value){
        $_POST[$key] = $value;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Duplicate will run when copying a page with a block, 
    * or editing a block for the first time within a page version (before the save).
    */
    public function duplicate($newBID)
    {
        $b = $this->getBlockObject();
        $c = $b->getBlockCollectionObject();

        $db = BlockUtils::getThisApp()->make('database')->connection();

        $q = "SELECT * FROM {$this->btFormTable} WHERE bID = ? LIMIT 1";
        $r = $db->executeQuery($q, array($this->bID));

        $row = $r->fetchRow();

        //if the same block exists in multiple collections with the same questionSetID
        if (count($row) > 0) {
            $oldQuestionSetId = $row['questionSetId'];

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * It should only generate a new question set id if the block is copied to a new page,
            * otherwise it will loose all of its answer sets (from all the people who've used the form on this page)
            */
            $questionSetCIDs = $db->fetchAll("SELECT distinct cID FROM {$this->btFormTable} AS f, CollectionVersionBlocks AS cvb ".
                                             "WHERE f.bID=cvb.bID AND questionSetId=" . intval($row['questionSetId']));

            //this question set id is used on other pages, so make a new one for this page block
            if (count($questionSetCIDs) > 1 || !in_array($c->cID, $questionSetCIDs)) {
                $newQuestionSetId = time();

                $this->setNewQuestionID('qsID', $newQuestionSetId);

            } else {
                //otherwise the question set id stays the same
                $newQuestionSetId = $row['questionSetId'];
            }

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * duplicate survey block record
            * with a new Block ID and a new Question
            */
            $v = array(
                  $newQuestionSetId,
                  $row['surveyName'],
                  $row['submitText'],
                  $newBID,
                  $row['thankyouMsg'],
                  intval($row['notifyMeOnSubmission']),
                  $row['recipientEmail'],
                  $row['displayCaptcha'],
                  $row['addFilesToSet']
                 );

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * NEW record within Form Table
            */
            $q = "INSERT INTO {$this->btFormTable} (questionSetId,
                                                    surveyName,
                                                    submitText,
                                                    bID,
                                                    thankyouMsg,
                                                    notifyMeOnSubmission,
                                                    recipientEmail,
                                                    displayCaptcha,
                                                    addFilesToSet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $db->executeQuery($q, $v);

            $rs = $db->executeQuery("SELECT * FROM {$this->btFormQuestionsTablename} WHERE questionSetId=$oldQuestionSetId AND bID= " . intval($this->bID));

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * NEW record within Questions
            */
            while ($row = $rs->fetchRow()) {

                $v = array(
                      $newQuestionSetId,
                      intval($row['msqID']),
                      intval($newBID),
                      $row['question'],
                      $row['inputType'],
                      $row['options'],
                      $row['position'],
                      $row['width'],
                      $row['height'],
                      $row['required'],
                      $row['defaultDate']
                     );

                $sql = "INSERT INTO {$this->btFormQuestionsTablename} (questionSetId,
                                                                       msqID,
                                                                       bID,
                                                                       question,
                                                                       inputType,
                                                                       options,
                                                                       position,
                                                                       width,
                                                                       height,
                                                                       required,
                                                                       defaultDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $db->executeQuery($sql, $v);
            }

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * fetch OLD record within btTable: Block Table
            */
            $rs = $db->executeQuery("SELECT * FROM {$this->btTable} WHERE questionSetId=$oldQuestionSetId AND bID= " . intval($this->bID));

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * NEW record within Block Table
            */
            while ($row = $rs->fetchRow()) {

                $v = array(
                      intval($newBID),
                      $newQuestionSetId,
                      $row['title'],
                      $row['subtitle'],
                      $row['telephone'],
                      $row['address'],
                      $row['openHours'],
                      $row['fbPageUrl'],
                      $row['email'],
                      $row['bgColorRGBA'],
                      $row['bgFID'],
                      $row['fgColorRGB'],
                      $row['isAnimated']
                     );

                
                $sql = "INSERT INTO {$this->btTable} (bID,
                                                      questionSetId,
                                                      title,
                                                      subtitle,
                                                      telephone,
                                                      address,
                                                      openHours,
                                                      fbPageUrl,
                                                      email,
                                                      bgColorRGBA,
                                                      bgFID,
                                                      fgColorRGB,
                                                      isAnimated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


                $db->executeQuery($sql, $v);
            }

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * Update Reports counts
            */
            $sql = "UPDATE {$this->btFormAnswerSetTablename} SET questionSetId = ? WHERE questionSetId= ?";
            $db->executeQuery($sql, array($newQuestionSetId, $oldQuestionSetId));


            return $newQuestionSetId;
        }

        return 0;
    }

    /**
     * Users submits the completed survey.
     *
     * @param int $bID
     */
    public function action_submit_form($bID = false)
    {
        if ($this->bID != $bID) {
            return false;
        }

        $ip = BlockUtils::getThisApp()->make('ip');
        $this->view();

        if ($ip->isBanned()) {
            $this->set('invalidIP', $ip->getErrorMessage());

            return;
        }

        $txt = BlockUtils::getThisApp()->make('helper/text');
        $db = BlockUtils::getThisApp()->make('database')->connection();

        //question set id
        $qsID = intval(Request::post('qsID'));

        if ($qsID == 0) {
            throw new \Exception(t("Oops, something is wrong with the form you posted (it doesn't have a question set id)"));
        }

        //get all questions for this question set
        $rows = $db->fetchAll("SELECT * FROM {$this->btFormQuestionsTablename} WHERE questionSetId=? AND bID=? order by position asc, msqID", array($qsID, intval($this->bID)));

        if (!count($rows)) {
            throw new \Exception(t("Oops, something is wrong with the form you posted (it doesn't have any questions)"));
        }

        // set all properties values
        $q = "SELECT * FROM {$this->btFormTable} WHERE questionSetId = ? LIMIT 1";
        $r = $db->executeQuery($q, array($qsID));

        foreach ($r->fetchRow() as $key => $value) {
            $this->{$key} = $value;
        }

        $errors = $errorDetails = array();

        // check captcha if activated
        if ($this->displayCaptcha) {
            $captcha = BlockUtils::getThisApp()->make('captcha');
            if (!$captcha->check()) {
                $errors['captcha'] = t("Incorrect captcha code");
            }
        }

        //checked required fields
        foreach ($rows as $row) {

            if ($row['inputType'] == 'datetime') {
                if (!isset($datetime)) {
                    $datetime = BlockUtils::getThisApp()->make('helper/form/date_time');
                }
                $translated = $datetime->translate('Question' . $row['msqID']);
                if ($translated) {
                    $this->setNewQuestionID('Question' . $row['msqID'], $translated);
                }
            }

            if (intval($row['required']) == 1) {
                $notCompleted = 0;

                if ($row['inputType'] == 'email') {
                    if (!BlockUtils::getThisApp()->make('helper/validation/strings')->email(Request::post('Question' . $row['msqID']))) {
                        $errors['emails'] = t('You must enter a valid email address');
                        $errorDetails[$row['msqID']]['emails'] = $errors['emails'];
                    }
                }

                if ($row['inputType'] == 'checkboxlist') {
                    $answerFound = 0;
                    foreach (Request::post() as $key => $value) {
                        if (strstr($key, 'Question' . $row['msqID'] . '_') && strlen($value)) {
                            $answerFound = 1;
                        }
                    }
                    if (!$answerFound) {
                        $notCompleted = 1;
                    }
                } elseif ($row['inputType'] == 'fileupload') {

                    // this request file uploaded
                    $thisUploadedFile = $this->request->files->get('Question'.$row['msqID']);

                    if (!isset($thisUploadedFile) || !is_uploaded_file($thisUploadedFile['tmp_name'])) {
                        $notCompleted = 1;
                    }
                } elseif (!strlen(trim(Request::post('Question'.$row['msqID'])))) {
                    $notCompleted = 1;
                }

                if ($notCompleted) {
                    $errors['CompleteRequired'] = t('Complete required fields *');
                    $errorDetails[$row['msqID']]['CompleteRequired'] = $errors['CompleteRequired'];
                }
            }
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * try importing the file if everything else went ok
        */
        $tmpFileIds = array();

        if (!count($errors)) {
            foreach ($rows as $row) {
                if ($row['inputType'] != 'fileupload') {
                    continue;
                }

                // this request file uploaded
                $thisUploadedFile = $this->request->files->get('Question'.$row['msqID']);

                if (!intval($row['required']) &&
                    (
                    !isset($thisUploadedFile['tmp_name']) || !is_uploaded_file($thisUploadedFile['tmp_name'])
                    )
                ) {
                    continue;
                }
                $fi = new FileImporter();
                $resp = $fi->import($thisUploadedFile['tmp_name'], $thisUploadedFile['name']);

                if (!($resp instanceof Version)) {

                    switch ($resp) {
                    case FileImporter::E_FILE_INVALID_EXTENSION:
                        $errors['fileupload'] = t('Invalid file extension');
                        $errorDetails[$row['msqID']]['fileupload'] = $errors['fileupload'];
                        break;
                    case FileImporter::E_FILE_INVALID:
                        $errors['fileupload'] = t('Invalid file');
                        $errorDetails[$row['msqID']]['fileupload'] = $errors['fileupload'];
                        break;
                    }

                } else {
                    $tmpFileIds[intval($row['msqID'])] = $resp->getFileID();
                    if (intval($this->addFilesToSet)) {
                        $fs = new FileSet();
                        $fs = $fs->getByID($this->addFilesToSet);
                        if ($fs->getFileSetID()) {
                            $fs->addFileToSet($resp);
                        }
                    }
                }
            }
        }

        if (count($errors)) {

            // Collate all errors and put them into divs
            $errors = isset($errors) && is_array($errors) ? $errors : array();

            if (isset($invalidIP) && $invalidIP) {
                $errors[] = $invalidIP;
            }

            $errorMsg = array();

             // It's okay for this one thing to have the html here,
             // it can be identified in CSS via parent wrapper div (e.g. '.formblock .error')
            foreach ($errors as $error) {
               $errorMsg[] = $error;
            }

            $this->set('errors', $errors);
            $this->set('errorHeader', t('Please correct the following errors:'));
            $this->set('errorMsg', $errorMsg);
            $this->set('errorDetails', $errorDetails);

        } else {

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * NO form errors
            * Save main survey record
            */

            $u = new User();
            $uID = 0;

            if ($u->isRegistered()) {
                $uID = $u->getUserID();
            }

            $q = "INSERT INTO {$this->btFormAnswerSetTablename} (questionSetId, uID) VALUES (?,?)";
            $db->executeQuery($q, array($qsID, $uID));

            $answerSetID = $db->lastInsertId();
            $this->lastAnswerSetId = $answerSetID;

            $questionAnswerPairs = array();

            if (Config::get('concrete.email.form_block.address') && strstr(Config::get('concrete.email.form_block.address'), '@')) {
                $formFormEmailAddress = Config::get('concrete.email.form_block.address');
            } else {
                $adminUserInfo = BlockUtils::getThisApp()->make(\Concrete\Core\User\UserInfoRepository::class)->getByID(USER_SUPER_ID);
                $formFormEmailAddress = $adminUserInfo->getUserEmail();
            }

            $replyToEmailAddress = $formFormEmailAddress;

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * loop through each question and get the answers
            */
            foreach ($rows as $row) {
                /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
                * save each answer
                */
                $answerDisplay = '';

                switch ($row['inputType']) {
                case 'checkboxlist':
                    $answer = array();
                    $answerLong = "";
                    foreach (Request::post() as $key => $value) {
                        if (strpos($key, 'Question' . $row['msqID'] . '_') === 0) {
                            $answer[] = $txt->sanitize($value);
                        }
                    }
                    break;
                case 'text':
                    $answerLong = $txt->sanitize(Request::post('Question'.$row['msqID']));
                    $answer = '';
                    break;
                case 'fileupload':
                    $answerLong = "";
                    $answer = intval($tmpFileIds[intval($row['msqID'])]);
                    if ($answer > 0) {
                        $answerDisplay = File::getByID($answer)->getVersion()->getDownloadURL();
                    } else {
                        $answerDisplay = t('No file specified');
                    }
                    break;
                case 'url':
                    $answerLong = "";
                    $answer = $txt->sanitize(Request::post('Question'.$row['msqID']));
                    break;
                case 'email':
                    $answerLong = "";
                    $answer = $txt->sanitize(Request::post('Question'.$row['msqID']));
                    if (!empty($row['options'])) {
                        $settings = unserialize($row['options']);
                        if (is_array($settings) && array_key_exists('send_notification_from', $settings) && $settings['send_notification_from'] == 1) {
                            $email = $txt->email($answer);
                            if (!empty($email)) {
                                $replyToEmailAddress = $email;
                            }
                        }
                    }
                    break;
                case 'telephone':
                    $answerLong = "";
                    $answer = $txt->sanitize(Request::post('Question'.$row['msqID']));
                    break;
                default:
                    $answerLong = "";
                    $answer = $txt->sanitize(Request::post('Question'.$row['msqID']));
                }

                if (is_array($answer)) {
                    $answer = implode(',', $answer);
                }

                $questionAnswerPairs[$row['msqID']]['question'] = $row['question'];
                $questionAnswerPairs[$row['msqID']]['answer'] = $txt->sanitize($answer.$answerLong);
                $questionAnswerPairs[$row['msqID']]['answerDisplay'] = strlen($answerDisplay) ? $answerDisplay : $questionAnswerPairs[$row['msqID']]['answer'];

                $v = array($row['msqID'],$answerSetID,$answer,$answerLong);
                $q = "INSERT INTO {$this->btFormAnswersTablename} (msqID, asID, answer, answerLong) VALUES (?,?,?,?)";
                $db->executeQuery($q, $v);
            }
            $foundSpam = false;

            $submittedData = '';

            foreach ($questionAnswerPairs as $questionAnswerPair) {
                $submittedData .= $questionAnswerPair['question']."\r\n".$questionAnswerPair['answer']."\r\n"."\r\n";
            }

            $antispam = BlockUtils::getThisApp()->make('helper/validation/antispam');

            if (!$antispam->check($submittedData, 'form_block')) {
                /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
                * found to be spam. We remove it
                */
                $foundSpam = true;

                $q = "DELETE FROM {$this->btFormAnswerSetTablename} WHERE asID = ?";
                $v = array($this->lastAnswerSetId);

                $db->executeQuery($q, $v);
                $db->executeQuery("DELETE FROM {$this->btFormAnswersTablename} WHERE asID = ?", array($this->lastAnswerSetId));
            }

            if (intval($this->notifyMeOnSubmission) > 0 && !$foundSpam) {
                if (Config::get('concrete.email.form_block.address') && strstr(Config::get('concrete.email.form_block.address'), '@')) {
                    $formFormEmailAddress = Config::get('concrete.email.form_block.address');
                } else {
                    $adminUserInfo = BlockUtils::getThisApp()->make(\Concrete\Core\User\UserInfoRepository::class)->getByID(USER_SUPER_ID);
                    $formFormEmailAddress = $adminUserInfo->getUserEmail();
                }

                $mh = BlockUtils::getThisApp()->make('mail');

                $mh->to($this->recipientEmail);
                $mh->from($formFormEmailAddress);
                $mh->replyto($replyToEmailAddress);

                $mh->addParameter('formName', $this->surveyName);
                $mh->addParameter('questionSetId', $this->questionSetId);
                $mh->addParameter('questionAnswerPairs', $questionAnswerPairs);

                $mh->load('block_form_submission');

                /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
                * set Subject Form
                */
                $mh->setSubject(t('%s Form Submission', $this->surveyName));

                //echo $mh->body.'<br>';
                @$mh->sendMail();
            }

            if (!$this->noSubmitFormRedirect) {
                $targetPage = null;
                if ($this->redirectCID == HOME_CID) {
                    $targetPage = Page::getByID(HOME_CID);
                } elseif ($this->redirectCID > 0) {
                    $pg = Page::getByID($this->redirectCID);
                    if (is_object($pg) && $pg->cID) {
                        $targetPage = $pg;
                    }
                }
                if (is_object($targetPage)) {
                    $response = Redirect::page($targetPage);
                } else {
                    $response = Redirect::page(Page::getCurrentPage());
                    $url = $response->getTargetUrl() . "?surveySuccess=1&qsid=".$this->questionSetId."#formblock".$this->bID;
                    $response->setTargetUrl($url);
                }
                $response->send();
                exit;
            }
        }
    }

    public function delete()
    {
        $db = BlockUtils::getThisApp()->make('database')->connection();

        $deleteData['questionsIDs'] = array();
        $deleteData['strandedAnswerSetIDs'] = array();

        $miniSurvey = new MiniSurvey();
        $info = $miniSurvey->getMiniSurveyBlockInfo($this->bID);

        //get all answer sets
        $q = "SELECT asID FROM {$this->btFormAnswerSetTablename} WHERE questionSetId = ".intval($info['questionSetId']);
        $db->executeQuery($q);

        //delete the questions
        $deleteData['questionsIDs'] = $db->fetchAll("SELECT qID FROM {$this->btFormQuestionsTablename} WHERE questionSetId = ".intval($info['questionSetId']).' AND bID='.intval($this->bID));
        foreach ($deleteData['questionsIDs'] as $questionData) {
            $db->executeQuery("DELETE FROM {$this->btFormQuestionsTablename} WHERE qID=".intval($questionData['qID']));
        }

        //delete left over answers
        $strandedAnswerIDs = $db->fetchAll('SELECT fa.aID FROM `btFormAnswers` AS fa LEFT JOIN btFormQuestions AS fq ON fq.msqID=fa.msqID WHERE fq.msqID IS NULL');
        foreach ($strandedAnswerIDs as $strandedAnswer) {
            $db->executeQuery('DELETE FROM `btFormAnswers` WHERE aID='.intval($strandedAnswer['aID']));
        }

        //delete the left over answer sets
        $deleteData['strandedAnswerSetIDs'] = $db->fetchAll('SELECT aset.asID FROM btFormAnswerSet AS aset LEFT JOIN btFormAnswers AS fa ON aset.asID=fa.asID WHERE fa.asID IS NULL');
        foreach ($deleteData['strandedAnswerSetIDs'] as $strandedAnswerSetIDs) {
            $db->executeQuery('DELETE FROM btFormAnswerSet WHERE asID='.intval($strandedAnswerSetIDs['asID']));
        }

        //delete the form block
        $q = "DELETE FROM {$this->btFormTable} WHERE bID = '{$this->bID}'";
        $db->executeQuery($q);

        parent::delete();

        return $deleteData;
    }
 
    public function save($args)
    {

        // Update custom Styles for all pages 
        foreach (array_keys(self::get_btStyles()) as $key) {

            switch ($key) {
            case (lcfirst(substr($key, -3)) == 'fID'):
                if (empty($args[$key])) {
                    $args[$key] = 0;
                }
                break;
            case 'bgColorRGBA':
            case 'fgColorRGB':
                if (empty($args[$key])) {
                    $args[$key] = 'transparent';
                }
                break;
            }
        }

        // Sanitize input for DB
        foreach (array_keys(self::get_btFields()) as $key) {

            // Prevent Default Value from setting
            if (empty($args[$key])) {
                $args[$key] = ' ';
            }
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Make sure questionSetId (qsID) is set
        */
        $args['qsID'] = $args['questionSetId'] = (Request::post('qsID') == true ? Request::post('qsID') : time());

        // Validate form ($btFormTable)
        $this->saveForm($args);

        // Validate details ($btTable)
        parent::save($args);
    }
 
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Handlers Design Methods
    */
    protected static function getViewPointId()
    {
        return self::$btHandlerId;
    }

    protected function getSectionId()
    {
        return 's' . $this->bID;
    }

    protected function getStyleSelector()
    {
        return '#' . $this->getSectionId() . '.' . self::$btHandlerId;
    }

    protected function getJSelectorId()
    {
        return $this->getSectionId() . '.' . self::$btHandlerId;
    }
 
    protected function getSelectorBlock()
    {
        return str_replace('-', '_', self::$btHandlerId);
    }

    protected function getCustomTemplateName()
    {
        $tName = 'no_template';
        $block = $this->getBlockObject();

        if (is_object($block)) {
          $tName = ($block->getBlockFilename() == true ? $block->getBlockFilename() : $tName);
        } 

        return $tName;
    }

    protected function getCustomFgColorClassName()
    {
        return (BlockUtils::isValidColor($this->fgColorRGB) ? 'cfg-color' : null);
    }

    protected function getPackageHandle()
    {
        return 'theme_' . $this->btDefaultSet;
    }

    protected function getBlockHandle()
    {
        return 'l5b_' . $this->getSelectorBlock();
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Methods
    * Background inline Styles Methods
    */
    public function getBgFID()
    {
        if ($this->bgFID > 0) {
            $fObj = BlockUtils::getFileObject($this->bgFID);
        }

        return (isset($fObj) && is_object($fObj)) ? $fObj : null;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Check if Animation is enabled (ideal for JS variables)
    */
    public function getIsAnimationEnabled()
    {        
        return ($this->getIsAnimated() === true && Page::getCurrentPage()->isEditMode() == false) ? true : false;
    }

    public function getIsEditMode()
    {
        return (Page::getCurrentPage()->isEditMode() == false) ? 0 : 1;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom Animation / Transition
    */
    public function getIsAnimated()
    {
        $cName  = 'isAnimated';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = true;

        return filter_var(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}), FILTER_VALIDATE_BOOLEAN);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Background Opacity Over Image
    */
    public function getBgColorOpacity()
    {
        $cName  = 'bgColorOpacity';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = self::$bgOverImageOpacity;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Background Opacity Over Image Options
    */
    public function getBgColorOpacityOptions()
    {
        return array(
            '-75%' => 0.25,
            '-50%' => 0.5,
            '-25%' => 0.75,
            'default' => 1
        );
    }

    protected function getCustomStyleImagePath()
    {
        return BlockUtils::getThisApp()->make('helper/image')->getThumbnail($this->getBgFID(), self::$btStyleUploadThumbWidth, self::$btStyleUploadThumbHeight, false)->src;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Methods
    */
    protected function isCustomOverImageOpacity($value)
    {
        return (($value == true) && ($this->getBgColorOpacity() != 1)) == true ? true : false;
    }

    protected function getOverImageBgColor()
    {
        return $this->bgColorRGBA;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Form Overlay (Edit/Add) Methods
    */
    public function getBlockAssetsURL()
    {
        $bt = BlockType::getByHandle($this->getBlockHandle());
        $bPath = BlockUtils::getThisApp()->make('helper/concrete/urls')->getBlockTypeAssetsURL($bt);

        return $bPath;
    }

    protected function addLocalAssets($path, $type = 'css')
    {
        $this->addHeaderItem(BlockUtils::getThisApp()->make('helper/html')->{$type}($this->getBlockAssetsURL() . $path));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Add Form (Window Overlay) - default Values
    */
    protected function addFormDefaultValues()
    {
        // Retrieve defaults Values
        foreach (array_keys(self::get_btFields()) as $key) {
            if (method_exists($this, 'get' . ucfirst($key))) {
                $o = $this->{'get' . ucfirst($key)}();
                $o = is_array($o) ? $o : trim($o);
                $this->set($key, $o);
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Add Form (Window Overlay) - extra Values
    */
    protected function addFormExtraValues()
    {
        // Retrieve defaults Values
        foreach (array_keys(self::get_btStyles()) as $key) {
            if (method_exists($this, 'get' . ucfirst($key))) {
                $this->set($key, $this->{'get' . ucfirst($key)}());
            }
        }

        // Retrieve extra Values
        foreach (array_keys(self::get_btFormExtraValues()) as $key) {
            if (method_exists($this, 'get' . ucfirst($key))) {
                $this->set($key, $this->{'get' . ucfirst($key)}());
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Add Form (Window Overlay)
    */
    protected function add()
    {

        // Custom Styles Palettes
        $this->set('color', BlockUtils::getThisApp()->make('helper/form/color'));
        $this->set('asset', BlockUtils::getThisApp()->make('helper/concrete/asset_library'));

        $this->set('fgColorPalette', BlockUtils::getFgColorPalette(false, true));
        $this->set('bgColorPalette', BlockUtils::getBgColorPalette(true, true, self::$btStyleOpacity));

        $this->set('btWrapperForm', $this->btWrapperForm);

        // Add Assets Site-Map
        $this->requireAsset('core/sitemap');

        // Page Selector
        $this->set('pageSelector', BlockUtils::getThisApp()->make('helper/form/page_selector'));

        // User Interface
        $this->set('hUI', BlockUtils::getThisApp()->make('helper/concrete/ui'));
        // Urls
        $this->set('hUrl', BlockUtils::getThisApp()->make('helper/concrete/urls'));

        $this->addFormDefaultValues();
        $this->addFormExtraValues();

        // Add Assets to Window Overlay
        $this->addLocalAssets('../../../css/tools/lazy-global-ui.css', 'css');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Edit Form (Window Overlay)
    */
    protected function edit() 
    {
        $this->add();
    }
}
