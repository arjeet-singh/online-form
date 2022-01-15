<?php
  
  include'../connection/connection.php';
  if(isset($_COOKIE['userName'])) {
    $userId = $_COOKIE["userId"];
    $systemId = $_COOKIE["systemId"];
    $userdatab = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID ='$userId'"));
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

    <script src="js/form_main.js"></script>
    <script src="js/form_response.js"></script>
    <script src="js/valid_user_js.js"></script>
    
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
<script>
    let userId = '<?php echo $userId; ?>';
</script>
<script>
    // let question_d = {};
    // <?php
      
    //    $form_id = $_GET["id"];
    // //    error_log(print_r($form_id));
    //    $form_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'"));
    //    if($form_data["ADMIN"]){
    //     $question_data = $conn->query("SELECT * FROM IFORM_QUESTIONS_DATA WHERE FORM_ID = '$form_id'");
    //     while($questios = $question_data->fetch_assoc()){
    //         ?>
    //         var question_set = <?php //echo json_encode($questios); ?>;
            
    //         <?php
    //         $question_no = $questios["QUESTION_NO"];
    //          if($questios["QUESTION_TYPE"] == 'radio' || $questios["QUESTION_TYPE"] == 'checkbox' || $questios["QUESTION_TYPE"] == 'select'){
    //              $options_value = $conn->query("SELECT * FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$question_no'");
    //              ?>
    //                 var option_value = <?php //echo json_encode($options_value,true); ?>;
    //             <?php
    //         }
    //         ?>
    //         var question_data_det = {};
    //         question_data_det.questio = question_set;
    //         question_data_det.option_value = option_value;
    //         question_d["questions"] = question_data_det;
    //         <?php
    //     }
    //    }
    //    else{
    //        echo "<script> alert('Form does not exist'); </script>";
    //    }
       
       
    // ?>
    </script>
    <script>
    //  function addquestions(ques_data){
    //     console.log(ques_data);
    // }
    $(document).ready(function(){
        // addquestions(question_d);
    });
   
</script>

<body>
   <?php include'../pages/page_head.html'; ?>
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
                                        <p class='question-type-flag'>".$questios["QUESTION_TYPE"]."</p>
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
                                                echo "<select class='q_ans select-input-ans'><option disabled selected value> -- select -- </option>";
                                            } 
                                            while($questions_options = $options_value->fetch_assoc()){
                                               
                                                if($questios["QUESTION_TYPE"] == 'select'){
                                                    echo "<option value='".$questions_options["OPTION_VALUE"]."'>".$questions_options["OPTION_VALUE"]."</option>";  
                                                } 
                                                else{
                                                    echo "<div id='".$questions_options["SN"]."' class='checkbox-option-container option-container'>
                                                    <div class='input-field-data-section'>";
                                                    if($questios["QUESTION_TYPE"] == 'checkbox'){
                                                        $option_name = $question_no."checkbox".$questions_options["SN"];
                                                    }
                                                    else{
                                                        $option_name = $question_no."radio";
                                                    }
                                                    echo "<input id='".$question_no."id".$questions_options["SN"]."' class='q_ans checkbox-input multi-option-response' type='".$questios["QUESTION_TYPE"]."' name='".$option_name."' value='".$questions_options["OPTION_VALUE"]."' ".$required." >
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
                    <input id="formSubmitBtn" type="submit" name="submit" value="Save">
                </div>
            </div>
        </form>
    </div>

  
</body>
<script src="../js/userlogin.js"></script>
</html>