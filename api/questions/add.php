<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->title) || !isset($request->textContent) || !isset($request->categories)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$title = htmlspecialchars($request->title);
$textContent = htmlspecialchars($request->textContent);
$postedOn = (new DateTime())->format('Y-m-d H:i:s');
$userId = $request->userId;
$categories = $request->categories;

execute("INSERT INTO `Questions` SET `Title` = ?, `TextContent` = ?, `PostedOn` = ?, `PosterUserId` = ?", [$title, $textContent, $postedOn, $userId]);
$lastQuestionId = lastInsertId();

foreach ($categories as $categoryId) {
    execute("INSERT INTO `QuestionCategories` SET `QuestionId` = ?, `CategoryId` = ?", [$lastQuestionId, $categoryId]);
}
