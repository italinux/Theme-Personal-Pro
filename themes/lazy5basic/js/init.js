/**
* ============================================
* File type: Init
* File provides: Navigation
*
* @author: Matteo Montanari <matteo@italinux.com>
*
* TERMS OF USE
* Open source under the MIT License.
*
* Permission is hereby granted, free of charge, to any person obtaining
* a copy of this software and associated documentation files (the "Software"),
* to deal in the Software without restriction, including without limitation
* the rights to use, copy, modify, merge, publish, distribute, sublicense,
* and/or sell copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included
* in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
* IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
* ============================================
*/

/** - - - - - - - - - - - - - - - - - - - - -
*  PRELOADER
* - - - - - - - - - - - - - - - - - - - - -*/
$(function() {

    var thisPreload = "div#preloader";
    var transMsecs = 300;
    var delayMsecs = 300;

    // Adding some lagging to preload?
    var addLagging = false;


    if ($(location).attr("hash")) {
        $(thisPreload).hide();
    } else {

        switch (addLagging) {
          case true:

          // new background opacity
          var newOpacity = '0.98';

          // new timing delay (msecs)
          delayMsecs = 1500;

          // new timing transition (msecs)
          transMsecs = 300;

          var curBackgroundColor = $(thisPreload).css('background-color'),  // rgba(xxx, xxx, xxx, 0.cx)
              newBackgroundColor = curBackgroundColor.replace(/[^,]+(?=\))/, newOpacity);  // rgba(xxx, xxx, xxx, 0.nx)

              $(thisPreload).css({ backgroundColor: newBackgroundColor });
          break;
        }

        // now Animate preload spinner
        $(thisPreload).children("div").delay(delayMsecs).fadeOut(transMsecs, function() {
            $(this).parent().fadeOut(transMsecs);
        });
    }

    /**
    * ============================================
    * INTERNAL: CTA buttons / targeting anchors
    * ============================================
    */
    $(".scroll").click(function(e) {

        e.preventDefault();

        var speedFactor = 3; // + o - speed (play with decimals first)

        // minimum animation duration in millisecs
        var animDurationMsecsDefault = 400;

        /**
        * Add a base offset in case of elements changing positions while scrolling
        * (e.g. Sticky Menu)
        */
        var baseOffset = 0;

        /**
        * Check devices resolutions where that's the case
        */
        var isTablet = window.matchMedia("only screen and (max-width: 1024px)");

        /**
        * Then change base Offset to match the dynamic element height
        */
        if ((document.querySelector('section.sticky.menu') !== null) && (isTablet.matches === false)) {

            // Check if FIXED already
            if ( ! $('section.sticky.menu').hasClass('sticky-fixed')) {

                // GET MENU Offset to Top
                var stickyOffsetTop = $('section.sticky.menu').offset().top;

                // SET Menu Height
                var stickyOffsetPlus = 40;

                /**
                * Then change default Offset to match the dynamic element height
                */
                if ($(document).scrollTop() < (stickyOffsetTop + stickyOffsetPlus)) {
                    baseOffset = 80;
                }
            }
        }

        /**
        * Then change default Offset to match the dynamic element height
        */
        if (document.querySelector('section.static.menu') !== null) {
            baseOffset = -50;
        }

        // default offset target destination
        var offsetDefault = { desktop: 70, mobile: 50 };

        // config offset target destination
        var offsetConfig = {};

        // get current anchor hash 
        var thisHash =  this.hash.substring(1);

        // Exceptions
        switch(thisHash) {
            case 'what-i-do-more':
                offsetConfig = { desktop: 165 };
                thisHash = "what-i-do";
            break;
            case 'about-me':
                offsetConfig = { desktop: 120};
                break;
            case 'curriculum-vitae':
                offsetConfig = { desktop: 120, mobile: 40 };
                break;
            case 'curriculum-vitae-skills':
                offsetConfig = { desktop: 120, mobile: 100 };
                break;
            case 'curriculum-vitae-resume':
                offsetConfig = { desktop: 120, mobile: 150 };
                break;
            case 'contacts-more':
                case 'contacts-more-mobile':
                case 'contacts-more-address':
                case 'contacts-more-email':
                    offsetConfig = { desktop: 120, mobile: 150 };
                    break;
        }

        // get current handler for this add-on
        var thisHandler = "#" + thisHash;

        // detect handler if Any
        if ($(thisHandler).length) {

            // get handler Offset
            var thisHandlerOffset = $(thisHandler).first().offset().top;

            // get current element offset
            var thisElementOffset = $(this).offset().top;

            // calculate speed (animation)
            var animDurationMsecs = Math.ceil((thisHandlerOffset - thisElementOffset) / speedFactor);

            // final speed (animation)
            var thisAnimDurationMsecs = (animDurationMsecs < animDurationMsecsDefault) ? animDurationMsecsDefault : animDurationMsecs;

            /**
            * ============================================
            * Media Queries:
            *   calculate position offset
            * ============================================
            */
            var isMobile = window.matchMedia("only screen and (max-width: 800px)");

            var thisOffsetDefault = (isMobile.matches) ? offsetDefault.mobile : offsetDefault.desktop;

            var thisOffsetConfig = (isMobile.matches) ? ('mobile' in offsetConfig) ? offsetConfig.mobile : null : ('desktop' in offsetConfig) ? offsetConfig.desktop : null;

            // END Media Queries


            var postOffset = baseOffset + ((thisOffsetConfig === undefined || thisOffsetConfig === null) ? thisOffsetDefault : thisOffsetConfig);

            // Scroll + Animate (fadeOut at completion)
            $("html, body").animate({
                scrollTop: thisHandlerOffset - postOffset
            }, {
               duration: thisAnimDurationMsecs,
               easing: "swing",
               complete: function(){
                 // close menu hamburger
                 $("nav").find(".hamburger").removeClass("is-active");

                 // hide toggle menu (fullscreen)
                 $("nav").find(".fixed").removeClass('animated').fadeOut(250, "swing", function() {
                     $(this).removeClass("fixed").addClass('animated');
                 });
               }
            });
        }
    });

    /** - - - - - - - - - - - - - - - - - - - - -
    *  SHOW PRE-LOADER on click CTA to external pages ONLY
    * - - - - - - - - - - - - - - - - - - - - -*/
    if (CCM_EDIT_MODE === false) {

        $("body").on("click", "a", function() {

             if ( ! $(this).filter('.scroll, .scroll-up, .popup-image, [class*="lightbox"], [href^="#"]').length) {

                /** - - - - - - - - - - - - - - - - - -
                * Additional Check on anchor Class
                * if NOT mobile devices (tablets & mobiles), then show pre-loader
                * - - - - - - - - - - - - - - - - - - -*/
                if ($(this).hasClass('dropdown-on-mobiles') == false) {

                    /** - - - - - - - - - - - - - - - - - -
                    * Additional Check on Hrefs
                    * if not _self, then show pre-loader
                    * - - - - - - - - - - - - - - - - - - -*/
                    var href = $(this).attr('href');

                    if ((typeof href !== typeof undefined && href !== false && href !== null) && (((href.substring(0, 1) === '/') || (href.substring(0, 4) === 'http')))) {

                        /** - - - - - - - - - - - - - - - - - -
                        * Additional Check on Targets
                        * if not _self, then show pre-loader
                        * - - - - - - - - - - - - - - - - - - -*/
                        var target = $(this).attr('target');

                        // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
                        if ((typeof target === typeof undefined || target === false || target === null) || (target == '_self') || (target == '')) {

                            // SET thisPreload HIDDEN FLAG to false
                            var thisPreloadHidden = false;

                            // Maximum delay before preloader eventually fades out
                            var maxDelayInFadeOutMsecs = 15000;

                            // HIDE preload spinner on Navigation History (back button pressed)
                            window.addEventListener('pageshow', function (event) {
                                if (event.persisted || performance.getEntriesByType('navigation')[0].type === 'back_forward') {
                                    // HIDE PRELOAD
                                    $(thisPreload).hide();

                                    // SET thisPreload HIDDEN FLAG to true
                                    thisPreloadHidden = true;
                                }
                            });

                            // MAKE SURE thisPreload gets shown when necessary
                            if (thisPreloadHidden === false ) {
                                // SHOW PRELOAD with Maximum delay
                                $(thisPreload).fadeIn(100, function() {
                                    $(this).children().fadeIn(300);
                                }).delay(maxDelayInFadeOutMsecs).fadeOut(300).hide(0);
                            }
                        }
                    }
                }
            }
        });
    }

    /** - - - - - - - - - - - - - - - - - - - - -
    *  HIDE PRE-LOADER on double-click (security measure)
    * - - - - - - - - - - - - - - - - - - - - -*/
    $(thisPreload).click(function() {
        // hide pre-loader
        $(this).hide(0, function() {
            $(this).children().hide();
        });
    });

    /** - - - - - - - - - - - - - - - - - - - - -
    *  SCROLL-TOP show bottom arrow
    * - - - - - - - - - - - - - - - - - - - - -*/
    // get current handler
    thisHandler = '#scroll-top';
    transMsecs = 0;
    delayMsecs = 2e3; // (20 x 20 x 20) = 2000

    var timer;

    $(window).scroll(function() {

        if ($(this).scrollTop() > 500) {
            $(thisHandler).not(".visible").addClass("visible");

            if ((typeof timer === 'undefined') || timer === null) {
                timer = setTimeout(function() {
                    $(thisHandler).animate({
                        width: "85px",
                        height: "85px",
                        paddingLeft: "0.8%",
                        paddingTop: "0.5%",
                        fontSize: "0.65em",
                    }, transMsecs, "swing");
                }, delayMsecs);
            }
        } else {
            $(thisHandler + ".visible").removeClass("visible");
        }
    });

    /** - - - - - - - - - - - - - - - - - - - - -
    *  SCROLL-TOP on click bottom arrow
    * - - - - - - - - - - - - - - - - - - - - -*/
    $(".scroll-up").click(function(e) {

        e.preventDefault();

        var speedFactor = 3.5; // + o - speed (play with decimals first)

        // minimum animation duration in millisecs
        var animDurationMsecsDefault = 500;

        // get current element offset
        var thisElementOffset = $(this).offset().top;

        // calculate speed (animation)
        var animDurationMsecs = Math.ceil(thisElementOffset / speedFactor);

        // final speed (animation)
        var thisAnimDurationMsecs = (animDurationMsecs < animDurationMsecsDefault) ? animDurationMsecsDefault : animDurationMsecs;

        // Scroll + Animate (fadeOut at completion)
        $("html, body").animate({
            scrollTop: 0
        }, {
            duration: thisAnimDurationMsecs,
            easing: "swing",
            complete: function(){
              // close menu hamburger
              $("nav").find(".hamburger").removeClass("is-active");

              // hide toggle menu (fullscreen)
              $("nav").find(".fixed").removeClass('animated').fadeOut(250, "swing", function() {
                  $(this).removeClass("fixed").addClass('animated');
              });
            }
        });
    });
});
