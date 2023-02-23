<?php

require '../../helpers/init.php';
allowedMethods(['GET']);

$search = $_GET['search'] ?? null;
$searchQuery = $search != null ? "AND `Title` LIKE '%$search%'" : '';
$orderBy = $_GET['orderBy'] ?? 'DESC';
$by = $_GET['by'] ?? '';

switch ($by) {
    case 'user':
        getQuestionsByUser();
        break;  
    case 'category':
        getQuestionsByCategory();
        break;
    case 'answers':
        getQuestionsByNumberOfAnswers();
        break;
    default:
        getQuestionsByTime();
        break;
}

function getQuestionsByTime()
{
    global $searchQuery, $orderBy;
    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `Questions` 
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `IsDeleted` = 0 $searchQuery
            ORDER BY `PostedOn` $orderBy
        "
    );

    for ($i = 0; $i < count($questions); $i++) {

        $questionCategories = select(
            "SELECT `Categories`.`Id`, `Categories`.`Name` 
                FROM `QuestionCategories`
                INNER JOIN `Categories` ON `QuestionCategories`.`CategoryId` = `Categories`.`Id` 
                WHERE `QuestionId` = ?",
            [$questions[$i]['Id']]
        );

        $questions[$i]["categories"] = $questionCategories;
    }

    jsonResponse($questions);
}

function getQuestionsByCategory()
{
    global $searchQuery, $orderBy;

    if (!isset($_GET['categoryId'])) {
        http_response_code(400);
        jsonResponseAndDie(['message' => 'Category is required']);
    }

    $categoryId = $_GET['categoryId'];
    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `QuestionCategories`
            INNER JOIN `Questions` ON `QuestionCategories`.`Questionid` = `Questions`.`Id`
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `CategoryId` = ? AND `Questions`.`IsDeleted` = 0 $searchQuery
            ORDER BY `PostedOn` $orderBy",
        [$categoryId]
    );

    jsonResponse($questions);
}

function getQuestionsByUser()
{
    global $searchQuery, $orderBy;

    if (!isset($_GET['userId'])) {
        http_response_code(400);
        jsonResponseAndDie(['message' => 'User is required']);
    }

    $userId = $_GET['userId'];
    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `Questions` 
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `IsDeleted` = 0 AND `PosterUserId` = ? $searchQuery
            ORDER BY `PostedOn` $orderBy
        ",
        [$userId]
    );

    for ($i = 0; $i < count($questions); $i++) {

        $questionCategories = select(
            "SELECT `Categories`.`Id`, `Categories`.`Name` 
                FROM `QuestionCategories`
                INNER JOIN `Categories` ON `QuestionCategories`.`CategoryId` = `Categories`.`Id` 
                WHERE `QuestionId` = ?",
            [$questions[$i]['Id']]
        );

        $questions[$i]["categories"] = $questionCategories;
    }

    jsonResponse($questions);
}

function getQuestionsByNumberOfAnswers()
{
    global $searchQuery, $orderBy;

    $questions = select(
        "SELECT 
            `Questions`.`Id`, 
            `Title`, 
            `Questions`.`PostedOn`, 
            `Profiles`.`Name` AS `PosterUserName`, 
            (SELECT COUNT(*) FROM `Answers` WHERE `QuestionId` = `Questions`.`Id`) AS `NumberOfAnswers`
        FROM `Questions`
        INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
        WHERE `IsDeleted` = 0 $searchQuery
        ORDER BY `NumberOfAnswers` $orderBy
    ");

    jsonResponse($questions);
}
