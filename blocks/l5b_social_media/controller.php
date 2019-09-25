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
namespace Concrete\Package\ThemeLazy5basic\Block\L5bSocialMedia;

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

    protected $btTable = "btLazy5basicSocialMedia";
    protected static $btHandlerId = "social-media";
    protected $btDefaultSet = 'lazy5basic';

    /* Configure Block Grid per Media in View
     *  key: Number of items
     *  value: Max number of items per Media per row
     *
     *  LG = Large Screen, MD = Desktop, SM = Tablet, SX = Mobile
     */
    protected static $btItemsGrid = array(4 => array('lgMax' => 4, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                                          3 => array('lgMax' => 3, 'mdMax' => 3, 'smMax' => 2, 'sxMax' => 1),
                                          2 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                                          1 => array('lgMax' => 1, 'mdMax' => 1, 'smMax' => 1, 'sxMax' => 1));

    // Configure Offsets per Media (NB: depending on value above) if you want to CENTER the last ODD item
    // e.g. if value above is one figure less than it's main key, add an offset below
    // first key is items TOTAL COUNT, second key is OFFSET amount per Media
    protected static $btItemsCount = array(3 => array('smOffset' => 1));

    // Custom Image Thumb Width X Height (pixels)
    protected static $btCustomImageThumbWidth = 64;
    protected static $btCustomImageThumbHeight = 64;

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.7';

    // Style Upload Background Image size in KBytes (1KB = 1025b)
    protected static $btStyleUploadImageSize = 450;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1680;
    protected static $btStyleUploadThumbHeight = 945;

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 1;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1420";
    protected $btInterfaceHeight = "900";

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

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: All Default Values in Window Overlay
    * @description Prefill Fields with Values
    * @return Mixed (string|boolean|integer)
    */
    protected static function getDefaultValue($id, $key = null)
    {
        $o = array(
          'title' => t('social profiles'),
          'subtitle' => t('follow me ..'),
           1 => array(
             'isEnabled' => true,
                   'url' => 'https://facebook.com/mateus73',
                  'hash' => null,
                  'icon' => 'facebook',
           ),
           2 => array(
             'isEnabled' => true,
                   'url' => null,
                  'hash' => '#contacts-more',
                  'icon' => 'whatsapp',
           ),
           3 => array(
             'isEnabled' => true,
                   'url' => 'https://instagram.com/italinux',
                  'hash' => null,
                  'icon' => 'instagram',
           ),
           4 => array(
             'isEnabled' => true,
                   'url' => 'https://linkedin.com/in/italinux',
                  'hash' => null,
                  'icon' => 'linkedin',
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
        );

        // loop multiple items
        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $o = array_merge($o, array(
                  'o'.$i.'_url' => array(
                      'label' => t($ordNum.' %s', t('Profile URL')),
                      'validCondition' => array('method' => 'isEnabled_ValidUrl',
                                                'params' => array('o'.$i)),
                  ),
                  'o'.$i.'_hash' => array(
                      'label' => t($ordNum.' %s', t('Custom anchor')),
                  ),
                  'o'.$i.'_icon' => array(
                      'label' => t($ordNum.' %s', t('Profile icon')),
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
            'bgColorRGBA' => t('Background Colour'),
            'bgColorOpacity' => t('Adjust Background Opacity'),
            'bgFID' => t('Background Image'),
            'fgColorRGB' => t('Foreground Colour'),
            'isAnimated' => t('Animation / Transition'),
        );

        // loop multiple items
        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $o = array_merge($o, array(
                 'o'.$i.'_isEnabled' => t($ordNum.' %s', t('Profile')),
                 'o'.$i.'_fID' => t($ordNum.' %s', t('Custom image')),
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
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block: Items Total Number
    * @return integer
    */
    protected static function get_btItemsTotal()
    {
       return count(self::$btItemsGrid);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block: Info Methods
    */
    public function getBlockTypeName()
    {

        return t('L5b Social Media');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b Social Media to your website');
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

    public function get_hash($id)
    {
        $key  = 'hash';
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
        if ($value[$key.'_isEnabled'] == true) {

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * URL is Valid?
            */
            if (trim($value[$key.'_url']) == true ) {
                if (BlockUtils::getIsValidURL(trim($value[$key.'_url'])) === false) {
                    $label = t('%s', $btFields[$key.'_url']['label']);
                    $error = true;
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
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Window Overlay Methods
    */
    public function getItemsTotalTabs()
    {
        $o = array();

        for ($i=1; $i<(self::get_btItemsTotal()+1); $i++) {

             $ordNum = BlockUtils::getOrdinalNumberShort($i);

             $value = ($i===1) ? true : false;

             array_push($o, array(
                  'item_'.$i, t($ordNum . ' %s', t('Social Profile')), $value,
             ));
        };

        return $o;
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
            '500px',
            'amazon',
            'android',
            'apple',
            'bitbucket',
            'bitbucket-square',
            'bitcoin',
            'delicious',
            'deviantart',
            'digg',
            'dropbox',
            'facebook',
            'facebook-official',
            'facebook-square',
            'flickr',
            'foursquare',
            'git',
            'git-square',
            'github',
            'github-alt',
            'github-square',
            'gitlab',
            'google',
            'google-plus',
            'google-plus-circle',
            'google-plus-square',
            'instagram',
            'lastfm',
            'lastfm-square',
            'linkedin',
            'linkedin-square',
            'linux',
            'meetup',
            'openid',
            'paypal',
            'pinterest',
            'pinterest-p',
            'pinterest-square',
            'reddit',
            'reddit-alien',
            'reddit-square',
            'snapchat',
            'snapchat-square',
            'skype',
            'slack',
            'soundcloud',
            'spotify',
            'tripadvisor',
            'tumblr',
            'tumblr-square',
            'twitch',
            'twitter',
            'twitter-square',
            'viadeo',
            'viadeo-square',
            'vimeo',
            'vimeo-square',
            'wechat',
            'whatsapp',
            'wikipedia-w',
            'youtube',
            'youtube-play',
            'youtube-square'
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get custom class for anchor (lightbox popup | scroll | goto)
    * @return string
    */
    protected function getClassByID($id)
    {
        return trim($this->get_url($id)) == true ? 'goto' : 'scroll';
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get targhet for anchor (blank | self)
    * @return string
    */
    protected function getTargetByID($id)
    {
        return trim($this->get_url($id)) == true ? 'blank' : 'self';
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
                     'id' => self::getAnimateId($offset, $this->getAll_isEnabled($profiles)),
                  'class' => $this->getClassByID($key),
                   'link' => $this->get_url($key),
                   'hash' => trim($this->get_hash($key)),
                 'target' => '_' . $this->getTargetByID($key),
                    'img' => array(
                       'src' => $this->getBlockForegroundImageURL($this->get_fID($key)),
                    ),
                   'icon' => array(
                       'tag' => $this->get_icon($key),
                   ),
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

        // Calculate the number of columns requited in the View Layout per number of items chosen
        ${$key . 'Max'} = is_int(self::$btItemsGrid[$items][$key . 'Max']) ? (12 / self::$btItemsGrid[$items][$key . 'Max']) : null;

        // Calculate Offset if required
        ${$key . 'Offset'} = (isset(self::$btItemsCount[$offset][$key . 'Offset']) && ($items == $offset)) ? ($items * self::$btItemsCount[$offset][$key . 'Offset']) : 0;

        // set the value into an array
        $data = ${$key . 'Max'} == true ? array(${$key . 'Max'}, 'offset' => ${$key . 'Offset'}) : array();


        return $data;
    }

    public static function getAnimateId($key, $value)
    {

        switch(count($value)) {
           case 1:
             $o ='center';
           break;
           case 2:
             $o = ($key == 1 ? 'left' : 'right');
           break;
           case 3:
             switch($key) {
                case 1:
                  $o = 'left';
                break;
                case 2:
                  $o = 'center';
                break;
                case 3:
                  $o = 'right';
             }
           break;
           case 4:
             switch($key) {
                case 1:
                  $o = 'left';
                break;
                case 2:
                  $o = 'center-left';
                break;
                case 3:
                  $o = 'center-right';
                break;
                case 4:
                  $o = 'right';
             }
         }

        return $o;
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

        // Sanitize & set some of the main values
        $this->set('allData', $this->getAll_data(range(1, self::get_btItemsTotal())));

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
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/l5b_social_media/jscript/lazy-animate.conf.js', $cf, 'theme_lazy5basic');
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
                if (empty($args[$key])) {
                    $args[$key] = 0;
                }
                break;
            case (lcfirst(substr($key, -3)) == 'pID'):
                if (empty($args[$key])) {
                    $args[$key] = 0;
                }
                break;
            case 'bgColorRGBA':
                if (empty($args[$key])) {
                    $args[$key] = 'transparent';
                }
                break;
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
        return (is_object($fID) ? BlockUtils::getThisApp()->make('helper/image')->getThumbnail($fID, $width, $height, true)->src : null);
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
        return ($value == true && (self::$bgOverImageOpacity != $this->getBgColorOpacity())) === true ? true : false;
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
        $this->addLocalAssets('../../../themes/lazy5basic/css/tools/lazy-global-ui.css', 'css');
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Edit Form (Window Overlay)
    */
    protected function edit() 
    {
        $this->add();
    }
}
