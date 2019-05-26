/**
* ============================================
* File type: Init
* File provides: Auto Scroll down after submit
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

$(document).ready(function(e) {

    /**
    * Add loader on form Submit
    */
    $('form#miniSurveyView').on('submit', function() {
        $(this).children('div.form-actions').addClass('loader');
    });

    /**
    * INIT Scrolling on URL
    * Scroll to the block section (contacts)
    */
    if ($(location).attr("hash")) {

        if ($(location).attr("hash").substr(1, 9) == "formblock") {

            scrollToFormResult();
        }
    }

    /**
    * ============================================
    * EXTERNAL:
    *   Scrolling through Direct Url
    *   with speed in milliseconds
    * ============================================
    */
    function scrollToFormResult() {

        // delay animation start (milliseconds)
        var delayMsecs = 1500;

        var speedFactor = 2.5; // + o - speed (play with decimals first)

        // offset target destination
        var postOffset = -50;

        // get current handler for this add-on
        var thisHandler = "#contacts";

        var timer;

        // detect handler if Any
        if ($(thisHandler).length) {

            // get handler Offset
            var thisHandlerOffset = $(thisHandler).first().offset().top;

            // calculate speed (animation)
            var thisAnimDurationMsecs = Math.ceil(thisHandlerOffset / speedFactor);

            clearTimeout(timer);

            timer = setTimeout(function() {
                $("html, body").animate({
                    scrollTop: thisHandlerOffset - postOffset
                }, thisAnimDurationMsecs, "swing");
            }, delayMsecs);
        }
    }
});
