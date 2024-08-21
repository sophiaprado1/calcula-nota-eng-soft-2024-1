
CREATE DATABASE IF NOT EXISTS tbl_engsoft;
USE tbl_engsoft;

CREATE TABLE tbl_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE tbl_notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomealuno VARCHAR(255) NOT NULL,
    nota1 INT NOT NULL,
    nota2 INT NOT NULL,
    media_provisoria FLOAT NOT NULL,
    nota_examefinal INT NOT NULL,
    media_final FLOAT NOT NULL
);