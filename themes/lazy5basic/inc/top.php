<?php 
  defined('C5_EXECUTE') or die("Access Denied.");

  /* - - - - - - - - - - - - - - - - - - - 
  * SEO Metatags info page
  */
  $seo = \Config::get('app.config.SEO');
  $sPage = (is_array($seo['page']) == false ? array() : array_map('html_entity_decode', array_map("t", $seo['page'])));
  $domain = trim(strtolower(\Config::get('app.config.domain')));

  // Fetch site name
  // 1. app.php
  // 2. dashboard
  $siteName = ($seo['siteName'] == true ? $seo['siteName'] : \Config::get('concrete.site'));

  // Add domain to title (is enabled)
  if (isset($sPage['pageTitle']) && ($seo['showDomain'] == true)) {
      $sPage['pageTitle'] = sprintf('%1$s %2$s %3$s', t($sPage['pageTitle']), '-', $domain);
  }

  // Add site name to title (is enabled)
  if (isset($sPage['pageTitle']) && ($siteName == true)) {
      $sPage['pageTitle'] = sprintf('%3$s %2$s %1$s', t($sPage['pageTitle']), '-', $siteName);
  }
?>
<head>
    <meta name="author" content="Matteo Montanari, @italinux.com">
    <meta name="package" content="<?php echo $theme->getThemeDisplayName()?>">
    <meta name="version" content="<?php echo $theme->getVersion()?>">

    <?php echo $html->css($view->getStylesheet('main.less'))?>

    <?php if (User::isLoggedIn()) { echo $html->css($this->getThemePath() . '/css/tools/c5-ui.css'); }?>

    <?php View::element('header_required', $sPage)?>
<?php
  /* - - - - - - - - - - - - - - - - - - -
  * Theme Colour (Mobile devices Address Bar)
  */
  $theme_color = \Config::get('app.config.theme-color');

  if (isset($theme_color)) { ?>
    <!-- Theme Colour (Mobile devices Address Bar) -->
    <meta name="theme-color" content="<?php echo $theme_color?>">
    <meta name="msapplication-navbutton-color" content="<?php echo $theme_color?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $theme_color?>">
  <?php }?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
