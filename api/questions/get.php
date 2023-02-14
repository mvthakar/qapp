<?php

require '../../helpers/init.php';
allowedMethods(['GET']);

function getRecentQuestions()
{
    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `Questions` 
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `IsDeleted` = 0 
            ORDER BY `PostedOn` DESC
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

    echo json_encode($questions);
}

function getQuestionsByCategory()
{
    if (!isset($_GET['categoryId'])) {
        die(json_encode(['message' => 'Category is required']));
    }

    $categoryId = $_GET['categoryId'];
    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `QuestionCategories`
            INNER JOIN `Questions` ON `QuestionCategories`.`Questionid` = `Questions`.`Id`
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `CategoryId` = ? AND `Questions`.`IsDeleted` = 0",
        [$categoryId]
    );

    echo json_encode($questions);
}

function getQuestionsByUser()
{
    $userId = $_GET['userId'];

    $questions = select(
        "SELECT 
            `Questions`.`Id`, `Title`, `PostedOn`, `Profiles`.`Name` AS `PosterUserName`
            FROM `Questions` 
            INNER JOIN `Profiles` ON `Questions`.`PosterUserId` = `Profiles`.`UserId` 
            WHERE `IsDeleted` = 0 AND `PosterUserId` = ?
            ORDER BY `PostedOn` DESC
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

    echo json_encode($questions);
}

// getRecentQuestions();
// getQuestionsByCategory();
getQuestionsByUser();
