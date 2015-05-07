<?php

if( isset($_POST) ){
  date_default_timezone_set('US/Eastern');

  $formok = true;

  $errors = array();
  $data = array();

  $dataInput = json_decode(file_get_contents('php://input'));
  
  $formname = $dataInput->name;
  $formcomment = nl2br($dataInput->comment);
  $formemail = $dataInput->email;
  $formphone = $dataInput->phone;
  $formlaw = $dataInput->law;
  
  $data['stuff'] = $dataInput;

  if (empty( $dataInput->formname) ){
    $errors['name'] = 'name is required.';
    $formok = false;
  }
 
  if (empty( $dataInput->formphone) ){
    $errors['phone'] = 'phone is required.';
    $formok = false;
  }

  if (empty( $dataInput->formemail) ){
    $errors['email'] = 'email is required.';
    $formok = false;
  }
 
  if (empty($errors) && $formok) {
    $headers = "From: Marc Reisman <marc@gelmanreisman.com>" . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
 
    $emailbody = "<h1 style='font-size:15px;color:#5b3f44;padding:20px 20px 10px 20px;font-family:sans-serif'>Gelman and Reisman Website Email</h1><h1 style=font-size:16px;padding:20px;background:#5b3f44;color:#fff;font-family:sans-serif;font-weight:300>from: <span style=font-weight:900>{$formname}</span></h1><h2 style='font-weight:300;font-family:sans-serif;text-transform:uppercase;font-size:12px;padding:10px 20px 5px 20px'>return email</h2><p style='font-size:16px;padding:5px 20px 22px 20px;line-height:22px'>{$formemail}</p><p><h2 style='font-weight:300;font-family:sans-serif;text-transform:uppercase;font-size:12px;padding:10px 20px 5px 20px'>return phone number</h2></p><p style='font-size:16px;padding:5px 20px 22px 20px;line-height:22px'>{$formphone}</p><p><h2 style='font-weight:300;font-family:sans-serif;text-transform:uppercase;font-size:12px;padding:10px 20px 5px 20px'>additional comment</h2></p><p style='font-size:16px;padding:5px 20px 22px 20px;line-height:22px'>{$formcomment}</p><h2 style='font-weight:300;font-family:sans-serif;text-transform:uppercase;font-size:12px;padding:10px 20px 5px 20px'>interested law practice</h2><p style='font-size:16px;padding:5px 20px 22px 20px;line-height:22px'>{$formlaw}</p>";
    $emailMessage = "GelmanAndReisman.com Email";

    mail("shaneckel@gmail.com",$emailMessage,$emailbody,$headers);

    $data['success'] = true;
    $data['message'] = 'Your email was sent at '. date("g:i a") . '.';
 
  }else{
    $data['success'] = false;
    $data['errors'] = $errors;
  }

  echo json_encode($data);

}