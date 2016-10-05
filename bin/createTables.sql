drop database nextGen;
create database nextGen; 

use nextGen; 

drop table if exists users;
create table users(
    username varchar(50) primary key not null,
    email varchar(50) not null, 
    password binary(32) not null
); 

grant select on users to 'ubuntu'@'localhost'; 

insert into users values 
('a9', 'example@test.com', md5('test')),
('a1', 'example2@test.com', md5('test'));

drop table if exists billetOwners;
create table billetOwners(
	posn varchar(50) primary key not null,
	user varchar(50) not null references users.username
);

grant select on billetOwners to 'ubuntu'@'localhost';

insert into billetOwners values
( 'abc', 'a9'),
( 'def', 'a9');

drop table if exists billetData; 
create table billetData (
	posn varchar(50) not null references billetOwners.posn,
	tkey  varchar(50), 
	val  varchar(100)
);

insert into billetData values 
	('abc', 'afsc', '61A'),
	('abc', 'grade', 'Lt Col'),
	('abc', 'location', 'Pentagon'),
	('abc', 'unit', 'AF/A9'), 
	('def', 'afsc', '38P'),
	('def', 'grade', 'Maj'),
	('def', 'location', 'Pentagon'),
	('def', 'unit', 'AF/A1') 
	;

drop table if exists billetDescs;
create table billetDescs (
	posn varchar(50) not null references billetOwners.posn,
	txt varchar(5000)
);
insert into billetDescs values 
	('abc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.'),
	('def', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.')
	;

grant select, update, insert on billetData to 'ubuntu'@'localhost';
grant select, update, insert on billetDescs to 'ubuntu'@'localhost'; 