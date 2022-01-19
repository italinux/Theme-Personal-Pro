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

  /* - - - - - - - - - - - - - - - - - - - 
  * SEO Metatags - Default app.php
  */
  $seo = \Config::get('app.config.SEO');
  $sPage = (is_array($seo['page']) == false ? array() : array_map('html_entity_decode', array_map("t", $seo['page'])));
  $domain = trim(strtolower(\Config::get('app.config.domain')));

  /* - - - - - - - - - - - - - - - - - - -
  * SEO Metatags - Dashboard
  */
  // Title
  $sPage['pageTitle'] = ($c->getAttribute('meta_title') == true) ? $c->getAttribute('meta_title') : $sPage['pageTitle'];

  // Description
  $sPage['pageDescription'] = ($c->getAttribute('meta_description') == true) ? $c->getAttribute('meta_description') : $sPage['pageDescription'];

  // Keywords
  $sPage['pageKeywords'] = ($c->getAttribute('meta_keywords') == true) ? $c->getAttribute('meta_keywords') : $sPage['pageKeywords'];

  /* - - - - - - - - - - - - - - - - - - -
  * SEO additionals
  */
  // Add domain to title (if enabled)
  if (isset($sPage['pageTitle']) && ($seo['showDomain'] == true)) {
      $sPage['pageTitle'] = sprintf('%1$s %2$s %3$s', t($sPage['pageTitle']), '-', $domain);
  }

  // Fetch site name
  $siteName = ($seo['siteName'] == true ? $seo['siteName'] : null);

  // Add site name to title (if enabled)
  if (isset($sPage['pageTitle']) && ($siteName == true)) {
      $sPage['pageTitle'] = sprintf('%3$s %2$s %1$s', t($sPage['pageTitle']), '-', $siteName);
  }
?>
<head>
    <meta name="author" content="Matteo Montanari, @italinux.com">
    <meta name="package" content="<?php echo $theme->getThemeDisplayName()?>">
    <meta name="version" content="<?php echo $theme->getVersion()?>">

    <link rel="preload" href="<?php echo $view->getStylesheet('main.less')?>" as="style">

    <link rel="preload" href="<?php echo $theme->getThemePath()?>/images/pre-loader.gif" as="image">

    <?php View::element('header_required', $sPage)?>

    <?php if (User::isLoggedIn()) { echo $html->css($theme->getPackagePath() . '/css/tools/c5-ui.css'); }?>

    <?php echo $html->css($view->getStylesheet('main.less'))?>
<?php
  /* - - - - - - - - - - - - - - - - - - -
  * Theme Colour (Mobile devices Address Bar)
  */
  $theme_color = \Config::get('app.config.theme-color');

  // Theme Colour (Mobile devices Address Bar)
  if (isset($theme_color)) { ?>
    <meta name="theme-color" content="<?php echo $theme_color?>">
    <meta name="msapplication-navbutton-color" content="<?php echo $theme_color?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $theme_color?>">
  <?php }?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
