CREATE DATABASE Urban_Pixel;

USE Urban_Pixel;

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
	idAdministrador INT NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (idCategoria) REFERENCES categoria(id),
	FOREIGN KEY (idAdministrador) REFERENCES usuario(id) 
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

INSERT INTO usuario(nombre, apellido, correo, clave, idRol) VALUES 
('Cristian Ferney', 'Sotelo Lancheros', 'cfsotelol@udistrital.edu.co', '51f5ba3406f5d930999897226474cbef', 1);