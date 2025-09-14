CREATE DATABASE IF NOT EXISTS supermc;
USE supermc;

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    country VARCHAR(100),
    whyChoose TEXT,
    experience TEXT,
    benefit TEXT,
    discord VARCHAR(100),
    mcname VARCHAR(100),
    whyHere TEXT
);
