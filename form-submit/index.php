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
    <!-- <script src="js/valid_user_js.js"></script> -->
    
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
         .input-container h2{
             color: teal;
             font-family: Goudy Bookletter 1911, sans-serif;

         }
    </style>
</head>
<script>
    let userId = '<?php echo $userId; ?>';
</script>
<script>
    
  $(document).ready(function(){
    let form_id = '<?php echo $form_id; ?>';
    $('#anotherRe').attr('href',$('#anotherRe').attr('href') + '?id=' +form_id);
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
            <div id='<?php echo $form_id; ?>' class='container'>
                  <div class="input-container">
                      <h2>Successfully submitted !</h2>
                      <br><br>
                      <a id="anotherRe" href="../form/" target="blank"><h4>Submit another response</h4></a>
                      <a id="anotherRe" href="../new_form/" target="blank"><h4>Create your own form</h4></a>
                  </div>      
            </div>
        </form>
    </div>

  
</body>
<!-- <script src="../js/userlogin.js"></script> -->
</html>