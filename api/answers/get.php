<?php

require '../../helpers/init.php';
allowedMethods(['GET']);

if (!isset($_GET['questionId'])) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$questionId = $_GET['questionId'];
$orderBy = $_GET['orderBy'] ?? 'DESC';

$questions = select(
    "SELECT * FROM `Answers` 
        WHERE `IsDeleted` = ? AND `QuestionId` = ?
        ORDER BY `PostedOn` $orderBy      
    ",
    [0, $questionId]
);

jsonResponse($questions);
