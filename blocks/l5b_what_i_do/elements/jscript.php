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
| @copyright (c) 2020                                                       |
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

<script type="text/javascript">

   $(function() {
     // - - - - - - - - - - - - - - - - - - - - - - - - -
     // JQuery UI Sortable Tabs drag & drop
     //
     $("ul.nav-tabs").sortable({
        items: "li:not(.ui-sortable-disabled)",
        start: function(e, ui) {},
         stop: function(e, ui) {

           // - - - - - - - - - - - - - - - - - - - - - - - - -
           // New Tab position (after drag & drop)
           var endPosition = ui.item.index();

           // Targets
           var listTarget = $(this).children("li:not(.ui-sortable-disabled)");
           var thisTarget = listTarget.eq(endPosition);

           var tabData = thisTarget.children('a').attr('data-tab');

           // - - - - - - - - - - - - - - - - - - - - - - - - -
           // Tabs Toggle Actives
           listTarget.removeClass('active');
           thisTarget.addClass('active');

           // Content Toggle (show|hide)
           $(this).siblings("div.ccm-tab-content").hide();
           $(this).siblings("div#ccm-tab-content-" + tabData).show();
         },
       change: function(e, ui) {},
       update: function(e, ui) {

         // Target anchor
         var aTarget, aID, ordNum, tabData, tabText;

         // Target input name & value
         var inputName, inputValue;


         // - - - - - - - - - - - - - - - - - - - - - - - - -
         // Reset Tab text Titles
         $("ul.nav-tabs > li:not(.ui-sortable-disabled)").each(function (key, value) {

           // Target anchor
           aTarget = $(this).children('a');

           tabData = aTarget.attr('data-tab');

           // Strip all current digits to be replaced
           tabText = aTarget.text().replace(/\d+/g, '');

           // new ID
           aID = (key + 1);

           // Ordinal Numbers
           switch(aID.toString().slice(-1)) {
             case "1":
               ordNum = 'st';
               break;
             case "2":
               ordNum = 'nd';
               break;
             case "3":
               ordNum = 'rd';
               break;
             default:
               ordNum = 'th';
           }

           // Update Tab text Title (sorted)
           aTarget.text(aID + ordNum + tabText.substring(2, tabText.length));

           // - - - - - - - - - - - - - - - - - - - - - - - - -
           // Reset tab content fields indexes
           $.each( [ "input:not(:radio)",
                     "select",
                     "textarea",
                     "input:radio[id*=_isPopup]",
                     "input:radio[id*=_linkType]",
                     "input:radio[id*=_imageType]" ], function(id, el) {

             $("#ccm-tab-content-" + tabData).find(el).each(function () {

               if ($(this).length) {

                 // Create / Update Attributes data-check
                 if ($(this).is(":checked")) {
                   $(this).attr('data-check', true);
                 }

                 // Target input name & value
                  inputName = $(this).attr('name');
                 inputValue = $(this).val();

                 // Create / Update Attributes data-name & data-value
                 $(this).attr('data-name', 'o' + (key + 1) + inputName.substring(2, inputName.lenght));
                 $(this).attr('data-value', inputValue);
               }
             });
           });
         });
       },
     });

     // Target key
     var tabData;

     // Target input value
     var inputValue;

     // - - - - - - - - - - - - - - - - - - - - - - - - -
     // Radio inputs event on Change
     //
     $("ul.nav-tabs > li:not(.ui-sortable-disabled)").each(function() {

     tabData = $(this).children('a').attr('data-tab');

       // - - - - - - - - - - - - - - - - - - - - - - - - -
       // Loop through fields indexes
       $.each( [ "input:radio[id*=_isPopup]",
                 "input:radio[id*=_linkType]",
                 "input:radio[id*=_imageType]" ], function(key, el) {

         $("#ccm-tab-content-" + tabData).find(el).each(function() {

           if ($(this).length) {

             // Create / Update Attributes data-check
             if ($(this).is(":checked")) {
               $(this).attr('data-check', true);
             }

             // - - - - - - - - - - - - - - - - -
             // Trigget event on change
             $(this).on('change', function(){

              // Target input value
              inputValue = $(this).val();

              // Create / Update Attribute data-value
              $(this).attr('data-value', inputValue);

              // Remove all attributes data-check
              $(el).removeAttr('data-check');

              // Set attribute data-check
              $(this).attr('data-check', true);
            });
           }
         });
       });
     });

     // - - - - - - - - - - - - - - - - - - - - - - - - -
     // JQuery function BEFORE form submission
     //
     $("form").on("submit", function(e){
       // this will prevent the default submit
       // commented because on insert would not work otherwise !important
       // e.preventDefault();

       // Target key
       var tabData;

       // Target input value
       var inputName;

       // - - - - - - - - - - - - - - - - - - - - - - - - -
       // JQuery UI Sortable Refresh & Refresh Positions
       $("ul.nav-tabs").sortable( "refresh" );
       // $("ul.nav-tabs").sortable( "refreshPositions" );

       // - - - - - - - - - - - - - - - - - - - - - - - - -
       // Loop through Tabs indexes
       $("ul.nav-tabs > li:not(.ui-sortable-disabled)").each(function() {

         // Target anchor
         tabData = $(this).children('a').attr('data-tab');

         // - - - - - - - - - - - - - - - - - - - - - - - - -
         // Loop through fields indexes
         $.each( [ "input:not(:radio)",
                   "select",
                   "textarea",
                   "input:radio[id*=_isPopup]",
                   "input:radio[id*=_linkType]",
                   "input:radio[id*=_imageType]" ], function(id, el) {

           $("#ccm-tab-content-" + tabData).find(el).each(function() {

             if ($(this).length) {

               // - - - - - - - - - - - - - - - - - - - - - - 
               // Update Cloned values: name, value, checked
               //
               // Target input data-name > name
               inputName = $(this).attr('data-name');
               $(this).attr('name', inputName);

               // Target input data-value > value
               if ($(this).attr('data-value')) {
                 $(this).val($(this).attr('data-value'));
               }

               // Target input data-check > checked
               if ($(this).attr('data-check')) {
                 $(this).prop("checked", true);
               }
             }
           });
         });
       });
     });

     // - - - - - - - - - - - - - - - - - - - - - - - - -
     // Additional functions with JQuery UI Sortable
     //
     $("ul.nav-tabs").sortable("refresh");
     $("ul.nav-tabs").sortable("refreshPositions");
     $("ul.nav-tabs").disableSelection();

     $("ul.nav-tabs > li:not(.plus)").prepend('<span class="fa fa-minus"></span>');
      $("ul.nav-tabs > li:not(.plus)").append('<span class="fa fa-arrows"></span>');


      var plusHide = '';

      // max tabs reached, so hide plus
      if ($("ul.nav-tabs > li.hide").length == 0) {
          plusHide = 'hide';
      }

      $("ul.nav-tabs").append('<li class="ui-sortable-disabled ' + plusHide + ' plus"><span class="fa fa-plus fa-2x"></span></li>');

      // - - - - - - - - - - - - - - - - - - - - - - - - -
      // Show new data-tab (function)
      //
      // @p1 action type (plus|minus)
      // @p2 animation is milliseconds
      //
      $.fn.activeTab = function(p1, p2) {

        var animSecs = (p2 !== undefined && p2 !== null) ? p2 : 1000;

        var dataTab = this.siblings('.active').eq(0).children('a').attr('data-tab');

        this.parent().siblings('div.ccm-tab-content').hide(0, function() {
          if ($(this).attr('id') == 'ccm-tab-content-' + dataTab) {

            if (p1 == 'plus') {
              $(this).changeStatusItem(1);
            }
            $(this).fadeIn(animSecs, 'swing');
          }
        });

        if (p1 == 'minus') {
          $('div#ccm-tab-content-' + this.children('a').attr('data-tab')).changeStatusItem(0);
        }
      };

      // - - - - - - - - - - - - - - - - - - - - - - - - -
      // Status item change (function)
      // 
      // @return true|false (enabled|disabled)
      //
      $.fn.changeStatusItem = function(value) {

        var $thisEnabled = $(this).find("input:hidden[id*=_isEnabled]");

            $thisEnabled.attr("value", value);
            $thisEnabled.attr("data-value", value);
      };

      // - - - - - - - - - - - - -
      // ADD new Tab (PLUS)
      //
      $("ul.nav-tabs > li > span.fa-plus").on("click", function() {

        var $thisParent = $(this).parent();

        $thisParent.siblings().removeClass('only active');
        $thisParent.siblings('.hide').eq(0).addClass('active').removeClass('hide');

        // - - - - - - - - - - - - -
        // Show new data-tab
        //
        $thisParent.activeTab('plus');

        // max tabs reached, so hide plus
        if ($thisParent.siblings('.hide').length == false) {
            $(this).parent().hide(0);
        }
      });

      // - - - - - - - - - - - - -
      // REMOVE this Tab (MINUS)
      //
      $("ul.nav-tabs > li > span.fa-minus").on("click", function() {

        var $thisParent = $(this).parent();

        if ($thisParent.hasClass('active')) {

          var $thisTab = ($thisParent.nextAll('li:not(.hide, .plus):first').length == true) ? $thisParent.nextAll('li:not(.hide, .plus):first') : $thisParent.prevAll('li:not(.hide, .plus):first');
              $thisTab.addClass('active');
        }

        // - - - - - - - - - - - - -
        // Show new data-tab
        //
        $thisParent.activeTab('minus', 200);

        // hide current tab control
        $thisParent.removeClass('active').addClass('hide');

        // min tabs reached, so hide minus
        var $minTabs = $thisParent.siblings('li:not(.hide, .plus)');

        if ($minTabs.length == 1) {
            $minTabs.addClass('active only');

            $thisParent.activeTab('minus', 0);
        }

        // show always plus tab
        $thisParent.siblings('li.plus').removeClass('hide').show(0);
      });
   });
</script>
