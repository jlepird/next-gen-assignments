
-- TODO: Remove drop statements before production!

drop table if exists users cascade;
create table users (
    username varchar(50) primary key,
    email varchar(50) not null, 
    password varchar(32) not null,
    owner boolean not null,
    officer boolean not null,
    name varchar(200) unique not null
); 


insert into users values 
('a9', 'example@test.com',  md5('test'), true, true, 'Maj Dysfunction'),
('a1', 'example2@test.com', md5('test'), false, true, 'Capt Smith');

-- Billetdescs is the authoritative source of the list of billets
drop table if exists billetDescs cascade;
create table billetDescs (
	posn varchar(50) primary key,
	txt varchar(5000)
);

insert into billetDescs values 
	('abc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.'),
	('def', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui.')
	;

drop table if exists billetOwners cascade;
create table billetOwners(
	posn varchar(50) not null,
	username varchar(50),
	constraint fk_billetOwners_users
	   foreign key (username)
	   references users(username),
	constraint fk_billetOwners_posns
		foreign key (posn)
		references billetDescs(posn)
);

insert into billetOwners values
( 'abc', 'a9'),
( 'def', 'a9');

drop table if exists billetData cascade; 
create table billetData (
	posn varchar(50) not null,
	tkey varchar(50) not null, 
	val  varchar(100),
	constraint fk_billetData_owners
		foreign key (posn)
		references billetDescs (posn)
);

insert into billetData values 
	('abc', 'afsc',         '61A'),
	('abc', 'grade',        'O5'),
	('abc', 'location',     'JB Anacostia'),
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
	('abc', 'state',        'VA'),
	('abc', 'regularHours', 'yes'),
	('def', 'afsc',         '38P'),
	('def', 'grade',        'O4'),
	('def', 'location',     'The Pentagon'),
	('def', 'unit',         'AF/A1'), 
	('def', 'lastOccupant', 'Maj Smith'),
	('def', 'poc',          'A1 Supervisor'),
	('def', 'aadLevel',     'bs'),
	('def', 'aadDegree',    'None'), 
	('def', 'start',        '0830'),
	('def', 'stop',         '1700'),
	('def', 'tdy',          '25'),
	('def', 'deployable',   'no'),
	('def', 'contact?',     'no'),
	('def', 'dutyTitle',    'Human Resources Specialist'),
	('def', 'acqLevel',     ' '),
	('def', 'state',        'MD'),
	('def', 'regularHours', 'yes')
	;

drop table if exists allowableDegrees cascade;
create table allowableDegrees(
	code varchar(4) primary key,
	degree varchar(100)
);

drop table if exists locations cascade; 
create table locations(
	location varchar(100) primary key,
	lon numeric(16, 10), 
	lat numeric(16, 10)
);

insert into locations values 
	('Ramstein Air Base', 49.4417857579 ,   7.6008885732),
    ('The Pentagon'     , 38.8707481657 , -77.0540203771);

drop table if exists airmanPrefs cascade;
create table airmanPrefs (
	username varchar(50) not null, 
	posn varchar(50) not null,
	pref int not null,
	constraint fk_airmanPrefs_users
		foreign key (username)
		references users (username), 
	constraint fk_airmanPrefs_posn
		foreign key (posn)
		references billetDescs (posn)
);

drop table if exists billetPrefs cascade;
create table billetPrefs ( 
	name varchar(500) not null, 
	posn varchar(50) not null,
	pref int not null,
	constraint fk_billetPrefs_users
		foreign key (name)
		references users (name), 
	constraint fk_billetPrefs_posn
		foreign key (posn)
		references billetDescs (posn)
);
	
drop table if exists acqLevels cascade; 
create table acqLevels (
	code varchar(1) primary key,
	level varchar(100) not null
); 

drop table if exists coreCodes cascade; 
create table coreCodes (
	afsc varchar(3) primary key,
	txt varchar(100) not null
); 

drop table if exists favorites cascade;
create table favorites (
	username varchar(50) not null,
	posn varchar(50) not null,
	constraint fk_favs_users
		foreign key (username)
		references users (username), 
	constraint fk_favs_posn
		foreign key (posn)
		references billetDescs (posn)
);

drop table if exists userActivity;
create table userActivity (
		username varchar(50) not null,
		login timestamp,
		constraint fk_useractivty_users
			foreign key (username)
			references users (username)
);

drop table if exists billetViews;
create table billetViews ( 
	username varchar(50) not null,
	posn varchar(50) not null,
	at timestamp,
	constraint fk_billetViews_users
		foreign key (username)
		references users (username),
	constraint fk_billetViews_posn
		foreign key (posn)
		references billetDescs (posn)
);

select 'Complete' as Update;  