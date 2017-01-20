SET @siteName = 'seri';
SET @url = '127.0.0.1/projects/seri';
SET @logo = 'http://127.0.0.1/projects/seri/files/logo.jpg';
SET @caption = 'kurtlar vadisi';
SET @facebook = 'badr2097';
SET @twitter = 'badr2097' ;
SET @about = 'about section is empty for this moment';
SET @adminName = 'admin';
SET @adminMail = 'admin@seri.ma';
SET @adminPass = 'bcnvkl';








CREATE TABLE basic (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	var  VARCHAR(255),
	val VARCHAR(255),
	last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO basic (var, val) VALUES ('name', @siteName);
INSERT INTO basic (var, val) VALUES ('statu', 1);
INSERT INTO basic (var, val) VALUES ('url', @url);
INSERT INTO basic (var, val) VALUES ('logo', @logo);
INSERT INTO basic (var, val) VALUES ('caption', @caption);
INSERT INTO basic (var, val) VALUES ('close_txt', 'site closed');
INSERT INTO basic (var, val) VALUES ('facebook', @facebook);
INSERT INTO basic (var, val) VALUES ('twitter', @twitter);
INSERT INTO basic (var, val) VALUES ('about', @about);

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	name VARCHAR(100),
	email VARCHAR(255),
	password VARCHAR(255),
	class INT DEFAULT 3,
	avatar VARCHAR(255) DEFAULT 'files/avatar.jpg',
	website VARCHAR(255) DEFAULT 'none'
);
INSERT INTO users (name, email, password, class) VALUES (@adminName, @adminMail, @adminPass, 1);

CREATE TABLE episodes (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	number INT NOT NULL,
	season INT NOT NULL,
	url VARCHAR(255) NOT NULL,
	comments BOOLEAN,
	date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	description VARCHAR(500),
	views INT DEFAULT 0
);


CREATE TABLE comments (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	user_id INT NOT NULL,
	ep_id INT NOT NULL,
	comment_txt TEXT NOT NULL,
	date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);