<?php

require '../../helpers/init.php';

mustBeLoggedIn();
$user = getLoggedInUser();
if ($user['IsVerified'] == 1)
{
    http_response_code(401);
    die();
}

$request = getRequestBody();
$receivedOtp = $request->otp;

$actualOtp = selectOne("SELECT * FROM `OTP` WHERE `UserId` = ?", [$user['Id']]);
if ($actualOtp == null || $receivedOtp != $actualOtp['GeneratedOTP'])
{
    http_response_code(400);
    die(json_encode(["message" => "Wrong OTP!"]));
}

execute("UPDATE `Users` SET `IsVerified` = ? WHERE `Id` = ?", [1, $user['Id']]);
execute("DELETE FROM `OTP` WHERE `UserId` = ?", [$user['Id']]);
