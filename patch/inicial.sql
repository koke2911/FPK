create database playkids;

use playkids;

CREATE TABLE usuarios (
  id INT(10) NOT NULL AUTO_INCREMENT,
  rut VARCHAR(255) NOT NULL,
  clave VARCHAR(255) DEFAULT NULL,
  nombre VARCHAR(255) NOT NULL,
  apellidos VARCHAR(255) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  contacto VARCHAR(255) DEFAULT NULL,
  email VARCHAR(255) NOT NULL,
  tipo VARCHAR(255) DEFAULT NULL,
  estado INT(10) DEFAULT 0,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL,  
  PRIMARY KEY (id)
);

INSERT INTO usuarios (rut, clave, nombre, apellidos, fecha_nacimiento, contacto, email, tipo, estado, fecha_creacion)
VALUES ('17525457-9', 'c0e21b77a35c69aaf01cb8bb7a3f3194', 'Victor', 'Martinez Zamora', '1991-11-29', '975143052', 'koke1592@gmail.com', 'U', 1, '1991-11-21 00:00:00');


update usuarios set clave='c0e21b77a35c69aaf01cb8bb7a3f3194' where rut='17525457-9';

create table solicitudes (
id INT(10) NOT NULL AUTO_INCREMENT,
nombre varchar(255),
rut varchar(255),
edad INT(10),
email varchar(255),
fono INT(10),
region varchar(255),
ciudad varchar(255),
comuna varchar(255),
estado int(10),
fecha_soliciud date,
 PRIMARY KEY (id)
);

alter table solicitudes add correo int(10) default 0;

--drop table lista_espera;

create table lista_espera (
id INT(10) NOT NULL AUTO_INCREMENT,
id_solicitud int(10),
nombre_responsable varchar(255),
fono int(10),
direccion varchar(255),
fecha date,
estado int(10),
 PRIMARY KEY (id)
);



create table lista_espera_traza (
id INT(10) NOT NULL AUTO_INCREMENT,
id_solicitud int(10),
estado int(10),
observacion varchar(255),
fecha date,
usuario varchar(10),
 PRIMARY KEY (id)
 );

create table estados_le (
id int(2),
glosa varchar(100),
estado int(1));


insert into estados_le values(0,'En lista de espera',1);
insert into estados_le values(1,'Correo enviado',1);
insert into estados_le values(2,'Seguimiento Whatsapp',1);
insert into estados_le values(3,'Terapeuta designada',1);
insert into estados_le values(4,'Proceso completado',1);
insert into estados_le values(5,'No contesto correo',1);
insert into estados_le values(6,'No siguio el proceso',1);
insert into estados_le values(7,'En atención',1);

CREATE TABLE regiones (
    codigo CHAR(2) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO regiones (codigo, nombre) VALUES 
('01', 'Tarapacá'),
('02', 'Antofagasta'),
('03', 'Atacama'),
('04', 'Coquimbo'),
('05', 'Valparaíso'),
('06', 'O’Higgins'),
('07', 'Maule'),
('08', 'Biobío'),
('09', 'Araucanía'),
('10', 'Los Lagos'),
('11', 'Aysén'),
('12', 'Magallanes'),
('13', 'Metropolitana'),
('14', 'Los Ríos'),
('15', 'Arica y Parinacota'),
('16', 'Ñuble');


-- Crear la tabla
CREATE TABLE ciudades (
    codigo CHAR(4) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Insertar los registros
INSERT INTO ciudades (codigo, nombre) VALUES
('0101', 'Iquique'),
('0102', 'Alto Hospicio'),
('0201', 'Antofagasta'),
('0202', 'Mejillones'),
('0203', 'Sierra Gorda'),
('0204', 'Taltal'),
('0301', 'Copiapó'),
('0302', 'Chañaral'),
('0303', 'Diego de Almagro'),
('0304', 'Caldera'),
('0305', 'Tierra Amarilla'),
('0306', 'Vallenar'),
('0401', 'La Serena'),
('0402', 'Coquimbo'),
('0403', 'Andacollo'),
('0404', 'La Higuera'),
('0405', 'Paihuano'),
('0406', 'Vicuña'),
('0501', 'Valparaíso'),
('0502', 'Viña del Mar'),
('0503', 'Concón'),
('0504', 'Quilpué'),
('0505', 'Quintero'),
('0506', 'Puchuncaví'),
('0507', 'Casablanca'),
('0508', 'Juan Fernández'),
('0601', 'Rancagua'),
('0602', 'San Fernando'),
('0603', 'Curicó'),
('0604', 'Talca'),
('0701', 'Talca'),
('0702', 'Curicó'),
('0703', 'Linares'),
('0704', 'Cauquenes'),
('0801', 'Chillán'),
('0802', 'Concepción'),
('0803', 'Coronel'),
('0804', 'Los Ángeles'),
('0901', 'Temuco'),
('0902', 'Angol'),
('0903', 'Villarrica'),
('0904', 'Padre Las Casas'),
('1001', 'Puerto Montt'),
('1002', 'Osorno'),
('1003', 'Puerto Varas'),
('1101', 'Coyhaique'),
('1102', 'Chile Chico'),
('1103', 'Coihaique Alto'),
('1201', 'Punta Arenas'),
('1202', 'Porvenir'),
('1203', 'Natales'),
('1301', 'Santiago'),
('1302', 'Puente Alto'),
('1303', 'Maipú'),
('1304', 'La Florida'),
('1305', 'San Bernardo'),
('1401', 'Valdivia'),
('1402', 'Los Lagos'),
('1501', 'Arica'),
('1502', 'Parinacota'),
('1601', 'Chillán'),
('1602', 'Bulnes');

create table fecha_lista (
fecha varchar(120));

insert into fecha_lista values('30 de Mayo 2025');