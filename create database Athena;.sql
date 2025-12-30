create database Athena;
use athena;
CREATE TABLE User (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    password VARCHAR(150) NOT NULL,
    role VARCHAR(50) DEFAULT 'membre'
);
CREATE TABLE Prject (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'actif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
create table Sprint (
    sprint_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    title VARCHAR(100) NOT NULL,
    start_date DATE,
    status VARCHAR(50) DEFAULT 'en cours',
    FOREIGN KEY (project_id) REFERNCES Prject(project_id) ON DELETE CASCADE
);
CREATE TABLE Sprint (
    sprint_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    title VARCHAR(100) NOT NULL,
    start_date DATE,
    status VARCHAR(50) DEFAULT 'en cours',
    FOREIGN KEY (project_id) REFERENCES Prject(project_id) ON DELETE CASCADE
);
CREATE TABLE Task (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    sprint_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'à faire',
    priority VARCHAR(50) DEFAULT 'moyenne',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sprint_id) REFERENCES Sprint(sprint_id) ON DELETE CASCADE
);
CREATE TABLE UserTask (
    user_id INT,
    task_id INT,
    assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, task_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES Task(task_id) ON DELETE CASCADE
);
CREATE TABLE Comment (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT,
    user_id INT,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Task(task_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);
CREATE TABLE Notification (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);