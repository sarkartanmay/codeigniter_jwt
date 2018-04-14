create database cijwtsample;
use cijwtsample;
create table tbl_user(
user_id int(5) primary key auto_increment,
first_name varchar(25) not null,
last_name varchar(25) not null,
email varchar(25) not null unique,
password varchar(75) not null,
user_typ tinyint(1) not null default 1 comment '1 for normal user 2 for admin',
user_status tinyint(1) not null default 1 comment '1 for active user 2 for inactive'
);

create table tbl_fruit(
fruit_id int(5) primary key auto_increment,
name varchar(25) not null unique
);
