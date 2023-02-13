<?php

require '../../helpers/init.php';
require pathOf('./helpers/mailer.php');

allowedMethods(['POST']);
$request = getRequestBody();

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'signup';
if ($mode != 'signup' && $mode != 'forgot-password') {
    http_response_code(400);
    exit();
}

if (!isset($request->email)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$email = $request->email;
if (!validateEmail($email)) {
    http_response_code(400);
    die(json_encode(["message" => "Invalid email!"]));
}

$user = selectOne("SELECT * FROM `Users` WHERE `Email` = ?", [$email]);

if ($mode == 'sigup' && $user != null) {
    http_response_code(409);
    die(json_encode(["message" => "Could not sign up with this email!"]));
} else if ($mode == 'forgot-password' && $user == null) {
    http_response_code(400);
    die(json_encode(["message" => "Could not send OTP!"]));
}

$otp = random_int(111111, 999999);
$generatedOn = (new DateTime())->format('Y-m-d h:i:s');
$expiresOn = ((new DateTime())->add(new DateInterval('PT5M')))->format('Y-m-d h:i:s');

try {
    $subject = 'QApp OTP';
    $body = "Your OTP: $otp";

    sendEmail($email, $subject, $body);
    
    if ($mode == 'signup')
        execute("INSERT INTO `SignUpOTPs` SET `GeneratedOTP` = ?, `GeneratedOn` = ?, `ExpiresOn` = ?, `Email` = ?", [$otp, $generatedOn, $expiresOn, $email]);
    else
        execute("INSERT INTO `ForgotPasswordOTPs` SET `GeneratedOTP` = ?, `GeneratedOn` = ?, `ExpiresOn` = ?, `UserId` = ?", [$otp, $generatedOn, $expiresOn, $user['Id']]);
} catch (Exception $e) {

    http_response_code(500);
    die(json_encode(["message" => "Could not send OTP!"]));
}
