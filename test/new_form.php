<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="1082811644666-99350d7ukavs0p44n69830h07m27ur2b.apps.googleusercontent.com">
    <title>From</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/480a62ecd0.js" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="css/form_style.css?t=32">
    <link rel="stylesheet" href="css/page_head.css?t=34">

    <script src="js/new_form_main.js"></script>
</head>

<body>
    <?php
       include'page_head.html';
    ?>
    <div class="wrapper">
        <div class="heading">
           
            <input class="heading-input" type="text" name="heading" value="Registration Form" placeholder="Heading" required>
            <input class="sub-heading-input" type="text" name="sub_heading" value="Sub-heading" placeholder="Sub Heading">
        </div>
        <form id="newForm">
            <div class="container">
                <div id="1" class="input-container">
                    <div class="q-type-section">
                          <div class="lable-input">
                             <input class="lable-input-field text-input-field" name="lable_input" value="" placeholder="Question" required>
                          </div>
                          <div class="q-type-edit-section hidden-section-field">
                             <select class="question-type-selection" name="question_type">
                                 <option class="question-type-options" value="shortAnswer">Short Answer</option>
                                 <option class="question-type-options" value="radio">Multipal Choice</option>
                                 <option class="question-type-options" value="checkbox">Checkbox</option>
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
                   <!-- Question Tools -->
                    
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
                                <input class="required-check question-edit-input" type="checkbox" name="required" value="1">
                                <label class="question-edit-input-label">Required</label>
                            </p>
                        </div>
                        <div class="btn-container">
                            <p class="question-limitation-btn question-edit-btn noselect">
                            <div class="op-container">
                            <label class="opttion-bar-btn"><i class="fas fa-ellipsis-v font-awesome-kit copt-btn"></i></label>
                            <input type="text" class="menubar" value="Menu" readonly>  


                                <div class="menu-options">
                                    <p class="options-val"><input type="checkbox" class="tool-check" name="validation" value="Validation"><label> Validation</label></p>
                                    <p class="options-val"><input type="checkbox" class="tool-check" name="discription" value="Discription"><label> Discription</label></p>
                                </div>
                            </div>    
                            </p>
                        </div>
                    </div>
                    
                </div>
            <!----------------CheckBox Field-------------------------------->
     <!--       
            <div class="input-container">
                    <div class="q-type-section">
                          <div class="lable-input">
                             <input class="lable-input-field text-input-field" name="lable_input" value="Name" placeholder="Question" required>
                          </div>
                          <div class="q-type-edit-section">
                             <select class="question-type-selection" name="question_type">
                                 <option class="question-type-options" value="mcq">Multipal Choice</option>
                                 <option class="question-type-options" value="checkbox">checkbox</option>
                             </select>
                          </div>
                    </div>
                    
                    <div class="slected-input">
                    <div class="client-input-field">
                        <div class="checkbox-option-container">
                            <div class="input-field-data-section">
                                 <input class="checkbox-input" type="checkbox" name="option1" value="" disabled>
                                 <input class="text-input-field checkbox-option-value" type="text" name="checkboxOptionValue" placeholder="Option" required >
                            </div>
                            <div class="mcq-option-delete-section">
                                <p class="mcq-option-delete-btn">Delete</p>
                            </div>
                        </div>
                        <div class="mcq-add-btn-field">
                            <p class="checkbox-add-btn">Add Option</p>
                        </div>
                        <div class="mcq-option-container">
                            <input class="radio-btn-input" type="radio" name="option1" value="" disabled>
                            <input class="text-input-field mcq-option-value" type="text" name="mcqOptionValue" placeholder="Option" required >
                        </div>
                    </div>
                    </div>
                    <div class="input-limitation-field">
                        
                    </div>
                    <div class="question-contraions">
                        
                    </div>
                    
                </div>

           
                <div class="input-container">
                    <div class="q-type-section">
                          <div class="lable-input">
                             <input class="lable-input-field text-input-field" name="lable_input" value="Name" placeholder="Question" required>
                          </div>
                          <div class="q-type-edit-section">
                             <select class="question-type-selection" name="question_type">
                                 <option class="question-type-options" value="mcq">Multipal Choice</option>
                                 <option class="question-type-options" value="checkbox">checkbox</option>
                             </select>
                          </div>
                    </div>
                    
                    <div class="slected-input">
                        <div class="mcq-option-container">
                            <div class="input-field-data-section">
                                 <input class="radio-btn-input" type="radio" name="option1" value="" disabled>
                                 <input class="text-input-field mcq-option-value" type="text" name="mcqOptionValue" placeholder="Option" required >
                            </div>
                            <div class="mcq-option-delete-section">
                                <p class="mcq-option-delete-btn">Delete</p>
                            </div>
                        </div>
                        <div class="mcq-add-btn-field">
                            <p class="mcq-add-btn">Add Option</p>
                        </div>
                        <div class="mcq-option-container">
                            <input class="radio-btn-input" type="radio" name="option1" value="" disabled>
                            <input class="text-input-field mcq-option-value" type="text" name="mcqOptionValue" placeholder="Option" required >
                        </div>
                    </div>
                    <div class="input-limitation-field">
                        
                    </div>
                    <div class="question-contraions">
                        <div class="btn-container">
                            <p class="question-delete-btn noselect">
                                Delete
                            </p>
                        </div>
                        
                    </div>
                    
                </div>
    -->
                <div class="submit-input-container">
                    <input type="submit" name="submit" value="Save">
                </div>
            </div>
        </form>
    </div>

  <div class="form-tool-section">
      <div class="tools-container">
          <p class="addNewQuestion event-btn noselect">Add <i class="fas fa-plus"></i></p>
      </div>
  </div>
</body>
<script src="js/userlogin.js"></script>
</html>