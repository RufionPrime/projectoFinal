-- Crear la base de datos
CREATE DATABASE registro;
USE registro;
-- Crear la tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    hashp VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    imagen VARCHAR(255) DEFAULT 'avatar_default.png',
    confirmado TINYINT(1) DEFAULT 0,
    token VARCHAR(255),
    token_expira_a DATETIME,
    telefono VARCHAR(15),
    nif_nie VARCHAR(15) NOT NULL UNIQUE,
    fecha_nacimiento DATE,
    rol ENUM('administrador', 'cliente') DEFAULT 'cliente',
    creado_a DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- Insertar registros de prueba
INSERT INTO usuarios (
        email,
        hashp,
        nombre,
        apellidos,
        telefono,
        nif_nie,
        fecha_nacimiento,
        rol,
        confirmado,
        token,
        token_expira_a,
        imagen
    )
VALUES -- Usuarios con correo validado
    (
        'maria.garcia@example.com',
        '$2y$10$7h6.xzwsZwuz0g2KFxOk3evVMuV3S2PQKn1SVh0NXpTwnmca9Zja.',
        'María',
        'García López',
        '600123456',
        '12345678Z',
        '1990-05-15',
        'cliente',
        1,
        NULL,
        NULL,
        'maria.png'
    ),
    (
        'juan.perez@example.com',
        '$2y$10$JRQ2v0kK55QH.lrZLNdOqeKi5rRJ5t1w9ZGGe0OzMud7pHK9Kc2TS',
        'Juan',
        'Pérez Martínez',
        '600654321',
        'X1234567L',
        '1985-03-22',
        'administrador',
        1,
        NULL,
        NULL,
        'juan.png'
    ),
    -- Usuarios sin correo validado
    (
        'ana.lopez@example.com',
        '$2y$10$q4vZFevSYJeJwXWwvg8.reQWum8zi64bOdpy2kwfiu0pwPwTDOtHy',
        'Ana',
        'López Sánchez',
        '600987654',
        'Y1234567M',
        '1993-07-10',
        'cliente',
        NULL,
        'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p',
        NOW() + INTERVAL 1 DAY,
        'ana.png'
    ),
    (
        'pedro.gomez@example.com',
        '$2y$10$21.WBF5LIr6OXPHLmen8sOYPcME3iKVA4sUAbds5gGQxszgfiDgyC',
        'Pedro',
        'Gómez Ruiz',
        '600111222',
        '98765432A',
        '1992-02-28',
        'cliente',
        NULL,
        'q1w2e3r4t5y6u7i8o9p0a1s2d3f4g5h',
        NOW() + INTERVAL 1 DAY,
        'pedro.png'
    ),
    (
        'lucia.martin@example.com',
        '$2y$10$31AkB7nMXExrmDSSYP..AuOrtKVj5vSzkb3MkRSTRNISeOZaHp3hq',
        'Lucía',
        'Martín Gómez',
        '600333444',
        'Z7654321B',
        '2000-11-05',
        'cliente',
        NULL,
        'z9y8x7w6v5u4t3s2r1q0p9o8n7m6l5k',
        NOW() + INTERVAL 1 DAY,
        'avatar_default.png'
    ),
    (
        'carlos.diaz@example.com',
        '$2y$10$vsBiuXo9iScPsonzfNkpYuUj6MLn9ffw1EuQoWP8kAMSDKCpyFPxK',
        'Carlos',
        'Díaz Fernández',
        '600555666',
        'T1234567C',
        '1995-08-18',
        'cliente',
        NULL,
        'x1x2x3x4x5x6x7x8x9x0x1x2x3x4x5x6',
        NOW() + INTERVAL 1 DAY,
        'carlos.png'
    );