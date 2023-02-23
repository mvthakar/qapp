<?php

require '../../helpers/init.php';
allowedMethods(['POST']);

$request = getRequestBody();
if (!isset($request->otp) || !isset($request->email) || !isset($request->password)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$otp = $request->otp;
$email = $request->email;
$password = $request->password;

if (!validateEmail($email)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Invalid email!"]);
}

$signUpOtp = selectOne("SELECT * FROM `SignUpOTPs` WHERE `Email` = ?", [$email]);
if ($signUpOtp == null || $signUpOtp['GeneratedOTP'] != $otp) {
    http_response_code(403);
    jsonResponseAndDie(["message" => "Wrong or expired OTP!"]);
}

$currentDate = new DateTime();
$expiresOn = DateTime::createFromFormat('Y-m-d H:i:s', $signUpOtp['ExpiresOn']);

if ($currentDate > $expiresOn) {
    execute("DELETE FROM `SignUpOTPs` WHERE `Email` = ?", [$email]);
    
    http_response_code(403);
    jsonResponseAndDie(["message" => "Wrong or expired OTP!"]);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
execute("INSERT INTO `Users` SET `Email` = ?, `PasswordHash` = ?, `UserType` = 'U'", [$email, $passwordHash]);
execute("DELETE FROM `SignUpOTPs` WHERE `Email` = ?", [$email]);

http_response_code(201);
