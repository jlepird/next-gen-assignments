drop database nextGen;
create database nextGen; 

use nextGen; 

-- TODO: Remove drop statements before production!

drop table if exists users;
create table users(
    username varchar(50) primary key not null,
    email varchar(50) not null, 
    password binary(32) not null,
    owner bit not null,
    officer bit not null
); 


insert into users values 
('a9', 'example@test.com',  md5('test'), 1, 0),
('a1', 'example2@test.com', md5('test'), 0, 1);

drop table if exists billetOwners;
create table billetOwners(
	posn varchar(50) primary key not null,
	user varchar(50) not null references users.username
);

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
	('abc', 'afsc',         '61A'),
	('abc', 'grade',        'Lt Col'),
	('abc', 'location',     'Pentagon'),
	('abc', 'unit',         'AF/A9'), 
	('abc', 'lastOccupant', 'Capt Snuffy'),
	('abc', 'poc',          'A9A Supervisor'),
	('abc', 'aadLevel',     'ms'), 
	('abc', 'aadDegree',    'Operations Research'),
	('abc', 'start',        '0730'),
	('abc', 'stop',         '1630'),
	('abc', 'tdy',          '5'), 
	('abc', 'deployable',   'yes'), 
	('def', 'afsc',         '38P'),
	('def', 'grade',        'Maj'),
	('def', 'location',     'Pentagon'),
	('def', 'unit',         'AF/A1'), 
	('def', 'lastOccupant', 'Maj Smith'),
	('def', 'poc',          'A1 Supervisor'),
	('def', 'aadLevel',     'bs'),
	('def', 'aadDegree',    'None'), 
	('def', 'start',        '0730'),
	('def', 'stop',         '1700'),
	('def', 'tdy',          '25'),
	('def', 'deployable',   'yes')
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

drop table if exists allowableDegrees;
create table allowableDegrees(
	code varchar(4),
	degree varchar(50)
);

-- Build up a query to grand all the correct rights 
set @qry = concat('grant all on *.* to ', @user, '; ');
select @qry; 

prepare stmt from @qry; 
execute stmt; 
deallocate prepare stmt; 


select 'Complete' as 'Update';  