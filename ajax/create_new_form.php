<?php
include'../connection/connection.php';
if(isset($_COOKIE['userName'])) {
   echo $_POST["formData"];
}
else{
  $response["STATUS"] = "faild";
  echo json_encode($response);
}
?>