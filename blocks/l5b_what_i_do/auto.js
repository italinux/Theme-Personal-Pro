/**
* ============================================
* File type: Init
* File provides: Switch link type (Type a URL | Select a Page)
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
var thisTypeSwitch = {
    init: function () {

        // Get inputs Container
        var containerLink = $('div[id$="_linkTypes"]');

        // - - - - - - - - - - - - - - - - - - - - - - - -
        // Select Link (url|page selector)
        containerLink.find('input[type="radio"]').change(function() {

            // prefix div ID selector
            var nID = 'div#' + this.name;

            switch(this.value) {
            case 'url':
                $(nID + '_' + this.value).show();
                $(nID + '_pID').hide();
                break;
            case 'pID':
                $(nID + '_' + this.value).show();
                $(nID + '_url').hide();
                break;
            }
        });
    }
};
