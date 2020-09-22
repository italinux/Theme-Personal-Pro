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
namespace Concrete\Package\ThemeLazy5basic\Block\L5bBanner;

use Concrete\Package\ThemeLazy5basic\Src\Utils\Utils as BlockUtils;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Page\Page;
use Concrete\Core\User\User;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\File\FileList;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

    protected $btTable = "btLazy5basicBanner";
    protected static $btHandlerId = "banner";
    protected $btDefaultSet = 'lazy5basic';

    // Custom Image Thumb Width X Height (pixels)
    protected static $btCustomImageThumbWidth = 520;
    protected static $btCustomImageThumbHeight = 520;

    // Custom Image Thumb Size (pixels) Min & Max
    protected static $btCustomImageThumbSizeMin = 200;
    protected static $btCustomImageThumbSizeMax = 1000;

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.4';

    // Style Upload Background Image size in KBytes (1KB = 1024b)
    protected static $btStyleUploadImageSize = 1540;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1680;
    protected static $btStyleUploadThumbHeight = 945;

    // Set default Active Template Tab in Window Overlay
    protected static $btDefaultTemplatePrefix = 'no_template';

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 1;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1350";
    protected $btInterfaceHeight = "900";

    protected $btWrapperClass = 'ccm-ui';
    protected $btWrapperForm = 'lazy-ui mini-wysiwyg';

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
            'bgSID' =>  t('Background File Set ID'),
            'fgColorRGB' => t('Foreground Colour'),
            'isAnimated' => t('Animation / Transition'),
            'fs_CTA_pID' =>  t('Select a Page'),
            'fs_isVideoEnabled' =>  t('Video On / Off'),
            'cs_CTA_pID' =>  t('Select a Page'),
            'cs_isVideoEnabled' =>  t('Video On / Off'),
            'iam_wid_CTA_pID' =>  t('Select a Page'),
            'iam_wid_isVideoEnabled' =>  t('Video On / Off'),
            'img_sd_CTA_pID' =>  t('Select a Page'),
            'img_sd_isVideoEnabled' =>  t('Video On / Off'),
            'img_sd_fID' =>  t('Custom Foreground image'),
            'img_sd_sID' =>  t('File Set ID'),
        );
    }

    protected static function get_btFields()
    {
        return array(
            'fs_content' => array(
                'label' =>  t('Content'),
                'allowEmpty' => false,
            ),
            'fs_videoURL' => array(
                'label' =>  t('YouTube Video Url'),
                'validCondition' => 'fs_video_isEnabled_ValidUrl',
            ),
            'fs_videoHQ' => array(
                'label' =>  t('Video Quality'),
                'allowEmpty' => false,
            ),
            'fs_CTA_linkType' => array(
                'label' =>  t('Link type'),
                'allowEmpty' => false,
            ),
            'fs_CTA_url' => array(
                'label' =>  t('Action Link'),
                'validCondition' => 'fs_CTA_isEnabled_ValidUrl',
            ),
            'fs_CTA_hash' => array(
                'label' =>  t('Custom anchor'),
            ),
            'fs_CTA_target' => array(
                'label' =>  t('Target of link'),
                'allowEmpty' => false,
            ),
            'fs_CTA_text' => array(
                'label' =>  t('Link name'),
            ),
            'cs_title' => array(
                'label' =>  t('Title'),
                'allowEmpty' => false,
            ),
            'cs_subtitle' => array(
                'label' =>  t('Subtitle'),
            ),
            'cs_videoURL' => array(
                'label' =>  t('YouTube Video Url'),
                'validCondition' => 'cs_video_isEnabled_ValidUrl',
            ),
            'cs_videoHQ' => array(
                'label' =>  t('Video Quality'),
                'allowEmpty' => false,
            ),
            'cs_CTA_linkType' => array(
                'label' =>  t('Link type'),
                'allowEmpty' => false,
            ),
            'cs_CTA_url' => array(
                'label' =>  t('Action Link'),
                'validCondition' => 'cs_CTA_isEnabled_ValidUrl',
            ),
            'cs_CTA_hash' => array(
                'label' =>  t('Custom anchor'),
            ),
            'cs_CTA_target' => array(
                'label' =>  t('Target of link'),
                'allowEmpty' => false,
            ),
            'cs_CTA_text' => array(
                'label' =>  t('Link name'),
            ),
            'iam_wid_iam' => array(
                'label' =>  t('I am'),
            ),
            'iam_wid_title' => array(
                'label' =>  t('Title'),
                'allowEmpty' => false,
            ),
            'iam_wid_ido' => array(
                'label' =>  t('I do'),
            ),
            'iam_wid_subtitle' => array(
                'label' =>  t('Subtitle'),
            ),
            'iam_wid_videoURL' => array(
                'label' =>  t('YouTube Video Url'),
                'validCondition' => 'iam_wid_video_isEnabled_ValidUrl',
            ),
            'iam_wid_videoHQ' => array(
                'label' =>  t('Video Quality'),
                'allowEmpty' => false,
            ),
            'iam_wid_CTA_linkType' => array(
                'label' =>  t('Link type'),
                'allowEmpty' => false,
            ),
            'iam_wid_CTA_url' => array(
                'label' =>  t('Action Link'),
                'validCondition' => 'iam_wid_CTA_isEnabled_ValidUrl',
            ),
            'iam_wid_CTA_hash' => array(
                'label' =>  t('Custom anchor'),
            ),
            'iam_wid_CTA_target' => array(
                'label' =>  t('Target of link'),
                'allowEmpty' => false,
            ),
            'iam_wid_CTA_text' => array(
                'label' =>  t('Link name'),
            ),
            'img_sd_title' => array(
                'label' =>  t('Title'),
                'allowEmpty' => false,
            ),
            'img_sd_subtitle' => array(
                'label' =>  t('Subtitle'),
            ),
            'img_sd_content' => array(
                'label' =>  t('Content'),
                'allowEmpty' => false,
            ),
            'img_sd_imageType' => array(
                'label' => t('Image type'),
                'allowEmpty' => false,
            ),
            'img_sd_imageWidth' => array(
                'label' => t('Image width'),
                'allowEmpty' => false,
                'validCondition' => 'img_sd_isValidSize_imageWidth',
            ),
            'img_sd_imageHeight' => array(
                'label' => t('Image height'),
                'allowEmpty' => false,
                'validCondition' => 'img_sd_isValidSize_imageHeight',
            ),
            'img_sd_videoURL' => array(
                'label' =>  t('YouTube Video Url'),
                'validCondition' => 'img_sd_video_isEnabled_ValidUrl',
            ),
            'img_sd_videoHQ' => array(
                'label' =>  t('Video Quality'),
                'allowEmpty' => false,
            ),
            'img_sd_CTA_linkType' => array(
                'label' =>  t('Link type'),
                'allowEmpty' => false,
            ),
            'img_sd_CTA_url' => array(
                'label' =>  t('Action Link'),
                'validCondition' => 'img_sd_CTA_isEnabled_ValidUrl',
            ),
            'img_sd_CTA_hash' => array(
                'label' =>  t('Custom anchor'),
            ),
            'img_sd_CTA_target' => array(
                'label' =>  t('Target of link'),
                'allowEmpty' => false,
            ),
            'img_sd_CTA_text' => array(
                'label' =>  t('Link name'),
            ),
            'bg_imageType' => array(
                'label' => t('Background Image type'),
                'allowEmpty' => false,
            ),
        );
    }

    protected static function get_btWYSIWYG()
    {
        return array(
            'fs_content' => array(
                'label' => t('Content'),
            ),
            'img_sd_content' => array(
                'label' => t('Content'),
            ),
        );
    }

    protected static function get_btFormExtraValues()
    {
        return array(
            'img_sd_imageObject' => array(
                'label' => t('Custom Foreground image'),
            ),
            'bgImageObject' => array(
                'label' => t('Background Image'),
            ),
            'bgColorOpacityOptions' => array(
                'label' => t('Options adjust background opacity'),
            ),
            'fileSetOptions' => array(
                'label' => t('Options file sets list'),
            ),
            'fileSetHowToURL' => array(
                'label' => t('URL How to add a file set'),
            ),
            'templatesHowToURL' => array(
                'label' => t('URL How to change a template'),
            ),
            'optionsVideoHQ' => array(
                'label' => t('Video Quality options'),
            ),
            'templateDefaultTab' => array(
                'label' => t('Default template tab in Window Overlay'),
            ),
            'templateNames' => array(
                'label' => t('All Template names'),
            ),
            'imageTypes' => array(
                'label' => t('Image types list'),
            ),
            'imageSizeLimit' => array(
                'label' => t('Image size limit'),
            ),
            'imageWidthPlaceholder' => array(
                'label' => t('Image width placeholder'),
            ),
            'imageHeightPlaceholder' => array(
                'label' => t('Image height placeholder'),
            ),
            'linkTypes' => array(
                'label' => t('Link types list'),
            ),
            'linkTargets' => array(
                'label' => t('Link targets list'),
            ),
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block info Methods
    */
    public function getBlockTypeName()
    {

        return t('L5b Banner');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b Banner to your website');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Main Methods
    */
    protected static function getAppConfigFsTemplatePath()
    {
        return 'templates.free_style';
    }

    protected static function getAppConfigCsTemplatePath()
    {
        return 'templates.clean_style';
    }

    protected static function getAppConfigIam_widTemplatePath()
    {
        return 'templates.i_am_what_i_do';
    }

    protected static function getAppConfigImg_sdTemplatePath()
    {
        return 'templates.image_shape_dir';
    }

    public function getFs_content()
    {
        $cName  = 'fs_content';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.content';
        $dValue = "<h1>" . t('this banner') . "</h1>";
        $dValue.= "<h2>" . t('is nice') . "</h2>";

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_videoURL()
    {
        $cName  = 'fs_videoURL';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.URL';
        $dValue = 'http://youtu.be/SWAbthUf68o';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_videoHQ()
    {
        $cName  = 'fs_videoHQ';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.HQ';
        $dValue = 'medium';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_isVideoEnabled()
    {
        $cName  = 'fs_isVideoEnabled';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.isEnabled';
        $dValue = false;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_CTA_url()
    {
        $cName  = 'fs_CTA_url';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.url';
        $dValue = null;

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getFs_CTA_linkType()
    {
        $cName  = 'fs_CTA_linkType';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.linkType';
        $dValue = 'url';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_CTA_pID()
    {
        return $this->fs_CTA_pID;
    }

    public function getFs_CTA_hash()
    {
        $cName  = 'fs_CTA_hash';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.hash';
        $dValue = '#what-i-do-more';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_CTA_target()
    {
        $cName  = 'fs_CTA_target';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.target';
        $dValue = 'self';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getFs_CTA_text()
    {
        $cName  = 'fs_CTA_text';
        $pTempl = self::getAppConfigFsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.text';
        $dValue = t('find out more');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_title()
    {
        $cName  = 'cs_title';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.title';
        $dValue = t('pen name');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_subtitle()
    {
        $cName  = 'cs_subtitle';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.subtitle';
        $dValue = t('writer of novels');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_videoURL()
    {
        $cName  = 'cs_videoURL';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.URL';
        $dValue = 'http://youtu.be/eR1K_TbUkbc';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_videoHQ()
    {
        $cName  = 'cs_videoHQ';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.HQ';
        $dValue = 'medium';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_isVideoEnabled()
    {
        $cName  = 'cs_isVideoEnabled';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.isEnabled';
        $dValue = false;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_CTA_url()
    {
        $cName  = 'cs_CTA_url';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.url';
        $dValue = null;

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getCs_CTA_linkType()
    {
        $cName  = 'cs_CTA_linkType';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.linkType';
        $dValue = 'url';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_CTA_pID()
    {
        return $this->cs_CTA_pID;
    }

    public function getCs_CTA_hash()
    {
        $cName  = 'cs_CTA_hash';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.hash';
        $dValue = '#what-i-do-more';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_CTA_target()
    {
        $cName  = 'cs_CTA_target';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.target';
        $dValue = 'self';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCs_CTA_text()
    {
        $cName  = 'cs_CTA_text';
        $pTempl = self::getAppConfigCsTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.text';
        $dValue = t('check me out');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_iam()
    {
        $cName  = 'iam_wid_iam';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.iam';
        $dValue = t('I am');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_title()
    {
        $cName  = 'iam_wid_title';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.title';
        $dValue = t('cool name');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_ido()
    {
        $cName  = 'iam_wid_ido';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.ido';
        $dValue = t('I do');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }    

    public function getIam_wid_subtitle()
    {
        $cName  = 'iam_wid_subtitle';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.subtitle';
        $dValue = t('songwriting');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_videoURL()
    {
        $cName  = 'iam_wid_videoURL';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.URL';
        $dValue = 'http://youtu.be/eR1K_TbUkbc';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_videoHQ()
    {
        $cName  = 'iam_wid_videoHQ';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.HQ';
        $dValue = 'medium';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_isVideoEnabled()
    {
        $cName  = 'iam_wid_isVideoEnabled';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.isEnabled';
        $dValue = false;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_CTA_url()
    {
        $cName  = 'iam_wid_CTA_url';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.url';
        $dValue = null;

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getIam_wid_CTA_linkType()
    {
        $cName  = 'iam_wid_CTA_linkType';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.linkType';
        $dValue = 'url';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_CTA_pID()
    {
        return $this->iam_wid_CTA_pID;
    }

    public function getIam_wid_CTA_hash()
    {
        $cName  = 'iam_wid_CTA_hash';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.hash';
        $dValue = '#about-me';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_CTA_target()
    {
        $cName  = 'iam_wid_CTA_target';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.target';
        $dValue = 'self';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getIam_wid_CTA_text()
    {
        $cName  = 'iam_wid_CTA_text';
        $pTempl = self::getAppConfigIam_widTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.text';
        $dValue = t('check it out');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_title()
    {
        $cName  = 'img_sd_title';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.title';
        $dValue = t('name');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_subtitle()
    {
        $cName  = 'img_sd_subtitle';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.subtitle';
        $dValue = t('singer');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_content() 
    {
        $cName  = 'img_sd_content';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.content';
        $dValue = "<p>" . t('This is a sample text') . "</p>";
        $dValue.= "<p>" . t('here you will write few information about you') . "</p>";
        $dValue.= "<p>" . t('or the concept of your website') . "</p>";

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_imageType()
    {
        $cName  = 'img_sd_imageType';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.image.type';
        $dValue = 'fID';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_imageWidth()
    {
        $cName  = 'img_sd_imageWidth';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.image.width';
        $dValue = self::$btCustomImageThumbWidth;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_imageHeight()
    {
        $cName  = 'img_sd_imageHeight';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.image.height';
        $dValue = self::$btCustomImageThumbHeight;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_videoURL()
    {
        $cName  = 'img_sd_videoURL';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.URL';
        $dValue = 'http://youtu.be/SWAbthUf68o';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_videoHQ()
    {
        $cName  = 'img_sd_videoHQ';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.HQ';
        $dValue = 'medium';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_isVideoEnabled()
    {
        $cName  = 'img_sd_isVideoEnabled';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.video.isEnabled';
        $dValue = false;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_CTA_url()
    {
        $cName  = 'img_sd_CTA_url';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.url';
        $dValue = 'http://italinux.com/addon-curriculum-vitae';

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getImg_sd_CTA_linkType()
    {
        $cName  = 'img_sd_CTA_linkType';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.linkType';
        $dValue = 'url';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_CTA_pID()
    {
        return $this->img_sd_CTA_pID;
    }

    public function getImg_sd_CTA_hash()
    {
        $cName  = 'img_sd_CTA_hash';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.hash';
        $dValue = null;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_CTA_target()
    {
        $cName  = 'img_sd_CTA_target';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.target';
        $dValue = 'blank';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_CTA_text()
    {
        $cName  = 'img_sd_CTA_text';
        $pTempl = self::getAppConfigImg_sdTemplatePath();
        $config = self::$btHandlerId . '.' . $pTempl . '.CTA.text';
        $dValue = t('see how');

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getImg_sd_sID()
    {

        return $this->img_sd_sID;
    }

    public function getImg_sd_fID()
    {

        return $this->img_sd_fID;
    }

    public function getImg_sd_imageObject()
    {
        if ($this->img_sd_fID > 0) {
            $fObj = BlockUtils::getFileObject($this->img_sd_fID);
        }

        return (isset($fObj) && is_object($fObj)) ? $fObj : null;
    }

    public function getBg_imageType()
    {
        $cName  = 'bg_imageType';
        $config = self::$btHandlerId . '.bgImageType';
        $dValue = 'fID';

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * All Methods for Custom Validations
    */
    public function getImg_sd_isValidSize_imageWidth($value)
    {
        return $this->getIsValidImageSize(array('img_sd', 'imageWidth'), $value);
    }

    public function getImg_sd_isValidSize_imageHeight($value)
    {
        return $this->getIsValidImageSize(array('img_sd', 'imageHeight'), $value);
    }

    public function getIsValidImageSize($param, $value)
    {
        $o = array();

        $error = false;
        $label = false;

        // Get first parameter
        $key = current($param);

        // Get next parameter
        $field = next($param);

        // Retrieve ALL fields (for labels)
        $btFields = self::get_btFields();

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Image Size (width|height) are Valid?
        */
        if (BlockUtils::getIsValidImageSize(trim($value[$key.'_'.$field]), self::$btCustomImageThumbSizeMin, self::$btCustomImageThumbSizeMax) === false) {
            $label = t('%s', $btFields[$key.'_'.$field]['label']);
            $error = true;
        }

        // create error messages
        if ($error !== false) {
            $o['error'] = t('Invalid Image Size');
        }

        // create labels
        if ($label !== false) {
            $o['label'] = $label;
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * YouTube Video URL Valiation
    */
    public function getFs_video_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_Valid_YT_Url('fs', $value);
    }

    public function getCs_video_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_Valid_YT_Url('cs', $value);
    }

    public function getIam_wid_video_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_Valid_YT_Url('iam_wid', $value);
    }

    public function getImg_sd_video_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_Valid_YT_Url('img_sd', $value);
    }

    public function getIsEnabled_Valid_YT_Url($key, $value)
    {
        $o = array();

        $error = false;
        $label = false;

        // Retrieve ALL fields (for labels)
        $btFields = self::get_btFields();

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * if Enabled: YES
        */
        if ($value[$key.'_isVideoEnabled'] == true) {
            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * URL is Valid?
            */
            if (trim($value[$key.'_videoURL']) == true ) {
                if (self::getIsValidYouTubeURL(trim($value[$key.'_videoURL'])) === false) {
                    $label = t('%s', $btFields[$key.'_videoURL']['label']);
                    $error = true;
                }
            }
        }

        // create error messages
        if ($error !== false) {
            $o['error'] = t('Invalid URL');
        }

        // create labels
        if ($label !== false) {
            $o['label'] = $label;
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * CTA (Call To Action) URL Valiation
    */
    public function getFs_CTA_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_ValidUrl('fs', $value);
    }

    public function getCs_CTA_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_ValidUrl('cs', $value);
    }

    public function getIam_wid_CTA_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_ValidUrl('iam_wid', $value);
    }

    public function getImg_sd_CTA_isEnabled_ValidUrl($value)
    {
        return $this->getIsEnabled_ValidUrl('img_sd', $value);
    }

    public function getIsEnabled_ValidUrl($key, $value)
    {
        $o = array();

        $error = false;
        $label = false;

        // Retrieve ALL fields (for labels)
        $btFields = self::get_btFields();

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * if Link Type (Select a Page / URL)
        */
        switch ($value[$key.'_CTA_linkType']) {
        case 'url':
            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * URL is Valid?
            */
            if (trim($value[$key.'_CTA_url']) == true ) {
                if (BlockUtils::getIsValidURL(trim($value[$key.'_CTA_url'])) === false) {
                    $label = t('%s', $btFields[$key.'_CTA_url']['label']);
                    $error = true;
                }
            }
            break;
        }

        // create error messages
        if ($error !== false) {
            $o['error'] = t('Invalid URL');
        }

        // create labels
        if ($label !== false) {
            $o['label'] = $label;
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Window Overlay Methods
    */
    public function getImageTypes()
    {
        return array('fID' => t('Single image'),
                     'sID' => t('Multiple images'),
                    );
    }

    public function getImageSizeLimit()
    {
        return self::$btCustomImageThumbSizeMin;
    }

    public function getImageWidthPlaceholder()
    {
        return self::$btCustomImageThumbWidth;
    }

    public function getImageHeightPlaceholder()
    {
        return self::$btCustomImageThumbHeight;
    }
 
    public function getLinkTypes()
    {
        return array('url' => t('Type a URL'),
                     'pID' => t('Select a Page'),
                    );
    }

    public function getLinkTargets()
    {
        return array( 'self' => t('Same window'),
                     'blank' => t('New window'),
                    );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block additional Methods
    */
    public function getTemplatesHowToURL()
    {

        return "http://italinux.com/howto/templates";
    }

    public function getFileSetHowToURL()
    {

        return "http://italinux.com/howto/fileset";
    }

    protected function getFileSetRandomImage($el)
    {
        $files = array();

        $fsObj = BlockUtils::getFileSetObject($this->{'get' . $el}());

        // Check whether fileset object exists
        if (is_object($fsObj)) {

            $fsFList = new FileList();
 
            $fsFList->filterBySet($fsObj);
            $fsFList->setItemsPerPage(1);
            $fsFList->sortBy('RAND()');

            foreach ($fsFList->get() as $fsFile) {

                // get current file version
                $file = $fsFile->getRecentVersion();

                switch ($file->getMimeType()) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/png':
                    switch ($file->getExtension()) {
                    case 'jpeg':
                    case 'jpg':
                    case 'png':
                         $files[] = $file->getFile();
                         break;
                    }
                    break;
                }
            }
        }

        return ((is_array($files) && count($files) > 0) ? current($files) : false);
    }

    protected function getFileSetOptions()
    {
        $o = array(0 => t('%1$s Select a %2$s %1$s', '*', t('File Set')));

        $sets = FileSet::getMySets();

        if (is_array($sets)) {
            foreach ($sets as $set) {
                $o[$set->getFileSetID()] = $set->getFileSetName();
            }
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Retrieve foreground image URLs
    *
    * @return array
    */
    protected function getThisBlockDefaultImageURL($id, $width = null, $height = null)
    {
        switch ($this->{'get' . $id . '_imageType'}()) {
        case 'sID':

            $fObj = (($this->{'get' . $id . '_sID'}() == true) ? $this->getFileSetRandomImage($id . '_sID') : false);
            break;
        case 'fID':

            $fObj = $this->{'get' . $id . '_fID'}();
            break;
        }

        return (is_object($fObj) ? array('path' => $this->getBlockForegroundImageURL($id, $fObj, $width, $height), 'default' => false) : array('path' => $this->getBlockDefaultImageURL(null), 'default' => true));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get if content has lightbox in it
    * @return boolean
    */
    protected function getHasLightbox($id)
    {
        // The Regular Expression filter lightbox
        $pattern = '/<a(?:\s+(?:
                      target=["\'](?P<target>[^"\'<>]+)["\']
                     |
                      data-concrete5-link-lightbox=["\'](?P<lightbox>[^"\'<>]+)["\']
                     |
                      \w+=["\'][^"\'<>]+["\']))+/ix';

        return (preg_match($pattern, $this->{'get' . ucfirst($id) . '_content'}()) == true ? true : false);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Retrieve Template in use
    * + Set Prefix for Values in the Views
    * @return string
    */
    protected function getThisBlockTemplatePrefix()
    {
        $tName = self::$btDefaultTemplatePrefix;

        $templates = array(
            'no_template' => 'cs',
            'free_style' => 'fs',
            'clean_style' => 'cs',
            'i_am_what_i_do' => 'iam_wid',
            'image_round_right' => 'img_sd',
            'image_square_right' => 'img_sd',
        );

        $block = $this->getBlockObject();

        if (is_object($block)) {
            $tName = ($block->getBlockFilename() == true ? $block->getBlockFilename() : $tName);
        }

        return $templates[$tName];
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Set Current active tab to Window Overlay
    * @return array
    */
    protected function getTemplateDefaultTab()
    {
        $dTabs = array(
            'fs' => false,
            'cs' => false,
            'iam_wid' => false,
            'img_sd' => false,
        );

        // get current template in use
        $tName = $this->getThisBlockTemplatePrefix();

        $dTabs[$tName] = true;

        return $dTabs;
    }

    // get Template Names to Window Overlay
    protected static function getTemplateNames()
    {
        return array(
            'fs' => t('Free Style'),
            'cs' => t('Clean Style'),
            'iam_wid' => t('I am What I do'),
            'img_sd' => t('Image on the Right'),
        );
    }

    // get Template Name for Error Messages
    protected static function getTemplateNameByField($field)
    {
        $tNames = self::getTemplateNames();

        $o = t('Template Warning: %s', t('Missing'));

        foreach ($tNames as $key => $value) {
            if (preg_match('#^'.$key.'_#', $field) === 1) {
                // Found Template which this field belongs
                $o = $value;
            }
        }

        return $o;
    }

    public function getOptionsVideoHQ()
    {
        return array(
            'default' => 'Auto',
            'small'   => 'Low',
            'medium'  => 'Medium',
            'hd720'   => 'High',
            'hd1080'  => 'very High',
        );
    }

    public function getVideoStartFrom() 
    {
        $cName  = 'videoStartFrom';
        $config = self::$btHandlerId . '.videoStart.from';
        $dValue = 1;
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }
    
    public function getVideoStartTo() 
    {
        $cName  = 'videoStartTo';
        $config = self::$btHandlerId . '.videoStart.to';
        $dValue = 3;
        
        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public static function getDisplayVideoStatus()
    {
        return (User::isLoggedIn() == false ? 'hide' : 'show');
    }

    public static function getVideoStatus($value)
    {
        return ($value == true ? array('text' => t('Enabled'), 'class' => 'video-on') : array('text' => t('Disabled'), 'class' => 'video-off'));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Sanitize youtube url
    * get youtube video ID from URL
    *
    * @param string $url - full youtube video url
    * @return string / bool - youtube video id or FALSE if none found. 
    */
    protected static function sanitizeYouTubeURL($url)
    {
        $pattern = 
            '%^             # Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x'
            ;

        $result = preg_match($pattern, $url, $matches);

        if ($result) {

            return 'http://youtu.be/' . $matches[1];
        }

        return false;
    }

    /**
     * Check youtube url, check video exists or not,
     *
     * @param $url   full youtube video url
     * @return bool - true / false
     */
    protected static function getIsValidYouTubeURL($url) 
    {
        $url = self::sanitizeYouTubeURL(urldecode(rawurldecode($url)));

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $headers = get_headers('http://gdata.youtube.com/feeds/api/videos/' . $match[1]);
            
            if (strpos($headers[0], '200')) {

                // return true
                return $match[1];
            }

            // return false;
            return $match[1];
        }
        
        return false;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get custom class for anchor (scroll | null)
    * @return string
    */
    protected function getClassByID($id)
    {
        // scroll or null
        switch ($this->{'get'.$id.'_target'}()) {
        case "self":
            switch ($this->{'get'.$id.'_linkType'}()) {
            case "pID":
                $o = $this->{'get'.$id.'_pID'}() == false ? 'scroll' : null;
                break;
            case "url":
                $o = $this->{'get'.$id.'_url'}() == false ? 'scroll' : null;
                break;
            }
            break;
          case "blank":
              $o = 'goto';
              break;
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get link for anchor (image URL | html URL)
    *
    * @return string
    */
    protected function getLinkByID($id)
    {
        // page or url
        switch ($this->{'get'.$id.'_linkType'}()) {
        case "pID":

            $page = ($this->{'get'.$id.'_pID'}() == true) ? BlockUtils::getPageObject($this->{'get'.$id.'_pID'}()) : null;

            $o = is_object($page) == true ? parse_url(BlockUtils::getThisApp()->make('helper/navigation')->getLinkToCollection($page), PHP_URL_PATH) : null;
            break;
        case "url":

            $o = $this->{'get'.$id.'_url'}();
            break;
        }

        return trim($o);
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
        if ($this->getIsAnimationEnabled() === true) {
            // Import Animations CSS & JS Configuration
            $this->requireAsset('jst.animate.conf');
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Retrieve current template (prefix)
        */
        $cTempl = $this->getThisBlockTemplatePrefix();

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Load lightbox on Demand for current Template
        */
        if (preg_grep('/^'.$cTempl.'/i', array_keys(self::get_btWYSIWYG())) == true) {

            if ($this->getHasLightbox($cTempl) == true) {
                // load Magnific-popup : Css & JS
                $this->requireAsset('core/lightbox');
            }
        }

        // load youtube player if required
        if (Page::getCurrentPage()->isEditMode() == false && $this->{'get' . ucfirst($cTempl) . '_IsVideoEnabled'}() == true) {
            // Import JS this Block
            $this->requireAsset('jst.ytplayer');
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block View/Validate/Save Methods
    */
    public function view()
    {

        if ($this->getIsAnimationEnabled() === true) {
            // class which master animation at its best
            $this->set('nopaque', 'nopaque');
        } else {
            $this->set('nopaque', null);
        }

        // this block this template prefix
        $cTempl = $this->getThisBlockTemplatePrefix();

        // Set style values
        $this->set('sID', $this->getSectionId());
        $this->set('viewPoint', self::getViewPointId());
        $this->set('cTemplate', $this->getCustomTemplateName());
        $this->set('cFgColorClass', $this->getCustomFgColorClassName());

        // Sanitize WYSIWYGs inputs
        foreach (array_keys(self::get_btWYSIWYG()) as $key) {
            $this->set($key, LinkAbstractor::translateFrom($this->{'get' . ucfirst($key)}()));
        }

        // Set main values
        // template prefix (es: cs, iam_wid, img_sd)
        $this->set('cTempl', $cTempl);

        // set foreground image
        $this->set('image', array_merge($this->getThisBlockDefaultImageURL('Img_sd'), array( 'width' => $this->getImg_sd_imageWidth(),
                                                                                            'height' => $this->getImg_sd_imageHeight())));

        // set Video Parameters
        $this->set('videoParams', "containment: 'self',
                                   ration: '16/9',
                                   autoPlay: true,
                                   startAt: 0,
                                   useOnMobile: false,
                                   stopMovieOnBlur: true,
                                   playOnlyIfVisible: true,
                                   realfullscreen: false,
                                   optimizeDisplay: true,
                                   abundance: 0,
                                   mute: true,
                                   loop: true,
                                   showControls: false,
                                   gaTrack: false,
                                   showYTLogo: false,
                                   opacity: 1");

        // display Video Status (class: show, hide)
        $this->set('displayVideoStatus', self::getDisplayVideoStatus());

        // All templates: Video Statuses (text: Enabled, Disabled) (pointer class: on, off)
        $this->set('videoStatus', self::getVideoStatus($this->{'get' . ucfirst($cTempl) . '_IsVideoEnabled'}()));

        // Current Template CTA fields Prefix 
        $cTemplPrefixCTA = ucfirst($cTempl) . '_CTA';

        // Retrieve CTA buttons (current template view)
        $this->set('CTA', array('text' => $this->{'get' . $cTemplPrefixCTA . '_text'}(),
                               'class' => $this->getClassByID($cTemplPrefixCTA),
                                'link' => $this->getLinkByID($cTemplPrefixCTA),
                                'hash' => trim($this->{'get' . $cTemplPrefixCTA . '_hash'}()),
                              'target' => '_' . $this->{'get' . $cTemplPrefixCTA . '_target'}()));

        // Import Custom Css3 inline
        $this->set('cStyle', $this->getCustomStyle());
    }

    public function on_start()
    {
        $al = AssetList::getInstance();

        $ph = Array(
            'position' => Asset::ASSET_POSITION_HEADER,
            'minify' => true,
            'combine' => true
        );

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

        // Register Assets this Block: YTPlayer
        $al->register('javascript-inline', 'ytplayer-conf', 'var videoStartAt = ' . rand(intval($this->getVideoStartFrom()), intval($this->getVideoStartTo())) . ';', $pf, $this->getPackageHandle());
        $al->register('javascript', 'ytplayer-main', 'blocks/' . $this->getBlockHandle() . '/jscript/min/jquery.mb.YTPlayer.min.js', $pf, $this->getPackageHandle());
        $al->register('javascript', 'ytplayer-init', 'blocks/' . $this->getBlockHandle() . '/jscript/YTPlayer.init.js', $pf, $this->getPackageHandle());
        $al->register('css', 'ytplayer-style', 'blocks/' . $this->getBlockHandle() . '/style/ytplayer/jquery.mb.YTPlayer.min.css', $ph, $this->getPackageHandle());

        $al->registerGroup(
            'jst.ytplayer', array(
               array(
                   'javascript-inline',
                   'ytplayer-conf'
               ),
               array(
                   'javascript',
                   'ytplayer-main'
               ),
               array(
                   'javascript',
                   'ytplayer-init'
               ),
               array(
                   'css',
                   'ytplayer-style'
               ),
            )
        );

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
            BlockUtils::isValidColor($this->fgColorRGB) ||
            BlockUtils::isValidImage($this->getCustomStyleImage()) ||
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
                          background-image: -webkit-linear-gradient(top, <?php echo $this->bgColorRGBA?> 20%, rgba(255, 255, 255, 0) 85%) !important;
                          background-image:    -moz-linear-gradient(top, <?php echo $this->bgColorRGBA?> 20%, rgba(255, 255, 255, 0) 85%) !important;
                          background-image:     -ms-linear-gradient(top, <?php echo $this->bgColorRGBA?> 20%, rgba(255, 255, 255, 0) 85%) !important;
                          background-image:      -o-linear-gradient(top, <?php echo $this->bgColorRGBA?> 20%, rgba(255, 255, 255, 0) 85%) !important;
                          background-image:         linear-gradient(to bottom, <?php echo $this->bgColorRGBA?> 20%, rgba(255, 255, 255, 0) 85%) !important;
                    <?php } ?>
                    <?php
                      if ($this->isCustomOverImageOpacity($this->bgColorOpacity)) { ?>
                          opacity: <?php echo $this->bgColorOpacity?> !important;
                    <?php } ?>
                  }
              <?php } ?>

              <?php
                if (BlockUtils::isValidColor($this->bgColorRGBA) ||
                    BlockUtils::isValidColor($this->fgColorRGB) ||
                    BlockUtils::isValidImage($this->getCustomStyleImage())) {
                ?>
                  section<?php echo $this->getStyleSelector()?>.over-image {
                    <?php
                      if (BlockUtils::isValidImage($this->getCustomStyleImage())) { ?>
                          background-image: url('<?php echo $this->getCustomStyleImagePath()?>') !important;
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

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Main Validate
    */
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

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Validate input Fields
        */
        foreach (self::get_btFields() as $key => $value) {

            // Detect if field requires custom condition
            if (isset($value['validCondition'])) {

                // do Validation (basic + custom)
                $this->doValidateMore($e, $args, $key, $value);
            } else {

                // do Validation (basic)
                $this->doValidate($e, $args, $key, $value);
            }
        }

        return $e;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * do Validation
    */
    protected function doValidate($e, $args, $key, $value)
    {
        // Allowed Empty?
        if (isset($value['allowEmpty']) && ($value['allowEmpty'] === false)) {
            if (empty($args[$key])) {
                $e->add(t('Warning in Template %s', t('%1$s%2$s%1$s', '"', self::getTemplateNameByField($key))));
                $e->add(' -> ' . t('Cannot be empty: %s', $value['label']));
                $e->add('&nbsp;');
            }
        }

        // URL is Valid?
        if (!empty($args[$key])) {
            if (isset($value['validateURL']) && ($value['validateURL'] === true)) {
                if (BlockUtils::getIsValidURL($args[$key]) === false) {
                    $e->add(t('Warning in Template %s', t('%1$s%2$s%1$s', '"', self::getTemplateNameByField($key))));
                    $e->add(' -> ' . t('Invalid URL: %s', $value['label']));
                    $e->add('&nbsp;');
                }
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * do more Validation (custom)
    */
    protected function doValidateMore($e, $args, $key, $value)
    {
        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Detect IF custom condition value IS within input value
        */
        if (isset($args[$value['validCondition']])) {

            // Retrieve custom condition as input value
            $validCond = $args[$value['validCondition']];
        } else {

            // Call custom condition method with argument param
            $validCond = (method_exists($this, 'get' . ucfirst($value['validCondition'])) == true ? $this->{'get' . ucfirst($value['validCondition'])}($args) : false);
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Custom condition is Valid:
        *     NOW Detect Errors
        */
        if ($validCond == true) {
            if (is_array($validCond) && array_key_exists('error', $validCond)) {
                $e->add(t('Warning in Template %s', t('%1$s%2$s%1$s', '"', self::getTemplateNameByField($key))));
                $e->add(' -> ' . t($validCond['error'] .': %s', $validCond['label']));
                $e->add('&nbsp;');
            }

            // do Validation (additional)
            $this->doValidate($e, $args, $key, $value);
        }
    }

    public function save($args)
    {

        // Update custom Styles for all pages
        foreach (array_keys(self::get_btStyles()) as $key) {

            switch ($key) {
            case (lcfirst(substr($key, -3)) == 'sID'):
            case (lcfirst(substr($key, -3)) == 'fID'):
            case (lcfirst(substr($key, -3)) == 'pID'):
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

            // Custom Field hash
            switch ($key) {
            case (substr($key, -4) == 'hash'):

                if (trim($args[$key]) == true) {
                    $args[$key] = '#' . str_replace('#', '', trim($args[$key]));
                }
                break;
            }

            // Prevent Default Value from setting
            if (empty($args[$key])) {
                $args[$key] = ' ';
            }
        }

        // WYSIWYGs inputs
        foreach (array_keys(self::get_btWYSIWYG()) as $key) {

            // Strip 'End Of Line' symbol for this platform ("\n" or "\r")
            $args[$key] = trim(str_replace(PHP_EOL, '', $args[$key]));

            // Sanitize URLs
            $args[$key] = LinkAbstractor::translateTo($args[$key]);
        }

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
    * Retrieve foreground image relative path
    *
    * @return string
    */
    protected function getBlockForegroundImageURL($id, $fObj, $w = null, $h = null)
    {
        // set thumbnail width
        $width = ($w == false) ? $this->{'get' . $id . '_imageWidth'}() : $w;

        // set thumbnail height
        $height = ($h == false) ? $this->{'get' . $id . '_imageHeight'}() : $h;

        // get source thumbnail image
        return (is_object($fObj) ? parse_url(BlockUtils::getThisApp()->make('helper/image')->getThumbnail($fObj, $width, $height, true)->src, PHP_URL_PATH) : null);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Template & Block - Default & Background Images URLs
    *
    * @return image URL (for HTML src attribute)
    */
    protected function getBlockDefaultImageURL($idx)
    {
        $image = $this->getDefaultImageFullSrc('default', $idx);

        return $image['url'];
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Template & Block - Paths & URLs 
    *
    * @param true / false
    * @return image base Path and URL (Template / Block)
    */
    protected function getBlockImagesBaseURL($tPath=false)
    {
        return $this->getBlockAssetsURL() . ($tPath !== false ? $this->getBlockTemplateRelativePath() : null) . '/images';
    }

    protected function getBlockImagesBasePath($tPath=false)
    {
        return __DIR__ . ($tPath !== false ? $this->getBlockTemplateRelativePath() : null) . '/images';
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Template - Paths & URLs 
    *
    * @return image base Path and URL for a Template
    */
    protected function getBlockImagesBaseTemplateURL()
    {
        return $this->getBlockImagesBaseURL(true);
    }

    protected function getBlockImagesBaseTemplatePath()
    {
        return $this->getBlockImagesBasePath(true);
    }

    /** Get Template relative Path */
    protected function getBlockTemplateRelativePath()
    {
        return ($this->getCustomTemplateName() == false ? null : '/templates/' . $this->getCustomTemplateName());
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * get Template or Block images Paths & URLs
    * IMPORTANT: it uses inheritance
    * Returns image from Template or Block folders
    *
    * @param default / background
    * @return array (path, url)
    */
    private function getBlockTemplateImageFullPaths($f, $e)
    {
        return array('path' => $this->getBlockImagesBaseTemplatePath() . '/' . $f . '.' . $e,
                      'url' => $this->getBlockImagesBaseTemplateURL() . '/' . $f . '.' . $e);
    }

    private function getBlockImageFullPaths($f, $e)
    {
        return array('path' => $this->getBlockImagesBasePath() . '/' . $f . '.' . $e,
                      'url' => $this->getBlockImagesBaseURL() . '/' . $f . '.' . $e);
    }

    private function getDefaultImageFullSrc($file='default', $idx)
    {
        $image = null;

        // extensions lookup
        $exts = array('png', 'jpg');

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * check if Template Image folder has images
        */
        if (is_dir($this->getBlockImagesBaseTemplatePath())) {
            foreach ($exts as $ext) {

                // fallback image (default.jpg | .png)
                $imgFallBack = $this->getBlockTemplateImageFullPaths($file, $ext);

                // additional images (default2.jpg | default3.jpg | default4.jpg)
                $imgSiblings = $this->getBlockTemplateImageFullPaths($file . $idx, $ext);

                // setup current image
                $thisImage = is_file($imgSiblings['path']) == true ? $imgSiblings : $imgFallBack;

                if (is_file($thisImage['path'])) {
                    $image = array('path' => $thisImage['path'],
                                    'url' => $thisImage['url']);
                }
            }
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * otherwise use images within Block
        */
        if ($image == false) {
            foreach ($exts as $ext) {

                // fallback image (default.jpg | .png)
                $imgFallBack = $this->getBlockImageFullPaths($file, $ext);

                // additional images (default2.jpg | default3.jpg | default4.jpg)
                $imgSiblings = $this->getBlockImageFullPaths($file . $idx, $ext);

                // setup current image
                $thisImage = is_file($imgSiblings['path']) == true ? $imgSiblings : $imgFallBack;

                if (is_file($thisImage['path'])) {
                    $image = array('path' => $thisImage['path'],
                                    'url' => $thisImage['url']);
                }
            }
        }

        return (array) $image;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Methods
    * Background inline Styles Methods
    */
    public function getBgSID()
    {

        return $this->bgSID;
    }

    public function getBgFID()
    {

        return $this->bgFID;
    }

    public function getBgImageObject()
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

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Retrieve custom style background image relative path
    *
    * @return string
    */
    protected function getCustomStyleImagePath()
    {
        // get custom style background image relative path
        return parse_url(BlockUtils::getThisApp()->make('helper/image')->getThumbnail($this->getCustomStyleImage(), self::$btStyleUploadThumbWidth, self::$btStyleUploadThumbHeight, false)->src, PHP_URL_PATH);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Retrieve custom style background image object
    *
    * @return object
    */
    protected function getCustomStyleImage()
    {
        switch ($this->getBg_imageType()) {
        case 'sID':

            $fObj = (($this->getBgSID() == true) ? $this->getFileSetRandomImage('BgSID') : false);
            break;
        case 'fID':

             $fObj = $this->getBgImageObject();
            break;
        }

        return $fObj;
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

        // Retrieve WYSIWYG Editor Values translation
        foreach (array_keys(self::get_btWYSIWYG()) as $key) {
            $this->set($key, LinkAbstractor::translateFrom($this->{'get' . ucfirst($key)}()));
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
        // WYSIWYG Editor
        if (is_array(self::get_btWYSIWYG())) {

            $editor = BlockUtils::getThisApp()->make('editor');

            $editor->setAllowFileManager(true);
            $editor->setAllowSitemap(false);

            // We can include and exclude editor plugins.
            $editor->getPluginManager()->deselect(array('table', 'specialcharacters'));
            $editor->getPluginManager()->select('fontsize');

            $this->set('editor', $editor);
        }

        // Custom Styles Palettes
        $this->set('color', BlockUtils::getThisApp()->make('helper/form/color'));
        $this->set('asset', BlockUtils::getThisApp()->make('helper/concrete/asset_library'));

        $this->set('fgColorPalette', BlockUtils::getFgColorPalette(false, true));
        $this->set('bgColorPalette', BlockUtils::getBgColorPalette(true, true, self::$btStyleOpacity));

        $this->set('btWrapperForm', $this->btWrapperForm);

        // Page Selector
        $this->set('pageSelector', BlockUtils::getThisApp()->make('helper/form/page_selector'));

        // User Interface
        $this->set('hUI', BlockUtils::getThisApp()->make('helper/concrete/ui'));

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
