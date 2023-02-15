<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->id) || !isset($request->textContent)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$id = $request->id;
$userId = $request->userId;
$textContent = htmlspecialchars($request->textContent);

$answer = selectOne("SELECT * FROM Answers WHERE `Id` = ? AND `UserId` = ?", [$id, $userId]);
if ($answer == null) {
    http_response_code(400);
    die();
}

execute("UPDATE `Answers` SET `TextContent` = ? WHERE `Id` = ? AND `UserId` = ?", [$textContent, $id, $userId]);
