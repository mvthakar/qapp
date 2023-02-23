<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->id) || !isset($request->textContent)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$id = $request->id;
$userId = $request->userId;
$textContent = htmlspecialchars($request->textContent);

$answer = selectOne("SELECT * FROM Answers WHERE `Id` = ? AND `UserId` = ?", [$id, $userId]);
if ($answer == null) {
    http_response_code(400);
    jsonResponseAndDie(['message' => 'Answer does not exist!']);
}

execute("UPDATE `Answers` SET `TextContent` = ? WHERE `Id` = ? AND `UserId` = ?", [$textContent, $id, $userId]);
