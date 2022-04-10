CREATE DATABASE webtoonlike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonlike;

CREATE TABLE Users (
    userID BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(32),
    email VARCHAR(256),
    registeredAt DATETIME,
    PRIMARY KEY (userID)
)  ENGINE=INNODB;

CREATE TABLE Report (
    reportID BIGINT NOT NULL AUTO_INCREMENT,
    type INT,
    userID BIGINT NOT NULL,
    PRIMARY KEY (reportID),
    FOREIGN KEY (userID) REFERENCES Users(userID)
)  ENGINE=INNODB;

CREATE TABLE TranslationProposition (
    translationPropositionID BIGINT NOT NULL AUTO_INCREMENT,
    proposedTranslation TEXT,
    PRIMARY KEY (translationPropositionID)
)  ENGINE=INNODB;

CREATE TABLE Webtoons (
    webtoonID BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(256),
    author VARCHAR(128),
    description TEXT,
    PRIMARY KEY (webtoonID)
)  ENGINE=INNODB;

CREATE TABLE Chapter (
     chapterID BIGINT NOT NULL AUTO_INCREMENT,
     number INT,
     title VARCHAR(256),
     webtoonID BIGINT NOT NULL,
     PRIMARY KEY (chapterID),
     FOREIGN KEY (webtoonID) REFERENCES Webtoons(webtoonID)
)  ENGINE=INNODB;

CREATE TABLE Image (
     imageID BIGINT NOT NULL AUTO_INCREMENT,
     `index` INT,
     path VARCHAR(256),
     chapterID BIGINT NOT NULL,
     PRIMARY KEY (imageID),
     FOREIGN KEY (chapterID) REFERENCES Chapter(chapterID)
)  ENGINE=INNODB;

CREATE TABLE CellPosition (
    cellPositionID BIGINT NOT NULL AUTO_INCREMENT,
    xAxis INT,
    yAxis INT,
    PRIMARY KEY (cellPositionID)
)  ENGINE=INNODB;

CREATE TABLE AvailableLanguage (
    languageID VARCHAR(256) NOT NULL,
    languageName VARCHAR(256) NOT NULL,
    PRIMARY KEY (languageID)
)  ENGINE=INNODB;

CREATE TABLE Cell (
    cellID BIGINT NOT NULL AUTO_INCREMENT,
    content TEXT,
    imageID BIGINT NOT NULL,
    cellPositionID BIGINT NOT NULL,
    languageID VARCHAR(256) NOT NULL,
    PRIMARY KEY (cellID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID),
    FOREIGN KEY (cellPositionID) REFERENCES CellPosition(cellPositionID),
    FOREIGN KEY (languageID) REFERENCES AvailableLanguage(languageID)
)ENGINE=INNODB;