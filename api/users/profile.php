<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($name)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$user = getLoggedInUser();
$userId = $user['Id'];

$name = htmlspecialchars($request->name);
$profile = selectOne("SELECT * FROM `Profiles` WHERE UserId = ?", [$userId]);
if ($profile != null)
    execute("UPDATE `Profiles` SET `Name` = ? WHERE `UserId` = ?", [$name, $userId]);
else
    execute("INSERT INTO `Profiles` SET `Name` = ?, `UserId` = ?", [$name, $userId]);
