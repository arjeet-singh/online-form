<?php
error_reporting(0);

include'../../connection/connection.php';
  //  class UserData {
  //      public $userName;
  //      public $userId;
  //      public $userImage;
  //      public $userMail;
  //      function __construct($userId,$userName,$userImage,$userMail)
  //      {
  //        $this->userId = $userId;
  //        $this->userName = $userName;
  //        $this->userImage = $userImage;
  //        $this->userMail = $userMail;  
  //      }
  //  }
    function makeId($id,$mail){
      $userid = $id % 10000000;
      $userid .= $mail;
      return $userid;
    }
    function createSystemId($mail){
      $systemId = rand(1000000,999999999);
      $systemId .= $mail;
      return $systemId;
    }
    $userData = json_decode($_POST["userDatalogin"],true);
    $name = $userData["UserName"];
    $id = $userData["userId"];
    $image = $userData["userImage"];
    $mail = $userData["userMail"];
    $system_id = createSystemId($mail);
   $userId = makeId($id,$mail);

    $checkUserData = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID = '$userId'"));
    if($checkUserData["USER_ID"]){
      $userUpdate = "UPDATE IFORM_USER SET SYSTEM_ID = '$system_id' WHERE USER_ID = '$userId'";
      if($conn->query($userUpdate)){
        $response = array("STATUS"=>"success","USER_ID"=>$userId,"SYSTEM_ID"=>$system_id);
      }
      else{
        $response["STATUS"] = "faild";
      }
    }
   else{
     $newUser = $conn->prepare("INSERT INTO IFORM_USER(USER_ID,USER_NAME,USER_MAIL,USER_IMAGE,SYSTEM_ID)VALUES(?,?,?,?,?)");
     $newUser->bind_param('sssss',$newuserid,$newusername,$newusermail,$newuserimage,$newsystemid);
     $newuserid = $userId;
     $newusername = $name;
     $newusermail = $mail;
     $newuserimage = $image;
     $newsystemid = $system_id;
     
     if($newUser->execute()){
      $response = array("STATUS"=>"success","USER_ID"=>$userId,"SYSTEM_ID"=>$system_id);
     }
     else{
      $response["STATUS"] = "faild";
     }
     $newUser->close();
   }
  //   // $response = new UserData($id,$name,$image,$mail);
  // //  echo json_encode($response);
  //     if($name == "Arjeet Singh"){
  //         // $response = new UserData($id,$name,$image,$mail);
  //        $response = array("STATUS"=>"success");
  //     }
  //     else{
  //       $response["STATUS"] = "faild";
  //     }
      echo json_encode($response);
 
?>