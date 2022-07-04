Caso o script do banco de dados não funcione importando-o pelo MySQLWorkbench, é indicado ainda no programa que crie o banco de dados com as seguintes linhas de código: 


create database 'seminariotematico';
create table cliente 
(
id int not null auto_increment primary key
login varchar(500) not null,
senha varchar(500) not null,
nome varchar(500) not null
)
;
create table carros 
(
id int not null auto_increment primary key
marca varchar(
5
00) not null,
placa varchar(2
00) not null,
preco varchar(
5
00) not null
)
;
create table concesionaria 
(
id int not null auto_increment primary key
nome varchar(
500) not null,
endereco varchar(1000) not null,
contato varchar(
500) not null
)