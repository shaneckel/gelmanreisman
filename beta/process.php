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
    $headers = "From: gelmanreisman.com <donotreply@gelmanreisman.com>" . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $emailbody = "<h1 style='font-size:16px;color:#5b3f44;padding:20px 20px 10px 0;font-family:sans-serif'>Email from the Gelman and Reisman Website</h1><h1 style='font-size:16px;padding:20px;background:#5b3f44;color:#ffffff;font-family:sans-serif;font-weight:300;margin-bottom:0;'>From: <span style='font-weight:800;'>{$formname}</span></h1><div style='background:#e9edef;'><h2 style='color:#57595a;margin-top:0;font-weight:800;font-family:sans-serif;font-size:15px;padding:15px 20px 0 20px;'>RETURN EMAIL</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formemail}</p><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;font-size:15px;padding:10px 20px 0 20px;border-top:2px solid #ffffff;'>RETURN PHONE NUMBER</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formphone}</p>";
    $emailbody .= "<h2 style='color:#57595a;font-weight:800;font-family:sans-serif;font-size:15px;padding:10px 20px 0 20px;border-top:2px solid #ffffff;'>ADDITIONAL COMMENT</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formcomment}</p><h2 style='color:#57595a;font-weight:800;font-family:sans-serif;font-size:15px;padding:10px 20px 0 20px;border-top:2px solid #ffffff;'>INTERESTED LAW PRACTICE</h2><p style='font-size:16px;font-family:sans-serif;padding:0 20px 22px 20px;line-height:22px'>{$formlaw}</p></div>";
    $emailMessage = "From {$formname}, regarding {$formlaw}.";

    // mail("marc@gelmanreisman.com, bruce@gelmanreisman.com, shaneckel@gmail.com",$emailMessage,$emailbody,$headers);
    mail("shaneckel@gmail.com",$emailMessage,$emailbody,$headers);

    $data['success'] = true;
    $data['message'] = 'Thank you. Your email was sent at '. date("g:i a") . '. We will get back to you shortly.';
 
  }else{
    $data['success'] = false;
    $data['errors'] = $errors;
  }

  echo json_encode($data);

}