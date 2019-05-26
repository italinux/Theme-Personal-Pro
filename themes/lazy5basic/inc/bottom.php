<?php 
defined('C5_EXECUTE') or die("Access Denied.");

View::element('footer_required');

if (User::isLoggedIn()) { ?><div style="height: 70px"></div><?php }?>
