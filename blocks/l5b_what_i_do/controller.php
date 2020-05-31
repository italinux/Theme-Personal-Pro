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
|           http://concrete5.org/help/legal/commercial_add-on_license       |
|           or just: file://theme_lazy5basic/LICENSE.TXT                    |
|                                                                           |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/
namespace Concrete\Package\ThemeLazy5basic\Block\L5bWhatIDo;

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

    protected $btTable = "btLazy5basicWhatIDo";
    protected static $btHandlerId = "what-i-do";
    protected $btDefaultSet = 'lazy5basic';

    // Total layout number of Columns
    protected static $btLayoutColsTotal = 4;

    // Default layout number of Columns
    protected static $btLayoutColsDefault = 4;

    // Custom Image Thumb Width X Height (pixels)
    protected static $btCustomImageThumbWidth = 96;
    protected static $btCustomImageThumbHeight = 96;

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.5';

    // Style Upload Background Image size in KBytes (1KB = 1025b)
    protected static $btStyleUploadImageSize = 650;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1680;
    protected static $btStyleUploadThumbHeight = 945;

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 1;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1500";
    protected $btInterfaceHeight = "900";

    protected $btWrapperClass = 'ccm-ui';
    protected $btWrapperForm = 'lazy-ui mini-wysiwyg';

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

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: All Default Values in Window Overlay
    * @description Prefill Fields with Values
    * @return Mixed (string|boolean|integer)
    */
    protected static function getDefaultValue($id, $key = null)
    {
        $o = array(
          'title' => t('what I do'),
          'subtitle' => null,
           1 => array(
             'isEnabled' => true,
             'imageType' => 'icon',
              'linkType' => 'url',
                   'url' => null,
                  'hash' => null,
                'target' => 'self',
                 'icon'  => 'pencil',
                 'title' => t('paperbacks'),
               'content' => '<p>Crebritate tunica die et armatis nihil muros <strong>mandato obscuro</strong> Polam prope celeri</p>',
                'button' => t('check it out'),
           ),
           2 => array(
             'isEnabled' => true,
             'imageType' => 'icon',
              'linkType' => 'url',
                   'url' => 'http://librivox.org',
                  'hash' => null,
                'target' => 'blank',
                 'icon'  => 'headphones',
                 'title' => t('audio books'),
               'content' => '<p>Miaci celeri non <strong>non pavceids</strong> si hostes rapacium vastabant nec tamen <strong>ultro</strong> vantur</p>',
                'button' => t('listen to an extract'),
           ),
           3 => array(
             'isEnabled' => true,
             'imageType' => 'icon',
              'linkType' => 'url',
                   'url' => 'http://gutenberg.org',
                  'hash' => null,
                'target' => 'self',
                 'icon'  => 'tablet',
                 'title' => t('e-books'),
               'content' => '<p>Retentabant dubitatur esset Lotophagi domicilium <strong>virtutum humanitatis</strong> ingenuos</p>',
                'button' => t('read an extract'),
           ),
           4 => array(
             'isEnabled' => false,
             'imageType' => 'icon',
              'linkType' => 'url',
                   'url' => null,
                  'hash' => null,
                'target' => 'blank',
                 'icon'  => 'creative-commons',
                 'title' => t('process serving'),
               'content' => '<p>Laeva successorio <strong>Euphratis dextra</strong> cum limes cognomentum regna efficaciae</p>',
                'button' => t('check it out'),
           ),
           'CTA' => array(
              'linkType' => 'url',
                   'url' => null,
                  'hash' => '#about-me',
                'target' => 'self',
                  'text' => t('find out who I am'),
           ),
        );

        return (is_array($o[$id]) ? (array_key_exists($key, $o[$id]) ? $o[$id][$key] : false) : (array_key_exists($id, $o) ? $o[$id] : false));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: (Main)
    * @description Labels & Validation
    * @return Array
    */
    protected static function get_btFields()
    {
        $o = array(
            'title' => array(
                'label' => t('Title'),
            ),
            'subtitle' => array(
                'label' => t('Subtitle'),
            ),
            'CTA_linkType' => array(
                'label' => t('CTA %s', t('Link type')),
                'allowEmpty' => false,
            ),
            'CTA_url' => array(
                'label' => t('CTA %s', t('Global URL')),
                'validCondition' => array('method' => 'isEnabled_ValidUrl',
                                          'params' => array('CTA')),
            ),
            'CTA_hash' => array(
                'label' => t('CTA %s', t('Custom anchor')),
            ),
            'CTA_target' => array(
                'label' => t('CTA %s', t('Target of link')),
                'allowEmpty' => false,
            ),
            'CTA_text' => array(
                'label' => t('CTA %s', t('Text')),
            ),
        );

        // loop multiple items
        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $o = array_merge($o, array(
                  'o'.$i.'_imageType' => array(
                      'label' => t($ordNum.' %s', t('Image type')),
                      'allowEmpty' => false,
                  ),
                  'o'.$i.'_linkType' => array(
                      'label' => t($ordNum.' %s', t('Link type')),
                      'allowEmpty' => false,
                  ),
                  'o'.$i.'_url' => array(
                      'label' => t($ordNum.' %s', t('item What I Do URL')),
                      'validCondition' => array('method' => 'isEnabled_ValidUrl',
                                                'params' => array('o'.$i)),
                  ),
                  'o'.$i.'_hash' => array(
                      'label' => t($ordNum.' %s', t('Custom anchor')),
                  ),
                  'o'.$i.'_target' => array(
                      'label' => t($ordNum.' %s', t('Target of link')),
                      'allowEmpty' => false,
                  ),
                  'o'.$i.'_icon' => array(
                      'label' => t($ordNum.' %s', t('Icon')),
                  ),
                  'o'.$i.'_title' => array(
                      'label' => t($ordNum.' %s', t('Title')),
                  ),
                  'o'.$i.'_content' => array(
                      'label' => t($ordNum.' %s', t('Content')),
                  ),
                  'o'.$i.'_button' => array(
                      'label' => t($ordNum.' %s', t('Button text')),
                  ),
             ));
        };

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: (Styles)
    * @description Labels for additonal Fields
    * @return Array
    */
    protected static function get_btStyles()
    {
        $o = array(
            'layoutColumns' => t('Layout Design'),
            'bgColorRGBA' => t('Background Colour'),
            'bgColorOpacity' => t('Adjust Background Opacity'),
            'bgFID' => t('Background Image'),
            'fgColorRGB' => t('Foreground Colour'),
            'isAnimated' => t('Animation / Transition'),
            'CTA_pID' => t('CTA %s', t('Select a Page')),
        );

        // loop multiple items
        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $o = array_merge($o, array(
                 'o'.$i.'_isEnabled' => t($ordNum.' %s', t('Profile')),
                 'o'.$i.'_isImageStretched' => t($ordNum.' %s', t('Stretch image')),
                 'o'.$i.'_pID' => t($ordNum.' %s', t('Select a Page')),
                 'o'.$i.'_fID' => t($ordNum.' %s', t('Custom image')),
             ));
        };

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: (WhatYouSee Is WhatYouGet)
    * @description Labels & WYSIWYG Validation
    * @return Array
    */
    protected static function get_btWYSIWYG()
    {
        $o = array();

        // loop multiple items
        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $o = array_merge($o, array(
                  'o'.$i.'_content' => t($ordNum.' %s', t('Content')),
             ));
        };

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block: Add Extra Values to Window Overlay
    */
    protected static function get_btFormExtraValues()
    {
        return array(
            'layoutColumnsOptions' => array(
                'label' => t('Options layout design columns'),
            ),
            'itemsIcons' => array(
                'label' => t('Options icons'),
            ),
            'customImageSizeInfo' => array(
                'label' => t('Custom image size info'),
            ),
            'bgColorOpacityOptions' => array(
                'label' => t('Options adjust background opacity'),
            ),
            'itemsTotalTabs' => array(
                'label' => t('Window Overlay Items Tabs'),
            ),
            'imageTypes' => array(
                'label' => t('Image types list'),
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
    * This Block: Items Total Number
    * @return integer
    */
    protected static function get_btItemsTotal()
    {
       $btItemsLayout = BlockUtils::getBtItemsLayout(self::$btHandlerId, self::$btLayoutColsTotal);

       return count($btItemsLayout['grid']);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block: Info Methods
    */
    public function getBlockTypeName()
    {

        return t('L5b What I Do');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b What I Do to your website');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Convert Methods by items to Methods with item as parameter
    * @return Mixed (string|boolean|integer)
    */
    protected function get_btCall($field)
    {
        // create method (eg: getTitle)
        $method = 'get' . ucfirst($field);

        // default output
        $o = false;

        if (method_exists($this, $method)) {

            // call standard method
            $o = $this->{$method}();

        } else {

            if (in_array($method, self::getAll_btMethods_names())) {

                // rebuild method (e.g. "geto1_title()" to "get_title(o1)"
                $rebMethod = $this->rebuildMethod($method);

                // run rebuilt method or get property
                $o = ($rebMethod !== false) ? $this->{$rebMethod['method']}($rebMethod['params']) : $this->{$field};
            }
        }

        return $o;
    }

    protected function getAll_btMethods_names()
    {
        $all = array_merge(self::get_btFields(), self::get_btStyles());

        return array_map(function($k) {return 'get'.ucfirst($k);}, array_keys($all));
    }

    protected function rebuildMethod($method)
    {
        // e.g: get
        $prefix = substr($method, 0, 3);
        // e.g: _title
        $suffix = substr($method, strpos($method, '_'));

        // new method name (e.g: get_title)
        $new_method = $prefix.$suffix;

        // parameter = item id (e.g: 1, 2, 3 ..)
        $params = substr(preg_replace(array('/^'.$prefix.'/', '/'.$suffix.'$/'), '', $method), 1);

        return method_exists($this, $new_method) ? array('method' => $new_method, 'params' => $params) : false;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Main Methods
    */
    public function getTitle()
    {
        $cName  = 'title';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = self::getDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getSubtitle()
    {
        $cName  = 'subtitle';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = self::getDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block CTA Methods
    */
    public function getCTA_url()
    {
        $id = 'CTA';
        $key  = 'url';
        $cName  = $id . '_'. $key;
        $config = self::$btHandlerId . '.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function getCTA_linkType()
    {
        $id = 'CTA';
        $key  = 'linkType';
        $cName  = $id . '_'. $key;

        $config = self::$btHandlerId . '.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCTA_pID()
    {
        return $this->CTA_pID;
    }

    public function getCTA_hash()
    {
        $id = 'CTA';
        $key  = 'hash';
        $cName  = $id . '_'. $key;
        $config = self::$btHandlerId . '.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCTA_target()
    {
        $id = 'CTA';
        $key  = 'target';
        $cName  = $id . '_'. $key;
        $config = self::$btHandlerId . '.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function getCTA_text()
    {
        $id = 'CTA';
        $key  = 'text';
        $cName  = $id . '_'. $key;
        $config = self::$btHandlerId . '.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block Items Methods (Multiple Items)
    */
    public function get_isEnabled($id)
    {
        $key = 'isEnabled';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return filter_var(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}), FILTER_VALIDATE_BOOLEAN);
    }

    public function get_fID($id)
    {
        if ($this->{'o'.$id.'_fID'} > 0) {
            $fObj = BlockUtils::getFileObject($this->{'o'.$id.'_fID'});
        }

        return (isset($fObj) && is_object($fObj)) ? $fObj : null;
    }

    public function get_url($id)
    {
        $key  = 'url';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return trim(BlockUtils::getDefaultValue($config, $dValue, $this->{$cName}));
    }

    public function get_imageType($id)
    {
        $key  = 'imageType';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_linkType($id)
    {
        $key  = 'linkType';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_pID($id)
    {
        return $this->{'o'.$id.'_pID'};
    }

    public function get_hash($id)
    {
        $key  = 'hash';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_target($id)
    {
        $key  = 'target';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_icon($id)
    {
        $key  = 'icon';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_title($id)
    {
        $key  = 'title';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_content($id)
    {
        $key  = 'content';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_button($id)
    {
        $key  = 'button';
        $cName  = 'o'.$id.'_'.$key;
        $config = self::$btHandlerId . '.item.'.$id.'.'.$key;
        $dValue = self::getDefaultValue($id, $key);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * All Methods for Custom Validations
    */
    public function getIsEnabled_ValidUrl($param, $value)
    {
        $o = array();

        $error = false;
        $label = false;

        // Get first parameter
        $key = current($param);

        // Retrieve ALL fields (for labels)
        $btFields = self::get_btFields();

        // proceed only if Enabled (global CTA always is)
        if ($key == 'CTA' || $value[$key.'_isEnabled'] == true) {

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * if Link Type (Select a Page / URL)
            */
            switch ($value[$key.'_linkType']) {
            case 'url':

                /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
                * URL is Valid?
                */
                if (trim($value[$key.'_url']) == true ) {
                    if (BlockUtils::getIsValidURL(trim($value[$key.'_url'])) === false) {
                        $label = t('%s', $btFields[$key.'_url']['label']);
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
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Window Overlay Methods
    */
    public function getItemsTotalTabs()
    {
        $o = array();

        // only child
        $only = (count($this->getAll_isEnabled(range(1, self::get_btItemsTotal()))) == 1) ? 'only' : null;

        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             // active
             $value = ($i===1) ? true : false;

             // show
             $show = $this->get_isEnabled($i);

             array_push($o, array(
                  'item_'.$i, t($ordNum . ' %s', t('item What I Do')), $value, $show, $only,
             ));
        };

        return $o;
    }

    public function getImageTypes()
    {
        return array('icon' => t('Icon ready'),
                      'fID' => t('Single image'),
                    );
    }

    public function getLinkTypes()
    {
        return array('url' => t('Type a URL'),
                     'pID' => t('Select a Page'),
                    );
    }

    public function getLinkTargets()
    {
        return array( 'self' => t('Same Page'),
                     'blank' => t('New Page'),
                    );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Display custom image size info in Window Overlay (e.g: 160x90)
    */
    public function getCustomImageSizeInfo()
    {
            return self::$btCustomImageThumbWidth . 'x' . self::$btCustomImageThumbHeight . 'px';
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * All icons Available
    */
    public function getItemsIcons()
    {

        return array(
            'address-book',
            'address-book-o',
            'address-card',
            'address-card-o',
            'adjust',
            'american-sign-language-interpreting',
            'anchor',
            'archive',
            'area-chart',
            'assistive-listening-systems',
            'asterisk',
            'at',
            'automobile',
            'audio-description',
            'balance-scale',
            'ban',
            'bank',
            'bar-chart',
            'barcode',
            'bars',
            'battery-3',
            'bed',
            'beer',
            'bell',
            'bell-o',
            'bell-slash',
            'bell-slash-o',
            'bicycle',
            'binoculars',
            'birthday-cake',
            'blind',
            'bolt',
            'bomb',
            'book',
            'bookmark',
            'bookmark-o',
            'braille',
            'briefcase',
            'bug',
            'building',
            'building-o',
            'bullhorn',
            'bullseye',
            'bus',
            'cab',
            'calculator',
            'calendar',
            'calendar-o',
            'calendar-check-o',
            'calendar-minus-o',
            'calendar-plus-o',
            'calendar-times-o',
            'camera',
            'camera-retro',
            'car',
            'caret-square-o-down',
            'caret-square-o-left',
            'caret-square-o-right',
            'caret-square-o-up',
            'cart-plus',
            'cc',
            'certificate',
            'check',
            'check-circle',
            'check-circle-o',
            'check-square',
            'check-square-o',
            'child',
            'circle',
            'circle-o',
            'circle-o-notch',
            'circle-thin',
            'clock-o',
            'clone',
            'close',
            'cloud',
            'cloud-download',
            'cloud-upload',
            'code',
            'code-fork',
            'coffee',
            'cog',
            'cogs',
            'comment',
            'comment-o',
            'comments',
            'comments-o',
            'commenting',
            'commenting-o',
            'compass',
            'copyright',
            'credit-card',
            'credit-card-alt',
            'creative-commons',
            'crop',
            'crosshairs',
            'cube',
            'cubes',
            'cutlery',
            'dashboard',
            'database',
            'deaf',
            'desktop',
            'diamond',
            'dot-circle-o',
            'download',
            'drivers-license',
            'drivers-license-o',
            'edit',
            'ellipsis-h',
            'ellipsis-v',
            'envelope',
            'envelope-o',
            'envelope-open',
            'envelope-open-o',
            'envelope-square',
            'eraser',
            'exchange',
            'exclamation',
            'exclamation-circle',
            'exclamation-triangle',
            'external-link',
            'external-link-square',
            'eye',
            'eye-slash',
            'eyedropper',
            'fax',
            'female',
            'fighter-jet',
            'file-archive-o',
            'file-audio-o',
            'file-code-o',
            'file-excel-o',
            'file-image-o',
            'file-movie-o',
            'file-pdf-o',
            'file-photo-o',
            'file-picture-o',
            'file-powerpoint-o',
            'file-sound-o',
            'file-video-o',
            'file-word-o',
            'file-zip-o',
            'film',
            'filter',
            'fire',
            'fire-extinguisher',
            'flag',
            'flag-checkered',
            'flag-o',
            'flash',
            'flask',
            'folder',
            'folder-o',
            'folder-open',
            'folder-open-o',
            'frown-o',
            'futbol-o',
            'gamepad',
            'gavel',
            'gear',
            'gears',
            'genderless',
            'gift',
            'glass',
            'globe',
            'graduation-cap',
            'group',
            'hard-of-hearing',
            'hdd-o',
            'handshake-o',
            'hashtag',
            'headphones',
            'heart',
            'heart-o',
            'heartbeat',
            'history',
            'home',
            'hotel',
            'hourglass',
            'hourglass-1',
            'hourglass-2',
            'hourglass-o',
            'i-cursor',
            'id-badge',
            'id-card',
            'id-card-o',
            'image',
            'inbox',
            'industry',
            'info',
            'info-circle',
            'institution',
            'key',
            'keyboard-o',
            'language',
            'laptop',
            'leaf',
            'legal',
            'lemon-o',
            'level-down',
            'level-up',
            'life-saver',
            'lightbulb-o',
            'line-chart',
            'location-arrow',
            'lock',
            'low-vision',
            'magic',
            'magnet',
            'mail-forward',
            'mail-reply',
            'mail-reply-all',
            'male',
            'map',
            'map-o',
            'map-pin',
            'map-signs',
            'map-marker',
            'meh-o',
            'microchip',
            'microphone',
            'microphone-slash',
            'minus',
            'minus-circle',
            'minus-square',
            'minus-square-o',
            'mobile',
            'money',
            'moon-o',
            'mortar-board',
            'motorcycle',
            'mouse-pointer',
            'music',
            'navicon',
            'newspaper-o',
            'object-group',
            'object-ungroup',
            'paint-brush',
            'paper-plane',
            'paper-plane-o',
            'paw',
            'pencil',
            'pencil-square',
            'pencil-square-o',
            'percent',
            'phone',
            'phone-square',
            'picture-o',
            'pie-chart',
            'plane',
            'plug',
            'plus',
            'plus-circle',
            'plus-square',
            'plus-square-o',
            'podcast',
            'power-off',
            'print',
            'puzzle-piece',
            'qrcode',
            'question',
            'question-circle',
            'question-circle-o',
            'quote-left',
            'quote-right',
            'random',
            'recycle',
            'refresh',
            'registered',
            'remove',
            'reorder',
            'retweet',
            'road',
            'rocket',
            'rss',
            'rss-square',
            's15',
            'search',
            'search-minus',
            'search-plus',
            'send',
            'send-o',
            'server',
            'share-alt',
            'share-alt-square',
            'share-square',
            'share-square-o',
            'shield',
            'ship',
            'shopping-bag',
            'shopping-basket',
            'shopping-cart',
            'shower',
            'sign-in',
            'sign-out',
            'sign-language',
            'signal',
            'sitemap',
            'sliders',
            'smile-o',
            'snowflake-o',
            'soccer-ball-o',
            'sort',
            'sort-alpha-asc',
            'sort-alpha-desc',
            'sort-amount-asc',
            'sort-amount-desc',
            'sort-asc',
            'sort-desc',
            'sort-numeric-asc',
            'sort-numeric-desc',
            'space-shuttle',
            'spinner',
            'spoon',
            'square',
            'square-o',
            'star',
            'star-half',
            'star-half-empty',
            'star-o',
            'sticky-note',
            'sticky-note-o',
            'street-view',
            'suitcase',
            'sun-o',
            'support',
            'tablet',
            'tachometer',
            'tag',
            'tags',
            'tasks',
            'taxi',
            'television',
            'terminal',
            'thermometer-0',
            'thermometer-2',
            'thermometer-4',
            'thumb-tack',
            'thumbs-down',
            'thumbs-o-up',
            'thumbs-up',
            'ticket',
            'times',
            'times-circle',
            'times-circle-o',
            'times-rectangle',
            'times-rectangle-o',
            'tint',
            'toggle-off',
            'toggle-on',
            'trademark',
            'trash',
            'trash-o',
            'tree',
            'trophy',
            'truck',
            'tty',
            'tv',
            'umbrella',
            'universal-access',
            'university',
            'unlock',
            'unlock-alt',
            'unsorted',
            'upload',
            'user',
            'user-circle',
            'user-circle-o',
            'user-o',
            'user-plus',
            'user-secret',
            'user-times',
            'users',
            'video-camera',
            'volume-control-phone',
            'volume-down',
            'volume-off',
            'volume-up',
            'warning',
            'wheelchair',
            'wheelchair-alt',
            'window-close',
            'window-close-o',
            'window-maximize',
            'window-restore',
            'wifi',
            'wrench',
            'facebook'
        );
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

        return preg_match($pattern, $this->get_content($id)) == true ? true : false;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get custom class for anchor (lightbox popup | scroll | goto)
    * @return string
    */
    protected function getClassByID($id)
    {
        // scroll or goto
        switch ($this->get_target($id)) {
        case "self":
            switch ($this->get_linkType($id)) {
            case "pID":
                $o = $this->get_pID($id) == false ? 'scroll' : null;
                break;
            case "url":
                $o = $this->get_url($id) == false ? 'scroll' : null;
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
    * Get CTA class for anchor (scroll | goto)
    * @return string
    */
    protected function getCTA_class()
    {
        // scroll or goto
        switch ($this->getCTA_target()) {
        case "self":
            switch ($this->getCTA_linkType()) {
            case "pID":
                $o = $this->getCTA_pID() == false ? 'scroll' : null;
                break;
            case "url":
                $o = $this->getCTA_url() == false ? 'scroll' : null;
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
    * Get link for anchor (image URL | page or URL)
    * @return string
    */
    protected function getLinkByID($id)
    {
        // page or url
        switch ($this->get_linkType($id)) {
        case "pID":
            $page = ($this->get_pID($id) == true) ? BlockUtils::getPageObject($this->get_pID($id)) : null;
            $o = is_object($page) == true ? parse_url(BlockUtils::getThisApp()->make('helper/navigation')->getLinkToCollection($page), PHP_URL_PATH) : null;
            break;
        case "url":
            $o = $this->get_url($id);
            break;
        }

        return trim($o);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get CTA link for anchor (html URL)
    * @return string
    */
    protected function getCTA_link()
    {
        // page or url
        switch ($this->getCTA_linkType()) {
        case "pID":
            $page = ($this->getCTA_pID() == true) ? BlockUtils::getPageObject($this->getCTA_pID()) : null;
            $o = is_object($page) == true ? parse_url(BlockUtils::getThisApp()->make('helper/navigation')->getLinkToCollection($page), PHP_URL_PATH) : null;
            break;
        case "url":
            $o = $this->getCTA_url();
            break;
        }

        return trim($o);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get All profiles with lightbox WYSIWYG
    */
    public function getAll_hasLightbox($range)
    {
        $o = array();

        foreach (array_keys($this->getAll_isEnabled($range)) as $id) {
            $o[] = $this->getHasLightbox($id);
        }

        return array_diff($o, array(false));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get All enabled Profiles
    */
    public function getAll_isEnabled($range)
    {
        $o = array();

        foreach ($range as $id) {
            $o[$id] = $this->get_isEnabled($id);
        }

        return array_diff($o, array(false));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get All data Profiles to display
    */
    public function getAll_data($profiles)
    {
        $o = array();
        $offset = 0;

        foreach (array_keys($this->getAll_isEnabled($profiles)) as $key) {

        $offset++;

            $o[$key] = array(
                 'col-lg' => $this->getBootstrapCol_LG_Config($offset),
                 'col-md' => $this->getBootstrapCol_MD_Config($offset),
                 'col-sm' => $this->getBootstrapCol_SM_Config($offset),
                 'col-sx' => $this->getBootstrapCol_SX_Config($offset),
                  'class' => $this->getClassByID($key),
                   'link' => $this->getLinkByID($key),
                   'hash' => trim($this->get_hash($key)),
                 'target' => '_' . $this->get_target($key),
                    'img' => array(
                       'src' => $this->getBlockForegroundImageURL($this->get_fID($key)),
                     'width' => self::$btCustomImageThumbWidth,
                    'height' => self::$btCustomImageThumbHeight,
                    ),
                   'icon' => array(
                       'tag' => $this->get_icon($key),
                   ),
                  'title' => $this->get_title($key),
                'content' => $this->get_content($key),
                 'button' => $this->get_button($key),
            );
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block GRID Methods
    */
    public function getBootstrapCol_LG_Config($offset)
    {
        return $this->getBootstrapCol_Config($offset, 'lg');
    }

    public function getBootstrapCol_MD_Config($offset)
    {
        return $this->getBootstrapCol_Config($offset, 'md');
    }

    public function getBootstrapCol_SM_Config($offset)
    {
        return $this->getBootstrapCol_Config($offset, 'sm');
    }

    public function getBootstrapCol_SX_Config($offset)
    {
        return $this->getBootstrapCol_Config($offset, 'sx');
    }

    public function getBootstrapCol_Config($offset, $key)
    {

        $array = $this->getAll_isEnabled(range(1, self::get_btItemsTotal()));

        // Total number of items
        $items = count($array);

        // Get this BlockType Items Layout GRID 
        $btItemsLayout = BlockUtils::getBtItemsLayout(self::$btHandlerId, $this->getLayoutColumns());

        // Calculate the number of columns requited in the View Layout per number of items chosen
        ${$key . 'Max'} = is_int($btItemsLayout['grid'][$items][$key . 'Max']) ? (12 / $btItemsLayout['grid'][$items][$key . 'Max']) : null;

        // Calculate Offset if required
        ${$key . 'Offset'} = (isset($btItemsLayout['offset'][$offset][$key . 'Offset']) && ($items == $offset)) ? ($items * $btItemsLayout['offset'][$offset][$key . 'Offset']) : 0;

        // set the value into an array
        $data = ${$key . 'Max'} == true ? array(${$key . 'Max'}, 'offset' => ${$key . 'Offset'}) : array();

        return $data;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block RegisterViewAssets
    */
    public function registerViewAssets($outputContent = '')
    {

        if ($this->getIsAnimationEnabled() === true) {
            // Import Animations CSS & JS Configuration
            $this->requireAsset('jst.animate.conf');
        }

        if ($this->getAll_hasLightbox(range(1, self::get_btItemsTotal())) == true) {
            // load Magnific-popup : Css & JS
            $this->requireAsset('core/lightbox');
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * do NOT load Masonry assets if NOT required:
        * 1. if templates have hidden info (name ending like below)
        * 2. if only 1 Column Layout
        */
        if ((preg_match('/(^mobile_view)|(hidden_info|hidden|hide)$/', $this->getCustomTemplateName()) == false) && ($this->getLayoutColumns() != 1)) {
            // Import Masonry Configuration
            $this->requireAsset('jst.masonry.init');
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

        // Sanitize WYSIWYGs inputs
        foreach (array_keys(self::get_btWYSIWYG()) as $key) {
            $this->set($key, LinkAbstractor::translateFrom($this->get_btCall($key)));
        }

        // Sanitize & set some of the main values
        $this->set('allData', $this->getAll_data(range(1, self::get_btItemsTotal())));

        // global CTA button
        $this->set('CTA', array('text' => $this->getCTA_text(),
                               'class' => $this->getCTA_class(),
                                'link' => $this->getCTA_link(),
                                'hash' => $this->getCTA_hash(),
                              'target' => '_' . $this->getCTA_target()));

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
        // Register Assets Masonry Configuration
        $al->register('javascript', self::getViewPointId() . '.masonry-init', 'blocks/l5b_what_i_do/jscript/masonry.init.js', $cf, 'theme_lazy5basic');

        $al->registerGroup(
            'jst.masonry.init', array(
               array(
                   'javascript',
                   self::getViewPointId() . '.masonry-init'
               ),
            )
        );

        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/l5b_what_i_do/jscript/lazy-animate.conf.js', $cf, 'theme_lazy5basic');
        $al->register('javascript-inline', $this->getJSelectorId() . '.animate-init',  '$("section#' . $this->getSectionId()  . '").lazyAnimate(' . $this->getJSelectorBlock() . ');', $cf, 'theme_lazy5basic');

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
                $e->add(t('Cannot be empty: %s', $value['label']));
            }
        }

        // URL is Valid?
        if (!empty($args[$key])) {
            if (isset($value['validateURL']) && ($value['validateURL'] === true)) {
                if (BlockUtils::getIsValidURL($args[$key]) === false) {
                    $e->add(t('Invalid URL: %s', $value['label']));
                }
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * do more Validation (custom)
    */
    protected function doValidateMore($e, $args, $key, $value)
    {
        // output validation
        $oValid == false;

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * IF custom condition value IS a METHOD (has PARAMS)
        */
        $validCond = $value['validCondition'];

        if (is_array($validCond)) {

            $method = $validCond['method'];
            $params = $validCond['params'];

            // Call custom condition method with argument param
            $oValid = (method_exists($this, 'get' . ucfirst($method)) == true ? $this->{'get' . ucfirst($method)}($params, $args) : false);
        } else {

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * IF custom condition value IS a PROPERTY
            */
            if (isset($args[$method])) {

                // Retrieve custom condition as input value
                $oValid = $args[$method];
            }
        }

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * Custom condition is Valid:
        *     NOW Detect Errors
        */
        if ($oValid == true) {
            if (is_array($oValid) && array_key_exists('error', $oValid)) {
                $e->add(t($oValid['error'] . ': %s', $oValid['label']));
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
            case (lcfirst(substr($key, -3)) == 'fID'):
            case (lcfirst(substr($key, -3)) == 'pID'):
            case (substr($key, -16) == 'isImageStretched'):
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
 
    protected function getJSelectorBlock()
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

    public static function getBlockHandle()
    {
        return strtolower(basename(dirname(__FILE__)));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block - Foreground Custom Images PATHs
    *
    * @return image full Path (file system)
    */
    protected function getBlockForegroundImageURL($fID, $w = null, $h = null)
    {
        // set thumbnail width
        $width = ($w == false) ? self::$btCustomImageThumbWidth : $w;

        // set thumbnail height
        $height = ($h == false) ? self::$btCustomImageThumbHeight : $h;

        // get source thumbnail image
        return (is_object($fID) ? parse_url(BlockUtils::getThisApp()->make('helper/image')->getThumbnail($fID, $width, $height, true)->src, PHP_URL_PATH) : null);
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
    * Layout Design Columns
    */
    public function getLayoutColumns()
    {
        $cName  = 'layoutColumns';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = self::$btLayoutColsDefault;

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Layout Design Columns Options
    */
    public function getLayoutColumnsOptions()
    {
        $o = array();

        foreach (range(1, self::$btLayoutColsTotal) as $key) {
          $o[$key] = ($key == 1) ? t('%d Column', $key) : t('%d Columns', $key);
        }

        return $o;
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
        $bt = BlockType::getByHandle(self::getBlockHandle());
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
        if (method_exists(__CLASS__, 'get_btFields')) {

            foreach (array_keys(self::get_btFields()) as $key) {
                $o = $this->get_btCall($key);
                $o = is_array($o) ? $o : trim($o);
                $this->set($key, $o);
            }
        }

        // Retrieve WYSIWYG Editor Values translation
        if (method_exists(__CLASS__, 'get_btWYSIWYG')) {
            foreach (array_keys(self::get_btWYSIWYG()) as $key) {
                $this->set($key, LinkAbstractor::translateFrom($this->get_btCall($key)));
            }
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Add Form (Window Overlay) - extra Values
    */
    protected function addFormExtraValues()
    {
        // Retrieve defaults Values
        if (method_exists(__CLASS__, 'get_btStyles')) {
            foreach (array_keys(self::get_btStyles()) as $key) {
                $this->set($key, $this->get_btCall($key));
            }
        }

        // Retrieve extra Values
        if (method_exists(__CLASS__, 'get_btFormExtraValues')) {
            foreach (array_keys(self::get_btFormExtraValues()) as $key) {
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
        $this->set('hUI', new BlockUtils());

        $this->addFormDefaultValues();
        $this->addFormExtraValues();

        // Add Assets to Window Overlay
        $this->addLocalAssets('../../../themes/lazy5basic/css/build/tools/lazy-global-ui.css', 'css');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Edit Form (Window Overlay)
    */
    protected function edit() 
    {
        $this->add();
    }
}
