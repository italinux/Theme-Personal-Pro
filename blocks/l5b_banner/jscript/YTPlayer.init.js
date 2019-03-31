/**
* ============================================================
* File type: Init
* File provides: Video Banner Navigation
*
* @author:  Matteo Montanari <matteo@italinux.com>
*
* @component: jquery.mb.components
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
  
  if (CCM_EDIT_MODE === false) {
      /**
      * Detect Mobile Devices
      */
      var isMobile = window.matchMedia("only screen and (max-width: 760px)");

      // Conditional script here
      if (typeof isMobile === 'undefined' || isMobile.matches === false) {
      /**
      * ============================================
      * YouTube Video:
      * Trigger "on / off" only when available on the viewport (inView)
      * ==============================================
      * define video wrapper
      */
      var playerID = 'div[data-animation="bgVideo"]';

      // init YTPlayer
      var ytPlayer = $(playerID).YTPlayer();
        ytPlayer.on("YTPReady", function() {

          // jump to videoStart (seconds)
          ytPlayer.YTPSeekTo(videoStartAt);

          // stop video first when video Ready
          var timer = setTimeout(function() {
            ytPlayer.YTPPause();
          }, 500);

          // start video when wrapper in View
          timer = setTimeout(function() {
            var inview = new Waypoint.Inview({
              element: $(ytPlayer),
              enter: function(direction) {
                ytPlayer.YTPPlay();
              },
              exited: function(direction) {
                ytPlayer.YTPPause();
              }
            });
          }, 1000);

          if (typeof timer == 'undefined') {
              timer = 0;
              clearTimeout(timer);
          }
        });
      }
    }
});
