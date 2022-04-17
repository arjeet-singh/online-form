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
    // Google sign up
    if(isset($_POST["userDatalogin"])){
   
    $userData = json_decode($_POST["userDatalogin"],true);
    $name = $userData["UserName"];
    $id = $userData["userId"];
    $image = $userData["userImage"];
    $mail = $userData["userMail"];
    // $password = $userData["password"];
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
        $response["message"] = "User is logged-in with other device";
      }
    }
   else{
     $newUser = $conn->prepare("INSERT INTO IFORM_USER(USER_ID,USER_NAME,USER_MAIL,USER_IMAGE,SYSTEM_ID,USER_PASSWORD)VALUES(?,?,?,?,?,?)");
     $newUser->bind_param('ssssss',$newuserid,$newusername,$newusermail,$newuserimage,$newsystemid,$newPassword);
     $newuserid = $userId;
     $newusername = $name;
     $newusermail = $mail;
     $newuserimage = $image;
     $newsystemid = $system_id;
     $newPassword = $password;
     
     if($newUser->execute()){
      $response = array("STATUS"=>"success","USER_ID"=>$userId,"SYSTEM_ID"=>$system_id);
     }
     else{
      $response["STATUS"] = "faild";
      $response["message"] = "error";
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
         
    }
  // manual signup
    if(isset($_POST["userSignUp"])){
   
      $userData = json_decode($_POST["userSignUp"],true);
      $name = $userData["UserName"];
      $id = $userData["userId"];
      $image = $userData["userImage"];
      $mail = $userData["userMail"];
      $password = $userData["password"];
      $system_id = createSystemId($mail);
     $userId = $mail;
  
      $checkUserData = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID = '$userId'"));
      $checkUserData1 = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_MAIL = '$mail'"));
      if($checkUserData["USER_ID"] || $checkUserData1["USER_ID"]){
        // $userUpdate = "UPDATE IFORM_USER SET SYSTEM_ID = '$system_id' WHERE USER_ID = '$userId'";
        // if($conn->query($userUpdate)){
        //   $response = array("STATUS"=>"success","USER_ID"=>$userId,"SYSTEM_ID"=>$system_id);
        // }
        // else{
          $response["STATUS"] = "faild";
          $response["message"] = "User already exist";
        // }
      }
     else{
       $newUser = $conn->prepare("INSERT INTO IFORM_USER(USER_ID,USER_NAME,USER_MAIL,USER_IMAGE,SYSTEM_ID,USER_PASSWORD)VALUES(?,?,?,?,?,?)");
       $newUser->bind_param('ssssss',$newuserid,$newusername,$newusermail,$newuserimage,$newsystemid,$newPassword);
       $newuserid = $userId;
       $newusername = $name;
       $newusermail = $mail;
       $newuserimage = $image;
       $newsystemid = $system_id;
       $newPassword = $password;
       
       if($newUser->execute()){
        // $response = array("STATUS"=>"success","USER_ID"=>$userId,"SYSTEM_ID"=>$system_id);
        $response = array("STATUS"=>"success","USER_ID"=>$userId,"USER_NAME"=>$name,"USER_IMAGE"=>$image,"SYSTEM_ID"=>$system_id);
       }
       else{
        $response["STATUS"] = "faild";
        $response["message"] = "User already exist";
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
           
      }


    if(isset($_POST["userDataId"])){
      $userData = json_decode($_POST["userDataId"],true);
      $userId = $userData["userId"];
      $password = $userData["password"];
      $system_id = createSystemId($userId);
      $checkUser = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_MAIL = '$userId' && USER_PASSWORD = '$password'"));
      if($checkUser["USER_ID"]){
        $userId = $checkUser["USER_ID"];
        $userName = $checkUser["USER_NAME"];
        $userImage = $checkUser["USER_IMAGE"]; 
        $userUpdate = "UPDATE IFORM_USER SET SYSTEM_ID = '$system_id' WHERE USER_ID = '$userId'";
        if($conn->query($userUpdate)){
         $response = array("STATUS"=>"success","USER_ID"=>$userId,"USER_NAME"=>$userName,"USER_IMAGE"=>$userImage,"SYSTEM_ID"=>$system_id);
        }
        else{
          $response["STATUS"] = "faild";
          $response["message"] = "User Id or Password is incorrect";
        }
      }
      else{
        $response["STATUS"] = "faild";
        $response["message"] = "User Id or Password is incorrect";
      }
      echo json_encode($response);
    }
 
?>