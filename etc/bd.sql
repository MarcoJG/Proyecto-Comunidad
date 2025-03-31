CREATE DATABASE IF NOT EXISTS comunidad_db;
USE comunidad_db;

CREATE TABLE roles (
    id_roles INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL
);

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    email VARCHAR(45) NOT NULL UNIQUE,
    contrasena VARCHAR(45) NOT NULL,
    id_roles INT NOT NULL,
    CONSTRAINT fk_usuario_roles FOREIGN KEY (id_roles) REFERENCES roles(id_roles)
);

CREATE TABLE noticias (
    id_noticias INT AUTO_INCREMENT PRIMARY KEY,
    nombre_noticia VARCHAR(100) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    fecha DATE NOT NULL,
    es_destacada TINYINT(1) DEFAULT 0,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_noticias_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_eventos_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE votacion (
    id_votacion INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_votacion_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE voto (
    id_voto INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_votacion INT NOT NULL,
    opciones ENUM('Sí', 'No') NOT NULL DEFAULT 'Sí',
    CONSTRAINT fk_voto_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    CONSTRAINT fk_voto_votacion FOREIGN KEY (id_votacion) REFERENCES votacion(id_votacion)
);

CREATE TABLE baneo (
    id_baneo INT AUTO_INCREMENT PRIMARY KEY,
    motivo VARCHAR(255) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_baneo_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE foro (
    id_foro INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE hilo (
    id_hilo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    id_foro INT NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_hilo_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    CONSTRAINT fk_hilo_foro FOREIGN KEY (id_foro) REFERENCES foro(id_foro)
);

CREATE TABLE respuesta (
    id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
    contenido VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    id_hilo INT NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_respuesta_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    CONSTRAINT fk_respuesta_hilo FOREIGN KEY (id_hilo) REFERENCES hilo(id_hilo)
);

CREATE TABLE reserva_zona_comun (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    fecha_reserva DATETIME NOT NULL,
    zona VARCHAR(100),
    id_usuario INT NOT NULL,
    CONSTRAINT fk_reserva_zona_comun_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE incidencia (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    id_usuario INT NOT NULL,
    fecha_reporte DATETIME NOT NULL,
    estado ENUM('Pendiente', 'En proceso', 'Resuelta') NOT NULL DEFAULT 'Pendiente',
    CONSTRAINT fk_incidencia_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

INSERT INTO roles (nombre) VALUES 
('VECINO'),
('MODERADOR'),
('ADMINISTRADOR');

