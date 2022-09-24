<?php
if (isset ($_POST['name'])) {
  $to = "otec001369@gmail.com";
  $from = "Cars_project";
  $subject = "Заповнена контактна форма на сайті ".$_SERVER['HTTP_REFERER'];
  $message = "\nYour name: ".$_POST['your_name']."\nLast name: ".$_POST['last_name']."\nAddres line 1: ".$_POST['addres_line1']."\nAddres line 2: ".$_POST['addres_line2']."\nCity: ".$_POST['city']."\nPhone: ".$_POST['phone']."\nZip: ".$_POST['zip']."\nPayment Detalies\nCard Number: ".$_POST['card_number']."\nExpiration: ".$_POST['expiration']."\CVV: ".$_POST['cvv']."\n
 
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"
 
--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit
 
$message";
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'])));
         $filename = $_FILES['fileFF']['name'];
         $filetype = $_FILES['fileFF']['type'];
         $filesize = $_FILES['fileFF']['size'];
         $message.="
  
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
     }
  $message.="
--$boundary--";
 
  if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
    mail($to, $subject, $message, $headers);
    echo $_POST['name'].', Your message has been sent, thank you!';
  } else {
    echo 'Sorry, the letter was not sent. All files are larger than 10MB.';
  }
}
?>