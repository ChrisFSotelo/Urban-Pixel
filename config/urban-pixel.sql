CREATE DATABASE urban_pixel;

USE urban_pixel;

-- ---------------------
-- Creación de tablas
-- ---------------------

CREATE TABLE rol (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,

	PRIMARY KEY (id)
);

CREATE TABLE usuario (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,
	apellido VARCHAR(255) NOT NULL,
	correo VARCHAR(255) NOT NULL,
	clave VARCHAR(255) NOT NULL,
	idRol INT NOT NULL,
	idEstado INT NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (idRol) REFERENCES rol(id) 
);

CREATE TABLE cliente (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,
	apellido VARCHAR(255) NOT NULL,
	correo VARCHAR(255) NOT NULL,
	clave VARCHAR(255) NOT NULL,
	idRol INT NOT NULL,
	idEstado INT NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (idRol) REFERENCES rol(id) 
);

CREATE TABLE categoria (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,

	PRIMARY KEY (id)
);

CREATE TABLE producto (
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,
	cantidad INT NOT NULL,
	precio INT NOT NULL,
	idCategoria INT NOT NULL,
	estado INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (idCategoria) REFERENCES categoria(id)
);

CREATE TABLE factura (
	id INT NOT NULL AUTO_INCREMENT,
	fecha DATE NOT NULL,
	hora TIME NOT NULL,
	subtotal INT NOT NULL,
	iva INT NOT NULL,
	total INT NOT NULL,
	idCliente INT NOT NULL,
	ciudad VARCHAR(255) NOT NULL,
	direccion VARCHAR(255) NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (idCliente) REFERENCES cliente(id)
);

CREATE TABLE producto_factura (
	idFactura INT NOT NULL,
	idProducto INT NOT NULL,
	cantidad INT NOT NULL,
	precioVenta INT NOT NULL,

	PRIMARY KEY (idFactura, idProducto),
	FOREIGN KEY (idFactura) REFERENCES factura(id),
	FOREIGN KEY (idProducto) REFERENCES producto(id)
);


-- ---------------------
-- Inserción de datos
-- ---------------------

INSERT INTO rol (nombre) VALUES
('Administrador'),
('Cliente');

INSERT INTO categoria (nombre) VALUES
('Pantalones'),
('Camisetas');

INSERT INTO producto (nombre, cantidad, precio, idCategoria) VALUES
('Pantalon', 36, 47500, 1),
('Camisa polo', 120, 22000, 2);

INSERT INTO usuario(nombre, apellido, correo, clave, idRol, idEstado) VALUES 
('Cristian Ferney', 'Sotelo Lancheros', 'cfsotelol@udistrital.edu.co', '202cb962ac59075b964b07152d234b70', 1, 1);

INSERT INTO cliente(nombre, apellido, correo, clave, idRol, idEstado) VALUES 
('Jose', 'Jose', 'jose1@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 1),
('Carlos', 'Lopez', 'krlosL0pz@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 0);

ALTER TABLE `producto` ADD `descripcion` VARCHAR(250) NOT NULL AFTER `estado`;