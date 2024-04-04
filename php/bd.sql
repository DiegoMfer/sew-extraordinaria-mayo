-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS central_reservas;

-- Usar la base de datos recién creada
USE central_reservas;

-- Tabla de usuarios
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL
);

-- Tabla de recursos turísticos
CREATE TABLE recurso_turistico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    limite_ocupacion INT,
    precio DECIMAL(10,2) NOT NULL
);

-- Tabla de reservas
CREATE TABLE reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla intermedia entre reservas y recursos turísticos
CREATE TABLE reserva_recurso (
    id_reserva INT,
    id_recurso INT,
    PRIMARY KEY (id_reserva, id_recurso),
    FOREIGN KEY (id_reserva) REFERENCES reservas(id),
    FOREIGN KEY (id_recurso) REFERENCES recursos_turisticos(id)
);

-- Tabla de tipos de recursos turísticos
CREATE TABLE tipo_recurso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla intermedia entre recursos turísticos y tipos de recursos
CREATE TABLE recurso_tipo (
    id_recurso INT,
    id_tipo INT,
    PRIMARY KEY (id_recurso, id_tipo),
    FOREIGN KEY (id_recurso) REFERENCES recursos_turisticos(id),
    FOREIGN KEY (id_tipo) REFERENCES tipos_recursos(id)
);

-- Insertar tipos de recursos turísticos
INSERT INTO tipo_recurso (nombre) VALUES 
('Museo'),
('Ruta'),
('Restaurante'),
('Hotel'),
('Playa');

-- Insertar recursos turísticos (debes agregar más según tus necesidades)
INSERT INTO recurso_turistico (nombre, tipo, descripcion, limite_ocupacion, precio) VALUES
('Catedral de Palma de Mallorca', 'Museo', 'La Catedral de Santa María de Palma de Mallorca, más conocida como La Seu, es la catedral de la Diócesis de Mallorca, sede del obispado de Mallorca. Es una de las principales obras del gótico en la isla.', 200, 15.00),
('Playa de Es Trenc', 'Playa', 'Es Trenc es una playa que se encuentra en el municipio de Campos, al sur de Mallorca. Es conocida por su arena fina y blanca y sus aguas cristalinas.', 500, 0.00),
('Castillo de Bellver', 'Museo', 'El Castillo de Bellver es una fortificación de estilo gótico mallorquín situado en la colina de Bellver, a 112 metros sobre el nivel del mar, a 3 km al oeste del casco antiguo de Palma de Mallorca.', 100, 8.00),
('Cala Varques', 'Playa', 'Cala Varques es una playa situada en la costa este de Mallorca, cerca de la localidad de Porto Cristo. Es conocida por su belleza natural y sus aguas turquesas.', 300, 0.00);

