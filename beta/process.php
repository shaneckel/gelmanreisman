<?php

if( isset($_POST) ){
  date_default_timezone_set('US/Eastern');

  $formok = true;

  $errors = array();
  $data = array();

  $formname = $_POST['name'];
  $formcomment = nl2br($_POST['comment']);
  $formemail = $_POST['email'];
  $formphone =$_POST['phone'];
  $formlaw = $_POST['law'];

  if (empty( $_POST['name']) ){
    $errors['name'] = 'name is required.';
    $formok = false;
  }
 
  if (empty( $_POST['phone']) ){
    $errors['phone'] = 'phone is required.';
    $formok = false;
  }

  if (empty(  $_POST['email']) ){
    $errors['email'] = 'email is required.';
    $formok = false;
  }
 
  if (empty($errors) && $formok) {
    $headers = "From: G&S Website <donotreply@gelmanreisman.com>" . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
 
    $emailbody = "<h1 style='font-size:16px;color:#5b3f44;padding:20px 20px 10px 0;font-family:sans-serif'>Email from the Gelman and Reisman Website</h1><h1 style=font-size:16px;padding:20px;background:#5b3f44;color:#fff;font-family:sans-serif;font-weight:300>from: <span style=font-weight:800>{$formname}</span></h1><div style=background:#e9edef><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;text-transform:uppercase;font-size:15px;padding:15px 20px 0 20px'>return email</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formemail}</p><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;text-transform:uppercase;font-size:15px;padding:10px 20px 0 20px;border-top:2px solid #5b3f44'>return phone number</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formphone}</p><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;text-transform:uppercase;font-size:15px;padding: 10px 20px 0 20px;border-top:2px solid #5b3f44'>additional comment</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formcomment}</p><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;text-transform:uppercase;font-size:15px;padding:10px 20px 0 20px;border-top:2px solid #5b3f44'>interested law practice</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formlaw}</p></div>";
    $emailMessage = "G&S.com Email From: {$formname}";

    mail("shane@businesscasualarchnemesis.com, shaneckel@gmail.com",$emailMessage,$emailbody,$headers);
    // mail("marc@gelmanreisman.com, bruce@gelmanreisman.com, shaneckel@gmail.com",$emailMessage,$emailbody,$headers);

    $data['success'] = true;
    $data['message'] = 'Thank you. Your email was sent at '. date("g:i a") . '. We will get back to you shortly.';
 
  }else{
    $data['success'] = false;
    $data['errors'] = $errors;
  }

  echo json_encode($data);

}