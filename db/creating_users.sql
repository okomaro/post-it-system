
drop table if exists users;

create table users (
id int primary key auto_increment,
username varchar(40) unique,
pwhash varchar(255)
);

insert into users (username, pwhash) values ('Olga', '6786798709');
insert into users (username, pwhash) values ('Jan', '787987979');

select * from users;

select id, pwhash from users where username="Olga";
