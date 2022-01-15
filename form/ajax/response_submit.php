<?php
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
   function createResponseId(){
    $ResponseId = rand(100000,99999999);
    $ResponseId .= time();
    return md5($ResponseId);
}
//  $response = json_decode($_POST["formData"],true);
  $formData = json_decode($_POST["formData"],true);
  $formId = $formData["formId"];
  $responseId = createResponseId();
//   $valid_upto = date('Y-m-d H:i:s', strtotime(+$l_p_date.' month', strtotime($datetime)));
  $response["STATUS"] = 'SUCCESS';
  $response["UserId"] = $user_id;
  $response["formId"] = $formId;
  $submitTime=1;
  $submission = mysqli_fetch_assoc($conn->query("SELECT COUNT(RESPONSE_ID) FROM IFORM_RESPONSES WHERE FORM_ID = '$formId' && USER_ID = '$user_id'"));
  if($submission["COUNT(RESPONSE_ID)"]){
      $submitTime = $submission["COUNT(RESPONSE_ID)"]+1;
  }
  if($formData["Submit_type"] == 'New'){
  
  $createResponse = $conn->prepare("INSERT INTO IFORM_RESPONSES(FORM_ID,USER_ID,RESPONSE_ID,SUBMISSION)VALUES(?,?,?,?)");
  $createResponse->bind_param("sssi",$newformid,$newadmin,$newresponseId,$newsubmitTime);
  $newformid=$formId;
  $newadmin=$user_id;
  $newresponseId = $responseId;
  $newsubmitTime = $submitTime;
  $createResponse->execute();
  $createResponse->close();
  $questions = $formData["Questions"];
  $questionsdata=[];

  //Responses
  $insertResponse = $conn->prepare("INSERT INTO IFORM_RESPONSE_DATA(RESPONSE_ID,QUESTION_NO,RESPONSES)VALUES(?,?,?)");
  $insertResponse->bind_param("sis",$newresponseIds,$newQuestionNo,$newResponses);

   for($i=0; $i<sizeof($questions); $i++){
    $questionsdata[$i]["question"] = $questions[$i]["question"];
    $questionsdata[$i]["optionValue"] = $questions[$i]["optionValue"];
    $newresponseIds = $responseId;
    $newQuestionNo = $questions[$i]["question"];
    $newResponses = json_encode($questions[$i]["optionValue"]);
    $insertResponse->execute();
     
    $questionsdata[$i]['ID'] = $conn->insert_id;
  }
  $insertResponse->close();
 
  $response["questions"] = $questionsdata;
  $response["formId"] = $formId;
  
}
else{
  $response["STATUS"] = "faild";
}
}
echo json_encode($response);

?>