<?php
error_reporting(0);

include'../../connection/connection.php';
date_default_timezone_set("Asia/Calcutta");
$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
$time = date("H:i:s");
$l_p_date = 2;
$user_id = $_COOKIE['userId'];
$user_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID = '$user_id'"));
$user_id = $user_data["USER_ID"];
if($user_id) {
   function createFormId(){
    $formId = rand(100000,99999999);
    $formId .= time();
    return md5($formId);
   }
//  $response = json_decode($_POST["formData"],true);
  $formData = json_decode($_POST["formData"],true);
  $formId = $formData["formId"];
  $Heading = $formData["Heading"];
  $subHeading = $formData["SubHeading"];
  $formId = createFormId();
  $valid_upto = date('Y-m-d H:i:s', strtotime(+$l_p_date.' month', strtotime($datetime)));
  
  $response["UserId"] = $user_id;
  $response["formId"] = $formId;
  $response["Heading"] = $Heading;
  $response["SubHeading"] = $subHeading;
  $response["ValidFrom"] = $datetime;
  $response["ValidUpto"] = $valid_upto;
  $response["Access"] = 0;
  $response["Admin"] = $user_id;
  $createForm = $conn->prepare("INSERT INTO IFORM_FORM_DATA(FORM_ID,ADMIN,VALID_FROM,VALID_UPTO,FORM_HEADING,FORM_SUB_HEADING)VALUES(?,?,?,?,?,?)");
  $createForm->bind_param("ssssss",$newformid,$newadmin,$newvalidfrom,$newvalidupto,$formHeading,$formSubHeading);
  $newformid=$formId;
  $newadmin=$user_id;
  $newvalidfrom=$datetime;
  $newvalidupto=$valid_upto;
  $formHeading = $Heading;
  $formSubHeading = $subHeading;
  $createForm->execute();
  $createForm->close();
  $questions = $formData["Questions"];
  $questionsdata=[];

  //Question
  $insertQuestion = $conn->prepare("INSERT INTO IFORM_QUESTIONS_DATA(FORM_ID,QUESTION_NO,QUESTION,QUESTION_TYPE,IS_REQUIRED)VALUES(?,?,?,?,?)");
  $insertQuestion->bind_param("sisss",$questionformd,$newQuestionNo,$newquestion,$newquestiontype,$newquestionrequired);

  // Description
  $QuestionDescription = $conn->prepare("INSERT INTO IFORM_QUESTION_DESCRIPTION_DATA(QUESTION_NO,DESCRIPTION)VALUES(?,?)");
  $QuestionDescription->bind_param("is",$desquestionno,$descriptionvalue);

  // Validation
  $QuestionValidation = $conn->prepare("INSERT INTO IFORM_QUESTION_VALIDATION_TYPE(QUESTION_NO,VALIDATION_TYPE)VALUES(?,?)");
  $QuestionValidation->bind_param("is",$validationquestionno,$validationtype);

  //MCQ Options
  $QuestionOptions = $conn->prepare("INSERT INTO IFORM_QUESTION_OPTIONS_DATA(QUESTION_NO,OPTION_NO,OPTION_VALUE)VALUES(?,?,?)");
  $QuestionOptions->bind_param("iis",$questionno,$optionNo,$newoptionvalue);
  for($i=0; $i<sizeof($questions); $i++){
    $questionsdata[$i]["question"] = $questions[$i]["question"];
    $questionsdata[$i]["required"] = $questions[$i]["required"];
    $newQuestionNo = $i+1;
    $formquestion = $questions[$i]["question"];
    $questionRequired = $questions[$i]["required"];
    $questiontype = $questions[$i]["questionType"];
    $questionformd = $formId;
    $newquestion = $formquestion;
    $newquestiontype = $questiontype;
    $newquestionrequired = $questionRequired;
    $insertQuestion->execute();
    $last_id = $conn->insert_id;

    // Insert Description 
    if($questions[$i]["setdiscription"]){
      $desquestionno = $last_id;
      $descriptionvalue = $formquestion = $questions[$i]["discription"];
      $QuestionDescription->execute();
    }
    
   // MCQ
    if($questions[$i]["questionType"] == "radio" || $questions[$i]["questionType"] == "checkbox" || $questions[$i]["questionType"] == "select"){
      //$optionvalue = $questions[$i]["optionValue"];
      // for($j=0; $j<sizeof($questions[$i]["optionValue"]); $j++){
        $opNo = 1;
        foreach($questions[$i]["optionValue"] as $optionkey => $optionvalue){
        // $questionsdata[$i]["options"][$j] = $optionvalue[$j];
        $questionno = $last_id;
        $optionNo = $opNo;
        $newoptionvalue = $optionvalue;
        $QuestionOptions->execute();
        $opNo++;
      }
    }
    else if($questions[$i]["validation"]){
      $validationquestionno = $last_id;
      $validationtype = 
      $QuestionValidation->execute();
    }
  }
  $insertQuestion->close();
  $QuestionDescription->close();
  $QuestionOptions->close();
  $QuestionValidation->close();
  $response["questions"] = $questionsdata;
  $response["formId"] = $formId;
  
}
else{
  $response["STATUS"] = "faild";
}

echo json_encode($response);

?>