create table user (
    id int auto_increment primary key,
    name varchar(255) ,
    mail varchar(255),
    password varchar(255),
    picture varchar(255),
    birthday date,
    gender varchar(255),
    background text,
    qualification text,
    profile text
);

create table jobChange (
    id int auto_increment primary key,
    userId int,
    reason text,
    motivation text,
    experience text,
    foreign key (userId) references user(id) on delete cascade
);

create table career (
    id int auto_increment primary key,
    userId int,
    start date,
    finish date,
    overview varchar(255),
    explain_text text,
    foreign key (userId) references user(id) on delete cascade
);

create table book (
    id int auto_increment primary key,
    userId int,
    title varchar(255),
    explain_text text,
    picture varchar(255),
    foreign key (userId) references user(id) on delete cascade
);

create table admin (
    id int auto_increment primary key,
    mail varchar(255),
    password varchar(255)
);