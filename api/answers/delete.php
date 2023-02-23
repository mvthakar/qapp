<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->id)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$id = $request->id;
$userId = $request->userId;

$answer = selectOne("SELECT * FROM Answers WHERE `Id` = ? AND `UserId` = ?", [$id, $userId]);
if ($answer == null) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Answer does not exist!"]);
}
    
execute("UPDATE `Answers` SET `IsDeleted` = ? WHERE `Id` = ?", [1, $id]);
