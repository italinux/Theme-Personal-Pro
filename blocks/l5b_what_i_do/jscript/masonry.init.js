/**
* ============================================
* File type: Conf & INIT
* File provides: Masonry GRID Layout
* Requires: Masonry v4.2.0
*
* @author:  Matteo Montanari <matteo@italinux.com>
*
* @component: jquery.masonry.min.js
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

    // set reference item
    var $thisElement = $('section.pre-hand.what-i-do');

    // check if element exists
    if ($thisElement.length) {

        // Find each items
        var $thisGrid = $thisElement.find('div.main');

        // init Masonry
        $thisGrid.masonry({

            // enable / disable layout on initialization
            initLayout: true,

            // Recommended. If not set, will use the outer width of the first item.
            // columnWidth: 600,

            // specifies which child elements will be used
            itemSelector: '.main-item',

            // maintain horizontal left-to-right order
            horizontalOrder: true,

            // sets item positions in percent values
            percentPosition: true,

            // fast transitions
            // transitionDuration: '0.2s'

            // slow transitions
            // transitionDuration: '0.8s'

            // no transitions
            transitionDuration: 0,

            // staggers item transitions,
            // so items transition incrementally after one another
            // stagger: 30
        });
    }
});
