CREATE DATABASE IF NOT EXISTS webtoonlike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonlike;

CREATE TABLE User (
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
    FOREIGN KEY (userID) REFERENCES User(userID)
)  ENGINE=INNODB;

CREATE TABLE Webtoon (
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
    FOREIGN KEY (webtoonID) REFERENCES Webtoon(webtoonID)
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
    CellPositionID BIGINT NOT NULL AUTO_INCREMENT,
    xAxis INT,
    yAxis INT,
    PRIMARY KEY (CellPositionID)
)  ENGINE=INNODB; 

CREATE TABLE Language (
    languageID VARCHAR(256) NOT NULL,
    languageName VARCHAR(256) NOT NULL,
    PRIMARY KEY (languageID)
)  ENGINE=INNODB;

CREATE TABLE Block (
    blockID BIGINT NOT NULL AUTO_INCREMENT,
    content TEXT,
    imageID BIGINT NOT NULL,
    CellPositionID BIGINT NOT NULL,
    PRIMARY KEY (blockID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID),
    FOREIGN KEY (CellPositionID) REFERENCES CellPosition(CellPositionID)
)ENGINE=INNODB;

CREATE TABLE Translation (
    languageId BIGINT NOT NULL AUTO_INCREMENT,
    blockID BIGINT NOT NULL,
    content TEXT,
    PRIMARY KEY (languageId),
    FOREIGN KEY (blockID) REFERENCES Block(blockID)
)  ENGINE=INNODB;

CREATE TABLE TranslationProposition (
    translationPropositionID BIGINT NOT NULL AUTO_INCREMENT,
    proposedTranslation TEXT,
    blockID BIGINT NOT NULL,
    userID BIGINT NOT NULL,
    PRIMARY KEY (translationPropositionID),
    FOREIGN KEY (blockID) REFERENCES Block(blockID),
    FOREIGN KEY (userID) REFERENCES User(userID)
)  ENGINE=INNODB;