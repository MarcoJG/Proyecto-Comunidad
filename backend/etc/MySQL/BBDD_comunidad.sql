-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS proyecto_comunidad;

-- Usar la base de datos
USE proyecto_comunidad;

-- Crear tabla de roles
CREATE TABLE IF NOT EXISTS roles (
    id_roles INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    usuario VARCHAR(100) NOT NULL,
    contrasenya VARCHAR(255) NOT NULL,
    id_roles INT NOT NULL,
    CONSTRAINT fk_usuarios_roles FOREIGN KEY(id_roles) REFERENCES roles(id_roles)
);

-- Crear tabla de noticias
CREATE TABLE IF NOT EXISTS noticias (
    id_noticias INT AUTO_INCREMENT PRIMARY KEY,
    nombre_noticia VARCHAR(100) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    fecha DATE NOT NULL,
    es_destacada TINYINT(1) DEFAULT 0,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_noticias_usuario FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de eventos
CREATE TABLE IF NOT EXISTS eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_eventos_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de votación
CREATE TABLE IF NOT EXISTS votacion (
    id_votacion INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_votacion_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de votos
CREATE TABLE IF NOT EXISTS voto (
    id_voto INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_votacion INT NOT NULL,
    opciones ENUM('Sí', 'No', 'En blanco') NOT NULL DEFAULT 'En blanco',
    CONSTRAINT fk_voto_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_voto_votacion FOREIGN KEY(id_votacion) REFERENCES votacion(id_votacion)
);

-- Crear tabla de baneos
CREATE TABLE IF NOT EXISTS baneo (
    id_baneo INT AUTO_INCREMENT PRIMARY KEY,
    motivo VARCHAR(255) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_baneo_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de hilos
CREATE TABLE IF NOT EXISTS hilo (
    id_hilo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    id_foro INT NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_hilo_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de respuestas
CREATE TABLE IF NOT EXISTS respuesta (
    id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
    contenido VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    id_hilo INT NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_respuesta_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de foro
CREATE TABLE foro (
    id_foro INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100)
);

-- Relacionar hilos con foros
ALTER TABLE hilo
    ADD CONSTRAINT fk_hilo_foro
    FOREIGN KEY (id_foro) REFERENCES foro(id_foro);

-- Crear tabla de reservas de zonas comunes
CREATE TABLE IF NOT EXISTS reserva_zona_comun (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    fecha_reserva DATETIME NOT NULL,
    zona VARCHAR(100),
    id_usuario INT NOT NULL,
    CONSTRAINT fk_reserva_zona_comun_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de incidencias
CREATE TABLE IF NOT EXISTS incidencia (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    id_usuario INT NOT NULL,
    fecha_reporte DATETIME NOT NULL,
    estado ENUM('Pendiente', 'En proceso', 'Resuelta') NOT NULL DEFAULT 'PENDIENTE',
    CONSTRAINT fk_incidencia_usuarios FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

-- NUEVO CONTENIDO!!! Actualizado 24/04/2025
-- Crear tabla de likes en hilos
CREATE TABLE IF NOT EXISTS likes_hilo (
    id_like INT AUTO_INCREMENT PRIMARY KEY,
    id_hilo INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (id_hilo, id_usuario),
    FOREIGN KEY (id_hilo) REFERENCES hilo(id_hilo),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla de dislikes en hilos
CREATE TABLE IF NOT EXISTS dislikes_hilo (
    id_dislike INT AUTO_INCREMENT PRIMARY KEY,
    id_hilo INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_dislike (id_hilo, id_usuario),
    FOREIGN KEY (id_hilo) REFERENCES hilo(id_hilo),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- NUEVO CONTENIDO!!! Actualizado 24/04/2025
-- Añadir columnas a la tabla usuarios: baneado y fecha_fin_timeout
ALTER TABLE usuarios
ADD COLUMN baneado BOOLEAN DEFAULT FALSE;

ALTER TABLE usuarios
ADD COLUMN fecha_fin_timeout DATETIME NULL;

-- Insertar eventos asignados a John Doe (id_usuario = 1)
INSERT INTO eventos (titulo, descripcion, fecha, id_usuario)
VALUES
('Reunión General', 'Reunión general para discutir temas importantes de la comunidad.', '2024-05-10', 3),
('Mantenimiento de Ascensores', 'Mantenimiento programado de los ascensores en todo el edificio.', '2025-11-15', 3),
('Fiesta de Navidad', 'Celebra con nosotros la fiesta de Navidad de la comunidad.', '2026-12-20', 3),
('Junta Extraordinaria', 'Junta extraordinaria para resolver problemas de la comunidad.', '2026-01-22', 3),
('Reparación de Fachada', 'Reparación de la fachada del edificio programada para este mes.', '2025-03-17', 3);

ALTER TABLE hilo
ADD COLUMN contenido VARCHAR(255) NOT NULL;

ALTER TABLE usuarios
ADD COLUMN email_verificado BOOLEAN DEFAULT FALSE;
