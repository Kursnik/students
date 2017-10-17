create database students;
grant usage on *.* to test@localhost identified by 'some123';
grant all privileges on students.* to test@localhost;

alter schema students default character set utf8 ;
