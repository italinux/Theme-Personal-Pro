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
namespace Concrete\Package\ThemeLazy5basic\Block\L5bContacts;

use Concrete\Package\ThemeLazy5basic\Src\Utils\Utils as BlockUtils;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

    protected $btTable = "btLazy5basicContacts";
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
    protected $btInterfaceWidth = "1120";
    protected $btInterfaceHeight = "700";

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

    // HOT-FIX: PHPv8 Compatibility = ADD properties all btStyles
    // Set properties: all btStyles
    protected $bgColorRGBA;
    protected $bgColorOpacity;
    protected $bgFID;
    protected $fgColorRGB;
    protected $isAnimated;

    // HOT-FIX: PHPv8 Compatibility = SET Default property Value
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: Set Default Property Value
    * @description Prefill Fields with Values
    * @return Mixed (string|boolean|integer)
    */
    protected function setDefaultValue($cName)
    {
        // Set Default Value for property: null
        if ( ! isset($this->{$cName})) {
            $this->{$cName} = null;
        }

        return $this->{$cName};
    }

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

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getSubtitle()
    {
        $cName  = 'subtitle';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('yeah, go ahead!');

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getTelephoneType()
    {
        $cName  = 'telephoneType';
        $config = self::$btHandlerId . '.telephone.type';
        $dValue = 'telephone';

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getTelephone()
    {
        $cName  = 'telephone';
        $config = self::$btHandlerId . '.telephone.number';
        $dValue = '+0 (1)2 34 56 78';

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getAddress()
    {
        $cName  = 'address';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('%s Example', '10 rue de') . "\n";
        $dValue.= t('%s Paris', '75006') . "\n";
        $dValue.= t('France');

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getOpenHours()
    {
        $cName  = 'openHours';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('Monday %1$s Friday: %2$s', '-', '9am - 6pm') . "\n";
        $dValue.= t('Saturday: %s', '9am - 2pm') . "\n";
        $dValue.= t('Sunday: Closed');

        self::setDefaultValue($cName);
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFbPageUrl()
    {
        $cName  = 'fbPageUrl';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = null;

        self::setDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getEmail()
    {
        $cName  = 'email';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('%1$s@email.%2$s', t('your'), t('here'));

        self::setDefaultValue($cName);

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

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block RegisterViewAssets
    */
    public function registerViewAssets($outputContent = '')
    {

        // Import this Block view Assets (css|js)
        $this->requireAsset('jst.block.' . $this->getBlockAssetsHandle() . '-view.assets');

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * load assets if animation required:
        */
        // Import JQuery UI
        // $this->requireAsset('javascript', 'jquery/ui');
        // $this->requireAsset('css', 'jquery/ui');

        if ($this->getIsAnimated() === true && Page::getCurrentPage()->isEditMode() == false ) {
            // Import Animations CSS & JS Configuration
            $this->requireAsset('jst.animate.' . $this->getBlockAssetsId() . '.conf');
        }

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
    }

    public function on_start()
    {
        $al = AssetList::getInstance();

        $cf = array(
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false
        );

        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/' . $this->getBlockHandle() . '/jscript/lazy-animate.conf.js', $cf, $this->getPackageHandle());
        $al->register('javascript-inline', $this->getJSelectorId() . '.animate-init',  '$("section#' . $this->getSectionId()  . '").lazyAnimate(' . $this->getSelectorBlock() . ');', $cf, $this->getPackageHandle());

        $al->registerGroup(
            'jst.animate.' . $this->getBlockAssetsId() . '.conf', array(
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
                    // HOT-FIX: PHPv8 Compatibility REMOVE = null;
                    $args[$key] = '';
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

    protected function getBlockAssetsId()
    {
        return $this->getJSelectorId();
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

    protected function getBlockAssetsHandle()
    {
        return self::$btHandlerId;
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

        // HOT-FIX: PHPv8 Compatibility = ADD set bgColorRGBA & fgColorRGB
        $this->set('bgColorRGBA', $this->bgColorRGBA);
        $this->set('fgColorRGB', $this->fgColorRGB);

        // Add Assets to Window Overlay
        $this->addLocalAssets('../../../css/tools/bootstrap-grid.min.css', 'css');
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
