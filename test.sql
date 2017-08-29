CREATE table users(
  id int(10) unsigned not null auto_increment,
  username VARCHAR(12) unique,
  password VARCHAR(255) not null,
  PRIMARY KEY (id),
  UNIQUE KEY users_username_unique (username)
)engine=innodb;