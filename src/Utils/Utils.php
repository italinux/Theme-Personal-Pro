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
| @copyright (c) 2021                                                       |
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
namespace Concrete\Package\ThemeLazy5basic\Src\Utils;

use Concrete\Core\Page\Page;
use Concrete\Core\File\File;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\Block\View\BlockView;

class Utils {

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get Facade Application
    */
    public static function getThisApp()
    {

        // retrieve Facade Application
        return Application::getFacadeApplication();
    }

    /**
    * Direct to Values: 1. property local / 2. app/config / 3. method local
    */
    public static function getDefaultValue($key, $value, $name=null)
    {

        if (isset($name)) {

            $o = $name;

        } else {

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * Detect base path config: concrete | app
            */
            $config = (current(explode(".", $key)) == 'concrete' ? null : 'app.') . $key;

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * Retrieve DIRECT value (e.g. app.team.item.1.imageWidth)
            */
            $o = Config::get(trim($config));

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * IF empty AND 'item' (CHILD) THEN Retrieve PARENT value
            */
            if (empty($o)) {

              $full = explode(".", $config);

              // Check IF it's 'item' (CHILD)
              if ($full[2] == 'item') {

                switch ($full[4]) {
                /** - - - - - - - - - - - - - - - - - - - - - - - - -
                * Add entries HERE to AVOID climbing up to PARENT value (e.g. title)
                */
                case 'title':
                    break;
                default:
                  /** - - - - - - - - - - - - - - - - - - - - - - - - -
                  * NOW climb up to PARENT value (e.g. app.team.imageWidth)
                  */
                  array_splice($full, 3, 1);
                  $o = Config::get(trim(implode(".", $full)));
                }
              }
            }

            /** - - - - - - - - - - - - - - - - - - - - - - - - -
            * Swap value if numeric
            */
            if (is_numeric($o) === true) {
              $value = $o;
            }

            /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * Retrieve VALUE
            */
            $o = (is_bool($o) === true) ? ((int) $o) : (((empty($o) === true) || is_numeric($o)) ? $value : ((is_array($o) == true) ? $o :  t($o)));
        }

        return $o;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * BlockView instance
    */
    public static function getInstanceBlockView()
    {

        // retrieve blockView: Object
        return BlockView::getInstance();
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Page Methods
    */
    public static function getPageObject($value)
    {

        // retrieve page: Object
        return Page::getByID($value);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * File Methods
    */
    public static function getFileObject($value)
    {

        // retrieve file: Object
        return File::getByID($value);
    }

    public static function getFileSetObject($value)
    {

        // retrieve file set: Object
        return FileSet::getByID($value);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Image Upload maximum size
    */
    public static function getUploadImageSize($size)
    {

        return (int) ($size * 1024);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Human Readable image size
    */
    public static function getHumanReadUploadImageSize($size)
    {

        return self::getHumanReadableFileSize($size);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Human Readable file size
    */
    public static function getHumanReadableFileSize($size)
    {

        $units = explode(' ','B KB MB GB TB PB');

        for ($i = 0; $size > 1024; $i++) {
             $size /= 1024;
        }

        return round($size, 2) . $units[$i];
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * File Upload maximum size
    */
    public static function getUploadFileSize($size)
    {

        return (int) ($size * 1024);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get Ordinal number from Cardinal number
    */
    public static function getOrdinalNumberShort($value)
    {

        switch (substr($value, -1)) {
        case 1:
            $ord='st';
            break;
        case 2:
            $ord='nd';
            break;
        case 3:
            $ord='rd';
            break;
        default:
            $ord='th';
        }

        return $value.$ord;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Methods
    */
    public static function getCustomStyleSanitised($buffer)
    {

        $search = array(
            '/\}[^\S ]+/s',  /* strip whitespaces after closing tag, except space */
            '/[^\S ]+\{/s',  /* strip whitespaces before opening tag, except space */
            '/(\s)+/s'       /* shorten multiple whitespace sequences */
        );
        $replace = array(
            '}',
            '{',
            '\\1'
        );

        $o = preg_replace($search, $replace, $buffer);

        return $o;
    }

    protected static function getRGBColors($rgba)
    {

        preg_match('/\((.*?)\)/', $rgba, $match);

        if (substr_count($match[1], ',') > 2) {
            $match[1] = substr($match[1], 0, strrpos($match[1], ','));
        }

        return explode(',', $match[1]);
    }

    public static function isValidColor($value)
    {

        return (substr(trim($value), 0, 3) =='rgb' ? true : false);
    }

    public static function isValidImage($value)
    {

        return (is_object($value) ? true : false);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Check if is a valid url
    * @return boolean (true | false)
    */
    public static function getIsValidURL($uri)
    {

        return ((substr($uri, 0, 4) == 'http' && filter_var($uri, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) !== false) ? true : false);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Check if is a valid image size
    * @return boolean (true | false)
    */
    public static function getIsValidImageSize($value, $min, $max)
    {

        return (is_numeric($value) ? (filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max))) ? true : false) : false);
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Config (window overlay)
    * Background Colours Palette
    */
    public static function getBgColorPalette($showAlpha = false, $showPalette = true, $opacity)
    {

        return array(
                'showAlpha' => $showAlpha,
                'showPalette' => $showPalette,
                'palette' => array(
                    // greens
                    array(
                      "rgba(0, 141, 6, $opacity)",
                      "rgba(0,  95, 4, $opacity)",
                      "rgba(0,  58, 3, $opacity)"
                    ),
                    // lightblues
                    array(
                      "rgba(0, 90, 141, $opacity)",
                      "rgba(0, 61,  95, $opacity)",
                      "rgba(0, 37,  58, $opacity)"
                    ),
                    // blues
                    array(
                      "rgba(0, 23, 142, $opacity)",
                      "rgba(0, 15,  95, $opacity)",
                      "rgba(0,  9,  58, $opacity)"
                    ),
                    // purples
                    array(
                      "rgba(61, 0, 142, $opacity)",
                      "rgba(41, 0,  95, $opacity)",
                      "rgba(25, 0,  58, $opacity)"
                    )
              )
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Custom inline Style Config (window overlay)
    * Foreground Colours Palette
    */
    public static function getFgColorPalette($showAlpha = false, $showPalette = true)
    {

        return array(
                'showAlpha' => $showAlpha,
                'showPalette' => $showPalette,
                'palette' => array(
                    // blacks
                    array(
                      "rgb(0, 0, 0)",
                      "rgb(34, 34, 34)",
                      "rgb(85, 85, 85)"
                    ),
                    // greens
                    array(
                      "rgb(0, 141, 6)",
                      "rgb(0,  95, 4)",
                      "rgb(0,  58, 3)"
                    ),
                    // purples
                    array(
                      "rgb(61, 0, 142)",
                      "rgb(41, 0,  95)",
                      "rgb(25, 0,  58)"
                    ),
                    // whites
                    array(
                      "rgb(255, 255, 255)",
                      "rgb(238, 238, 238)",
                      "rgb(204, 204, 204)"
                    )
              )
        );
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * @param array $tabs
    * @param bool $jstabs
    * @param string $callback
    *
    * @return string
    */
    public static function tabs($tabs, $jstabs = true, $callback = 'ccm_activateTabBar')
    {

        $tcn = rand(0, getrandmax());

        $html = '<ul class="nav-tabs nav" id="ccm-tabs-' . $tcn . '">';

        foreach ($tabs as $tab) {

            $dt = $tab[0];
            $href = '#';

            if ($jstabs == false) {
                $dt = '';
                $href = $tab[0];
            }

            $html .= '<li class="' . (($tab[2] === true) ? $tab[4] . ' active' : (($tab[3] === false) ? 'hide' : null)) . '">';
            $html .= '  <a href="' . $href . '" data-tab="' . $dt . '">' . $tab[1] . '</a>';
            $html .= '</li>';
        }

        $html .= '</ul>';

        if ($jstabs) {
            $html .= '<script type="text/javascript">$(function() { ' . $callback . '($(\'#ccm-tabs-' . $tcn . '\'));});</script>';
        }

        return $html;
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Configure Block Type Grid per each Media in View
    *
    *  [ GRID ]
    *
    *     id: Number of items enabled
    *    key: Number of items to show
    *  value: Max number of items per Media per row
    *
    *  LG = Large Screen, MD = Desktop, SM = Tablet, SX = Mobile
    *
    *  [ OFFSET ]
    *
    *  Configure Offsets per Media (NB: depending on value above) if you want to CENTER the last ODD item
    *  e.g. if value above is one figure less than it's main key, add an offset below
    *  first key is items TOTAL COUNT, second key is OFFSET amount per Media
    *
    *
    * - - - - - - - - - - - - - - - - - - - - - - - - - - -
    * Get Layout Grid based on chosen number of columns
    *
    * @param   $key = block type (e.g. what-i-do)
    * @param $value = number of column chosen (e.g. 1, 2, 3, 4)
    * @return array (bootstrap grid & offset)  
    */
    public static function getBtItemsLayout($key, $value)
    {

          $grid = array();
        $offset = array();

        switch ($key) {

       /** - - - - - - - - - - - - - -
        * BLOCK TYPES: VARIOUS
        */
        case 'what-i-do':
        case 'social-media':
 
           /** - - - - - - - - - - - - - - - - - - - - - - - - - - -
            * switch config among numbers of column chosen by user
            */
            switch ($value) {
            case 4:

                $grid = array(4 => array('lgMax' => 4, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                              3 => array('lgMax' => 3, 'mdMax' => 3, 'smMax' => 2, 'sxMax' => 1),
                              2 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1));

              $offset = array(3 => array('smOffset' => 1));

                break;
            case 3:

                $grid = array(4 => array('lgMax' => 3, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                              3 => array('lgMax' => 3, 'mdMax' => 3, 'smMax' => 2, 'sxMax' => 1),
                              2 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1));

              $offset = array(4 => array('lgOffset' => 1),
                              3 => array('smOffset' => 1));
                break;
            case 2:

                $grid = array(4 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                              3 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1),
                              2 => array('lgMax' => 2, 'mdMax' => 2, 'smMax' => 2, 'sxMax' => 1));

              $offset = array(3 => array('lgOffset' => 1,
                                         'mdOffset' => 1,
                                         'smOffset' => 1));
                break;
            case 1:

                $grid = array(4 => array('lgMax' => 1, 'mdMax' => 1, 'smMax' => 1, 'sxMax' => 1),
                              3 => array('lgMax' => 1, 'mdMax' => 1, 'smMax' => 1, 'sxMax' => 1),
                              2 => array('lgMax' => 1, 'mdMax' => 1, 'smMax' => 1, 'sxMax' => 1));
                break;
            }

            break;
        }

        $shared = array(1 => array('lgMax' => 1, 'mdMax' => 1, 'smMax' => 1, 'sxMax' => 1));

        return array('grid' => array_replace_recursive($grid, $shared), 'offset' => $offset);
    }
}
