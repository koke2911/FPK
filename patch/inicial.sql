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
comuna varchar(255),
estado int(10),
fecha_soliciud date,
 PRIMARY KEY (id)
);

alter table solicitudes add correo int(10) default 0;
alter table solicitudes add sector varchar(255);
alter table solicitudes add fecha_nacimiento date;
alter table solicitudes modify edad varchar(100);


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

alter table lista_espera add ( whatsapp varchar(6),reunion varchar(6),mensualidad varchar(6));
alter table lista_espera add servicio_id int(10);
alter table lista_espera add (profesional_id int(10),sesiones_totales int(10), sesiones_actuales int(10));



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


-- insert into estados_le values(0,'En lista de espera',1);
insert into estados_le values(1,'En lista Espera',1);
insert into estados_le values(2,'Seguimiento Whatsapp',1);
insert into estados_le values(3,'Terapeuta designada',1);
insert into estados_le values(4,'Proceso completado',1);
insert into estados_le values(5,'No contesto correo',1);
insert into estados_le values(6,'No siguio el proceso',1);
insert into estados_le values(7,'En Proceso',1);

-- OTROS ESTADOS 
insert into estados_le values(8,'Solicitud Recibida',0);
insert into estados_le values(9,'Correo enviado',0);
insert into estados_le values(10,'Solicitud Rechazada',0);
insert into estados_le values(11,'Re-abre Solicitud',0);

insert into estados_le values(12,'Contacto por Whatspapp',0);
insert into estados_le values(13,'Registra Reunión Online',0);
insert into estados_le values(14,'Registra Mensualidad',0);

insert into estados_le values(15,'Registra Asignaciones',0);


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

-- SET SQL_SAFE_UPDATES = 0;
alter table regiones add (estado int default 0);
update regiones set estado=1 where codigo in(13,'05');

CREATE TABLE comunas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo_region VARCHAR(2) NOT NULL
);


-- Región Metropolitana (13)
INSERT INTO comunas (nombre, codigo_region) VALUES
('Alhué', '13'),
('Buin', '13'),
('Calera de Tango', '13'),
('Cerrillos', '13'),
('Cerro Navia', '13'),
('Colina', '13'),
('Conchalí', '13'),
('Curacaví', '13'),
('El Bosque', '13'),
('El Monte', '13'),
('Estación Central', '13'),
('Huechuraba', '13'),
('Independencia', '13'),
('Isla de Maipo', '13'),
('La Cisterna', '13'),
('La Florida', '13'),
('La Granja', '13'),
('La Pintana', '13'),
('La Reina', '13'),
('Lampa', '13'),
('Las Condes', '13'),
('Lo Barnechea', '13'),
('Lo Espejo', '13'),
('Lo Prado', '13'),
('Macul', '13'),
('Maipú', '13'),
('María Pinto', '13'),
('Melipilla', '13'),
('Ñuñoa', '13'),
('Padre Hurtado', '13'),
('Paine', '13'),
('Pedro Aguirre Cerda', '13'),
('Peñaflor', '13'),
('Peñalolén', '13'),
('Pirque', '13'),
('Providencia', '13'),
('Pudahuel', '13'),
('Puente Alto', '13'),
('Quilicura', '13'),
('Quinta Normal', '13'),
('Recoleta', '13'),
('Renca', '13'),
('San Bernardo', '13'),
('San Joaquín', '13'),
('San José de Maipo', '13'),
('San Miguel', '13'),
('San Pedro', '13'),
('San Ramón', '13'),
('Santiago', '13'),
('Talagante', '13'),
('Tiltil', '13'),
('Vitacura', '13');

-- Región de Valparaíso (05)
INSERT INTO comunas (nombre, codigo_region) VALUES
('Algarrobo', '05'),
('Cabildo', '05'),
('Calle Larga', '05'),
('Cartagena', '05'),
('Casablanca', '05'),
('Catemu', '05'),
('Concón', '05'),
('El Quisco', '05'),
('El Tabo', '05'),
('Hijuelas', '05'),
('Isla de Pascua', '05'),
('Juan Fernández', '05'),
('La Calera', '05'),
('La Cruz', '05'),
('La Ligua', '05'),
('Limache', '05'),
('Llay-Llay', '05'),
('Los Andes', '05'),
('Nogales', '05'),
('Olmué', '05'),
('Panquehue', '05'),
('Papudo', '05'),
('Petorca', '05'),
('Puchuncaví', '05'),
('Putaendo', '05'),
('Quillota', '05'),
('Quilpué', '05'),
('Quintero', '05'),
('Rinconada', '05'),
('San Antonio', '05'),
('San Esteban', '05'),
('San Felipe', '05'),
('Santa María', '05'),
('Santo Domingo', '05'),
('Valparaíso', '05'),
('Villa Alemana', '05'),
('Viña del Mar', '05'),
('Zapallar', '05');



create table fecha_lista (
fecha varchar(120));

insert into fecha_lista values('30 de Mayo 2025');

-- ******************SERVICIOOOOOOS REVISAR BIEN ESTOOOOOO ****************************

-- 5-- . servicios

CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,    
    estado INT DEFAULT 1
);
-- Servicios disponibles
INSERT INTO servicios (nombre, descripcion) VALUES ('Taller Personalizado',  NULL);
INSERT INTO servicios (nombre, descripcion) VALUES ('Babysitting Profesional',  NULL);
INSERT INTO servicios (nombre, descripcion) VALUES ('Terapias Profesionales',  NULL);
INSERT INTO servicios (nombre, descripcion) VALUES ('Playgroup',  NULL);
INSERT INTO servicios (nombre, descripcion) VALUES ('Couching a los Padres',  NULL);
INSERT INTO servicios (nombre, descripcion) VALUES ('Plan Hermanos',  NULL);


 --  PROFESIONES Y PROFESIONALES
 create table profesiones (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre varchar(150),
 estado int(10));
 


 insert into profesiones (nombre, estado)values('Fonoaudióloga',1);
 insert into profesiones (nombre, estado) values('Terapeuta Ocupacional',1);
 insert into profesiones (nombre, estado)values('Kinesiologa',1);

  create table profesionales(
 id INT AUTO_INCREMENT PRIMARY KEY,
 rut varchar(12),
 nombre varchar(150),
 apellido varchar(150),
 profesion_id int(10),
 estado int(10) 
 );


insert into profesionales (rut,nombre,apellido,profesion_id,estado) values('22222222-2','Javiera','Aliaga Aliaga',1,1);
insert into profesionales (rut,nombre,apellido,profesion_id,estado) values('17525457-9','Victoria','Martinez Zamora',3,1);