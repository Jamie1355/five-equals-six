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
TopicFolderPath	VARCHAR(40) NOT NULL
);

DROP TABLE IF EXISTS SubTopics;
CREATE TABLE SubTopics(
SubTopicID				INTEGER NOT NULL PRIMARY KEY,
TopicID					INTEGER NOT NULL,
SubTopicName			VARCHAR(30) NOT NULL,
SubTopicFolderPath		VARCHAR(30) NOT NULL,
AreQuestionsGenerated	BOOLEAN NOT NULL CHECK(AreQuestionsGenerated IN (0,1)),	--Does this subtopic generate questions or have lists of them?
FOREIGN KEY (TopicID) REFERENCES Topics(TopicID)
);

DROP TABLE IF EXISTS ExamQSubTopics;
CREATE TABLE ExamQSubTopics(
SubTopicID		INTEGER NOT NULL,
ExamQID	INTEGER NOT NULL,
FOREIGN KEY (SubTopicID) REFERENCES SubTopics(SubopicID),
FOREIGN KEY (ExamQID) REFERENCES ExamQuestions(ExamQID)
);

-- THIS TABLE IS PROBABLY NOT NEEDED; AT THE MOMENT THE PLAN IS TO CLASSIFY AS COVERED IF THE USER HAS AN ATTEMPT ON THAT SUBTOPIC.
DROP TABLE IF EXISTS Coverage;
CREATE TABLE Coverage(
UserID			INTEGER NOT NULL,
SubTopicID		INTEGER NOT NULL,
CoveragePercent	INTEGER NOT NULL CHECK(CoveragePercent >= 0 AND CoveragePercent <= 100),
FOREIGN KEY (UserID) REFERENCES Users(UserID),
FOREIGN KEY (SubTopicID) REFERENCES SubTopics(SubTopicID),
PRIMARY KEY(UserID, SubTopicID)
);

--MAYBE STORE THE USER'S ANSWERS?
DROP TABLE IF EXISTS Attempts;
CREATE TABLE Attempts(
UserID			INTEGER NOT NULL,
SubTopicID		INTEGER NOT NULL,
AttemptDateTime	DATETIME NOT NULL,
Score			INTEGER NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(UserID),
FOREIGN KEY (SubTopicID) REFERENCES SubTopics(SubTopicID),
PRIMARY KEY(UserID, SubTopicID, AttemptDateTime)
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

INSERT INTO ExamQSubTopics(SubTopicID, ExamQID) VALUES
(1,1),
(2,2),
(2,3);

INSERT INTO Coverage(UserID, SubTopicID, CoveragePercent) VALUES
(1,1,20),
(2,1,50),
(2,2,100),
(3,1,0),
(3,2,70);

INSERT INTO Attempts(UserID, SubTopicID, AttemptDateTime, Score) VALUES
(2, 1, '2017-09-05 09:00', 42),
(2, 2, '2017-09-06 16:20', 35),
(2, 2, '2017-09-06 16:40', 39),
(3, 2, '2017-09-10 13:30', 27);
