CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Identificador único para cada producto
    nombre VARCHAR(100) NOT NULL,                 -- Nombre del producto
    descripcion TEXT,                             -- Descripción del producto
    precio DECIMAL(10, 2) NOT NULL,               -- Precio del producto
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Fecha de creación automática
);
