<?php
  
  include'../connection/connection.php';
  if(isset($_COOKIE['userId'])) {
   
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
    <link rel="stylesheet" href="css/forms-data.css?t=33">

   <!-- <script src="js/new_form_main.js"></script> -->
    <script src="js/valid_user_js.js"></script>
    <script src="js/dragdrop.js"></script>
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
    <div class="heading-wrapper"></div>
   <div class="main-container">
       <div class="block-heading">
           <p>Recent Forms</p>
       </div>
       <div class="data-block">
           <?php
           $userMail = $_COOKIE["userId"];
            $form_data = $conn->query("SELECT * FROM IFORM_FORM_DATA WHERE ADMIN = '$userMail'");
            while($userform = $form_data->fetch_assoc()){
              echo  "<a href='../form/?id=".$userform["FORM_ID"]."'><div class='forms-data'>
                        <h2>".$userform["FORM_ID"]."</h2>
                     </div></a>";
            }
            
            ?>
       </div>
   </div>

  <div class="form-tool-section">
      <div class="tools-container">
          <p class="addNewQuestion event-btn noselect">Add <i class="fas fa-plus"></i></p>
      </div>
  </div>
</body>
<script src="../js/userlogin.js"></script>
</html>