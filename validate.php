<?php
  session_start();
  if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&strtolower($_SESSION["captchaCode"])==strtolower($_POST["captcha"]))
  {
    $status = "<p style='color:#FFFFFF; font-size:20px'>
    <span style='background-color:#46ab4a;'>Votre code captcha est correct.</span></p>"; 
  }else{
    $status = "<p style='color:#FFFFFF; font-size:20px'>
    <span style='background-color:#FF0000;'>Le code captcha entré ne correspond pas! Veuillez réessayer.</span></p>";
  }

  echo $status . " Code original: " . $_SESSION["captchaCode"] . " Captcha entré: " . $_POST["captcha"];

  header('Refresh: 5; URL=index.php');

?>
