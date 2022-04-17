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
    <link rel="stylesheet" href="../css/page_head.css?t=36">
    <link rel="stylesheet" href="css/forms-data.css?t=33">
    <link rel="stylesheet" href="../css/form-menu-bar.css?s=24">
   <!-- <script src="js/new_form_main.js"></script> -->
    <script src="js/valid_user_js.js"></script>
    <script src="js/dragdrop.js"></script>
    <script src="js/form-data.js"> </script>
    <script> 
    let form_id =  '';
    </script>
    <script src="../js/form-menu-bar.js"> </script>
    <script>
  
    //  $(document).ready(function(){
      
    // });
   
     
    </script>
    <style>
      .questions{
        font-size: 10px;
      }
    </style>
</head>

<body>
    <?php
       include'../pages/page_head.html';
    ?>
        <div class="menu-btn-container">
     <div class="menu-sub-btn">
         <p><i class="fas menu-btn-sub-bar fa-caret-down"></i></p>
         </div>
     </div>
    <div class="form-menu-bar">
     <div class="menu-items active-menu-bar">
             <a href="../home/">home</a>
        </div>
        
    </div>  
    <div class="heading-wrapper"></div>

    <div class="main-container">
       <div class="block-heading">
           <p>New Forms</p>
       </div>
       <div class="data-block mew-form-data-block">
          <a href='../new_form/'><div class='forms-data new-form-temp'>
                        <h2>New Form</h2>
                        <div class="form-sub-block">
                          <h1><i class="fas add-new-form-btn fa-plus"></i></h1>
                        </div>
                        </div>  </a>
                            
        
       </div>
   </div>
   <div class="main-container">
       <div class="block-heading">
           <p>Recent Forms</p>
       </div>
       <div class="data-block">
           <?php
           $userMail = $_COOKIE["userId"];
            $form_data = $conn->query("SELECT * FROM IFORM_FORM_DATA WHERE ADMIN = '$userMail' ORDER BY C_DATE DESC");
            while($userform = $form_data->fetch_assoc()){
              $FORMid = $userform["FORM_ID"];
              $question = $conn->query("SELECT * FROM IFORM_QUESTIONS_DATA WHERE FORM_ID = '$FORMid' ORDER BY QUESTION_NO LIMIT 2");
              echo  "
                    <div id='".$userform["FORM_ID"]."' class='forms-data form-data-block-con'>"; ?>
                    <div class='form-option-container'>
                    <p class='option-item'><i class='fas block-delete-btn fa-trash-alt'></i></p>
                    <a href="https://wa.me/?text=http://www.aapkaman.in/simliFY/updated/iform/form/?id=<?php echo $userform["FORM_ID"]; ?>" target="_blank"><p class='option-item'><i class='fas fa-share-alt'></i></p></a>
                    </div>
                     <?php  echo "<a class='form-link' href='../saved-from/?id=".$userform["FORM_ID"]."'>
                     <div class='form-sub-block'><h2>".$userform["FORM_HEADING"]."</h2>
                        <h6>".$userform["FORM_SUB_HEADING"]."</h6><hr>";
                 while($questions = $question->fetch_assoc()){
                     echo "<p class='questions'>".$questions["QUESTION"]."</p>";
                 }
                     echo "</div></a>
                    </div>";
            }
            
            ?>
       </div>
   </div>

  <div class="form-tool-section">
      <div class="tools-container">
      <a href='../new_form/'><p class="addNewQuestion event-btn noselect">New <i class="fas fa-plus"></i></p></a>
      </div>
  </div>
  <div class="undo-section">
      
      </div>
</body>
<script src="../js/userlogin.js"></script>
<script src="js/form-data.js"> </script>
</html>