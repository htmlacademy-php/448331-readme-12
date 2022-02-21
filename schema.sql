CREATE DATABASE readme
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE user (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	registration_date DATETIME DEFAULT NOW() NOT NULL,
	email VARCHAR(70) NOT NULL UNIQUE,
	login VARCHAR(70) NOT NULL UNIQUE,
	password VARCHAR(70) NOT NULL,
	avatar VARCHAR(255)
);

CREATE TABLE content_type (
	id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(8) UNIQUE NOT NULL,
	class VARCHAR(5) UNIQUE NOT NULL
);

CREATE TABLE post (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_date DATETIME DEFAULT NOW() NOT NULL,
	post_header VARCHAR(255) NOT NULL,
	post_content TEXT,
	quote_author VARCHAR(255),
	image VARCHAR(255),
	video VARCHAR(255),
	link VARCHAR(255),
	view_count INT UNSIGNED DEFAULT 0,
	user_id INT UNSIGNED NOT NULL,
	content_type TINYINT UNSIGNED NOT NULL,
	FULLTEXT (post_header, post_content),
	FOREIGN KEY (user_id) REFERENCES user(id),
	FOREIGN KEY (content_type) REFERENCES content_type(id)
);

CREATE TABLE comment (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	comment_date DATETIME DEFAULT NOW() NOT NULL,
	comment_content TEXT NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	post_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (user_id) REFERENCES user(id),
	FOREIGN KEY (post_id) REFERENCES post(id)
);

CREATE TABLE likes (
	user_id INT UNSIGNED NOT NULL,
	post_id INT UNSIGNED NOT NULL,
	like_date DATETIME DEFAULT NOW() NOT NULL,
	PRIMARY KEY (user_id, post_id)
);

CREATE TABLE subscription (
	subscriber_id INT UNSIGNED NOT NULL,
	author_id INT UNSIGNED NOT NULL,
	PRIMARY KEY (subscriber_id, author_id),
	FOREIGN KEY (subscriber_id) REFERENCES user(id),
	FOREIGN KEY (author_id) REFERENCES user(id)
);

CREATE TABLE message (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	message_date DATETIME DEFAULT NOW() NOT NULL,
	message_content TEXT NOT NULL,
	sender_id INT UNSIGNED NOT NULL,
	recipient_id INT UNSIGNED NOT NULL,
	is_read TINYINT(1) DEFAULT 0,
	FOREIGN KEY (sender_id)REFERENCES user(id),
	FOREIGN KEY (recipient_id) REFERENCES user(id)
);

CREATE TABLE hashtag (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	hashtag_name VARCHAR(100) UNIQUE NOT NULL 
);

CREATE TABLE tag_in_post (
	tag_id INT UNSIGNED,
	post_id INT UNSIGNED,
	PRIMARY KEY (tag_id, post_id),
	FOREIGN KEY (tag_id) REFERENCES hashtag(id),
	FOREIGN KEY (post_id) REFERENCES post(id)
)

CREATE FULLTEXT INDEX post_fulltext_search ON post(post_header, post_content);