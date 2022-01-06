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
| @copyright (c) 2022                                                       |
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
namespace Concrete\Package\ThemeLazy5basic\Theme\Lazy5basic;

use Concrete\Package\ThemeLazy5basic\Controller as cPackage;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme
{
    
    protected $pThemeGridFrameworkHandle = 'bootstrap3';


    public function getThemeDefaultBlockTemplates()
    {

        return array(
            'l5b_menu' => 'sticky',
            'l5b_banner' => 'clean_style',
            'l5b_what_i_do' => 'items_style_clean',
            'l5b_about_me' => 'image_clean_left',
            'l5b_contacts' => 'flatty_yellow_light',
            'l5b_social_media' => '',
            'l5b_footer' => 'show_credits',
        );
    }

    public function registerAssets() 
    {

        /** * * * * * * * * * * * * * * * * * * * * * * * * * *
        * Avoid Conflicts
        * JS + CSS to Avoid
        */
        // do NOT load: Bootstrap
        $this->providesAsset('css', 'bootstrap/*');

        // do NOT load: LightBox
        $this->providesAsset('css', 'core/frontend/*');

        // do NOT load: Font-Awesome
        // $this->providesAsset('css', 'font-awesome');

        /** * * * * * * * * * * * * * * * * * * * * * * * * * *
        * Required
        * JS + CSS Required
        */ 
        // JS JQuery v1.11.3
        $this->requireAsset('javascript', 'jquery');

        // Import Theme Assets CSS & JS
        $this->requireAsset('jst.theme.assets');

        // Import Masonry
        $this->requireAsset('jst.masonry.assets');

        // Import Animations Assets CSS & JS
        $this->requireAsset('jst.animate.assets');
    }

    public function getThemeDisplayName($format = 'html')
    {
        return cPackage::create()->getPackageName($format);
    }

    public function getThemeDescription()
    {
       return t('A perfectly crafted theme that uses all the power of %s', 'concrete5');
    }

    public function getThemePrefix()
    {
        return cPackage::create()->getPackagePrefix();
    }

    public function getVersion() 
    {
        return 'v' . cPackage::create()->getPackageVersion();
    }

    public function getAreasNames()
    {
        return cPackage::create()->getAreasNames();
    }

    public function getPackagePath()
    {
        return cPackage::create()->getRelativePath();
    }

    public function getThemeAreaClasses()
    {

        $areaClasses = array();

        $blockClasses = $this->getThemeBlockClasses();

        foreach ($this->getAreasNames() as $value) {
           $areaClasses[$value] = $blockClasses['*'];
        }

        return $areaClasses;
    }

    public function getThemeBlockClasses()
    {

        $blockClasses = array(
            'page-block',
            'no-spaces',
            'no-space-top',
            'no-space-bottom',
            'single-space-top',
            'single-space-bottom',
            'double-space-top',
            'double-space-bottom',
            'no-sides-spaces',
            'strict',
            'fix-spaces-buttons',
        );

        $bannerClasses = array(
            'video-fixed',
            'hidden-on-mobile',
        );

        return array('*' => $blockClasses,
                     'l5b_banner' => $bannerClasses,
                     'lazy_banner' => $bannerClasses);
    }

    public function getThemeResponsiveImageMap() 
    {

        return array(
            'large' => '900px',
            'medium' => '768px',
            'small' => '0'
        );
    }
}
