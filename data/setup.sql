/*SQLITE COMMANDS */
.mode column
.headers on

/*DDL data definition*/
DROP TABLE IF EXISTS Users;
CREATE TABLE Users(
UserID		INTEGER NOT NULL PRIMARY KEY,
UserEmail	VARCHAR(50) NOT NULL UNIQUE,
FirstName	VARCHAR(20) NOT NULL,
LastName	VARCHAR(20) NOT NULL
);

DROP TABLE IF EXISTS ExamQuestions;
CREATE TABLE ExamQuestions(
ExamQID		INTEGER NOT NULL PRIMARY KEY,
Year			VARCHAR(4) NOT NULL,
Cycle			VARCHAR(4) NOT NULL,
Paper			INTEGER NOT NULL,
Question		VARCHAR(6) NOT NULL
);

DROP TABLE IF EXISTS Topics;
CREATE TABLE Topics(
TopicID			INTEGER NOT NULL PRIMARY KEY,
TopicName		VARCHAR(30) NOT NULL,
ResourcePath	VARCHAR(50) NOT NULL		--Path to the notes for the topic
);

DROP TABLE IF EXISTS ExamQTopics;
CREATE TABLE ExamQTopics(
TopicID		INTEGER NOT NULL,
ExamQID	INTEGER NOT NULL,
FOREIGN KEY (TopicID) REFERENCES Topics(TopicID),
FOREIGN KEY (ExamQID) REFERENCES ExamQuestions(ExamQID)
);

DROP TABLE IF EXISTS TestQuestions;
CREATE TABLE TestQuestions(
TestQID			INTEGER NOT NULL PRIMARY KEY,
TopicID			INTEGER NOT NULL,
QuestionPath	VARCHAR(50) NOT NULL,		--Path to a single question and answer pair, be it from a fixed file or a generator.
IsGenerator		BOOLEAN NOT NULL CHECK(IsGenerator IN(0,1)),			--If the question is returned from a generator, it can be used again without duplicating questions.
FOREIGN KEY (TopicID) REFERENCES Topics(TopicID)
);

DROP TABLE IF EXISTS Coverage;
CREATE TABLE Coverage(
UserID			INTEGER NOT NULL,
TopicID			INTEGER NOT NULL,
CoveragePercent	INTEGER NOT NULL CHECK(CoveragePercent >= 0 AND CoveragePercent <= 100),
FOREIGN KEY (UserID) REFERENCES Users(UserID),
FOREIGN KEY (TopicID) REFERENCES Topics(TopicID),
PRIMARY KEY(UserID, TopicID)
);

DROP TABLE IF EXISTS Attempts;
CREATE TABLE Attempts(
UserID			INTEGER NOT NULL,
TopicID			INTEGER NOT NULL,
AttemptDateTime	DATETIME NOT NULL,
Score			INTEGER NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(UserID),
FOREIGN KEY (TopicID) REFERENCES Topics(TopicID),
PRIMARY KEY(UserID, TopicID, AttemptDateTime)
);

/*DATA ENTRY*/
INSERT INTO Users(UserEmail, FirstName, LastName) VALUES
('chrisriches42@gmail.com', 'Chris', 'Riches'),
('canningjamie@gmail.com', 'Jamie', 'Canning'),
('mynameisjeff@gmail.com', 'Jeff', 'Jeffington');

INSERT INTO ExamQuestions(Year, Cycle, Paper, Question) VALUES
('2015', 'June', 1, '7a'),
('2012', 'Jan', 2, '2'),
('2013', 'June', 2, '1bii');

INSERT INTO Topics(TopicName, ResourcePath) VALUES
('Input/Output Devices', 'inoutdevices/notes'),
('Binary Arithmetic', 'binmaths/notes');

INSERT INTO ExamQTopics(TopicID, ExamQID) VALUES
(1,1),
(2,2),
(2,3);

INSERT INTO TestQuestions(TopicID, QuestionPath, IsGenerator) VALUES
(1, 'inoutdevices/qs/q1.txt', 0),
(2, 'binmaths/qs/q1.txt', 0),
(2, 'binmaths/qs/q2.txt', 0),
(2, 'binmaths/qs/g1', 1);

INSERT INTO Coverage(UserID, TopicID, CoveragePercent) VALUES
(1,1,20),
(2,1,50),
(2,2,100),
(3,1,0),
(3,2,70);

INSERT INTO Attempts(UserID, TopicID, AttemptDateTime, Score) VALUES
(2, 1, '2017-09-05 09:00', 42),
(2, 2, '2017-09-06 16:20', 35),
(2, 2, '2017-09-06 16:40', 39),
(3, 2, '2017-09-10 13:30', 27);
