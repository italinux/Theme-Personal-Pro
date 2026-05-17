<?php 
/**
.-----------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   https://matteo-montanari.com
'-----------------------------------------------------------------------'
.-----------------------------------------------------------------------------.
| @copyright (c) current year                                               |
| --------------------------------------------------------------------------- |
| @license: ConcreteCMS.com Marketplace Commercial Add-Ons & Themes License   |
|           https://concretecms.com/about/legal/commercial-extension-license  |
|           or just: file://theme_lazy5basic/LICENSE.TXT                    |
|                                                                             |
| This program is distributed in the hope that it will be useful - WITHOUT    |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or       |
| FITNESS FOR A PARTICULAR PURPOSE.                                           |
'-----------------------------------------------------------------------------'
*/
defined('C5_EXECUTE') or die("Access Denied.");

View::element('footer_required');

if (User::isLoggedIn()) { ?><div style="height: 70px"></div><?php }?>
