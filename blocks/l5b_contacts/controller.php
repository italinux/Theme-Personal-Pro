<?php
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
            'telephone' => array(
                'label' => t('Telephone'),
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

    public function getTelephone()
    {
        $cName  = 'telephone';
        $config = self::$btHandlerId . '.' . $cName;
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
        $al->register('javascript', 'jst.contacts-main', 'blocks/l5b_contacts/jscript/contacts-main.js', $pf, 'theme_lazy5basic');

        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/l5b_contacts/jscript/lazy-animate.conf.js', $cf, 'theme_lazy5basic');
        $al->register('javascript-inline', $this->getJSelectorId() . '.animate-init',  '$("section#' . $this->getSectionId()  . '").lazyAnimateInit();', $cf, 'theme_lazy5basic');

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
