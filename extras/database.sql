DROP DATABASE IF EXISTS `QApp`;
CREATE DATABASE `QApp`;
USE `QApp`;

CREATE TABLE `UserRoles`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL
);

CREATE TABLE `Users`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Email` VARCHAR(200) NOT NULL,
    `PasswordHash` VARCHAR(500) NOT NULL,

    `UserRoleId` INT NOT NULL,
    CONSTRAINT `FkUserRoleIdInUsers` FOREIGN KEY (`UserRoleId`) REFERENCES `UserRoles`(`Id`)
);

CREATE TABLE `SignUpOTPs`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `GeneratedOTP` VARCHAR(6) NOT NULL,
    `GeneratedOn` DATETIME NOT NULL,
    `ExpiresOn` DATETIME NOT NULL,
    `Email` VARCHAR(200) NOT NULL
);

CREATE TABLE `ForgotPasswordOTPs`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `GeneratedOTP` VARCHAR(6) NOT NULL,
    `GeneratedOn` DATETIME NOT NULL,
    `ExpiresOn` DATETIME NOT NULL,

    `UserId` INT NOT NULL,
    CONSTRAINT `FkUserIdInForgotPasswordOTPs` FOREIGN KEY (`UserId`) REFERENCES `Users`(`Id`)
);

CREATE TABLE `Profiles`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL,
    `DisplayPicture` VARCHAR(300) NOT NULL,

    `UserId` INT NOT NULL,
    CONSTRAINT `FkUserIdInProfiles` FOREIGN KEY (`UserId`) REFERENCES `Users`(`Id`)
);

CREATE TABLE `Questions`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Title` VARCHAR(100) NOT NULL,
    `TextContent` VARCHAR(500) NOT NULL,
    `PostedOn` DATETIME NOT NULL,

    `PosterUserId` INT NOT NULL,
    CONSTRAINT `FkPosterUserIdInQuestions` FOREIGN KEY (`PosterUserId`) REFERENCES `Users`(`Id`)
);

CREATE TABLE `QuestionImages`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(300) NOT NULL,

    `QuestionId` INT NOT NULL,
    CONSTRAINT `FkQuestionIdInQuestionImages` FOREIGN KEY (`QuestionId`) REFERENCES `Questions`(`Id`)
);

CREATE TABLE `Categories`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL
);

CREATE TABLE `QuestionCategories`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,

    `QuestionId` INT NOT NULL,
    CONSTRAINT `FkQuestionIdInQuestionCategories` FOREIGN KEY (`QuestionId`) REFERENCES `Questions`(`Id`),

    `CategoryId` INT NOT NULL,
    CONSTRAINT `FkCategoryIdInQuestionCategories` FOREIGN KEY (`CategoryId`) REFERENCES `Categories`(`Id`)
);

CREATE TABLE `Answers`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `TextContent` VARCHAR(500) NOT NULL,
    `PostedOn` DATETIME NOT NULL,

    `UserId` INT NOT NULL,
    CONSTRAINT `FkUserIdInAnswers` FOREIGN KEY (`UserId`) REFERENCES `Users`(`Id`),

    `QuestionId` INT NOT NULL,
    CONSTRAINT `FkQuestionIdInAnswers` FOREIGN KEY (`QuestionId`) REFERENCES `Questions`(`Id`)
);

CREATE TABLE `AnswerImages`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(300) NOT NULL,

    `AnswerId` INT NOT NULL,
    CONSTRAINT `FkAnswerIdInAnswerImages` FOREIGN KEY (`AnswerId`) REFERENCES `Answers`(`Id`)
);

INSERT INTO `UserRoles` SET `Name` = 'Admin';
INSERT INTO `UserRoles` SET `Name` = 'User';