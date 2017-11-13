# ESTABLISHING DATABASE #

CREATE TABLE Celebrities (
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255),
    Wiki_Name varchar(255),
    dead int DEFAULT 0,
    PRIMARY KEY (ID)
);

CREATE TABLE Groups (
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255),
    CycleDuaration int,
    CycleInput real,
    LastDeath int,
    PRIMARY KEY (ID)
);

CREATE TABLE Payouts (
    GroupID int,
    UserID int,
    UnixTime int,
    amount real
);

CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255),
    UNIXJoined int,
    Email varchar(255),
    Password varchar(128),
    Balance real DEFAULT 0.00,
    PRIMARY KEY (ID)
);

CREATE TABLE Selection (
    GroupID int,
    UserID int,
    CelebrityID int,
    UnixTime int
);

CREATE TABLE Memberships (
    GroupID int,
    UserID int
);

INSERT INTO `Users`(`Name`, `UNIXJoined`, `Email`, `Password`) VALUES ("Connor Carter",1508857454,"connor@test_email.com","ebfc7910077770c8340f63cd2dca2ac1f120444f");