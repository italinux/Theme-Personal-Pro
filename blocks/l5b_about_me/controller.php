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
namespace Concrete\Package\ThemeLazy5basic\Block\L5bAboutMe;

use Concrete\Package\ThemeLazy5basic\Src\Utils\Utils as BlockUtils;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\File\FileList;
use Concrete\Core\Support\Facade\Url;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

    protected $btTable = "btLazy5basicAboutMe";
    protected static $btHandlerId = "about-me";
    protected $btDefaultSet = 'lazy5basic';

    // Custom Image Thumb Width X Height (pixels)
    protected static $btCustomImageThumbWidth = 500;
    protected static $btCustomImageThumbHeight = 375;

    // Style Background & Foreground Colours
    protected static $btStyleOpacity = '0.82';

    // Style Upload Background Image size in KBytes (1KB = 1024b)
    protected static $btStyleUploadImageSize = 500;

    // Style Background Image size: Width X Height (pixels)
    protected static $btStyleUploadThumbWidth = 1190;
    protected static $btStyleUploadThumbHeight = 650;

    // Style Background Over Image default Opacity
    protected static $bgOverImageOpacity = 1;

    // Window Overlay size: Width X Height (pixels)
    protected $btInterfaceWidth = "1400";
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
          'title' => t('who I am'),
          'content'  => "<p>" . t('This is the %1$sAbout Me%2$s sample section,', '<q>', '</q>') . "<br />".
                        t('here you will write information about yourself or your business.') . "</p>".
                        "<p>" . t('With the inline rich-text editor in %1$sedit mode%2$s', '<a class="info" data-concrete5-link-lightbox="iframe"
                                                                                                            data-concrete5-link-lightbox-height="520"
                                                                                                            data-concrete5-link-lightbox-width="900" target="lightbox" href="' . self::getPopUpVideoURL() . '"><span>', '</span></a> ').
                        t('you can edit this text, add fonts, %1$sstyle italic%2$s,', '<em>', '</em>').
                        " <b>" . t('bold type') . "</b>, " . t('%1$slarger%2$s or %3$ssmaller chars%4$s, images &amp; links', '<big>', '</big>', '<small>', '</small>') . "</p>".
                        "<p>" . t("People will get to know you better if your message is clear and straight forward.") . "</p>".
                        "<p>" . t("To start editing now") . " <a class='goto' href='" . Url::to('/login') . "'><span>" . t('click here') . "</span></a></p>",
           'CTA' => array(
              'linkType' => 'url',
                   'url' => null,
                  'hash' => '#contacts',
                'target' => 'self',
                  'text' => t('contact me'),
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
            'content' => array(
                'label' => t('Content'),
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
            'CTA_pID' => t('CTA %s', t('Select a Page')),
            'o1_sID' => t('1st %s',t('File Set ID')),
            'o1_fID' => t('1st %s',t('Custom image')),
        );

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Block Fields: (WhatYouSee Is WhatYouGet)
    * @description Labels & WYSIWYG Validation
    * @return Array
    */
    protected static function get_btWYSIWYG()
    {
        return array(
            'content' => array(
                'label' => t('Content'),
            ),
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This Block: Add Extra Values to Window Overlay
    */
    protected static function get_btFormExtraValues()
    {
        return array(
            'bgColorOpacityOptions' => array(
                'label' => t('Options adjust background opacity'),
            ),
            'fileSetOptions' => array(
                'label' => t('Options file sets list'),
            ),
            'fileSetHowToURL' => array(
                'label' => t('URL How to add a file set'),
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

        return t('L5b About Me');
    }

    public function getBlockTypeDescription()
    {

        return t('Add L5b About Me to your website');
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

    public function getContent()
    {
        $cName  = 'content';
        $config = self::$btHandlerId . '.' . $cName;
        $dValue = self::getDefaultValue($cName);

        return BlockUtils::getDefaultValue($config, $dValue, $this->{$cName});
    }

    public function get_sID($id)
    {
        return $this->{'o'.$id.'_sID'};
    }

    public function get_fID($id)
    {
        if ($this->{'o'.$id.'_fID'} > 0) {
            $fObj = BlockUtils::getFileObject($this->{'o'.$id.'_fID'});
        }

        return (isset($fObj) && is_object($fObj)) ? $fObj : null;
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

        /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
        * if Link Type (Select a Page / URL)
        */
        switch($value[$key.'_linkType']) {
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

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Window Overlay Methods
    */
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

    public function getFileSetHowToURL()
    {

        return "http://italinux.com/howto/fileset";
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * This block additional Methods
    */
    public static function getPopUpVideoURL()
    {

        return "//player.vimeo.com/video/144310867";
    }

    protected function setFileSetRandomImage($id)
    {
        $files = array();

        $fsObj = BlockUtils::getFileSetObject($this->get_sID($id));

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

        $this->{'o'.$id.'_sID'} = (is_array($files) && count($files) > 0) ? current($files) : false;
    }

    protected function getFileSetRandomImage($id)
    {
        return $this->{'o'.$id.'_sID'};
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
    * @return object
    */
    protected function getThisBlockDefaultImageURL($id, $width = null, $height = null)
    {
        $this->setFileSetRandomImage($id);

        $fID = ($this->get_sID($id) == true ? $this->getFileSetRandomImage($id) : $this->get_fID($id));

        return ($fID == true ? array('path' => $this->getBlockForegroundImageURL($fID, $width, $height), 'default' => false) : array('path' => $this->getBlockDefaultImageURL($id), 'default' => true));
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get if content has lightbox in it
    * @return boolean
    */
    protected function getHasLightbox()
    {
        // The Regular Expression filter lightbox
        $pattern = '/<a(?:\s+(?:
                      target=["\'](?P<target>[^"\'<>]+)["\']
                     |
                      data-concrete5-link-lightbox=["\'](?P<lightbox>[^"\'<>]+)["\']
                     |
                      \w+=["\'][^"\'<>]+["\']))+/ix';

        return preg_match($pattern, $this->getContent()) == true ? true : false;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get CTA class for anchor (scroll | goto)
    * @return string
    */
    protected function getCTA_class()
    {
        // scroll or goto
        switch($this->getCTA_target()) {
        case "self":
            switch($this->getCTA_linkType()) {
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
    * Get CTA link for anchor (html URL)
    * @return string
    */
    protected function getCTA_link()
    {
        // page or url
        switch($this->getCTA_linkType()) {
        case "pID":
            $page = ($this->getCTA_pID() == true) ? BlockUtils::getPageObject($this->getCTA_pID()) : null;
            $o = is_object($page) == true ? BlockUtils::getThisApp()->make('helper/navigation')->getLinkToCollection($page) : null;
            break;
        case "url":
            $o = $this->getCTA_url();
            break;
        }

        return trim($o);
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

        if ($this->getHasLightbox() == true) {
            // load Magnific-popup : Css & JS
            $this->requireAsset('core/lightbox');
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

        // Set main values
        $this->set('popUpVideoURL', self::getPopUpVideoURL());
        $this->set('image', $this->getThisBlockDefaultImageURL(1));

        // polaroid image width / height
        $this->set('imgWidth', self::$btCustomImageThumbWidth);
        $this->set('imgHeight', self::$btCustomImageThumbHeight);

        // Play Animation (but ONLY in EditMode)
        $this->set('playNow', (Page::getCurrentPage()->isEditMode() == true) ? 'play-now' : null);

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
        // Register Assets Animate Configuration
        $al->register('javascript', $this->getJSelectorId() . '.animate-conf', 'blocks/l5b_about_me/jscript/lazy-animate.conf.js', $cf, 'theme_lazy5basic');
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
            case (lcfirst(substr($key, -3)) == 'sID'):
                if (empty($args[$key])) {
                    $args[$key] = 0;
                }
                break;
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
