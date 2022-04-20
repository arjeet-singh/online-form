class QuestionIndex {
    constructor(indexValue) {
        this.indexValue = indexValue;
        this.currentIndex = indexValue;
    }
    getQuestionIndex() {
        return this.indexValue;
    }
}
class Stack {

    // Array is used to implement stack
    constructor() {
        this.items = [];
    }

    // Functions to be implemented
    // push(item)
    push(element) {
            // push element into the items
            this.items.push(element);
        }
        // pop()
    pop() {
            // return top most element in the stack
            // and removes it from the stack
            // Underflow if stack is empty
            if (this.items.length == 0)
                return "Underflow";
            return this.items.pop();
        }
        // Pop Form Front
    shift() {
        if (this.items.length == 0)
            return "Underflow";
        return this.items.shift();
    }
}
let questionIndexvalue = 1;
let currentIndexValue = 1;


$(document).ready(function() {
    // Intialize Undo Stack
    let undoStack = new Stack();
    // Prevent Enter key
    document.addEventListener('keydown', e => {
    //    console.log(e);
       if(e.ctrlKey && e.altKey && e.code === "KeyN"){
           e.preventDefault();
        //    console.log("adding new question");
           increasQuestionIndex();
           var getIndex = questionIndex();
           var currentIndex = getCurrentIndex();
           addQuestioBlock(getIndex,currentIndex);
           $('html, body').animate({
            scrollTop: $("#"+getIndex).offset().top-150
        }, 1);
       }
       if(e.ctrlKey && e.altKey && e.key.toLowerCase() === "b"){
           var currentIndex = getCurrentIndex();
           var preType = $('#' + currentIndex + ' .question-type-selection').val();
        
        if (preType == 'checkbox' || preType == 'radio' || preType == 'select'){
            var currentIndex = getCurrentIndex();
            addOptions(currentIndex);
        }
    }
    if(e.ctrlKey && e.altKey && e.key === "ArrowUp"){
        var currentIndex = getCurrentIndex();
        var prevQ = $('#' + currentIndex).prev().attr('id');
        while(prevQ){
            if($('#'+prevQ).css('display') == 'none'){
                prevQ = $('#' + prevQ).prev().attr('id');
            }
            else{
                break;
            }
        }
        if(prevQ){
            switchQuestion(currentIndex,prevQ)
            $('html, body').animate({
                scrollTop: $("#"+prevQ).offset().top-130
            }, 1);
        }
     
    }
    if(e.ctrlKey && e.altKey && e.key === "ArrowDown"){
        var currentIndex = getCurrentIndex();
        var nextQ = $('#' + currentIndex).next().attr('id');
        while(nextQ){
            if($('#'+nextQ).css('display') == 'none'){
                nextQ = $('#' + nextQ).next().attr('id');
            }
            else{
                break;
            }
        }
        if(nextQ){
            switchQuestion(currentIndex,nextQ)
            $('html, body').animate({
                scrollTop: $("#"+nextQ).offset().top-130
            }, 1);
        }
     
    }
    if(e.ctrlKey && e.altKey && e.key === "Backspace"){
        var currentIndex = getCurrentIndex();
        DelteQuestion(currentIndex);
    }
    });
    $('#newForm').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    // Get Question Index --------------------------------------------------------


    function questionIndex() {
        return questionIndexvalue;
    }
    // Increase Index
    function increasQuestionIndex() {
        questionIndexvalue++;
    }
    // Update Current Index
    function updateCurrentIndex(curr) {
        currentIndexValue = curr;
    }
    // Get Current Index
    function getCurrentIndex() {
        return currentIndexValue;
    }
            // Perform all task before leaving the page
            $(window).blur(function() {

                while(undoStack.items.length > 0){
                    clearTimeout(undoStack.shift());
                }
                      
             });
    // Short Answer ---------------------------------------------------------------
    function addShortAnswerField(currentIndex) {
        $('#' + currentIndex + ' .client-input-field').remove();
        var inputstring = `<div class="client-input-field">
                <input class="text-input-field" type="text" name="shortAnswer" value="" placeholder="Short answer text" required disabled>
                </div>`;
        $('#' + currentIndex + ' .selected-input').append(inputstring);
    }
    // Add MCQ field -----------------------------------------------------------
    function addMcqField(currentIndex) {
        var preType = $('#' + currentIndex + ' .client-input-field input:first-child').attr('type');
        // console.log(preType);
        if (preType != 'checkbox' && preType != 'radio' && preType != 'number') {
            $('#' + currentIndex + ' .client-input-field').remove();
            var inputstring = `<div class="client-input-field">
                                <div class="mcq-option-container option-container">
                                <div class="input-field-data-section">
                                    <input class="radio-btn-input" type="radio" name="option1" value="" disabled>
                                    <input class="text-input-field mcq-option-value current-active-block" type="text" name="mcqOptionValue" placeholder="Option" required >
                                </div>
                                <div class="mcq-option-delete-section">
                                   <p class="mcq-option-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                                 </div>
                                </div>
                                <div class="mcq-add-btn-field">
                                   <p class="mcq-add-btn add-option-btn noselect hidden-section-field event-btn add-btn">Add Option <i class="fas fa-plus"></i></p>
                                </div></div>`;
            //var currentIndex = getCurrentIndex();
            $('#' + currentIndex + ' .selected-input').append(inputstring);
        } else {
            $('#' + currentIndex + ' .input-field-data-section input:first-child').attr('type', 'radio');
        }
    }
    // Add  Options -------------
    function addOptions(currentIndex){
        var countOption = $('#'+currentIndex+' .client-input-field').children().length;
        var preType = $('#' + currentIndex + ' .client-input-field input:first-child').attr('type');
        var addOption = `<div class="mcq-option-container option-container">
                                <div class="input-field-data-section">
                                        <input class="radio-btn-input" type="` + preType + `" name="option1" value="` + countOption + `" disabled>
                                        <input class="text-input-field mcq-option-value current-active-block" type="text" name="mcqOptionValue" placeholder="Option" required >
                                </div>
                                <div class="mcq-option-delete-section">
                                        <p class="mcq-option-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                                </div>
                                </div>`;
                                $('#'+currentIndex+' .client-input-field .mcq-add-btn-field').before(addOption);
        $('#' + currentIndex + ' .client-input-field:last-child input[type=text]').focus();

    }
    $(".container").on('click', '.add-option-btn', function(e) {
        var currentIndex = getCurrentIndex();
        addOptions(currentIndex);
        
        e.stopPropagation();
    });

    // Delete MCQ Options -----------

    $(".container").on('click', '.mcq-option-delete-btn', function(e) {
        var countOption = $(this).parent().closest('.client-input-field').children().length;
        //console.log(countOption);
        if (countOption > 2) {
            // removeQuestion(currentIndex)
            var optionField = $(this).parent().closest('.option-container').remove();
            var currentIndex = getCurrentIndex();
            var qtypeField = $('#' + currentIndex + ' .input-field-data-section input:first-child');

            qtypeField.each(function(index) {
                $(qtypeField[index]).val(index + 1);
            });


        } else {
            //alert('Unsuccessful');
        }
        e.stopPropagation();
    });

    // Add Checkbox Field -------------------------------------------------------
    function addcheckbox(currentIndex) {
        // Get pervious type
        var preType = $('#' + currentIndex + ' .client-input-field input:first-child').attr('type');
        //console.log(preType);
        if (preType != 'checkbox' && preType != 'radio' && preType != 'number') {
            //var currentIndex = getCurrentIndex();
            $('#' + currentIndex + ' .client-input-field').remove();
            var inputstring = `<div class="client-input-field">
                            <div class="checkbox-option-container option-container">
                            <div class="input-field-data-section">
                                 <input class="checkbox-input" type="checkbox" name="option1" value="" disabled>
                                 <input class="text-input-field checkbox-option-value multi-option-value current-active-block" type="text" name="checkboxOptionValue" placeholder="Option" required >
                            </div>
                            <div class="mcq-option-delete-section">
                                <p class="mcq-option-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                            </div>
                            </div>
                            <div class="mcq-add-btn-field">
                                 <p class="checkbox-add-btn add-option-btn noselect hidden-section-field event-btn add-btn">Add Option <i class="fas fa-plus"></i></p>
                            </div>
                            </div>`;

            $('#' + currentIndex + ' .selected-input').append(inputstring);
        } else {
            $('#' + currentIndex + ' .input-field-data-section input:first-child').attr('type', 'checkbox');
        }
        //console.log(currentIndex);
    }
    // Add Drop down field
    function addDropDown(currentIndex) {

        // Get pervious type
        var preType = $('#' + currentIndex + ' .client-input-field input:first-child').attr('type');
        //console.log(preType);
        if (preType != 'checkbox' && preType != 'radio') {
            //var currentIndex = getCurrentIndex();
            $('#' + currentIndex + ' .client-input-field').remove();
            var inputstring = `<div class="client-input-field">
                            <div class="checkbox-option-container option-container">
                            <div class="input-field-data-section">
                                 <input class="checkbox-input" type="number" name="option1" value="1" disabled>
                                 <input class="text-input-field checkbox-option-value multi-option-value current-active-block" type="text" name="checkboxOptionValue" placeholder="Option" required >
                            </div>
                            <div class="mcq-option-delete-section">
                                <p class="mcq-option-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                            </div>
                            </div>
                            <div class="mcq-add-btn-field">
                                 <p class="checkbox-add-btn add-option-btn noselect hidden-section-field event-btn add-btn">Add Option <i class="fas fa-plus"></i></p>
                            </div>
                            </div>`;

            $('#' + currentIndex + ' .selected-input').append(inputstring);
        } else {
            var qtypeField = $('#' + currentIndex + ' .input-field-data-section input:first-child');
            qtypeField.attr('type', 'number');
            qtypeField.each(function(index) {
                $(qtypeField[index]).val(index + 1);
            });

        }
    }
    // Add Date Input Field--------------------------
    function addDateField(currentIndex) {
        $('#' + currentIndex + ' .client-input-field').remove();
        var inputdate = `<div class="client-input-field">
                <input class="text-input-field" type="date" name="date" value="" placeholder="Short answer text" required disabled>
                </div>`;
        $('#' + currentIndex + ' .selected-input').append(inputdate);
    }
    // Add Time Input Field--------------------------
    function addTimeField(currentIndex) {
        $('#' + currentIndex + ' .client-input-field').remove();
        var inputtime = `<div class="client-input-field">
                <input class="text-input-field" type="time" name="time" value="" placeholder="Short answer text" required disabled>
                </div>`;
        $('#' + currentIndex + ' .selected-input').append(inputtime);
    }
    // Add File Upload Field -------------------
    function addFileUploadField(currentIndex) {
        $('#' + currentIndex + ' .client-input-field').remove();
        var inputfile = `<div class="client-input-field">
                <input class="text-input-field" type="file" name="file" value="" placeholder="Short answer text" required disabled>
                </div>`;
        $('#' + currentIndex + ' .selected-input').append(inputfile);
    }
    // Focus on a field ---------------------------
    $('.input-container').on('focus', 'input', function(e) {
        $(this).parent().closest('.input-container').click();
        e.stopPropagation();
    });

    // Select Question Type -----------------------------------------------------------
    $('.container').on('change', '.question-type-selection', function(e) {
        var currentIndex = getCurrentIndex();
        // Switch case for selecting function
        switch (this.value) {
            case "shortAnswer":
                addShortAnswerField(currentIndex);
                addValidationFieldwithMenu(currentIndex)
                break;
            case "radio":
                addMcqField(currentIndex);
                removeValidationFieldwithMenu(currentIndex);
                break;
            case "checkbox":
                addcheckbox(currentIndex);
                removeValidationFieldwithMenu(currentIndex);
                break;
            case "select":
                addDropDown(currentIndex);
                removeValidationFieldwithMenu(currentIndex);
                break;
            case "date":
                addDateField(currentIndex);
                addValidationFieldwithMenu(currentIndex)
                break;
            case "time":
                addTimeField(currentIndex);
                addValidationFieldwithMenu(currentIndex)
                break;
            case "file":
                addFileUploadField(currentIndex);
                addValidationFieldwithMenu(currentIndex)
                break;
        }
        //   e.stopPropagation();
        //   e.stopImmediatePropagation();
    });
    function addQuestioBlock(getIndex,currentIndex){
        var questionString = `<div id="` + getIndex + `" class="input-container"  draggable="false">
        <div class="dragable-active">
            <i class="fas fa-grip-horizontal drag-hanger"></i>
       </div>
        <div class="q-type-section">
              <div class="lable-input">
                 <input class="lable-input-field text-input-field" name="lable_input" value="" placeholder="Question" required>
              </div>
              <div class="q-type-edit-section hidden-section-field hidden-section-class">
                 <select class="question-type-selection" name="question_type">
                     <option class="question-type-options" value="shortAnswer">Short Answer</option>
                     <option class="question-type-options" value="radio">Multipal Choice</option>
                     <option class="question-type-options" value="checkbox">checkbox</option>
                     <option class="question-type-options" value="select">Dropdown</option>
                     <option class="question-type-options" value="date">Date</option>
                     <option class="question-type-options" value="time">Time</option>
                     <option class="question-type-options" value="file">File Upload</option>
                 </select>
              </div>
        </div>
        <div class="discription-box">
           
        </div>
        <div class="selected-input">
            <div class="client-input-field">
                 <input class="text-input-field" type="text" name="shortAnswer" value="" placeholder="Short answer text" required disabled>
            </div>
        </div>
        <div class="input-limitation-field hidden-section-field hidden-section-class">
            
        </div>
        <div class="question-contraions hidden-section-field hidden-section-class">
        <div class="btn-container">
                <p class="question-copy-btn question-edit-btn noselect">
                <i class="far fa-clone font-awesome-kit copt-btn"></i>
                </p>
            </div>
            <div class="btn-container">
                <p class="question-delete-btn question-edit-btn noselect">
                <i class="fas fa-trash-alt font-awesome-kit"></i>
                </p>
            </div>

            <div class="btn-container">
                <p class="question-required-btn question-edit-btn noselect">
                    <input id="questionRequiredBtn_` + getIndex + `" class="required-check question-edit-input" type="checkbox" name="required" value="1">
                    <label for="questionRequiredBtn_` + getIndex + `" class="question-edit-input-label">Required</label>
                </p>
            </div>
            <div class="btn-container">
            <p class="question-limitation-btn question-edit-btn noselect">
                <div class="op-container">
                <label class="opttion-bar-btn"><i class="fas fa-ellipsis-v font-awesome-kit copt-btn"></i></label>
                <input type="text" class="menubar" value="Menu" readonly>  
                <div class="menu-options">
                        <p class="options-val"><input id="validation_` + getIndex + `" type="checkbox" class="tool-check" name="validation" value="Validation"><label for="validation_` + getIndex + `"> Validation</label></p>
                        <p class="options-val"><input id="discription_` + getIndex + `" type="checkbox" class="tool-check" name="discription" value="Discription"><label for="discription_` + getIndex + `"> Discription</label></p>
                    </div>
                </div>    
                </p>
            </div>
        </div>
        <div class="add-new-question">
                    <div class="btn-container">
                            <p class="btn question-add-btn question-edit-btn noselect">
                            <i class="fas fa-plus font-awesome-kit"></i>
                            Add New Question
                            </p>
                        </div>
                    </div>
    </div>`;
$('#' + currentIndex).after(questionString);
$('#' + getIndex).click();
$('#' + getIndex + ' .lable-input-field').focus();
$('html, body').animate({
    scrollTop: $("#"+getIndex).offset().top-200
}, 1);
    }
    // Add New Question ----------------------------------------------------------------------
    $('.addNewQuestion').on('click', function(e) {
        increasQuestionIndex();
        var getIndex = questionIndex();
        // console.log(getIndex);
        var currentIndex = getCurrentIndex();
          
        addQuestioBlock(getIndex,currentIndex);
        e.stopPropagation();
    });
    $('.container').on('click','.question-add-btn',function(){
        increasQuestionIndex();
        var getIndex = questionIndex();
        var currentIndex = $(this).parent().closest('.input-container').attr('id'); //.attr('id', getIndex)
        addQuestioBlock(getIndex,currentIndex);
        e.stopPropagation();
    })
    //

    // Undo Remove 
    $('.undo-section').on('click', '.undo-btn', function(e) {
        var blockid = $(this).attr('id');
        blockid = blockid.replace('undo', '');
        // console.log(blockid);
        $('#' + blockid).fadeIn();
        clearTimeout(undoStack.pop());
        $(this).remove();

        e.stopPropagation();
    });
    // Remove question
    function removeQuestion(currentIndex) {
        var undobtn = `<div id='` + currentIndex + `undo' class='undo-btn noselect'><p>Undo</p><div class='geeks'></div></div>`;
        $('.undo-section').append(undobtn);
        undoStack.push(setTimeout(function() {
            $('#' + currentIndex + 'undo').remove();
            undoStack.shift();
            $('#' + currentIndex).remove();
        }, 10000));
    }
    // Delete Questions ------------------------------------------------------
    function DelteQuestion(currentIndex){
        var countOption = $('.container').children().length;
        //console.log('Child Length : '+countOption);
        if (countOption > 2) {
            
            if ($('#' + currentIndex).prevAll('.input-container').length > 0) {
                // $('#' + currentIndex).prevAll('.input-container:first').click();
                var nextQ = $('#' + currentIndex).prev().attr('id');
                while(nextQ){
                    if($('#'+nextQ).css('display') == 'none'){
                        nextQ = $('#' + nextQ).prev().attr('id');
                    }
                    else{
                        break;
                    }
                }
                $('#' + nextQ).click();

                // $('#' + currentIndex).prev().click();

                $('html, body').animate({
                    scrollTop: $("#"+currentIndex).prev().offset().top-130
                }, 1);
            } else {
                // $('#' + currentIndex).nextAll('.input-container:first').click();
                var nextQ = $('#' + currentIndex).next().attr('id');
                while(nextQ){
                    if($('#'+nextQ).css('display') == 'none'){
                        nextQ = $('#' + nextQ).next().attr('id');
                    }
                    else{
                        break;
                    }
                }
                $('#' + nextQ).click();

                $('html, body').animate({
                    scrollTop: $("#"+currentIndex).next().offset().top-130
                }, 1);
            }
            removeQuestion(currentIndex);
            $('#' + currentIndex).fadeOut();
            
        }
    }
    $('.container').on('click', '.question-delete-btn', function(e) {
        var currentIndex = getCurrentIndex();
        DelteQuestion(currentIndex);
        e.stopPropagation();
    });
    // Current Question Index -------------------------------------------------
    function switchQuestion(currentIndex1,currentIndex){
        $('#' + currentIndex1 + ' .hidden-section-field').addClass('hidden-section-class');
        $('#' + currentIndex1 + ' .text-input-field').removeClass('current-active-block');
        $('#' + currentIndex1).css('border-left', '1px solid teal');
        $('#'+currentIndex).css('border-left', '5px solid teal');
        $('#' + currentIndex + ' .hidden-section-field').removeClass('hidden-section-class');
        $('#' + currentIndex + ' .text-input-field').addClass('current-active-block');
        updateCurrentIndex(currentIndex);
    }
    $(".container").on('click', '.input-container', function(e) {

        var currentIndex1 = getCurrentIndex();
        var currentIndex = $(this).attr('id');
        switchQuestion(currentIndex1,currentIndex)
        e.stopPropagation();
    });
    // Create clone of Question
    $(".container").on('click', '.question-copy-btn', function(e) {
        increasQuestionIndex();
        var getIndex = questionIndex();
        var cloneQ = $(this).parent().closest('.input-container').clone().attr('id', getIndex); //.attr('id', getIndex)
        var currentIndex = getCurrentIndex();
        var questionType = $('#' + currentIndex + ' .question-type-selection').val();
        $('#' + currentIndex).after(cloneQ);
        if ($('#' + currentIndex + ' .tool-check[name="validation"]').prop('checked') == true) {
            var limittype = $('#' + currentIndex + ' .limit-type-option').val();
            $('#' + getIndex + ' .limit-type-option').val(limittype)
            if (limittype == 'Text' || limittype == 'Number') {
                $('#' + getIndex + ' .second-block-limitation select').val($('#' + currentIndex + ' .second-block-limitation select').val())
            }
        }
        $('#' + getIndex).click();
        $('#' + getIndex + ' .question-type-selection').val(questionType);
        e.stopPropagation();
    });
    // Form Submit Event ---------------------
    function changeLocation(formId) {
        console.log('Relocation');
        var page = "http://www.aapkaman.in/simliFY/updated/iform/saved-from/?id=" + formId;
        window.location.replace(page);
    }
    $('#newForm').submit(function() {
        try {
            var formData = {};
            formData['formId'] = $('.container').attr('id');
            formData['Heading'] = $('.heading-input').val();
            formData['SubHeading'] = $('.sub-heading-input').val();
            formData['Questions'] = [];
            $('.input-container').each(function(index) {
                var datablock = $(this).attr('id');

                var lableValue = $('#' + datablock + ' .lable-input-field').val();
                var qTyppe = $('#' + datablock + ' .question-type-selection').val();
                if (qTyppe == 'radio' || qTyppe == 'checkbox' || qTyppe == 'select') {
                    var multiOptionValue = $('#' + datablock + ' .client-input-field input[type=text]');
                    var optionValueContainer = [];
                    // $('#'+datablock+' .client-input-field').each(function( i ) {
                    //     optionValueContainer[i] = $(multiOptionValue[i]).val();
                    // });
                    for (var i = 0; i < ($('#' + datablock + ' .client-input-field').children().length) - 1; i++) {
                        optionValueContainer[i] = $(multiOptionValue[i]).val();
                    }
                }
                var questionSet = {};
                questionSet.question = lableValue;
                questionSet.questionType = qTyppe;
                questionSet.optionValue = optionValueContainer;
                questionSet.required = $('#' + datablock + ' .required-check').prop('checked');
                if ($('#' + datablock + ' .tool-check[name="discription"]').prop('checked') == true) {
                    questionSet.setdiscription = 1;
                    questionSet.discription = $('#' + datablock + ' .discription-box input').val();
                } else {
                    questionSet.setdiscription = 0;
                }
                if ($('#' + datablock + ' .tool-check[name="validation"]').prop('checked') == true) {
                    questionSet.validation = 1;
                    var validationData = {};

                    var validationtype = $('#' + datablock + ' .limit-type-option').val();
                    validationData['type'] = validationtype;
                    if (validationtype == 'Text' || validationtype == 'Number') {
                        var validationIn = $('#' + datablock + ' .second-block-limitation select').val();
                        validationData['typein'] = validationIn;
                        if (validationIn == 'range') {
                            validationData['lowerlimit'] = $('#' + datablock + ' .third-block-limitation input[name="low"]').val();
                            validationData['upperlimit'] = $('#' + datablock + ' .third-block-limitation input[name="high"]').val();
                        } else {
                            validationData['limit'] = $('#' + datablock + ' .third-block-limitation input').val();
                        }
                    } else if (validationtype == 'Expression') {
                        validationData['limit'] = $('#' + datablock + ' .second-block-limitation input').val();
                    }

                    questionSet.validData = validationData;
                } else {
                    questionSet.validation = 0;
                }
                formData['Questions'].push(questionSet);
            });

            // console.log(formData);
            data = JSON.stringify(formData);
            // console.log(data);
            //console.log('Question : '+lableValue+' Question Type : '+qTyppe);
            jQuery.ajax({
                type: "POST",
                url: "ajax/create_new_form.php",
                data: "formData=" + data,
                success: function(result) {

                    // console.log('php response : ' + result);
                    var reponse = jQuery.parseJSON(result);
                    var formId = reponse["formId"];
                    changeLocation(formId);
                    // console.log(reponse);
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

    // Keypress event'#'+getCurrentIndex(),
    //getCurrentIndex();
    // $(document).on('keypress', function(e){ 
    //         if(e.keyCode == 97){
    //             console.log('A key pressed');
    //             if(e.shiftKey){
    //                 console.log('Shift key pressed');
    //                 $('#'+getCurrentIndex()+' .add-option-btn').click();
    //             }
    //         }
    // });
    // $(document).keydown(function(){
    //     console.log('A key down');
    //     $(document).on('keypress', function(e){ 
    //         if(e.keyCode == 97){
    //             console.log('A key pressed');
    //             if(e.shiftKey){
    //                 console.log('Shift key pressed');
    //                 $('#'+getCurrentIndex()+' .add-option-btn').click();
    //             }
    //         }
    // });
    // });
    // Question Options ----- 
    //-------------------------------
    // Add Validation Field
    function addValidationField() {
        var currentIndex = getCurrentIndex();
        var validationString = `<div class="limitaion-container">
                            <div class="limit-container">
                            <div class="limittype limit-container-item">
                                <select class="limit-type-option">
                                    <option value="Text">Normal Text</option>
                                    <option value="Number">Normal Numbers</option>
                                    <option value="mobile">Mobile Number</option>
                                    <option value="mail">mail</option>
                                    <option value="URL">URL</option>
                                    <option value="Expression">Regular Expression</option>
                                </select>
                            </div>
                            <div class='second-block-limitation'>
                            <div class="limitin limit-container-item">
                                            <select class="text-limit-in-type">
                                            <option value="length">Length</option>
                                            <option value="contain">Contain</option>
                                            <option value="nocontain">Doesn't Contain</option>
                                            
                                            </select>
                                            </div>
                            </div>
                            <div class='third-block-limitation'>
                            
                            <div class="limitdata limit-container-item">
                            <input class="valid-rang-input text-input-field" type="number" name="length" value="" placeholder="length" required>
                            </div>
                            </div>
                            </div>
                            <div class="limit-container">
                            <div class="mcq-option-delete-section">
                                <p class="limit-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                            </div>
                            </div>
                        </div>`;
        $('#' + currentIndex + ' .input-limitation-field').append(validationString);
        $('#' + currentIndex + ' .menubar').focus();
    }
    // Change Validation ---------------------------------------

    // Number Validation -------------------------------------------
    // Validation Functions
    // Length
    function numberlengthLimit(currentIndex) {
        var limitrange = `<div class="limitdata limit-container-item">
                                        <input class="valid-rang-input text-input-field" type="number" name="length" value="10" placeholder="length">
                                        </div>`;

        $('#' + currentIndex + ' .third-block-limitation').append(limitrange);
    }
    // Range
    function numberrangeLimit(currentIndex) {
        var limitrange = `<div class="limitdata limit-container-item">
                                       <input class="valid-rang-input text-input-field" type="number" name="low" value="" placeholder="lower limit">
                                        <input class="valid-rang-input text-input-field" type="number" name="high" value="" placeholder="Upper limit">
                                        </div>`;

        $('#' + currentIndex + ' .third-block-limitation').append(limitrange);
    }
    // validation type
    $('.container').on('change', '.number-limit-in-type', function() {
        //console.log($(this).val());
        var currentIndex = getCurrentIndex();
        $('#' + currentIndex + ' .third-block-limitation').children().remove();

        switch ($(this).val()) {
            case 'length':
                numberlengthLimit(currentIndex);
                break;
            case 'size':
                numberlengthLimit(currentIndex);
                break;
            case 'range':
                numberrangeLimit(currentIndex);
                break;
            case 'greater':
                numberlengthLimit(currentIndex);
                break;
            case 'lesser':
                numberlengthLimit(currentIndex);
                break;
        }
    });
    // Change Validation
    //Numbers Validation
    function addNumberLimitField(currentIndex) {
        var textlimitstring = `<div class="limitin limit-container-item">
                                            <select class="number-limit-in-type">
                                            <option value="length">Length</option>
                                            <option value="size">Size</option>
                                            <option value="range">Range</option>
                                            <option value="greater">Greater Than</option>
                                            <option value="lesser">Less Than</option>
                                            </select>
                                            </div>`;
        var limitrange = `<div class="limitdata limit-container-item">
                                        <input class="valid-rang-input text-input-field" type="number" name="length" value="10" placeholder="length">
                                        </div>`;
        $('#' + currentIndex + ' .second-block-limitation').append(textlimitstring);
        $('#' + currentIndex + ' .third-block-limitation').append(limitrange);
    }
    // Text validation 
    // text validation functions
    // Length
    function textlengthLimit(currentIndex) {
        var limitrange = `<div class="limitdata limit-container-item">
                                        <input class="valid-rang-input text-input-field" type="number" name="length" value="10" placeholder="length">
                                        </div>`;

        $('#' + currentIndex + ' .third-block-limitation').append(limitrange);
    }
    // Contain
    function textcontain(currentIndex) {
        var textcontain = `<div class="limitdata limit-container-item">
                                        <input class="validation-input text-input-field" type="text" name="contain" value="">
                                        </div>`;

        $('#' + currentIndex + ' .third-block-limitation').append(textcontain);
    }
    // text validation type
    $('.container').on('change', '.text-limit-in-type', function() {
        //console.log($(this).val());
        var currentIndex = getCurrentIndex();
        $('#' + currentIndex + ' .third-block-limitation').children().remove();

        switch ($(this).val()) {
            case 'length':
                textlengthLimit(currentIndex);
                break;
            case 'contain':
                textcontain(currentIndex);
                break;
            case 'nocontain':
                textcontain(currentIndex);
                break;

        }
    });
    // Add Text Limit Field
    function addtextLimitField(currentIndex) {
        var textlimitstring = `<div class="limitin limit-container-item">
                                            <select class="text-limit-in-type">
                                            <option value="length">Length</option>
                                            <option value="contain">Contain</option>
                                            <option value="nocontain">Doesn't Contain</option>
                                            
                                            </select>
                                            </div>`;
        var limitrange = `<div class="limitdata limit-container-item">
                                        <input class="valid-rang-input text-input-field" type="number" name="length" value="10">
                                        </div>`;
        $('#' + currentIndex + ' .second-block-limitation').append(textlimitstring);
        $('#' + currentIndex + ' .third-block-limitation').append(limitrange);
    }
    // Regular Expression Validation 
    function addExpressionLimitField(currentIndex) {
        var expressionstring = `<div class="limitin limit-container-item">
                                            <input class="validation-input text-input-field" type="text" name="expression" value="" placeholder="Regular Expression">
                                            </div>`;

        $('#' + currentIndex + ' .second-block-limitation').append(expressionstring);

    }
    // Valition Change
    $('.container').on('change', '.limit-type-option', function() {
        //console.log($(this).val());
        var currentIndex = getCurrentIndex();
        $('#' + currentIndex + ' .second-block-limitation').children().remove();
        $('#' + currentIndex + ' .third-block-limitation').children().remove();
        switch ($(this).val()) {
            case 'Text':
                addtextLimitField(currentIndex);
                break;
            case 'Number':
                addNumberLimitField(currentIndex);
                break;
            case 'mobile':
                // addmobileLimitField(currentIndex);
                break;
            case 'mail':
                // addmailLimitField(currentIndex);
                break;
            case 'URL':
                // addURLLimitField(currentIndex);
                break;
            case 'Expression':
                addExpressionLimitField(currentIndex);
                break;
        }
    });
    // Remove Validation field
    function removeValidationField() {
        var currentIndex = getCurrentIndex();
        $('#' + currentIndex + ' .limitaion-container').remove();
        $('#' + currentIndex + ' .menubar').focus();
    }
    // Remove Validation field with Menu
    function removeValidationFieldwithMenu(currentIndex) {
        $('#' + currentIndex + ' .limitaion-container').remove();
        if ($('#' + currentIndex + ' .menu-options .options-val').length > 1) {
            $('#' + currentIndex + ' .menu-options .options-val:first-child').remove();
        }

    }
    // Add Validation field
    function addValidationFieldwithMenu(currentIndex) {
        var optionString = `<p class="options-val"><input type="checkbox" class="tool-check" name="validation" value="Validation"><label> Validation</label></p>`;
        if ($('#' + currentIndex + ' .menu-options .options-val').length < 2) {
            $('#' + currentIndex + ' .menu-options').prepend(optionString);
        }
    }
    // Discription Field
    function addDiscroptionField() {
        var currentIndex = getCurrentIndex();
        var discriptionString = `<div class="discription-field">
                            <div class="discription-input-block">
                            <input class="discription text-input-field current-active-block" type="text" value="" placeholder="discription" required>
                            </div>
                            <div class="mcq-option-delete-section hidden-section-field">
                                <p class="discription-delete-btn noselect question-edit-btn hidden-section-field"><i class="fas fa-times font-awesome-kit"></i></p>
                            </div>
                            </div>`;
        $('#' + currentIndex + ' .discription-box').append(discriptionString);
        $('#' + currentIndex + ' .menubar').focus();
    }
    // Remove Discription Field
    function removeDiscroptionField() {
        var currentIndex = getCurrentIndex();
        $('#' + currentIndex + ' .discription-field').remove();
        $('#' + currentIndex + ' .menubar').focus();
    }

    // Discription
    $('.container').on('click', '.discription-delete-btn', function(e) {
        var currentIndex = getCurrentIndex();
        $(this).parent().closest('.discription-field').remove();
        $('#' + currentIndex + ' .menu-options input[name="discription"]').prop('checked', false);
        e.stopPropagation();
    });
    //-------------------------------------------------------------------  
    // Validation   
    $('.container').on('click', '.limit-delete-btn', function(e) {
        var currentIndex = getCurrentIndex();
        $(this).parent().closest('.limitaion-container').remove();
        $('#' + currentIndex + ' .menu-options input[name="validation"]').prop('checked', false);
        e.stopPropagation();
    });
    $('.container').on('click', '.opttion-bar-btn', function(e) {
        $(this).nextAll('.menubar').focus();
        e.stopPropagation();
    });
    $('.container').on('change', '.tool-check', function(e) {
        if (this.checked) {
            // console.log('Checked '+$(this).val());
            switch ($(this).val()) {
                case 'Validation':
                    addValidationField();
                    break;
                case 'Discription':
                    addDiscroptionField();
                    break;
            }
        } else {
            //console.log('Unchecked '+$(this).val());
            switch ($(this).val()) {
                case 'Validation':
                    removeValidationField();
                    break;
                case 'Discription':
                    removeDiscroptionField();
                    break;
            }
        }
        e.stopPropagation();
    });
});