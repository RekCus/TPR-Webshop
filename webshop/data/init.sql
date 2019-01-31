CREATE DATABASE webshop;

use webshop;

CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	shirtname VARCHAR(30) NOT NULL,
	color VARCHAR(30) NOT NULL,
	gender VARCHAR(30) NOT NULL,
	shirtsize VARCHAR(50) NOT NULL,
	shirttext VARCHAR(50),
	stock INT(3),
	
	date TIMESTAMP
);