<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
mustBeLoggedIn();

$request = getRequestBody();

if (!isset($request->name)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$user = getLoggedInUser();
$userId = $user['Id'];

$profile = selectOne("SELECT * FROM `Profiles` WHERE UserId = ?", [$userId]);
if ($profile != null)
    execute("UPDATE `Profiles` SET `Name` = ? WHERE `UserId` = ?", [$request->name, $userId]);
else
    execute("INSERT INTO `Profiles` SET `Name` = ?, `UserId` = ?", [$request->name, $userId]);
