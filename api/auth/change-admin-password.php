<?php

require '../../helpers/init.php';
allowedMethods(['POST']);
$request = mustBeAdmin();

if (!isset($request->oldPassword) || !isset($request->newPassword)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$userId = $request->userId;
$oldPassword = $request->oldPassword;
$newPassword = $request->newPassword;

$user = selectOne("SELECT * FROM `Users` WHERE `Id` = ? AND `UserType` = 'A'", [$userId]);
if ($user == null) {
    http_response_code(401);
    jsonResponseAndDie(["message" => "Error updating password!"]);
}

if (!password_verify($oldPassword, $user['PasswordHash'])) {
    http_response_code(401);
    jsonResponseAndDie(["message" => "Error updating password!"]);
}

$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
execute("UPDATE `Users` SET `PasswordHash` = ? WHERE `Id` = ?", [$newPasswordHash, $userId]);

jsonResponse(["message" => "Password changed successfully!"]);
