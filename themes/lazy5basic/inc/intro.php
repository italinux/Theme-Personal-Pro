<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<section class="page-block howto-video-intro <?php echo (User::isLoggedIn() == false ? 'no-top-margins' : null)?>">
  <div class="container-fluid">
    <div class="row block-header">
      <h2><?php echo t('where to start')?></h2>
      <?php echo (User::isLoggedIn() == false ? "<h5>" . t('%1$s %2$slogin%3$s', t('Watch this and then'), '<a target="_self" href="' . URL::to("/login") . '">', '</a>') . "</h5>": null)?>
    </div>
    <div class="row main">
      <div class="col-xs-12">
        <iframe src="//player.vimeo.com/video/144310867?title=0&byline=0&portrait=0"
                width="100%"
                height="440"
                frameborder="0"
                webkitallowfullscreen
                mozallowfullscreen
                allowfullscreen>
        </iframe>
      </div>
      <div class="col-xs-12" style="margin:0.8em 0px; text-align: center">
        <p>
          <?php echo t('%1$sFull documentation: %2$s %3$s', '<b>', '</b>', '<a class="goto" target="_blank" href="http://matteo-montanari.com/theme-' . $theme->getThemePrefix() . '/docs"><span>' . t('click here') . '</span></a>')?>
        </p>
      </div>
      <div class="col-xs-12" style="text-align: left">
        <?php echo t('Credits: %s', '<a class="goto" target="_blank" href="http://matteo-montanari.com/its-me"><span>Matteo Montanari</span></a>')?>
      </div>
    </div>
  </div>
</section>
