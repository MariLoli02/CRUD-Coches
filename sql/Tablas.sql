drop Table if exists marcas;

drop table if exists autos;

create table marcas(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50) UNIQUE NOT NULL,
    pais VARCHAR(60) NOT NULL
);

create table autos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo varchar(100) NOT NULL,
    tipo enum('Diesel', 'Gasolina', 'Híbrido', 'Eléctrico', 'Gas'),
    matrícula CHAR(7) UNIQUE NOT NULL,
    marca_id int,
    constraint marca_auto FOREIGN KEY(marca_id) REFERENCES marcas(id)
    on delete CASCADE on update CASCADE
);