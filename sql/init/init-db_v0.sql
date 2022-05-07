DROP DATABASE IF EXISTS webtoonLike;
CREATE DATABASE webtoonLike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonLike;



CREATE TABLE `User` (
    userID BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) not null,
    email VARCHAR(256) not null,
    password VARCHAR(256) not null,
    registeredAt DATETIME not null default CURRENT_TIMESTAMP,
    deleted bool not null default false,
    PRIMARY KEY (userID)
)  ENGINE=INNODB;

CREATE TABLE Report (
    reportID BIGINT NOT NULL AUTO_INCREMENT,
    type INT not null,
    userID BIGINT NOT NULL,
    PRIMARY KEY (reportID),
    FOREIGN KEY (userID) REFERENCES `User`(userID)
)  ENGINE=INNODB;

CREATE TABLE Webtoon (
    webtoonID BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) not null,
    author VARCHAR(128) not null,
    `description` TEXT not null,
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
    needOCR bool not null default true,
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



INSERT INTO `language` (`identifier`, `name`) VALUES
('af', 'Afrikaans'),
('am', 'Amharic'),
('ar', 'Arabic'),
('as', 'Assamese'),
('az', 'Azerbaijani'),
('ba', 'Bashkir'),
('bg', 'Bulgarian'),
('bn', 'Bangla'),
('bo', 'Tibetan'),
('bs', 'Bosnian'),
('ca', 'Catalan'),
('cs', 'Czech'),
('cy', 'Welsh'),
('da', 'Danish'),
('de', 'German'),
('dv', 'Divehi'),
('el', 'Greek'),
('en', 'anglais'),
('es', 'Spanish'),
('et', 'Estonian'),
('eu', 'Basque'),
('fa', 'Persian'),
('fi', 'Finnish'),
('fil', 'Filipino'),
('fj', 'Fijian'),
('fo', 'Faroese'),
('fr', 'French'),
('fr-CA', 'French (Canada)'),
('ga', 'Irish'),
('gl', 'Galician'),
('gu', 'Gujarati'),
('he', 'Hebrew'),
('hi', 'Hindi'),
('hr', 'Croatian'),
('hsb', 'Upper Sorbian'),
('ht', 'Haitian Creole'),
('hu', 'Hungarian'),
('hy', 'Armenian'),
('id', 'Indonesian'),
('ikt', 'Inuinnaqtun'),
('is', 'Icelandic'),
('it', 'Italian'),
('iu', 'Inuktitut'),
('iu-Latn', 'Inuktitut (Latin)'),
('ja', 'Japanese'),
('ka', 'Georgian'),
('kk', 'Kazakh'),
('km', 'Khmer'),
('kmr', 'Kurdish (Northern)'),
('kn', 'Kannada'),
('ko', 'Korean'),
('ku', 'Kurdish (Central)'),
('ky', 'Kyrgyz'),
('lo', 'Lao'),
('lt', 'Lithuanian'),
('lv', 'Latvian'),
('lzh', 'Chinese (Literary)'),
('mg', 'Malagasy'),
('mi', 'Maori'),
('mk', 'Macedonian'),
('ml', 'Malayalam'),
('mn-Cyrl', 'Mongolian (Cyrillic)'),
('mn-Mong', 'Mongolian (Traditional)'),
('mr', 'Marathi'),
('ms', 'Malay'),
('mt', 'Maltese'),
('mww', 'Hmong Daw'),
('my', 'Myanmar (Burmese)'),
('nb', 'Norwegian'),
('ne', 'Nepali'),
('nl', 'Dutch'),
('or', 'Odia'),
('otq', 'Querétaro Otomi'),
('pa', 'Punjabi'),
('pl', 'Polish'),
('prs', 'Dari'),
('ps', 'Pashto'),
('pt', 'Portuguese (Brazil)'),
('pt-PT', 'Portuguese (Portugal)'),
('ro', 'Romanian'),
('ru', 'Russian'),
('sk', 'Slovak'),
('sl', 'Slovenian'),
('sm', 'Samoan'),
('so', 'Somali'),
('sq', 'Albanian'),
('sr-Cyrl', 'Serbian (Cyrillic)'),
('sr-Latn', 'Serbian (Latin)'),
('sv', 'Swedish'),
('sw', 'Swahili'),
('ta', 'Tamil'),
('te', 'Telugu'),
('th', 'Thai'),
('ti', 'Tigrinya'),
('tk', 'Turkmen'),
('tlh-Latn', 'Klingon (Latin)'),
('tlh-Piqd', 'Klingon (pIqaD)'),
('to', 'Tongan'),
('tr', 'Turkish'),
('tt', 'Tatar'),
('ty', 'Tahitian'),
('ug', 'Uyghur'),
('uk', 'Ukrainian'),
('ur', 'Urdu'),
('uz', 'Uzbek (Latin)'),
('vi', 'Vietnamese'),
('yua', 'Yucatec Maya'),
('yue', 'Cantonese (Traditional)'),
('zh-Hans', 'Chinese Simplified'),
('zh-Hant', 'Chinese Traditional'),
('zu', 'Zulu')



INSERT INTO `user` (`userID`, `username`, `email`, `password`, `registeredAt`, `deleted`) VALUES
(1, 'betatesteur', 'betatesteur123@fakemail.com', '\'$2y$10$8rI4eDLzSj4EpP43oLhGzuBlfWcnkwg61H5.09P1mjlEHCftX9cMC\'', '2022-05-08 01:09:40', 0),
(2, 'alphatesteur', 'alphatesteur123@fakemail.com', '\'$2y$10$uVttKWG49nQ1mu70cjWKp.KJS3Or1SMER7hdLdjtDzBaJaLJAwm/6\'', '2022-05-08 01:10:31', 0);



