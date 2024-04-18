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


INSERT INTO Recurso_turistico (nombre, tipo, descripcion, limite_ocupacion, precio) 
VALUES 
    ('Cala Llombards', 'Playa', 'Una pequeña y pintoresca cala en Mallorca, perfecta para relajarse y nadar.', 200, 10.00),
    ('Turismo Rural en Ibiza', 'Rural', 'Experimenta la autenticidad de Ibiza alojándote en hermosas casas rurales.', 8, 120.00),
    ('Cicloturismo por Formentera', 'Bicicleta', 'Descubre la belleza de Formentera en bicicleta, recorriendo sus caminos rurales y playas vírgenes.', NULL, 0.00),
    ('Cueva del Drach', 'Natural', 'Explora las impresionantes cuevas subterráneas en Mallorca, adornadas con estalactitas y estalagmitas.', 100, 25.00),
    ('Iglesia de Sant Miquel', 'Monumento', 'Visita esta encantadora iglesia en Ibiza, con una arquitectura tradicional y vistas panorámicas.', NULL, 3.50),
    ('Parque Natural de Mondragó', 'Parque', 'Sumérgete en la naturaleza en este parque protegido en Mallorca, hogar de una variedad de flora y fauna.', NULL, 0.00),
    ('Mercado de Pescado de Ciutadella', 'Mercado', 'Disfruta de la autenticidad de Menorca explorando este bullicioso mercado de pescado.', NULL, 0.00),
    ('Faro de Cap de Barbaria', 'Faro', 'Contempla las impresionantes vistas desde el Faro de Cap de Barbaria en Formentera, especialmente al atardecer.', NULL, 4.00),
    ('Fiesta de Sant Joan', 'Evento', 'Únete a la celebración de la Fiesta de Sant Joan en Mallorca, llena de tradición, música y fuegos artificiales.', NULL, 0.00),
    ('Necrópolis de Puig des Molins', 'Arqueológico', 'Explora las antiguas tumbas fenicias en este fascinante sitio arqueológico en Ibiza.', NULL, 7.00);
