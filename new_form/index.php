<?php
  error_reporting(0);
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
    <link rel="stylesheet" href="../css/form-menu-bar.css?s=24">
    <link rel="stylesheet" href="../css/ajax-loader.css?s=35">
    <link rel="stylesheet" href="css/animation.css?st=33">
    <script src="js/new_form_main.js"></script>
    <script src="js/valid_user_js.js"></script>
    <script src="js/dragdrop.js"></script>
    <script> 
    let form_id =  '<?php echo $form_id; ?>';
    </script>
    <script src="../js/form-menu-bar.js"> </script>
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
             <a href="../new_form/">form</a>
        </div>
    </div>   
    <div class="wrapper">
        <div class="heading">
           
            <input class="heading-input" type="text" name="heading" value="Registration Form" placeholder="Heading" required>
            <input class="sub-heading-input" type="text" name="sub_heading" value="Sub-heading" placeholder="Sub Heading">
        </div>
        <form id="newForm">
           
                 
            <div id="0" class="container">
               <div id="1" class="input-container" draggable="false">
                <div class="dragable-active">
                   <i class="fas fa-grip-horizontal drag-hanger"></i>
                </div>    
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
                
       
                <div class="submit-input-container">
                    <input type="submit" class="form-submit-btn" name="submit" value="Save">
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
<script src="../js/ajax-loader.js"></script>
</html>