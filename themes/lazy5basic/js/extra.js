/**
* ============================================
* File type: Theme Extra
* File provides: Smooth Scrolling on querying direct UrLs with anchor
*           es1: http://localhost/#contacts (Single Page)
*           es2: http://localhost/page/#contacts (Multi Pages)
*
* Suggested: .haccess for cleaner URLs
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

$(function() {

    /**
    * @preserve
    * Banner Image FadeIn when Ready
    */
    initBannerFadeIn();

    /**
    * @preserve
    * INIT Scrolling on URL
    */
    if ($(location).attr("hash")) {

        // set reference item Portfolio as it has Masonry GRID built on the fly
        var $thisElement = $('section.portfolio');

        // check if plugin exists
        if ($thisElement.length && ($.fn.imagesLoaded !== undefined)) {

            // Wait till all images are loaded
            $thisElement.find('div.main').imagesLoaded().always(function() {
                initScrollURL();
            });
        } else {
            initScrollURL();
        }
    }

    /**
    * @preserve
    * ============================================
    *   Banner Image FadeIn when Ready
    * ============================================
    */
    function initBannerFadeIn() {

        // set Banner Background FadeIn on image once loaded
        var $thisElement = $('section.banner');

        // check if plugin exists
        if ($thisElement.length) {

            if ($.fn.imagesLoaded !== undefined) {

                // Wait till all images are loaded
                $thisElement.imagesLoaded( { background: true }, function() {
                    // Now fade out
                    $thisElement.removeClass("with-fade");
                });
            } else {
                $thisElement.removeClass("with-fade");
            }
        }
    }

    /**
    * @preserve
    * ============================================
    * EXTERNAL:
    *   Scrolling through Direct Url INTERNET
    *   Main sections listed
    *   with speed in milliseconds
    * ============================================
    */
    function initScrollURL() {

        var delayMsecs = 1e3; // (10 x 10 x 10) = 1000 = 1sec
        var speedFactor = 2.5; // + o - speed (play with decimals first)

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
            baseOffset = 80;
        }

        /**
        * Then change default Offset to match the dynamic element height
        */
        if (document.querySelector('section.static.menu') !== null) {
            baseOffset = -50;
        }

        /**
        * The offset assigned by default if set to 0 (zero)
        */
        var offsetDefault = { desktop: 70, mobile: 50 };

        /**
        * @preserve
        * List of Handlers for Scrolling Direct
        * Add or Edit with new viewpoint / new add-ons
        *
        * Customise with + offset
        * Add-ons have same config in blocks/jscript (internal scrolling)
        * Change Both!
        */
        var options = {
            'menu': {},
            'banner': {}, 
            'what-i-do': {},
            'team': {},
            'services': {},
            'about-me': {},
            'my-skills': {},
            'curriculum-vitae': { mobile: 40 },
                'curriculum-vitae-skills': { desktop: 120, mobile: 150 },
                'curriculum-vitae-resume': { desktop: 120, mobile: 150 },
            'portfolio': {},
            'testimonials': {},
            'clients': {},
            'prices': {},
            'social-media': {},
            'contacts': {},
                'contacts-more': { desktop: 120, mobile: 150 },
                    'contacts-more-mobile': { desktop: 120, mobile: 150 },
                    'contacts-more-address': { desktop: 120, mobile: 150 },
                    'contacts-more-email': { desktop: 120, mobile: 150 },
            'footer': {},
        };

        /** ============================================
        *  default values do NOT touch BELOW this line.
        */
        var animDurationMsecsDefault = 1e3;

        var offsetConfig;
        var thisHandler;

        var thisHash = $(location).attr("hash").split('?')[0];

        /**
        *  if smooth scrolling is called from another page (Multipage)
        *  we add prefix #wyp- to adjust the target
        */
        if (thisHash.substring(1) in options) {
           thisHash = '#wyp-' + thisHash.substring(1);
        }

        /**
        *  check if smooth scrolling direct external link
        *  it uses prefix #wyp-
        */
        var thisPrefix = thisHash.substring(1, 4);

        if (thisPrefix == 'wyp') {

             var childHash = thisHash.substring(5);
            var parentHash = childHash.substr(0, childHash.lastIndexOf("-"));

            var timer;

            // Loop through main Object
            if (childHash in options) {
                offsetConfig = options[childHash];
            } else if (parentHash in options) {

                var thisParent = options[parentHash];
                var thisChild  = ((typeof thisParent !== 'undefined') && (typeof thisParent[childHash] !== 'undefined')) ? thisParent[childHash] : false;

                    // create current config obj and its fallback
                    offsetConfig = (thisChild) ? thisChild : thisParent;
            }

            // set Object Values
            if (offsetConfig) {

                // get current handler or its fallback
                thisHandler = "#" + ($("#" + childHash).length ? childHash : parentHash);

                // detect handler if Any
                if ($(thisHandler).length) {

                    // get handler Offset
                    var thisHandlerOffset = $(thisHandler).first().offset().top;

                    // calculate speed (animation)
                    var animDurationMsecs = Math.ceil(thisHandlerOffset / speedFactor);

                    var thisAnimDurationMsecs = (animDurationMsecs) ? animDurationMsecs : animDurationMsecsDefault;

                    /**
                    * ============================================
                    * Media Queries:
                    *   calculate position offset
                    * ============================================
                    */
                    var isMobile = window.matchMedia("only screen and (max-width: 800px)");

                    var thisOffsetDefault = (isMobile.matches) ? offsetDefault.mobile : offsetDefault.desktop;

                    var thisOffsetConfig = (isMobile.matches) ? ('mobile' in offsetConfig) ? offsetConfig.mobile : 0 : ('desktop' in offsetConfig) ? offsetConfig.desktop : 0;

                    // END Media Queries


                    var postOffset = baseOffset + ((thisOffsetConfig) ? thisOffsetConfig : thisOffsetDefault);

                    // Scroll Animate
                    clearTimeout(timer);

                    timer = setTimeout(function() {
                        $("html, body").animate({
                            scrollTop: thisHandlerOffset - postOffset
                        }, thisAnimDurationMsecs, "swing");
                    }, delayMsecs);
                }
            }
        }
    }
});
