<?php

require '../../helpers/init.php';
require pathOf('./helpers/mailer.php');

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

try {

    $subject = 'QApp OTP';
    $body = "Your OTP: $otp";

    sendEmail($receiverEmail, $subject, $body);
    execute("INSERT INTO `OTP` SET `GeneratedOTP` = ?, `GeneratedOn` = ?, `UserId` = ?", [$otp, $generatedOn, $user['Id']]);

} catch (Exception $e) {

    http_response_code(500);
    die(json_encode(["message" => "Could not send OTP!"]));
}
