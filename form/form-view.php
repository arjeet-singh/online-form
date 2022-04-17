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
    <link rel="stylesheet" href="../css/form-menu-bar.css?s=24">
    <script src="js/form_main.js"></script>
    <script src="js/valid_user_js.js"></script>
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
   <?php include'../pages/page_head.html'; ?>
   <!-- <div class="form-setting-block">
         <div class="status">
             <p id="formStatus">Saved</p>
         </div>
     </div> -->
     <div class="menu-btn-container">
     <div class="menu-sub-btn">
         <p><i class="fas menu-btn-sub-bar fa-caret-down"></i></p>
         </div>
     </div>
     <div class="form-menu-bar">
        <div class="menu-items">
             <a href="../new_form/saved_form.php">home</a>
        </div>
         <div class="menu-items">
             <a href="../saved-from/">form</a>
        </div>
        <div class="menu-items active-menu-bar">
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
           <h2 class="form-heading"><?php echo $form_data["FORM_HEADING"]; ?></h2>
           <h4 class="form-heading"><?php echo $form_data["FORM_SUB_HEADING"]; ?></h4>
           
        </div>
        <form id="newForm">
          
            
                <?php
                        echo "<div id='".$form_id."' class='container'>";
                        if($form_data["ADMIN"]){
                            $question_data = $conn->query("SELECT * FROM IFORM_QUESTIONS_DATA WHERE FORM_ID = '$form_id' ORDER BY QUESTION_NO+0");
                            while($questios = $question_data->fetch_assoc()){
                                $question_no = $questios["SN"];
                                $q_description = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_QUESTION_DESCRIPTION_DATA WHERE QUESTION_NO = '$question_no'"));
                                $required = false;
                                if($questios["IS_REQUIRED"]){
                                    $required = "required";
                                }
                                echo "<div id='".$question_no."' class='input-container'>
                                        
                                        <div class='lable-input'>
                                             <p class='lable-input-field text-input-field'>".$questios["QUESTION"]."</p>
                                        </div>";
                                        if($q_description["DESCRIPTION"]){
                                            echo "<div class='discription-field'>
                                            <div class='discription-input-block'>
                                            <p class='discription'>".$q_description["DESCRIPTION"]."</p>
                                            </div></div>";
                                        }
                                    echo "<div class='selected-input'><div class='client-input-field'>";
                                        if($questios["QUESTION_TYPE"] == 'radio' || $questios["QUESTION_TYPE"] == 'checkbox' || $questios["QUESTION_TYPE"] == 'select'){
                                            $options_value = $conn->query("SELECT * FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$question_no' ORDER BY OPTION_NO+0");
                                            if($questios["QUESTION_TYPE"] == 'select'){
                                                echo "<select class='q_ans'><option disabled selected value> -- select -- </option>";
                                            } 
                                            while($questions_options = $options_value->fetch_assoc()){
                                               
                                                if($questios["QUESTION_TYPE"] == 'select'){
                                                    echo "<option value='".$questions_options["OPTION_VALUE"]."'>".$questions_options["OPTION_VALUE"]."</option>";  
                                                } 
                                                else{
                                                    echo "<div class='checkbox-option-container option-container'>
                                                    <div class='input-field-data-section'>";
                                                    if($questios["QUESTION_TYPE"] == 'checkbox'){
                                                        $option_name = $question_no."checkbox".$questions_options["SN"];
                                                    }
                                                    else{
                                                        $option_name = $question_no."radio";
                                                    }
                                                    echo "<input id='".$question_no."id".$questions_options["SN"]."' class='q_ans checkbox-input' type='".$questios["QUESTION_TYPE"]."' name='".$option_name."' value='".$questions_options["OPTION_VALUE"]."' ".$required." >
                                                           <label for='".$question_no."id".$questions_options["SN"]."' class='text-input-field checkbox-option-value multi-option-value'>".$questions_options["OPTION_VALUE"]."</label>";
                                                echo "</div></div>";
                                                }
                                             }
                                             if($questios["QUESTION_TYPE"] == 'select'){
                                                echo "</select>";
                                            } 
                                        }
                                        else{
                                          echo "<input class='lable-input-field text-input-field ans-input-field' type='".$questios["QUESTION_TYPE"]."' name='ans' placeholder='Answer'>";
                                        }
                                        echo "</div></div>
                                        <div class='question-contraionsn'>
                                        <div class='btn-container'>
                                        <p class='clear-btn noselect'>Clear</p></div></div></div>";
                            }
                        }
                ?>
                <div class="submit-input-container">
                    <input type="submit" name="submit" value="Save" disabled>
                </div>
            </div>
        </form>
    </div>

  <div class="form-tool-section">
      <div class="tools-container">
      <a href="../new_form/"><p class="addNewQuestion event-btn noselect">New Form <i class="fas fa-plus"></i></p></a>
      </div>
  </div>
</body>
<script src="../js/userlogin.js"></script>
</html>