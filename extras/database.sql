DROP DATABASE IF EXISTS `QApp`;
CREATE DATABASE `QApp`;
USE `QApp`;

CREATE TABLE `Users`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Email` VARCHAR(200) NOT NULL,
    `PasswordHash` VARCHAR(500) NOT NULL,
    `UserType` VARCHAR(10) NOT NULL
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
    `DisplayPicture` VARCHAR(300),

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
    CONSTRAINT `FkPosterUserIdInQuestions` FOREIGN KEY (`PosterUserId`) REFERENCES `Users`(`Id`),

    `IsDeleted` INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE `Categories`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL,
    `IsDeleted` INT(1) NOT NULL DEFAULT 0
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
    CONSTRAINT `FkQuestionIdInAnswers` FOREIGN KEY (`QuestionId`) REFERENCES `Questions`(`Id`),

    `IsDeleted` INT(1) NOT NULL DEFAULT 0
);

-- Password: 123
INSERT INTO `Users` SET `Id` = 1, `Email` = 'admin@gmail.com', `UserType` = 'Admin', `Password` = '$2y$10$1owshVHI9vvsOFZaBbPNQOSRMDBzEu8IDOKIQEOCskClGezK04hEu';