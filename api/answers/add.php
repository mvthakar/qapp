<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->textContent) || !isset($request->questionId)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$questionId = $request->questionId;
$question = selectOne("SELECT * FROM `Questions` WHERE Id = ? AND `IsDeleted` = 0", [$questionId]);
if ($question == null) {
    http_response_code(400);
    die(json_encode(["message" => "Question doesn't exist!"]));
}

$textContent = htmlspecialchars($request->textContent);
$postedOn = (new DateTime())->format('Y-m-d H:i:s');
$userId = $request->userId;

execute("INSERT INTO `Answers` SET `TextContent` = ?, `PostedOn` = ?, `UserId` = ?, `QuestionId` = ?", [$textContent, $postedOn, $userId, $questionId]);
