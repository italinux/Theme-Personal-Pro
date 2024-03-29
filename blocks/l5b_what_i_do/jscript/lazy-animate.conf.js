/**
* ============================================
* File type: Conf
* File provides: Animation on Waypoint
* Requires: Waypoint + Lazy.Animate
*
* @author:  Matteo Montanari <matteo@italinux.com>
*
* @component: jquery.waypoints.min.js
* @component: jquery.lazy.animate.min.js
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

/**
* List of Handlers for Animation
*/
var what_i_do = {
    "what-i-do": {
        "icon": {
            0: {
                offset: 650,
                effect: "fadeIn",
                delay: 0.2,
            },
            1: {
                offset: 650,
                effect: "fadeIn",
                delay: 0.4,
            },
            2: {
                offset: 650,
                effect: "fadeIn",
                delay: 0.3,
            },
            3: {
                offset: 650,
                effect: "fadeIn",
                delay: 0.5,
            },
        },
        "title": {
            offset: 750,
            effect: "none",
            delay: 0,
        },
        "content": {
            0: {
                offset: 650,
                effect: "flipInX",
                delay: 0,
            },
            1: {
                offset: 650,
                effect: "flipInX",
                delay: 0.3,
            },
            2: {
                offset: 650,
                effect: "flipInX",
                delay: 0.2,
            },
            3: {
                offset: 650,
                effect: "flipInX",
                delay: 0,
            },
        },
        "cta": {
            offset: 750,
            effect: "none",
            delay: 0,
        },
        "global-cta": {
            offset: 750,
            effect: "none",
            delay: 0,
        },
    },
};
