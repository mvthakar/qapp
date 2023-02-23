<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->id) || !isset($request->title) || !isset($request->textContent) || !isset($request->categories)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$id = $request->id;
$title = htmlspecialchars($request->title);
$textContent = htmlspecialchars($request->textContent);

$postedOn = (new DateTime())->format('Y-m-d H:i:s');

$userId = $request->userId;
$categories = $request->categories;

execute("DELETE FROM `QuestionCategories` WHERE `QuestionId` = ?", [$id]);
execute("UPDATE `Questions` SET `Title` = ?, `TextContent` = ? WHERE `Id` = ?", [$title, $textContent, $id]);
foreach ($categories as $categoryId) {
    execute("INSERT INTO `QuestionCategories` SET `QuestionId` = ?, `CategoryId` = ?", [$id, $categoryId]);
}
