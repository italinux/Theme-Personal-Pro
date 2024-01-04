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
defined('C5_EXECUTE') or die('Access denied');
?>

<div class="install_wrapper">

  <h3><?php echo t('Choose how to start')?></h3>
  <p><?php echo t('This is how to start your theme installation on your server')?></p>

  <div class="clearfix cols_wrapper">
    <div class="col starting_point none active" style="background-color: #e4e8ec">
      <h3><?php echo t('No Content')?></h3>
    </div>
    <div class="col starting_point" style="background-color: #e3fee4">
      <h3><?php echo t('Full Content')?></h3>
    </div>
  </div>
</div>

<div class="alert alert-warning" role="alert">
  <p><?php echo t('%1$s Note: %2$s %3$s', '<strong>', '</strong>', t('All images on the demo are replaced by placeholders in your server'))?></p>
</div>

<style>
  .install_wrapper { margin-bottom: 20px}
  .cols_wrapper { margin-top: 20px; text-align: center}
  .starting_point {
    position: relative; width: 250px; height: 200px; margin: 0px 15px; border: 5px solid #fff;
    border-radius: 10px; cursor: pointer; float: left; overflow: hidden;
  }
  .starting_point h3 {
    position: absolute; top: 40%; left: 50%; width: 100%;
    margin: 0px auto; transform: translate(-50%, -50%);
  }
  .starting_point.active { border: 5px solid #428bca}
</style>

<script type="text/javascript">

  $(document).ready(function(){
    /**
    * ============================================
    *   Set import Full Content as Default 
    * ============================================
    */
    function initSetFullContentDefault() {

      $('input[name=pkgDoFullContentSwap][value=0]:radio').prop('checked', false);
      $('input[name=pkgDoFullContentSwap][value=1]:radio').prop('checked', true);

      $('.starting_point').toggleClass('active');
    }

    // initialise setting
    initSetFullContentDefault();

    /**
    * ============================================
    *   No Content / Full Content optional
    * ============================================
    */
    $('.starting_point').on('click',function(e){
      e.preventDefault();

      if(!$(this).is('.none')) {
        $('input[name=pkgDoFullContentSwap][value=0]:radio').prop('checked', false);
        $('input[name=pkgDoFullContentSwap][value=1]:radio').prop('checked', true);
      } else {
        $('input[name=pkgDoFullContentSwap][value=1]:radio').prop('checked', false);
        $('input[name=pkgDoFullContentSwap][value=0]:radio').prop('checked', true);
      }

      $('.starting_point').removeClass('active');
      $(this).toggleClass('active');
    });

    $('input[name=pkgDoFullContentSwap]:radio').on('click', function(){
      if($(this).val() == 0) {
        $('input[name=option][value="none"]:radio').prop('checked', true);
      } else {
        $('input[name=option]:eq(1)').prop('checked', true);
      }
    });
  });
</script>
