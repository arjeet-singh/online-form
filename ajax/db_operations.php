<?php
error_reporting(0);
include'../connection/connection.php';
// Delete Question
$response = [];
if(isset($_POST["delete_form"])){
    $form_id = $_POST["delete_form"];
    $response['ID'] = $form_id;
    $conn->query("DELETE FROM IFORM_QUESTION_DESCRIPTION_DATA WHERE QUESTION_NO IN(SELECT SN FROM IFORM_QUESTIONS_DATA WHERE FORM_ID  = '$form_id')");
    $stmt = "DELETE FROM IFORM_QUESTION_OPTIONS_DATA WHERE QUESTION_NO IN(SELECT SN FROM IFORM_QUESTIONS_DATA WHERE FORM_ID  = '$form_id')";
    // $stmt = "DELETE FROM IFORM_QUESTIONS_DATA WHERE SN = '$question_no'";
   if($conn->query($stmt)){
    $conn->query("DELETE FROM IFORM_QUESTIONS_DATA WHERE FORM_ID = '$form_id'");
    // $conn->query("DELETE FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'");
    if($conn->query("DELETE FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'")){
        $response['STATUS'] = 'SUCCESS';
        $response['ID'] = $form_id;
    }
    else{
        $response['STATUS'] = 'FAILED';
        $response['ID'] = $form_id;
    }
       
   }
   else{
       $response['STATUS'] = 'FAILED';
       $response['ID'] = $form_id;
   }
   // $response['STATUS'] = 'SUCCESS';
   // $response['ID'] = 420;
   echo json_encode($response);
} 
?>