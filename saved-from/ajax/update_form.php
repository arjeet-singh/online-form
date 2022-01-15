<?php
error_reporting(0);
include'../../connection/connection.php';
date_default_timezone_set("Asia/Calcutta");
$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
$time = date("H:i:s");
$response = [];

// Question Update
if(isset($_POST["heading_Update"])){
     
    $data = json_decode($_POST["heading_Update"],true);
    $formid = $data["ID"];
    $heading = $data["heading"];
    $response['ID'] = $formid;
    if($data["o_type"]=='heading'){
        $stmt = $conn->prepare("UPDATE IFORM_FORM_DATA SET FORM_HEADING = ? WHERE FORM_ID = ?");
    }
    else{
        $stmt = $conn->prepare("UPDATE IFORM_FORM_DATA SET FORM_SUB_HEADING = '$heading' WHERE FORM_ID = '$formid'");
    }
        $stmt->bind_param("ss",$newHeading,$updateId);
        $newHeading = $heading;
        $updateId = $formid;
    if($stmt->execute()){
        $response['STATUS'] = 'SUCCESS';
        $stmt->close();
    }
    else{
       $response['STATUS'] = 'FAILED';
      
    }
    echo json_encode($response);
}
// Question Update
 if(isset($_POST["Question_Update"])){
     
     $data = json_decode($_POST["Question_Update"],true);
     $blockid = $data["ID"];
     $question = $data["question_value"];
     $response['BLOCKID'] = $blockid;
     $stmt = $conn->prepare("UPDATE IFORM_QUESTIONS_DATA SET QUESTION = ? WHERE SN = ?");
     $stmt->bind_param("si",$newQuestion,$updateId);
     $newQuestion = $question;
     $updateId = $blockid;
     if($stmt->execute()){
        $stmt->close();
         $response['STATUS'] = 'SUCCESS';
     }
     else{
        $response['STATUS'] = 'FAILED';
       
     }
     echo json_encode($data);
 }
 // Question Type
 if(isset($_POST["Question_Type_Update"])){
    $data = json_decode($_POST["Question_Type_Update"],true);
    $blockid = $data["ID"];
    $question_type = $data["question_type"];
    $response['BLOCKID'] = $blockid;
    $stmt = $conn->prepare("UPDATE IFORM_QUESTIONS_DATA SET QUESTION_TYPE = ? WHERE SN = ?");
    $stmt->bind_param("si",$newQuestionType,$updateId);
    $newQuestionType = $question_type;
    $updateId = $blockid;
    if($stmt->execute()){
        $stmt->close();
         $response['STATUS'] = 'SUCCESS';
     }
     else{
        $response['STATUS'] = 'FAILED';
     }
    echo json_encode($data);
 }
 // MCQ
 if(isset($_POST["Question_Option_Update"])){
    $data = json_decode($_POST["Question_Option_Update"],true);
    $blockid = $data["OptionId"];
    $option_value = $data["option_value"];
    $response['BLOCKID'] = $blockid;
    $stmt = $conn->prepare("UPDATE IFORM_QUESTION_OPTIONS_DATA SET OPTION_VALUE = ? WHERE SN = ?");
    $stmt->bind_param("si",$newOptionValue,$updateId);
    $newOptionValue = $option_value;
    $updateId = $blockid;
    if($stmt->execute()){
        $stmt->close();
         $response['STATUS'] = 'SUCCESS';
     }
     else{
        $response['STATUS'] = 'FAILED';
     }
    echo json_encode($data);
 }
 // MCQ Delete
 if(isset($_POST["Question_Option_delete"])){
    $data = json_decode($_POST["Question_Option_delete"],true);
    $blockid = $data["ID"];
    $optionid = $data["OptionId"];
    $check = $data["check"];

    $response['BLOCKID'] = $blockid;
    if($check){
        $stmt = "DELETE FROM IFORM_QUESTION_OPTIONS_DATA  WHERE QUESTION_NO = '$blockid'";
    }
    else{
        $stmt = "DELETE FROM IFORM_QUESTION_OPTIONS_DATA  WHERE SN = '$optionid'";
    }
    
    if($conn->query($stmt)){
        $response['STATUS'] = 'SUCCESS';
    }
    else{
       $response['STATUS'] = 'FAILED';
      
    }
    echo json_encode($data);
 }
 // Add New Option
 if(isset($_POST["add_new_option"])){
     $question_no = $_POST["add_new_option"];
     $optionS = mysqli_fetch_assoc($conn->query("SELECT OPTION_NO FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$question_no' ORDER BY OPTION_NO DESC LIMIT 1"));
     if($optionS["OPTION_NO"]){
        $option_no = $optionS["OPTION_NO"]+1; 
     }
     else{
        $option_no = 1; 
     }
     
     $option_value = '';
    $stmt = $conn->prepare("INSERT INTO IFORM_QUESTION_OPTIONS_DATA(QUESTION_NO,OPTION_NO,OPTION_VALUE)VALUES(?,?,?)");
    $stmt->bind_param("iis",$updateQno,$updateOno,$newOption);
    $updateQno = $question_no;
    $updateOno = $option_no;
    $newOption = $option_value;
    if($stmt->execute()){
        $response['STATUS'] = 'SUCCESS';
        $response['ID'] = $conn->insert_id;
        $stmt->close();
    }
    else{
        $response['STATUS'] = 'FAILED';
        $response['ID'] = 420;
    }
    // $response['STATUS'] = 'SUCCESS';
    // $response['ID'] = 420;
    echo json_encode($response);
 }
  // Checked
  if(isset($_POST["required_question"])){
    $data = json_decode($_POST["required_question"],true);
    $blockid = $data["ID"];
    $q_status = $data["q_status"];
    $response['BLOCKID'] = $blockid;
    $stmt = $conn->prepare("UPDATE IFORM_QUESTIONS_DATA SET IS_REQUIRED = ? WHERE SN = ?");
    $stmt->bind_param("si",$isRequired,$updateId);
    $isRequired = $q_status;
    $updateId = $blockid;

    if($stmt->execute()){
        $response['STATUS'] = 'SUCCESS';
        $stmt->close();
    }
    else{
       $response['STATUS'] = 'FAILED';
      
    }
    echo json_encode($response);
 }
  // Add Discription
  if(isset($_POST["add_q_discription"])){
    $question_no = $_POST["add_q_discription"];
    $discription_value = '';
   $stmt = $conn->prepare("INSERT INTO IFORM_QUESTION_DESCRIPTION_DATA(QUESTION_NO,DESCRIPTION)VALUES(?,?)");
   $stmt->bind_param("is",$Qno,$newDiscription);
   $Qno = $question_no;
   $newDiscription = $discription_value;

   if($stmt->execute()){
       $response['STATUS'] = 'SUCCESS';
       $response['ID'] = $conn->insert_id;
       $stmt->close();
   }
   else{
       $response['STATUS'] = 'FAILED';
       $response['ID'] = 420;
   }
   // $response['STATUS'] = 'SUCCESS';
   // $response['ID'] = 420;
   echo json_encode($response);
}
 // Add Discription
 if(isset($_POST["discription_Update"])){
    $data = json_decode($_POST["discription_Update"],true);
    $blockid = $data["ID"];
    $discription = $data["discription"];
    $response['ID'] = $blockid;
    $stmt = $conn->prepare("UPDATE IFORM_QUESTION_DESCRIPTION_DATA SET DESCRIPTION = ? WHERE SN = ?");
    $stmt->bind_param("si",$newDiscription,$updateId);
    $newDiscription = $discription;
    $updateId = $blockid;
    if($stmt->execute()){
        $response['STATUS'] = 'SUCCESS';
        $stmt->close();
    }
    else{
       $response['STATUS'] = 'FAILED';
      
    }
    echo json_encode($data);
 }
  // Discription Delete
  if(isset($_POST["discription_delete"])){
    $data = json_decode($_POST["discription_delete"],true);
    $blockid = $data["ID"];
    $check = $data["check"];
    $response['ID'] = $blockid;
    
    $stmt = "DELETE FROM IFORM_QUESTION_DESCRIPTION_DATA  WHERE SN = '$blockid'";
    if($conn->query($stmt)){
        $response['STATUS'] = 'SUCCESS';
    }
    else{
       $response['STATUS'] = 'FAILED';
      
    }
    echo json_encode($response);
 }
 // Add question
   // Add Discription
   if(isset($_POST["add_new_question"])){
    $data = json_decode($_POST["add_new_question"],true);
    $one=1;
    $form_id = $data["ID"];
    $pre_question = $data["pre_question"];
    $question = $data["question"];
    $q_type = $data["q_type"];
    $is_required = $data["required"];
    $o_type = $data["o_type"];
    $responsids = [];
    $questionS = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_QUESTIONS_DATA WHERE SN = '$pre_question'"));
    $question_no = $questionS["QUESTION_NO"]+1; 
    $conn->query("UPDATE IFORM_QUESTIONS_DATA SET QUESTION_NO = QUESTION_NO + '$one' WHERE FORM_ID = '$form_id' AND QUESTION_NO >= '$question_no'");
   $stmt = $conn->prepare("INSERT INTO IFORM_QUESTIONS_DATA(FORM_ID,QUESTION_NO,QUESTION,QUESTION_TYPE,IS_REQUIRED)VALUES(?,?,?,?,?)");
   $stmt->bind_param("sisss",$updateId,$newQuestionNo,$newQuestion,$newQuestionType,$isRequired);
   $updateId = $form_id;
   $newQuestionNo = $question_no;
   $newQuestion = $question;
   $newQuestionType = $q_type;
   $isRequired = $is_required;
   if($stmt->execute()){
       
       $response['STATUS'] = 'SUCCESS';
        $new_id = $conn->insert_id;
        $response['ID'] = $new_id;
       if($o_type == 'clone'){
           $mcq_option = $conn->query("SELECT * FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$pre_question'");
           $insert_op = $conn->prepare("INSERT INTO IFORM_QUESTION_OPTIONS_DATA(QUESTION_NO,OPTION_NO,OPTION_VALUE)VALUES(?,?,?)");
           $insert_op->bind_param("iis",$questionNo,$optionNo,$optionValue);
          $mcqids = [];
           while($option_data = $mcq_option->fetch_assoc()){
              $questionNo = $new_id;
              $optionNo = $option_data["OPTION_NO"];
              $optionValue = $option_data["OPTION_VALUE"];
              $insert_op->execute();
              array_push($mcqids,$conn->insert_id);
           }
        $responsids["mcq_options"] = $mcqids;
        $discription_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_QUESTION_DESCRIPTION_DATA WHERE QUESTION_NO = '$pre_question' ORDER BY SN LIMIT 1"));
        if($discription_data["SN"]){
            $discription = $discription_data["DESCRIPTION"];
            $discr = $conn->prepare("INSERT INTO IFORM_QUESTION_DESCRIPTION_DATA(QUESTION_NO,DESCRIPTION)VALUES(?,?)");
            $discr->bind_param("is",$updateQno,$newDiscription);
            $updateQno = $new_id;
            $newDiscription = $discription;
            $discr->execute();
            $responsids["discription"] = $conn->insert_id;
        }
    }
   }
   else{
       $response['STATUS'] = 'FAILED';
       $response['ID'] = 420;
   }
   // $response['STATUS'] = 'SUCCESS';
   // $response['ID'] = 420;
   $response["responseId"] = $responsids;
   echo json_encode($response);
} 

// Delete Question
if(isset($_POST["question_delete"])){
    $question_no = $_POST["question_delete"];
    $stmt = "DELETE FROM IFORM_QUESTIONS_DATA WHERE SN = '$question_no'";
   if($conn->query($stmt)){
    $conn->query("DELETE FROM IFORM_QUESTION_DESCRIPTION_DATA WHERE QUESTION_NO = '$question_no'");
    $conn->query("DELETE FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO = '$question_no'");
    
       $response['STATUS'] = 'SUCCESS';
       $response['ID'] = $question_no;
   }
   else{
       $response['STATUS'] = 'FAILED';
       $response['ID'] = $question_no;
   }
   // $response['STATUS'] = 'SUCCESS';
   // $response['ID'] = 420;
   echo json_encode($response);
} 
?>