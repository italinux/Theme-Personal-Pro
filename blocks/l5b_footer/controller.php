<?php
namespace Concrete\Package\ThemeLazy5basic\Block\L5bFooter;

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

    protected $btTable = "btLazy5basicFooter";
    protected static $btHandlerId = "footer";
    protected $btDefaultSet = 'lazy5basic';

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.95';

    // Style Upload Background Image size in KBytes (1KB = 1024b)
    protected static $btStyleUploadImageSize = 450;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1190;
    protected static $btStyleUploadThumbHeight = 650;

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 0.25;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1050";
    protected $btInterfaceHeight = "650";

    protected $btWrapperClass = 'ccm-ui';
    protected $btWrapperForm = 'lazy-ui';
    
    // Support for Inline Editing
    protected $btSupportsInlineEdit = false;
    protected $btSupportsInlineAdd = false;

    // Bootstrap theme Grid Support
    protected $btIgnorePageThemeGridFrameworkContainer = false;

    // Cache block's database calls
    protected $btCacheBlockRecord = true;

    // Cache block's actual view output
    protected $btCacheBlockOutput = false;

    // Serve cached version even if the result of a post request
    protected $btCacheBlockOutputOnPost = true;

    // Server cached version even if user is logged in
    protected $btCacheBlockOutputForRegisteredUsers = true;

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
            'isQuoted' => t('Wrap title with Quotes')
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
            'credits1stMessage' => array(
                'label' => t('1st Credits %s', t('Wording')),
            ),
            'credits1stName' => array(
                'label' => t('1st Credits %s', t('Name')),
            ),
            'credits1stUrl' => array(
                'label' => t('1st Credits %s', t('Link to name')),
            ),
            'credits2ndMessage' => array(
                'label' => t('2nd Credits %s', t('Wording')),
                'encodeEntity' => true,
            ),
            'credits2ndName' => array(
                'label' => t('2nd Credits %s', t('Name')),
            ),
            'credits2ndUrl' => array(
                'label' => t('2nd Credits %s', t('Link to name')),
            ),
        );
    }

    protected static function get_btFormExtraValues()
    {
        return array(
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

        return t('L5b Footer');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b Footer to your website');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Main Methods
    */
    public function getTitle() 
    {
        $cName  = 'title';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('a footer phrase goes here');
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }
    
    public function getSubtitle() 
    {
        $cName  = 'subtitle';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = t('and subtitle here');
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIsQuoted()
    {
        $cName  = 'isQuoted';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = false;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits1stMessage()
    {
        $cName  = 'credits1stMessage';
        $config = self::$btHandlerId . '.credits.1.message';
        $dValue = t('you want to download other add-ons?');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits1stName()
    {
        $cName  = 'credits1stName';
        $config = self::$btHandlerId . '.credits.1.name';
        $dValue = t('click here');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits1stUrl()
    {
        $cName  = 'credits1stUrl';
        $config = self::$btHandlerId . '.credits.1.url';
        $dValue = 'http://italinux.com/addons';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits2ndMessage()
    {
        $cName  = 'credits2ndMessage';
        $config = self::$btHandlerId . '.credits.2.message';
        $dValue = t('developed with %s by', '&hearts;');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits2ndName()
    {
        $cName  = 'credits2ndName';
        $config = self::$btHandlerId . '.credits.2.name';
        $dValue = 'Matteo';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCredits2ndUrl()
    {
        $cName  = 'credits2ndUrl';
        $config = self::$btHandlerId . '.credits.2.url';
        $dValue = 'http://matteo-montanari.com/its-me';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block RegisterViewAssets
    */
    public function registerViewAssets($outputContent = '')
    {

        if ($this->getIsAnimated() === true && Page::getCurrentPage()->isEditMode() == false) {
            // Import Animations CSS & JS Configuration
            $this->requireAsset('jst.animate.conf');
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

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Set main values
        * 1st Credits CTA button
        */
        $this->set('credits1st', array('text' => $this->getCredits1stMessage(),
                                       'name' => $this->getCredits1stName(),
                                      'class' => 'goto',
                                       'link' => $this->getCredits1stUrl(),
                                     'target' => '_blank'));

        // 2nd Credits CTA button
        $this->set('credits2nd', array('text' => $this->getCredits2ndMessage(),
                                       'name' => $this->getCredits2ndName(),
                                      'class' => 'goto',
                                       'link' => $this->getCredits2ndUrl(),
                                     'target' => '_blank'));

        // Import Custom Css3 inline
        $this->set('cStyle', $this->getCustomStyle());
    }

    public function on_start()
    {
        $al = AssetList::getInstance();

        $cf = Array(
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => false,
            'combine' => false
        );

        // Register Assets this Block
        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/l5b_footer/jscript/lazy-animate.conf.js', $cf, 'theme_lazy5basic');
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
