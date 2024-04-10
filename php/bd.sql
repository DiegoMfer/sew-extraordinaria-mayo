DROP TABLE IF EXISTS Reserva;
DROP TABLE IF EXISTS Recurso_turistico;
DROP TABLE IF EXISTS Presupuesto;
DROP TABLE IF EXISTS Login;
DROP TABLE IF EXISTS Usuario;


-- Tabla de usuarios
CREATE TABLE Usuario (
  nombre VARCHAR(255) PRIMARY KEY,
  contrasena VARCHAR(255)
);

-- Tabla de recursos turísticos
CREATE TABLE Recurso_turistico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    limite_ocupacion INT,
    precio DECIMAL(10,2) NOT NULL
);

-- Tabla de reservas
CREATE TABLE Reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(255),
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    FOREIGN KEY (nombre_usuario) REFERENCES Usuario(nombre)
);

CREATE TABLE Presupuesto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50),
    precio DECIMAL(10, 2),
    FOREIGN KEY (nombre_usuario) REFERENCES Usuario(nombre) 
);

CREATE TABLE Login (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario VARCHAR(255),
  descripcion VARCHAR(255)
);

INSERT INTO Usuario (nombre, contrasena)
VALUES ('admin', 'admin');