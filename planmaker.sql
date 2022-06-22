CREATE DATABASE tarefas;

CREATE TABLE users(
	userID INT NOT NULL AUTO_INCREMENT,
	login VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255),
	PRIMARY KEY (userID)
);

CREATE TABLE projects(
	projectID INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL UNIQUE,
	user_ID INT NOT NULL,
	PRIMARY KEY (projectID),
	FOREIGN KEY (user_ID) REFERENCES users(userID) 	
);

CREATE TABLE status(
	statusID INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL UNIQUE,
	colour VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (statusID)
);

CREATE TABLE tasks(
	taskID INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
	content TEXT,
	xPos SMALLINT NOT NULL,
	yPos SMALLINT NOT NULL,
	deadline DATETIME,
    	project_ID INT NOT NULL,
	status_ID INT,
	PRIMARY KEY (taskID),
	FOREIGN KEY (project_ID) REFERENCES projects(projectID),
	FOREIGN KEY (status_ID) REFERENCES status(statusID)
);