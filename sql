create table cliente(
	id int not null AUTO_INCREMENT,
    nombre varchar(64) not null,
    apellido varchar(64) not null,
    fecha_nacimiento date,
    sexo char(1) not null,
    PRIMARY key(id)
);