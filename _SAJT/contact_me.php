<?php
if($_POST)
{
    // $to_email       = "bjnrds@open.telekom.rs";
    $to_email       = "marsovatz@gmail.com";
    $to_email_cc    = "marko@smartweb.rs";
   
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {       
        $output = json_encode(array(
            'type'=>'Greška!',
            'text' => 'Zahtev mora biti u Ajax POST formatu'
        ));
        die($output);
    }
   
    $user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $user_email     = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
    $subject      = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message        = filter_var($_POST["msg"], FILTER_SANITIZE_STRING);
   
    if(strlen($user_name)<4){
        $output = json_encode(array('type'=>'error', 'text' => 'Ime je suviše kratko ili je polje prazno!'));
        die($output);
    }
    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        $output = json_encode(array('type'=>'error', 'text' => 'Molimo unesite validan e-mail!'));
        die($output);
    }
    if(strlen($message)<3){
        $output = json_encode(array('type'=>'error', 'text' => 'Poruka je suviše kratka!'));
        die($output);
    }
   
    $message_body = "\r\nIme i Prezime : ".$user_name."\r\nEmail : ".$user_email."\r\nPredmet : ".$subject."\r\nPoruka : ".$message."\r\n";
   
    $headers .= "\r\n" . 'From: '.$user_name.'' . "\r\n" .
    $headers .= 'Cc: '.$to_email_cc.'' . "\r\n" .
	$subject = 'Kontakt forma sa BЯ consulting';
    $send_mail = mail($to_email, $subject, $message_body, $headers);
   
    if(!$send_mail) {
        $output = json_encode(array('type'=>'error', 'text' => 'Greška pri slanju poruke! Proverite PHP mail konfiguraciju.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Poštovani '.$user_name .', hvala Vam na vašoj poruci.'));
        die($output);
    }
}
?>