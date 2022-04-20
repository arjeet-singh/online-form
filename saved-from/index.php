<?php
  
  include'../connection/connection.php';
  if(isset($_COOKIE['userName'])) {
    $userMail = $_COOKIE["userId"];
    $systemId = $_COOKIE["systemId"];
    $userdatab = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID ='$userMail'"));
    if($userdatab["SYSTEM_ID"] == $systemId){
       // echo "<script> alert('Matched'); </script>";
    }
    else{
        //echo "<script> alert('".$userMail."Not Matched ".$userdatab["SYSTEM_ID"]."');  </script>";
    }
 }
else{
   // echo "<script> alert('Not Matched 2'); </script>"; 
   }
    $form_id = $_GET["id"];
    //    error_log(print_r($form_id));
    $form_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'"));
?>

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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="css/form_style.css?t=32">
    <link rel="stylesheet" href="../css/page_head.css?t=34">
    <link rel="stylesheet" href="css/ajax-loader.css?s=35">
    <link rel="stylesheet" href="../css/form-menu-bar.css?s=24">
    <link rel="stylesheet" href="css/animation.css">

    <script src="js/new_form_main.js"></script>
    <script src="js/valid_user_js.js"></script>
    <script src="js/dragdrop.js"></script>
    <script> 
    let form_id =  '<?php echo $form_id; ?>';
    </script>
    <script src="../js/form-menu-bar.js"> </script>
    <script>
              function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
        console.log('User signed out.');
        });
      }
      $('.log-out-btn').on('click', function(e) {
        signOut();
    });
    </script>
    <style>
        .hold{
              border: solid red 4px;
        }
        .hide{
            display: none;
         }
         .drop-box{
             width: 100%;
             margin: 10px 0px;
             padding: 20px 0px;
             border: 1px dashed red;
         }
    </style>
</head>

<body>
    <?php
       include'../pages/page_head.html';
    ?>
     <div class="form-setting-block">
         <div class="status">
             <p id="formStatus">Saved</p>
         </div>
     </div>
     <div class="menu-btn-container">
     <div class="menu-sub-btn">
         <p><i class="fas menu-btn-sub-bar fa-caret-down"></i></p>
         </div>
     </div>
     <div class="form-menu-bar">
         
     <div class="menu-items">
             <a href="../new_form/saved_form.php">home</a>
        </div>
         <div class="menu-items active-menu-bar">
             <a href="../saved-from/">form</a>
        </div>
        <div class="menu-items">
             <a href="../form/form-view.php">view</a>
        </div>
        <div class="menu-items">
             <a href="../responses/">responses</a>
        </div>
        <div class="menu-items">
             <a href="../form-setting/">settings</a>
        </div>
        <div class="menu-items">

             <a href="https://wa.me/?text=http://www.aapkaman.in/simliFY/updated/iform/form/" target="_blank">Share</a>
        </div>
    </div>        
    <div class="wrapper">
        <div class="heading">
            <input id="heading_<?php echo $form_id; ?>" class="heading-input" type="text" name="heading" value="<?php echo $form_data["FORM_HEADING"]; ?>" placeholder="Heading" required>
            <input id="sub_heading_<?php echo $form_id; ?>" class="sub-heading-input" type="text" name="sub_heading" value="<?php echo $form_data["FORM_SUB_HEADING"]; ?>" placeholder="Sub Heading">
        </div>
        <form id="newForm">
        <div id='<?php echo $form_id; ?>' class='container'>
        <?php
                        if($form_data["ADMIN"]){
                            $question_data = $conn->query("SELECT * FROM IFORM_QUESTIONS_DATA WHERE FORM_ID = '$form_id' ORDER BY QUESTION_NO+0");
                            while($questios = $question_data->fetch_assoc()){
                                $question_no = $questios["SN"];
                                $q_description = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_QUESTION_DESCRIPTION_DATA WHERE QUESTION_NO = '$question_no' ORDER BY SN LIMIT 1"));
                                $required = false;
                                $checked = false;
                                if($questios["IS_REQUIRED"]){
                                    $required = "required";
                                    $checked = "checked";
                                } ?>
                                    <div id='<?php echo $question_no; ?>' class='input-container'  draggable='false'>
                                       <div class='dragable-active'>
                                       <i class='fas fa-grip-horizontal drag-hanger'></i>
                                        </div>
                                        

                                       <div class='q-type-section'>
                                        <div class='lable-input'>
                                           <input class='lable-input-field text-input-field' name='lable_input' value="<?php echo htmlspecialchars($questios["QUESTION"]); ?>" placeholder='Question' required>
                                        </div>
                                        <div class='q-type-edit-section hidden-section-field hidden-section-class'>
                                           <select class='question-type-selection' name='question_type'>
                                               <option class='question-type-options' value='text'<?=$questios["QUESTION_TYPE"]=='text' ? 'selected = "selected"' : ''; ?>>Short Answer</option>
                                               <option class='question-type-options' value='radio'<?=$questios["QUESTION_TYPE"]=='radio' ? 'selected = "selected"' : ''; ?>>Multipal Choice</option>
                                               <option class='question-type-options' value='checkbox'<?=$questios["QUESTION_TYPE"]=='checkbox' ? 'selected = "selected"' : ''; ?>>checkbox</option>
                                               <option class='question-type-options' value='select'<?=$questios["QUESTION_TYPE"]=='select' ? 'selected = "selected"' : ''; ?>>Dropdown</option>
                                               <option class='question-type-options' value='date'<?=$questios["QUESTION_TYPE"]=='date' ? 'selected = "selected"' : ''; ?>>Date</option>
                                               <option class='question-type-options' value='time'<?=$questios["QUESTION_TYPE"]=='time' ? 'selected = "selected"' : ''; ?>>Time</option>
                                               <option class='question-type-options' value='file'<?=$questios["QUESTION_TYPE"]=='file' ? 'selected = "selected"' : ''; ?>>File Upload</option>
                                           </select>
                                        </div>
                                        </div>
                                        <div class='discription-box'>
                                        <?php
                                        if($q_description["SN"]){ ?>

                                            <div id='<?php echo $q_description["SN"]; ?>_discrition' class='discription-field'>
                                            <div class='discription-input-block'>
                                            <input class='discription text-input-field' type='text' value="<?php echo $q_description["DESCRIPTION"]; ?>" placeholder='discription' required>
                                            </div>
                                            <div class='mcq-option-delete-section hidden-section-field'>
                                                <p class='discription-delete-btn noselect question-edit-btn hidden-section-field hidden-section-class'><i class='fas fa-times font-awesome-kit'></i></p>
                                            </div>
                                            </div>

                                      <?php  } ?> 
                                      </div>
                                    <div class='selected-input'>
                                        <div class='client-input-field'>
                                     <?php   if($questios["QUESTION_TYPE"] == 'radio' || $questios["QUESTION_TYPE"] == 'checkbox' || $questios["QUESTION_TYPE"] == 'select'){
                                            $options_value = $conn->query("SELECT * FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$question_no' ORDER BY OPTION_NO+0");
                                            $op_no = 1;
                                            while($questions_options = $options_value->fetch_assoc()){
                                               ?>
                                                          <div  id='<?php echo $questions_options["SN"]; ?>_option' class='mcq-option-container option-container'>
                                                          <div class='input-field-data-section'>
                                                         <?php if($questios["QUESTION_TYPE"] == 'select'){
                                                            echo "<input class='radio-btn-input' type='number' name='option1' value='".$op_no."' disabled>";
                                                          }
                                                          else{
                                                            echo "<input class='radio-btn-input' type='".$questios["QUESTION_TYPE"]."' name='option1' value='' disabled>";
                                                          }
                                                    ?>
                                                <input class='text-input-field mcq-option-value' type='text' name='mcqOptionValue' value="<?php echo $questions_options["OPTION_VALUE"]; ?>" placeholder='Option' required >
                                                </div>
                                                <div class='mcq-option-delete-section'>
                                                <p class='mcq-option-delete-btn noselect question-edit-btn hidden-section-field hidden-section-class'><i class='fas fa-times font-awesome-kit'></i></p>
                                                </div></div>
                                              <?php  $op_no++;
                                             }
                                             ?>
                                                <div class="mcq-add-btn-field">
                                                <p class="mcq-add-btn add-option-btn noselect hidden-section-field event-btn hidden-section-class add-btn">Add Option <i class="fas fa-plus"></i></p>
                                                </div>
                                            <?php
                                        }
                                        else{
                                          echo "<input class='lable-input-field text-input-field' type='".$questios["QUESTION_TYPE"]."' name='ans' placeholder='Answer' disabled>";
                                        } ?>
                                        </div></div>
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
                                <input id="questionRequiredBtn_<?php echo $question_no; ?>" class="required-check question-edit-input" type="checkbox" name="required" value="1" <?php echo $checked; ?>>
                                <label for="questionRequiredBtn_<?php echo $question_no; ?>" class="question-edit-input-label">Required</label>
                            </p>
                        </div>
                        <div class="btn-container">
                        <p class="question-limitation-btn question-edit-btn noselect">
                            <div class="op-container">
                            <label class="opttion-bar-btn"><i class="fas fa-ellipsis-v font-awesome-kit copt-btn"></i></label>
                            <input type="text" class="menubar" value="Menu" readonly>  
                            <div class="menu-options">
                                <?php if($questios["QUESTION_TYPE"] != 'radio' && $questios["QUESTION_TYPE"] != 'checkbox' && $questios["QUESTION_TYPE"] != 'select'){
                                    ?>
                                    <p class="options-val"><input id="validation_` + getIndex + `" type="checkbox" class="tool-check" name="validation" value="Validation"><label for="validation_` + getIndex + `"> Validation</label></p>
                               <?php } ?>
                                    
                                    <p class="options-val"><input id="discription_` + getIndex + `" type="checkbox" class="tool-check" name="discription" value="Discription"><label for="discription_` + getIndex + `"> Discription</label></p>
                                </div>
                            </div>    
                            </p>
                        </div>
                    </div>
                    <div class="add-new-question">
                    <div class="btn-container">
                            <p class="btn add-btn question-add-btn question-edit-btn noselect">
                            <i class="fas fa-plus font-awesome-kit"></i>
                            Add New Question
                            </p>
                        </div>
                    </div>
                </div>
                                       <?php
                            }
                        }
                ?>
                <div class="submit-input-container">
                    <p class="submit-btn-status">Saved</p>
                </div>
            </div>
        </form>

    </div>

  <div class="form-tool-section">
      <div class="tools-container">
          <p class="addNewQuestion event-btn noselect">Add <i class="fas fa-plus"></i></p>
      </div>
  </div>
  <div class="undo-section">
      
  </div>
</body>
<script src="../js/userlogin.js"></script>
</html>