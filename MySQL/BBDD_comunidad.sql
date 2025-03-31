CREATE DATABASE IF NOT EXISTS proyecto_comunidad;
USE proyecto_comunidad;

CREATE TABLE usuario (
id_usuario INT AUTO_INCREMENT PRIMARY KEY,
nombre_completo VARCHAR(100) NOT NULL,
email VARCHAR(45) NOT NULL UNIQUE,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
id_roles INT NOT NULL
);
CREATE TABLE IF NOT EXISTS roles (
id_roles INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(45) NOT NULL
);
ALTER TABLE usuario
ADD CONSTRAINT fk_usuario_roles
FOREIGN KEY(id_roles) REFERENCES roles(id_roles);
CREATE TABLE IF NOT EXISTS noticias (
id_noticias INT AUTO_INCREMENT PRIMARY KEY,
nombre_noticia VARCHAR(100) NOT NULL,
titulo VARCHAR(100) NOT NULL,
contenido TEXT NOT NULL,
fecha DATE NOT NULL,
es_destacada TINYINT(1) DEFAULT 0,
id_usuario INT NOT NULL,
CONSTRAINT fk_noticias_usuario FOREIGN KEY (id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS eventos (
id_evento INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(100) NOT NULL,
descripción VARCHAR(255) NOT NULL,
fecha DATE NOT NULL,
id_usuario INT NOT NULL,
CONSTRAINT fk_eventos_usuario FOREIGN KEY (id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS votacion (
id_votacion INT AUTO_INCREMENT PRIMARY KEY,
descripción VARCHAR(255) NOT NULL,
fecha_inicio DATETIME,
fecha_fin DATETIME,
id_usuario INT NOT NULL,
CONSTRAINT fk_votacion_usuario FOREIGN KEY (id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS voto (
id_voto INT AUTO_INCREMENT PRIMARY KEY,
id_usuario INT NOT NULL,

id_votacion INT NOT NULL,
opciones ENUM('Sí', 'No') NOT NULL DEFAULT 'Sí',
CONSTRAINT fk_voto_usuario FOREIGN KEY (id_usuario) REFERENCES
usuario(id_usuario),
CONSTRAINT fk_voto_votacion FOREIGN KEY (id_votacion) REFERENCES
votacion(id_votacion)
);
CREATE TABLE IF NOT EXISTS baneo (
id_baneo INT AUTO_INCREMENT PRIMARY KEY,
motivo VARCHAR(255) NOT NULL,
fecha_inicio DATETIME,
fecha_fin DATETIME,
id_usuario INT NOT NULL,
CONSTRAINT fk_baneo_usuario FOREIGN KEY(id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS respuesta (
id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
contenido VARCHAR(255) NOT NULL,
fecha DATE NOT NULL,
id_hilo INT NOT NULL,
id_usuario INT NOT NULL,
CONSTRAINT fk_respuesta_usuario FOREIGN KEY(id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS hilo (
id_hilo INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(100) NOT NULL,
fecha DATE NOT NULL,
id_foro INT NOT NULL,
id_usuario INT NOT NULL,
CONSTRAINT fk_hilo_usuario FOREIGN KEY(id_usuario) REFERENCES
usuario(id_usuario)
);
ALTER TABLE IF NOT EXISTS respuesta
ADD CONSTRAINT fk_respuesta_hilo
FOREIGN KEY (id_hilo) REFERENCES hilo(id_hilo);
CREATE TABLE foro (
id_foro INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100)
);
ALTER TABLE hilo
ADD CONSTRAINT fk_hilo_foro
FOREIGN KEY (id_foro) REFERENCES foro(id_foro);
CREATE TABLE IF NOT EXISTS reserva_zona_comun (
id_reserva INT AUTO_INCREMENT PRIMARY KEY,
fecha_reserva DATETIME NOT NULL,
zona VARCHAR(100),
id_usuario INT NOT NULL,
CONSTRAINT fk_reserva_zona_comun_usuario FOREIGN KEY(id_usuario) REFERENCES
usuario(id_usuario)
);
CREATE TABLE IF NOT EXISTS incidencia (
id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
descripcion VARCHAR(255) NOT NULL,
id_usuario INT NOT NULL,
fecha_reporte DATETIME NOT NULL,
estado ENUM('Pendiente', 'En proceso', 'Resuelta') NOT NULL DEFAULT 'PENDIENTE',
CONSTRAINT fk_incidencia_usuario FOREIGN KEY(id_usuario) REFERENCES
usuario(id_usuario)
);

-- Usuario de prueba: usuario = admin, contraseña = admin123
INSERT INTO usuario (username, password) 
VALUES ('admin', SHA2('admin123', 256));