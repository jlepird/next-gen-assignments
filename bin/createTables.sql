
-- TODO: Remove drop statements before production!

drop table if exists users cascade;
create table users (
    username varchar(50) primary key not null,
    email varchar(50) not null, 
    password varchar(32) not null,
    owner boolean not null,
    officer boolean not null
); 


insert into users values 
('a9', 'example@test.com',  md5('test'), true, true),
('a1', 'example2@test.com', md5('test'), false, true);

drop table if exists billetOwners cascade;
create table billetOwners(
	posn varchar(50) primary key not null,
	username varchar(50) references users (username)
);

insert into billetOwners values
( 'abc', 'a9'),
( 'def', 'a9');

drop table if exists billetData cascade; 
create table billetData (
	posn varchar(50) not null references billetOwners (posn),
	tkey varchar(50) not null, 
	val  varchar(100)
);

insert into billetData values 
	('abc', 'afsc',         '61A'),
	('abc', 'grade',        'O5'),
	('abc', 'location',     'Ramstein Air Base'),
	('abc', 'unit',         'AF/A9'), 
	('abc', 'lastOccupant', 'Capt Snuffy'),
	('abc', 'poc',          'A9A Supervisor'),
	('abc', 'aadLevel',     'ms'), 
	('abc', 'aadDegree',    'Operations Research'),
	('abc', 'start',        '0730'),
	('abc', 'stop',         '1630'),
	('abc', 'tdy',          '5'), 
	('abc', 'deployable',   'yes'),
	('abc', 'contact?',     'yes'), 
	('abc', 'dutyTitle',    'Analyst'), 
	('abc', 'acqLevel',     '1'),
	('def', 'afsc',         '38P'),
	('def', 'grade',        'O4'),
	('def', 'location',     'The Pentagon'),
	('def', 'unit',         'AF/A1'), 
	('def', 'lastOccupant', 'Maj Smith'),
	('def', 'poc',          'A1 Supervisor'),
	('def', 'aadLevel',     'bs'),
	('def', 'aadDegree',    'None'), 
	('def', 'start',        '0730'),
	('def', 'stop',         '1700'),
	('def', 'tdy',          '25'),
	('def', 'deployable',   'no'),
	('def', 'contact?',     'no'),
	('def', 'dutyTitle',    'Human Resources Specialist'),
	('def', 'acqLevel',     ' ')
	;



drop table if exists billetDescs cascade;
create table billetDescs (
	posn varchar(50) not null references billetOwners (posn),
	txt varchar(5000)
);
insert into billetDescs values 
	('abc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.'),
	('def', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.')
	;

drop table if exists allowableDegrees cascade;
create table allowableDegrees(
	code varchar(4),
	degree varchar(50)
);

drop table if exists locations cascade; 
create table locations(
	location varchar(100) not null,
	lon numeric(16, 10), 
	lat numeric(16, 10)
);

drop table if exists airmanPrefs cascade;
create table airmanPrefs (
	username varchar(50) not null references users (username), 
	posn varchar(50) not null references billetOwners (posn),
	pref int not null
);

drop table if exists names cascade; 
create table names (
	username varchar(50) unique not null references users (username), 
	name varchar(100) primary key not null
);

insert into names values 
	('a9', 'Maj Dysfunction'),
	('a1', 'Capt Snuffy'); 

drop table if exists billetPrefs cascade;
create table billetPrefs ( 
	name varchar(100) not null references names (username), 
	posn varchar(50) not null references billetOwners (posn),
	pref int not null
);
	
drop table if exists acqLevels cascade; 
create table acqLevels (
	code varchar(1) primary key not null,
	level varchar(100) not null
); 

drop table if exists coreCodes cascade; 
create table coreCodes (
	afsc varchar(3) primary key not null,
	txt varchar(100) not null
); 

select 'Complete' as Update;  