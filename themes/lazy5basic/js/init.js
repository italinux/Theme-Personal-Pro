/**
* ===============================================================
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
* Tipically preloader custom
* ============================================
*/

/** - - - - - - - - - - - - - - - - - - - - -
*  PRELOADER
* - - - - - - - - - - - - - - - - - - - - -*/
$(function() {

    var thisHandler = "div#preloader";
    var transMsecs = 300;
    var delayMsecs = 300;

    // Adding some lagging to preload?
    var addLagging = false;


    if ($(location).attr("hash")) {
        $(thisHandler).hide();
    } else {

        switch (addLagging) {
          case true:

          // new background opacity
          var newOpacity = '0.98';

          // new timing delay (msecs)
          delayMsecs = 1500;

          // new timing transition (msecs)
          transMsecs = 300;

          var curBackgroundColor = $(thisHandler).css('background-color'),  // rgba(xxx, xxx, xxx, 0.cx)
              newBackgroundColor = curBackgroundColor.replace(/[^,]+(?=\))/, newOpacity);  // rgba(xxx, xxx, xxx, 0.nx)

              $(thisHandler).css({ backgroundColor: newBackgroundColor });
          break;
        }

        // now Animate preload spinner
        $(thisHandler).children("div").delay(delayMsecs).fadeOut(transMsecs, function() {
            $(this).parent().fadeOut(transMsecs);
        });
    }

/** - - - - - - - - - - - - - - - - - - - - -
*  SHOW PRE-LOADER on click CTA to external pages ONLY
* - - - - - - - - - - - - - - - - - - - - -*/
    if (CCM_EDIT_MODE === false) {

        $("div.main-wrapper a").not(".scroll").not(".popup-image").not(".lightbox").not("[href^='#']").click(function() {

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

                    // show pre-loader
                    $("div#preloader").fadeIn(100, function() {
                        $(this).children().fadeIn(50);
                    }).delay(1500).fadeOut(300).hide(0);
                }
            }
        });
    }

/** - - - - - - - - - - - - - - - - - - - - -
*  HIDE PRE-LOADER on double-click (security measure)
* - - - - - - - - - - - - - - - - - - - - -*/
    $(thisHandler).click(function() {
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

        // Scroll Animate
        $("html, body").animate({
            scrollTop: 0
        }, thisAnimDurationMsecs, "swing");
    });
});
