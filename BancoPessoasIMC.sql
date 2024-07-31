drop database if exists pessoasIMC;
create database if not exists pessoasIMC;

use pessoasIMC;

create table pessoas(
	id_pessoa INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    sobrenome VARCHAR(50),
    idade INT,
    peso DECIMAL(5,2),
    altura DECIMAL(4,2)
);

insert into pessoas values (1, "João", "Soder", 19, 60, 1.54);
insert into pessoas values (2, "Vinicius", "Melz", 20, 72, 1.87);
insert into pessoas values (3, "Johnny", "Becker", 22, 70, 1.75);
insert into pessoas values (4, "Gabriel", "Monteiro", 30, 65, 1.57);
insert into pessoas values (5, "Guilherme", "Ferreira", 16, 112, 2.12);
insert into pessoas values (6, "Yuri", "Nokudoy", 86, 63, 1.72);
insert into pessoas values (7, "Maria", "Perreira", 65, 40, 1.48);
insert into pessoas values (8, "Joana", "Silva", 47, 57, 1.70);
insert into pessoas values (9, "Jonas", "Siveira", 75, 92, 1.84);
insert into pessoas values (10, "Julia", "Morreira", 38, 57, 1.65);
insert into pessoas values (11, "Vitoria", "Correia", 29, 95, 1.96);
insert into pessoas values (12, "Anelise", "Schlosser", 17, 63, 1.73);
insert into pessoas values (13, "Djenifer", "Vidal", 25, 56, 1.75);
insert into pessoas values (14, "Yoake", "Kinada", 115, 84, 1.77);
insert into pessoas values (15, "Thiago", "Thiguense", 34, 86, 1.89);

DELIMITER //

CREATE FUNCTION calcular_imc(peso DECIMAL(5,2), altura DECIMAL(4,2))
RETURNS DECIMAL(6,2)
BEGIN
    DECLARE imc DECIMAL(6,2);
    SET imc = peso / (altura * altura);
    RETURN imc;
END//

DELIMITER ;
