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

$user = selectOne("SELECT * FROM `Users` WHERE `Email` = ?", [$email]);
if ($user == null) {
    http_response_code(404);
    jsonResponseAndDie(['message'=> 'User not found!']);
}

$forgotPasswordOtp = selectOne("SELECT * FROM `ForgotPasswordOTPs` WHERE `UserId` = ?", [$user['Id']]);
if ($forgotPasswordOtp == null || $forgotPasswordOtp['GeneratedOTP'] != $otp) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Wrong or expired OTP!"]);
}

$currentDate = new DateTime();
$expiresOn = DateTime::createFromFormat('Y-m-d H:i:s', $forgotPasswordOtp['ExpiresOn']);
if ($currentDate > $expiresOn) {
    execute("DELETE FROM `ForgotPasswordOTPs` WHERE `UserId` = ?", [$user['Id']]);
    
    http_response_code(403);
    jsonResponseAndDie(["message" => "Wrong or expired OTP!"]);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
execute("UPDATE `Users` SET `PasswordHash` = ? WHERE `Id` = ?", [$passwordHash, $user['Id']]);
execute("DELETE FROM `ForgotPasswordOTPs` WHERE `UserId` = ?", [$user['Id']]);
