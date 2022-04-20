<?php
error_reporting(0);
include'../../connection/connection.php';
date_default_timezone_set("Asia/Calcutta");
$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
$time = date("H:i:s");
$response = [];

// Question Update
// if(isset($_POST["heading_Update"])){
     
//     $data = json_decode($_POST["heading_Update"],true);
//     $formid = $data["ID"];
//     $heading = $data["heading"];
//     $response['ID'] = $formid;
//     if($data["o_type"]=='heading'){
//         $stmt = $conn->prepare("UPDATE IFORM_FORM_DATA SET FORM_HEADING = ? WHERE FORM_ID = ?");
//     }
//     else{
//         $stmt = $conn->prepare("UPDATE IFORM_FORM_DATA SET FORM_SUB_HEADING = '$heading' WHERE FORM_ID = '$formid'");
//     }
//         $stmt->bind_param("ss",$newHeading,$updateId);
//         $newHeading = $heading;
//         $updateId = $formid;
//     if($stmt->execute()){
//         $response['STATUS'] = 'SUCCESS';
//         $stmt->close();
//     }
//     else{
//        $response['STATUS'] = 'FAILED';
      
//     }
//     echo json_encode($response);
// }
if(isset($_POST["resubmit_Update"])){
     
    $data = json_decode($_POST["resubmit_Update"],true);
    $formid = $data["ID"];
    $state = $data["resubmit"];
    $response['ID'] = $formid;
    if($conn->query("UPDATE IFORM_FORM_DATA SET RESUBMIT = '$state' WHERE FORM_ID = '$formid'")){
        $response['STATUS'] = 'SUCCESS';
    }
    else{
        $response['STATUS'] = 'FAILED';
    }
    echo json_encode($response);
}
if(isset($_POST["order_Update"])){
     
    $data = json_decode($_POST["order_Update"],true);
    $formid = $data["ID"];
    $state = $data["order"];
    $response['ID'] = $formid;
    if($conn->query("UPDATE IFORM_FORM_DATA SET RANDOM_ORDER = '$state' WHERE FORM_ID = '$formid'")){
        $response['STATUS'] = 'SUCCESS';
    }
    else{
        $response['STATUS'] = 'FAILED';
    }
    echo json_encode($response);
}
if(isset($_POST["editable_Update"])){
     
    $data = json_decode($_POST["editable_Update"],true);
    $formid = $data["ID"];
    $state = $data["editable"];
    $response['ID'] = $formid;
    if($conn->query("UPDATE IFORM_FORM_DATA SET EDITABLE = '$state' WHERE FORM_ID = '$formid'")){
        $response['STATUS'] = 'SUCCESS';
    }
    else{
        $response['STATUS'] = 'FAILED';
    }
    echo json_encode($response);
}
?>