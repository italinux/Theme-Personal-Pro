/**
* ============================================
* File type: auto.js
* File provides: miniSurvey
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

var miniSurvey = {
    bid: 0,
    serviceURL: $("input[name=miniSurveyServices]").val() + '?block=form&',
    init: function () {
        this.tabSetup();

        $("#answerType").change(function (r) {
            miniSurvey.optionsCheck($('#answerType').get(0));
            miniSurvey.settingsCheck($('#answerType').get(0));
        }).trigger('change');

        $("#answerTypeEdit").change(function (r) {
            miniSurvey.optionsCheck($('#answerTypeEdit').get(0), 'Edit');
            miniSurvey.settingsCheck($('#answerTypeEdit').get(0), 'Edit');
        });

        $('#addQuestion').click(function () {
            miniSurvey.addQuestion();
            return false;
        });
        $('#editQuestion').click(function () {
            miniSurvey.addQuestion('Edit');
            return false;
        });
        $('#cancelEditQuestion').click(function () {
            $('#miniSurvey').show();
            $('#editQuestionForm').css('display', 'none');
        });
        this.serviceURL += 'cID=' + this.cID + '&arHandle=' + this.arHandle + '&bID=' + this.bID + '&btID=' + this.btID + '&';
        miniSurvey.refreshSurvey();
        $('#emailSettings').hide();
    },
    tabSetup: function () {
        $('ul#ccm-formblock-tabs li a').each(function (num, el) {
            el.onclick = function () {
                var pane = this.id.replace('ccm-formblock-tab-', '');
                miniSurvey.showPane(pane);
            };
        });
    },
    showPane: function (pane) {
        $('ul#ccm-formblock-tabs li').each(function (num, el) {
            $(el).removeClass('active');
        });
        $(document.getElementById('ccm-formblock-tab-' + pane).parentNode).addClass('active');
        $('div.ccm-formBlockPane').each(function (num, el) {
            el.style.display = 'none';
        });
        $('#ccm-formBlockPane-' + pane).css('display', 'block');
    },
    refreshSurvey: function () {
        $.ajax({
            url: this.serviceURL + 'mode=refreshSurvey&qsID=' + parseInt(this.qsID) + '&hide=' + miniSurvey.hideQuestions.join(','),
            success: function (msg) {
                $('#miniSurveyPreviewWrap').html(msg);
            }
        });
        $.ajax({
            url: this.serviceURL + 'mode=refreshSurvey&qsID=' + parseInt(this.qsID) + '&showEdit=1&hide=' + miniSurvey.hideQuestions.join(','),
            success: function (msg) {
                $('#miniSurveyWrap').html(msg);
            }
        });
    },
    optionsCheck: function (radioButton, mode) {
        if (mode != 'Edit') mode = '';
        if (radioButton.value == 'select' || radioButton.value == 'radios' || radioButton.value == 'checkboxlist') {
            $('#answerOptionsArea' + mode).css('display', 'block');
        } else $('#answerOptionsArea' + mode).css('display', 'none');

        if (radioButton.value == 'email') {
            $('#emailSettings' + mode).show();
        } else {
            $('#emailSettings' + mode).hide();
        }


        if (radioButton.value == 'date' || radioButton.value == 'datetime') {
            $('#answerDateDefault' + mode).show();
        } else {
            $('#answerDateDefault' + mode).hide();
        }
    },
    settingsCheck: function (radioButton, mode) {
        if (mode != 'Edit') mode = '';
        if (radioButton.value == 'text') {
            $('#answerSettings' + mode).css('display', 'block');
        } else {
            $('#answerSettings' + mode).css('display', 'none');
        }
    },
    addQuestion: function (mode) {
        var msqID = 0;
        if (mode != 'Edit') {
            mode = '';
        } else {
            msqID = parseInt($('#msqID').val(), 10);
        }
        var formID = '#answerType' + mode;
        var answerType = $(formID).val();
        var options = encodeURIComponent($('#answerOptions' + mode).val());
        var postStr = 'question=' + encodeURIComponent($('#question' + mode).val()) + '&options=' + options;
        postStr += '&defaultDate=' + encodeURIComponent($('#defaultDate' + mode).val());
        postStr += '&width=' + escape($('#width' + mode).val());
        postStr += '&height=' + escape($('#height' + mode).val());
        var req = $('input[type="radio"][name="required' + mode + '"]:checked').val();
        postStr += '&required=' + req;
        postStr += '&position=' + escape($('#position' + mode).val());
        var form = document.getElementById('ccm-block-form');
        postStr += '&inputType=' + answerType;
        postStr += '&msqID=' + msqID + '&qsID=' + parseInt(this.qsID);
        if (answerType == 'email') {
            postStr += '&send_notification_from=';
            if (mode == 'Edit') {
                fieldID = "#send_notification_from_edit";
            }
            else {
                fieldID = "#send_notification_from";
            }
            postStr += $(fieldID).is(':checked') ? "1" : "0";
        }
        $.ajax({
            type: "POST",
            data: postStr,
            url: this.serviceURL + 'mode=addQuestion&qsID=' + parseInt(this.qsID),
            success: function (msg) {
                /*jshint -W061 */
                eval('var jsonObj=' + msg);
                /*jshint +W061 */
                if (!jsonObj) {
                    alert(ccm_t('ajax-error'));
                } else if (jsonObj.noRequired) {
                    alert(ccm_t('complete-required'));
                } else {
                    var questionMsg;

                    if (jsonObj.mode == 'Edit') {
                        questionMsg = $('#questionEditedMsg');
                        questionMsg.fadeIn();
                        setTimeout(function () {
                            questionMsg.fadeOut();
                        }, 5000);
                        if (jsonObj.hideQID) {
                            miniSurvey.hideQuestions.push(miniSurvey.edit_qID); //jsonObj.hideQID);
                            miniSurvey.edit_qID = 0;
                        }
                    } else {
                        questionMsg = $('#questionAddedMsg');
                        questionMsg.fadeIn();
                        setTimeout(function () {
                            questionMsg.fadeOut();
                        }, 5000);
                        // miniSurvey.saveOrder();
                    }
                    $('#editQuestionForm').css('display', 'none');
                    $('#miniSurvey').show();
                    miniSurvey.qsID = jsonObj.qsID;
                    miniSurvey.ignoreQuestionId(jsonObj.msqID);
                    $('#qsID').val(jsonObj.qsID);
                    miniSurvey.resetQuestion();
                    miniSurvey.refreshSurvey();
                    // miniSurvey.showPane('preview');
                }
            }
        });
    },
    // prevent duplication of these questions, for block question versioning
    ignoreQuestionId: function (msqID) {

        msqID = $('#ccm-ignoreQuestionIDs');
        var ignoreEl = msqID;

        if (ignoreEl.val()) msqIDs = ignoreEl.val().split(',');
        else msqIDs = [];
        msqIDs.push(parseInt(msqID, 10));
        ignoreEl.val(msqIDs.join(','));
    },
    reloadQuestion: function (qID) {

        $.ajax({
            url: this.serviceURL + "mode=getQuestion&qsID=" + parseInt(this.qsID) + '&qID=' + parseInt(qID),
            success: function (msg) {
                /*jshint -W061 */
                eval('var jsonObj=' + msg);
                /*jshint +W061 */
                $('#editQuestionForm').css('display', 'block');
                $('#questionEdit').val(jsonObj.question);
                $('#answerOptionsEdit').val(jsonObj.optionVals.replace(/%%/g, "\r\n"));
                $('#widthEdit').val(jsonObj.width);
                $('#heightEdit').val(jsonObj.height);
                $('#positionEdit').val(jsonObj.position);
                $('#defaultDateEdit').val(jsonObj.defaultDate);
                if (parseInt(jsonObj.required, 10) == 1) {
                    $('input[name="requiredEdit"][value="1"]').prop('checked', true);
                    $('input[name="requiredEdit"][value="0"]').prop('checked', false);
                } else {
                    $('input[name="requiredEdit"][value="1"]').prop('checked', false);
                    $('input[name="requiredEdit"][value="0"]').prop('checked', true);
                }

                if (jsonObj.inputType == 'email') {
                    var options = jsonObj.optionVals.split(";");
                    for (var i = 0; i < options.length; i++) {
                        key_val = options[i].split('::');
                        if (key_val.length == 2) {
                            if (key_val[0] == 'send_notification_from') {
                                if (key_val[1] == 1) {
                                    $('.send_notification_from_edit input').prop('checked', true);
                                } else {
                                    $('.send_notification_from_edit input').prop('checked', false);
                                }
                            }
                        }
                    }
                }

                $('#msqID').val(jsonObj.msqID);
                $('#answerTypeEdit').val(jsonObj.inputType);
                $('#miniSurvey').hide();
                miniSurvey.optionsCheck($('#answerTypeEdit').get(0), 'Edit');
                miniSurvey.settingsCheck($('#answerTypeEdit').get(0), 'Edit');

                if (parseInt(jsonObj.bID) > 0)
                    miniSurvey.edit_qID = parseInt(qID);
                $('.miniSurveyOptions').first().closest('.ui-dialog-content').get(0).scrollTop = 0;
            }
        });
    },
    // prevent duplication of these questions, for block question versioning
    pendingDeleteQuestionId: function (msqID) {

        msqID = $('#ccm-pendingDeleteIDs');
        var el = msqID;

        if (el.val()) msqIDs = el.val().split(',');
        else msqIDs = [];
        msqIDs.push(parseInt(msqID, 10));
        el.val(msqIDs.join(','));
    },
    hideQuestions: [],
    deleteQuestion: function (el, msqID, qID) {
        if (confirm(ccm_t('delete-question'))) {
            $.ajax({
                url: this.serviceURL + "mode=delQuestion&qsID=" + parseInt(this.qsID) + '&msqID=' + parseInt(msqID),
                success: function (msg) {
                    miniSurvey.resetQuestion();
                    miniSurvey.refreshSurvey();
                }
            });

            miniSurvey.ignoreQuestionId(msqID);
            miniSurvey.hideQuestions.push(qID);
            miniSurvey.pendingDeleteQuestionId(msqID);
        }
    },
    resetQuestion: function () {
        $('#question').val('');
        $('#answerOptions').val('');
        $('#width').val('40');
        $('#height').val('10');
        $('#msqID').val('');
        $('#answerType').val('field').change();
        $('#answerOptionsArea').hide();
        $('#answerSettings').hide();
        $('#answerDateDefault').hide();
        $('#required input').prop('checked', false);
    },

    validate: function () {
        var failed = 0;

        var n = $('#surveyName');
        if (!n || parseInt(n.val().length, 10) == 0) {
            alert(ccm_t('form-name'));
            this.showPane('options');
            n.focus();
            failed = 1;
        }

        var Qs = $('.miniSurveyQuestionRow');
        if (!Qs || parseInt(Qs.length, 10) < 1) {
            alert(ccm_t('form-min-1'));
            failed = 1;
        }

        if (failed) {
            ccm_isBlockError = 1;
            return false;
        }
        return true;
    },

    moveUp: function (el, thisQID) {
        var qIDs = this.serialize();
        var previousQID = 0;
        for (var i = 0; i < qIDs.length; i++) {
            if (qIDs[i] == thisQID) {
                if (previousQID == 0) break;
                $('#miniSurveyQuestionRow' + thisQID).after($('#miniSurveyQuestionRow' + previousQID));
                break;
            }
            previousQID = qIDs[i];
        }
        this.saveOrder();
    },
    moveDown: function (el, thisQID) {
        var qIDs = this.serialize();
        var thisQIDfound = 0;
        for (var i = 0; i < qIDs.length; i++) {
            if (qIDs[i] == thisQID) {
                thisQIDfound = 1;
                continue;
            }
            if (thisQIDfound) {
                $('#miniSurveyQuestionRow' + qIDs[i]).after($('#miniSurveyQuestionRow' + thisQID));
                break;
            }
        }
        this.saveOrder();
    },
    serialize: function () {
        var t = document.getElementById("miniSurveyPreviewTable");
        var qIDs = [];
        for (var i = 0; i < t.childNodes.length; i++) {
            if (t.childNodes[i].className && t.childNodes[i].className.indexOf('miniSurveyQuestionRow') >= 0) {
                var qID = t.childNodes[i].id.substr('miniSurveyQuestionRow'.length);
                qIDs.push(qID);
            }
        }
        return qIDs;
    },
    saveOrder: function () {
        var postStr = 'qIDs=' + this.serialize().join(',') + '&qsID=' + parseInt(this.qsID);
        $.ajax({
            type: "POST",
            data: postStr,
            url: this.serviceURL + "mode=reorderQuestions",
            success: function () {
                miniSurvey.refreshSurvey();
            }
        });
    }
};

ccmValidateBlockForm = function () {
    return miniSurvey.validate();
};

$(document).ready(function () {
    // miniSurvey.init();
    /* TODO hackzors, this shouldnt be necessary */
    $('#ccm-block-form').closest('div').addClass('ccm-ui');
});
