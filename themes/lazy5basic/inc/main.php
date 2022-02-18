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
| @copyright (c) current year                                               |
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
defined('C5_EXECUTE') or die("Access Denied.");
?>

<?php
  /**
  * Check Areas Blocks
  * if all are unset or empty then return false
  */
  $totBlocks = array();

  // Loop all Areas and Display
  foreach ($theme->getAreasNames() as $value) {

     $a = new Area($value);
     if ($a->getTotalBlocksInArea($c) > 0 ) {

         // Check if block is empty
         $blockContent = Array();
         foreach ($a->getAreaBlocksArray($c) as $block) {

            // Check if is a core block and has content
            if (method_exists($block->getInstance(), 'getContent')) {

                // Check if this core block is an empty string
                $coreBlockContent = $block->getInstance()->getContent();
                  $blockContent[] = ( ! is_array($coreBlockContent) && trim($coreBlockContent === "")) ? false : true;
            } else {
                // we assume it has content
                $blockContent[] = true;
            }
       }
       // return false if block is empty, true otherwise
       $totBlocks[] = in_array(true, $blockContent, true);

     } else {
         // return false as NO block is present
         $totBlocks[] = false;
     }

     // Set Option for Area
     $a->setAreaGridMaximumColumns(12);  

     // Display Area
     $a->display($c);
  }

  // Save totBlocks value in session
  $session->set('totBlocks', $totBlocks)
?>
