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
| @copyright (c) 2023                                                       |
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
namespace Concrete\Package\ThemeLazy5basic;

use Concrete\Core\Application\Application as app;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Package\Package;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Block\BlockType\Set as BlockTypeSet;
use Concrete\Core\Support\Facade\Config;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{

    protected $pkgHandle = 'theme_lazy5basic';
    protected $pkgVersion = '2.6';
    protected $pkgPrefix = 'l5b';
    protected $pkgAlias = 'Personal Pro';

    protected $pkgAllowsFullContentSwap = true;

    protected $appVersionRequired = '9.0';

    protected $pkg;

    public static $_jsPath = 'js'; // base folder: js path
    public static $_cssPath = 'css'; // base folder: css path


    protected $presetBlocks = array(
        'banner',
        'main',
        'menu',
        'what_i_do',
        'about_me',
        'contacts',
        'social_media',
        'footer'
    );

    protected $pkgAutoloaderRegistries = [
        'src/Utils' => '\Concrete\Package\ThemeLazy5basic\Src\Utils',
    ];

    public static function create()
    {
        return new self(new app);
    }

    public function getPackageName()
    {
        return t('Theme Lazy5basic (a.k.a. Personal Pro)');
    }

    public function getPackageDescription()
    {
        return t('%1$s is responsive and multipurpose theme for your website.', $this->pkgAlias);
    }

    public static function getPackageNameID()
    {
        return 'Lazy5basic';
    }

    public function getPackageBlockTypeSetID()
    {
        return strtolower(self::getPackageNameID());
    }

    public function getPackageBlockTypeSetName()
    {
        return self::getPackageNameID();
    }

    public function getPackagePrefix()
    {
        return $this->pkgPrefix;
    }

    public function getPackageVersion()
    {
        return $this->pkgVersion;
    }

    public function getPackageDetails()
    {
        return t('%1$s %2$s', $this->pkgAlias, $this->getPackageVersion());
    }

    /** * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Assets paths
    */
    public static function _getThemePath() 
    {
        return 'themes/' . strtolower(self::getPackageNameID());
    }
    
    private static function _getJsPath() 
    {
        return self::_getThemePath() . '/' . self::$_jsPath;
    }

    private static function _getCssPath()
    {
        return self::_getThemePath() . '/' . self::$_cssPath;
    }

    /** * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Assets register
    */
    public function on_start()
    {

        $al = AssetList::getInstance();

        $ph = array(
            'position' => Asset::ASSET_POSITION_HEADER,
            'minify' => true,
            'combine' => true
        );

        $pf = array(
            'position' => Asset::ASSET_POSITION_FOOTER,
            'minify' => true,
            'combine' => true
        );

        /**
        * Required JS + CSS this Theme
        */
        // JS init
        $al->register('javascript', 'jt.theme.init', self::_getJsPath() . '/init.js', $pf, $this);

        // JS extra
        $al->register('javascript', 'jt.theme.extra', self::_getJsPath() . '/extra.js', $pf, $this);

        // Import Bootstrap
        $al->register('css', 'cst.bootstrap', self::_getCssPath() . '/build/bootstrap/bootstrap.min.css', $ph, $this);

        // CSS font-awesome
        $al->register('css', 'cst.font-awesome', self::_getCssPath() . '/font-awesome/min/font-awesome.min.css', $ph, $this);

        $al->registerGroup(
            'jst.theme.assets', array(
               array(
                   'javascript',
                   'jt.theme.init'
               ),
               array(
                   'javascript',
                   'jt.theme.extra'
               ),
               array(
                   'css',
                   'cst.bootstrap'
               ),
               array(
                   'css',
                   'cst.font-awesome'
               ),
            )
        );

        /**
        * Configuration these Blocks Views Assets (view.js|view.css)
        */
        $theseAssets = array(
            array(
                'type' => 'css',
            'rel-path' => 'style/view.css',
            'position' => $ph,
            ),
            array(
                'type' => 'javascript',
            'rel-path' => 'jscript/view.js',
            'position' => $pf,
            ),
        );

        /**
        * Register these Blocks Views Assets (view.js|view.css)
        */
        foreach (array_keys($this->getBlocksAvailable()) as $key) {

            $thisAssetGroup = array();

            $thisAssetName = str_replace("_", "-", $key) . '-view';

            // Loop these Blocks
            foreach ($theseAssets as $value) {

                $thisAssetFullName = $thisAssetName . '.' . $value['type'];

                $thisAssetFullPath = 'blocks/' . $this->pkgPrefix . '_' . $key . '/' . $value['rel-path'];

                // Detect if asset (js|css) is present
                if (is_file(__DIR__ . '/' . $thisAssetFullPath)) {

                    // register single asset
                    $al->register($value['type'], $thisAssetFullName, $thisAssetFullPath, $value['position'], $this);

                    // push it into group assets
                    array_push($thisAssetGroup, array($value['type'], $thisAssetFullName));
                }
            }

            // register group assets
            $al->registerGroup(
                'jst.block.' . $thisAssetName . '.assets', $thisAssetGroup
            );
        };

        /**
        * Register Assets: Masonry
        */
        $al->register('javascript', 'masonry-lib', self::_getJsPath() . '/min/jquery.masonry.min.js', $pf, $this);

        $al->registerGroup(
            'jst.masonry.assets', array(
               array(
                   'javascript',
                   'masonry-lib'
               ),
            )
        );

        /**
        * Required JS + CSS Animate for this Theme
        */
        $al->register('javascript', 'jt.jquery.migrate', self::_getJsPath() . '/min/jquery.migrate.min.js', $pf, $this);
        $al->register('javascript', 'jt.jquery.waypoints', self::_getJsPath() . '/min/jquery.waypoints.min.js', $pf, $this);

        // Register Assets Animate
        $al->register('javascript', 'animate-lib', self::_getJsPath() . '/min/jquery.lazy.animate.min.js', $pf, $this);

        $al->register('css', 'style.animate', self::_getCssPath() . '/build/animate/animate.min.css', $ph, $this);
        $al->register('css', 'style.animate.delay', self::_getCssPath() . '/build/animate/animate.delay.min.css', $ph, $this);
        $al->register('css', 'style.animate.duration', self::_getCssPath() . '/build/animate/animate.duration.min.css', $ph, $this);

        $al->registerGroup(
            'jst.animate.assets', array(
               array(
                   'javascript',
                   'jt.jquery.migrate'
               ),
               array(
                   'javascript',
                   'jt.jquery.waypoints'
               ),
               array(
                   'javascript',
                   'animate-lib'
               ),
               array(
                   'css',
                   'style.animate'
               ),
               array(
                   'css',
                   'style.animate.delay'
               ),
               array(
                   'css',
                   'style.animate.duration'
               ),
            )
        );
    }

    /** * * * * * * * * * * * * * * * * * * * * * * * * * *
    * custom Blocks methods Utils
    */
    protected function getBlocksAndTablesNames()
    {

        $blocksAndTables = array();

        foreach (array_keys($this->getBlocksAvailable()) as $key) {
            if (is_dir(__DIR__ . '/blocks/' . $this->pkgPrefix . '_' . $key)) {
                $blocksAndTables[$this->pkgPrefix . '_' . $key] = 'bt' . self::getPackageNameID() . ucfirst(str_replace('_', '', mb_convert_case(mb_strtolower($key, "UTF-8"), MB_CASE_TITLE, "UTF-8")));
            }
        }

        return $blocksAndTables;
    }

    public function getAreasNames()
    {

        $areas = array();

        foreach (array_keys($this->getBlocksAvailable()) as $key) {

            // list areas to display
            $areas[] = ucwords(str_replace('_', ' ', $key));
        }

        return $areas;
    }

    protected function getBlocksAvailable()
    {

        $o = array();

        // custom sort areas (in app config)
        $appConfigBlocks = Config::get('app.config.blocks');

        $blocks = (is_array($appConfigBlocks) == false ? $this->presetBlocks : $appConfigBlocks);

        if (is_array($blocks)) {
            foreach ($blocks as $key => $value) {
                if (is_array($value)) {
                    $o[$key] = $value;
                } else {
                    $o[$value] = array();
                }
            }
        }

        return $o;
    }

    /** * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Configure / Install / Upgrade / Uninstall
    */
    public function install() 
    {

        $this->pkg = parent::install();

        if (BlockTypeSet::getByHandle($this->getPackageBlockTypeSetID()) == false) {
            BlockTypeSet::add($this->getPackageBlockTypeSetID(), $this->getPackageBlockTypeSetName(), $this->pkg);
            Theme::add($this->getPackageBlockTypeSetID(), $this->pkg);
        }

        $this->configureBlocks();
    }
    
    public function upgrade() 
    {

        parent::upgrade();

        $this->pkg = Package::getByHandle($this->pkgHandle);

        $this->configureBlocks();
    }
    
    public function uninstall() 
    {

        parent::uninstall();

        $app = Application::getFacadeApplication();

        $db = $app->make('database')->connection();

        foreach ($this->getBlocksAndTablesNames() as $table) {
            $db->executeQuery('DROP TABLE IF EXISTS ' . $table);
        }
    }
    
    protected function configureBlocks() 
    {

        foreach (array_keys($this->getBlocksAndTablesNames()) as $block) {
            $$block = BlockType::getByHandle($block);
            
            if (!is_object($$block)) {
                BlockType::installBlockType($block, $this->pkg);
            }
        }
    }
}
