<?php
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   http://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) 2019                                                       |
| ------------------------------------------------------------------------- |
| @license: Concrete5.org Marketplace Commercial Add-Ons & Themes License   |
|           http://concrete5.org/help/legal/commercial_add-on_license       |
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
        start: function(e, ui) {},
         stop: function(e, ui) {

           // - - - - - - - - - - - - - - - - - - - - - - - - -
           // New Tab position (after drag & drop)
           var endPosition = ui.item.index();

           // Targets
           var listTarget = $(this).children("li");
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
         var aTarget, tabData, tabText;

         // Target input name & value
         var inputName, inputValue;

         // - - - - - - - - - - - - - - - - - - - - - - - - -
         // Reset Tab text Titles
         $("ul.nav-tabs > li").each(function (key, value) {

           // Target anchor
           aTarget = $(this).children('a');

           tabData = aTarget.attr('data-tab');
           tabText = aTarget.text();

           // Update Tab text Title
           aTarget.text((key + 1) + tabText.substring(1, tabText.length));

           // - - - - - - - - - - - - - - - - - - - - - - - - -
           // Reset tab content fields indexes
           $.each( [ "input:not(:radio)",
                     "select",
                     "textarea",
                     "input:radio[id*=_isEnabled]",
                     "input:radio[id*=_isPopup]",
                     "input:radio[id*=_linkType]" ], function(id, el) {

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
     $("ul.nav-tabs > li").each(function() {

     tabData = $(this).children('a').attr('data-tab');

       // - - - - - - - - - - - - - - - - - - - - - - - - -
       // Loop through fields indexes
       $.each( [ "input:radio[id*=_isEnabled]",
                 "input:radio[id*=_isPopup]",
                 "input:radio[id*=_linkType]" ], function(key, el) {

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
       $("ul.nav-tabs > li").each(function() {

         // Target anchor
         tabData = $(this).children('a').attr('data-tab');

         // - - - - - - - - - - - - - - - - - - - - - - - - -
         // Loop through fields indexes
         $.each( [ "input:not(:radio)",
                   "select",
                   "textarea",
                   "input:radio[id*=_isEnabled]",
                   "input:radio[id*=_isPopup]",
                   "input:radio[id*=_linkType]" ], function(id, el) {

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
     $("ul.nav-tabs").sortable("refresh");
     $("ul.nav-tabs").sortable("refreshPositions");
     $("ul.nav-tabs").disableSelection();
     $("ul.nav-tabs > li").prepend('<span class="fa fa-arrows"></span>');

   });
</script>
