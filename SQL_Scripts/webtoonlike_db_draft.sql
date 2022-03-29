CREATE DATABASE webtoonlike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonlike;

CREATE TABLE Users (
    userID BIGINT NOT NULL AUTO_INCREMENT,
    username TEXT,
    email TEXT,
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

CREATE TABLE Propose (
    translationPropositionID BIGINT NOT NULL,
    userID BIGINT NOT NULL,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (translationPropositionID) REFERENCES TranslationProposition(translationPropositionID)
)  ENGINE=INNODB; 

CREATE TABLE Webtoons (
    webtoonID BIGINT NOT NULL AUTO_INCREMENT,
    name TEXT,
    author TEXT,
    description TEXT,
    PRIMARY KEY (webtoonID)
)  ENGINE=INNODB; 

CREATE TABLE Chapter (
    chapterID BIGINT NOT NULL AUTO_INCREMENT,
    number INT,
    title TEXT,
    webtoonID BIGINT NOT NULL,
    PRIMARY KEY (chapterID),
    FOREIGN KEY (webtoonID) REFERENCES Webtoons(webtoonID)
)  ENGINE=INNODB; 

CREATE TABLE Image (
    imageID BIGINT NOT NULL AUTO_INCREMENT,
    position INT,
    path TEXT,
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

CREATE TABLE AvailibleLanguage (
    languageID BIGINT NOT NULL AUTO_INCREMENT,
    languageName TEXT,
    PRIMARY KEY (languageID)
)  ENGINE=INNODB; 

CREATE TABLE Cell (
    cellID BIGINT NOT NULL AUTO_INCREMENT,
    content TEXT,
    imageID BIGINT NOT NULL,
    cellPositionID BIGINT NOT NULL,
    languageID BIGINT NOT NULL,
    PRIMARY KEY (cellID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID),
    FOREIGN KEY (cellPositionID) REFERENCES CellPosition(cellPositionID),
    FOREIGN KEY (languageID) REFERENCES AvailibleLanguage(languageID)
)ENGINE=INNODB; 