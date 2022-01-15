$(document).ready(function() {
    function formAfterSubmission(formId) {
        var page = "../form-submit/?id=" + formId;
        window.location.replace(page);
    }
    // Form Submit Event ---------------------
    $('#newForm').submit(function() {
        $('#formSubmitBtn').prop('disabled', false);
        try {
            var formData = {};
            // formData['UserId'] = UserId;
            // console.log('UserId:' + UserId);
            formData['formId'] = $('.container').attr('id');
            formData['Submit_type'] = 'New';
            formData['Questions'] = [];

            $('.input-container').each(function(index) {
                var datablock = $(this).attr('id');
                var qTyppe = $('#' + datablock + ' .question-type-flag').html();
                console.log(qTyppe);
                if (qTyppe == 'radio' || qTyppe == 'checkbox' || qTyppe == 'select') {
                    // var multiOptionValue = $('#' + datablock + ' .client-input-field input[type=text]');
                    var optionValueContainer = {};
                    if (qTyppe == 'select') {
                        optionValueContainer[$('#' + datablock + ' .client-input-field .multi-option-response').val()] = $('#' + datablock + ' .client-input-field .multi-option-response').html();
                    } else {
                        $('#' + datablock + ' .client-input-field .multi-option-response:checked').each(function(index) {
                            console.log('ID' + $(this).val());
                            // if ($(this).children().closest('.multi-option-response:checked').val()) {
                            optionValueContainer[$(this).parent().closest('.checkbox-option-container').attr('id')] = $(this).val();
                            // }
                            // optionValueContainer[i] = $(multiOptionValue[i]).val();
                        });
                    }
                } else {
                    var optionValueContainer = {};
                    optionValueContainer['ans'] = $('#' + datablock + ' .client-input-field input').val();
                }
                var questionSet = {};
                questionSet.question = datablock;
                questionSet.questionType = qTyppe;
                questionSet.optionValue = optionValueContainer;

                formData['Questions'].push(questionSet);
            });

            console.log(formData);
            data = JSON.stringify(formData);
            // console.log(data);

            jQuery.ajax({
                type: "POST",
                url: "ajax/response_submit.php",
                data: "formData=" + data,
                success: function(result) {

                    // console.log('php response : ' + result);
                    var reponse = jQuery.parseJSON(result);
                    if (reponse["STATUS"] == "SUCCESS") {
                        formAfterSubmission(reponse["formId"]);
                    }
                    console.log(reponse);
                },
                error: function(errorData) {
                    console.log(errorData);
                }
            });
        } catch (err) {
            console.log(err.message);
        }
        return false;
    });

});