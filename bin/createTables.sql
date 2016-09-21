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

insert into users values (
'a9', 
'example@test.com', 
md5('test')
);