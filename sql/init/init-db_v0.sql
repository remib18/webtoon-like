DROP DATABASE IF EXISTS webtoonLike;
CREATE DATABASE webtoonLike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonLike;

CREATE TABLE `User` (
    userID BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) not null,
    email VARCHAR(256) not null,
    password VARCHAR(256) not null,
    registeredAt DATETIME not null,
    PRIMARY KEY (userID)
)  ENGINE=INNODB; 

CREATE TABLE Report (
    reportID BIGINT NOT NULL AUTO_INCREMENT,
    type INT not null,
    userID BIGINT NOT NULL,
    PRIMARY KEY (reportID),
    FOREIGN KEY (userID) REFERENCES `User`(userID)
)  ENGINE=INNODB;

CREATE TABLE Webtoon(
    webtoonID     BIGINT NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(256) not null,
    author        VARCHAR(128) not null,
    `description` TEXT not null,
    cover         VARCHAR(128) not null,
    PRIMARY KEY (webtoonID)
)  ENGINE=INNODB; 

CREATE TABLE Chapter (
    chapterID BIGINT NOT NULL AUTO_INCREMENT,
    `index` INT not null,
    title VARCHAR(256) not null,
    webtoonID BIGINT NOT NULL,
    PRIMARY KEY (chapterID),
    FOREIGN KEY (webtoonID) REFERENCES Webtoon(webtoonID)
)  ENGINE=INNODB;

CREATE TABLE `Language` (
    identifier VARCHAR(256) NOT NULL,
    `name` VARCHAR(256) NOT NULL,
    PRIMARY KEY (identifier)
)  ENGINE=INNODB;

CREATE TABLE Image (
    imageID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `index` INT not null,
    `path` VARCHAR(256) not null,
    needOCR bool not null,
    fontSize int,
    chapterID BIGINT NOT NULL,
    originalLanguage varchar(256) not null,
    FOREIGN KEY (originalLanguage) REFERENCES `Language`(identifier),
    FOREIGN KEY (chapterID) REFERENCES Chapter(chapterID)
)  ENGINE=INNODB;

CREATE TABLE `Block` (
    blockID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    originalContent TEXT not null,
    startX int not null,
    startY int not null,
    endX int not null,
    endY int not null,
    imageID BIGINT NOT NULL,
    FOREIGN KEY (imageID) REFERENCES Image(imageID)
)ENGINE=INNODB;

CREATE TABLE `Translation` (
    languageIdentifier VARCHAR(256) NOT NULL,
    blockID BIGINT NOT NULL not null,
    content TEXT not null,
    PRIMARY KEY (languageIdentifier, blockID),
    FOREIGN KEY (languageIdentifier) REFERENCES `Language`(identifier),
    FOREIGN KEY (blockID) REFERENCES `Block`(blockID)
)  ENGINE=INNODB;

CREATE TABLE TranslationProposition (
    translationPropositionID BIGINT NOT NULL AUTO_INCREMENT,
    proposedTranslation TEXT not null,
    blockID BIGINT NOT NULL,
    userID BIGINT NOT NULL,
    PRIMARY KEY (translationPropositionID),
    FOREIGN KEY (blockID) REFERENCES `Block`(blockID),
    FOREIGN KEY (userID) REFERENCES `User`(userID)
)  ENGINE=INNODB;

CREATE TABLE LoginToken (
    token VARCHAR(64) NOT NULL,
    lifeSpan BIGINT NOT NULL,
    userID BIGINT NOT NULL,
    PRIMARY KEY (token),
    FOREIGN KEY (userID) REFERENCES `User`(userID)
)  ENGINE=INNODB;

