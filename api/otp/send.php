<?php

require '../../helpers/init.php';
require pathOf('./vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mustBeLoggedIn();
$user = getLoggedInUser();
if ($user['IsVerified'] == 1)
{
    http_response_code(401);
    die();
}

$receiverEmail = $user['Email'];

$otp = random_int(111111, 999999);
$generatedOn = (new DateTime())->format('Y-m-d h:i:s');

$smtpHost = "smtp-mail.outlook.com";
$smtpPort = 587;

$senderEmail = "phpwebmaster@outlook.com";
$password = "GoodPassword@123";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $smtpHost;
    $mail->Port = $smtpPort;
    $mail->Username = $senderEmail;
    $mail->Password = $password;

    //Recipients
    $mail->setFrom($senderEmail, 'QApp');
    $mail->addAddress($receiverEmail);

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'QApp OTP';
    $mail->Body    = "Your OTP: $otp";

    $mail->send();

    execute("INSERT INTO `OTP` SET `GeneratedOTP` = ?, `GeneratedOn` = ?, `UserId` = ?", [$otp, $generatedOn, $user['Id']]);
} catch (Exception $e) {

    http_response_code(500);
    die(json_encode(["message" => "Could not send OTP!"]));
}
