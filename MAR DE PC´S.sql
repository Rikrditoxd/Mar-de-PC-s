-- ============================================================
--  BASE DE DATOS: ECOMMERCE DE TECNOLOGÍA
--  Proyecto Fin de Curso - FP
-- ============================================================

CREATE DATABASE IF NOT EXISTS mar_de_pcs
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mar_de_pcs;

-- ============================================================
--  1. USUARIOS
-- ============================================================
CREATE TABLE usuarios (
    id_usuario    INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(100)  NOT NULL,
    apellidos     VARCHAR(150)  NOT NULL,
    email         VARCHAR(150)  NOT NULL UNIQUE,
    password      VARCHAR(255)  NOT NULL,
    telefono      VARCHAR(20)   DEFAULT NULL,
    direccion     VARCHAR(255)  DEFAULT NULL,
    ciudad        VARCHAR(100)  DEFAULT NULL,
    codigo_postal VARCHAR(10)   DEFAULT NULL,
    administrador TINYINT(1)    NOT NULL DEFAULT 0 COMMENT '1 = admin, 0 = cliente',
    activo        TINYINT(1)    NOT NULL DEFAULT 1,
    creado_en     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  2. CATEGORÍAS
-- ============================================================
CREATE TABLE categorias (
    id_categoria  INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(100)  NOT NULL,
    descripcion   TEXT          DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  3. PRODUCTOS
-- ============================================================
CREATE TABLE productos (
    id_producto   INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria  INT           NOT NULL,
    nombre        VARCHAR(255)  NOT NULL,
    descripcion   TEXT          DEFAULT NULL,
    precio        DECIMAL(10,2) NOT NULL,
    stock         INT           NOT NULL DEFAULT 0,
    imagen_url    VARCHAR(500)  DEFAULT NULL,
    activo        TINYINT(1)    NOT NULL DEFAULT 1,
    creado_en     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  4. PEDIDOS
-- ============================================================
CREATE TABLE pedidos (
    id_pedido       INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario      INT           NOT NULL,
    estado          ENUM('pendiente','pagado','enviado','entregado','cancelado')
                                  NOT NULL DEFAULT 'pendiente',
    total           DECIMAL(10,2) NOT NULL,
    direccion_envio VARCHAR(255)  NOT NULL,
    creado_en       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  5. DETALLE DEL PEDIDO
-- ============================================================
CREATE TABLE pedido_items (
    id_item       INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido     INT           NOT NULL,
    id_producto   INT           NOT NULL,
    cantidad      INT           NOT NULL,
    precio_unidad DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido)   REFERENCES pedidos(id_pedido)    ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  6. CARRITO
-- ============================================================
CREATE TABLE carrito (
    id_carrito    INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario    INT           NOT NULL,
    id_producto   INT           NOT NULL,
    cantidad      INT           NOT NULL DEFAULT 1,
    FOREIGN KEY (id_usuario)  REFERENCES usuarios(id_usuario)   ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  DATOS DE EJEMPLO
-- ============================================================

INSERT INTO categorias (nombre, descripcion) VALUES
  ('Portatiles',     'Ordenadores portatiles de todas las gamas'),
  ('Smartphones',    'Telefonos moviles y accesorios'),
  ('Componentes PC', 'Procesadores, RAM, tarjetas graficas y mas'),
  ('Perifericos',    'Teclados, ratones, auriculares y webcams'),
  ('Almacenamiento', 'Discos duros, SSD y memorias USB');

INSERT INTO productos (id_categoria, nombre, descripcion, precio, stock, imagen_url) VALUES
  (1, 'Portatil Asus VivoBook 15',  'Intel i5, 8GB RAM, 512GB SSD, pantalla 15.6"', 599.99, 10, 'portatil_asus.jpg'),
  (1, 'Portatil Lenovo IdeaPad 3',  'AMD Ryzen 5, 8GB RAM, 256GB SSD',              449.99,  8, 'portatil_lenovo.jpg'),
  (2, 'Samsung Galaxy A55',         '6.6", 128GB, camara triple 50MP',              399.99, 20, 'samsung_a55.jpg'),
  (2, 'Xiaomi Redmi Note 13',       '6.67", 256GB, bateria 5000mAh',               229.99, 15, 'redmi_note13.jpg'),
  (3, 'Tarjeta Grafica RTX 4060',   'NVIDIA RTX 4060 8GB GDDR6',                   329.99,  5, 'rtx4060.jpg'),
  (3, 'Memoria RAM Kingston 16GB',  'DDR4 3200MHz, 2x8GB',                          49.99, 30, 'ram_kingston.jpg'),
  (4, 'Teclado Mecanico Logitech',  'Switch Red, retroiluminado RGB',               89.99, 12, 'teclado_logitech.jpg'),
  (4, 'Raton Razer DeathAdder V3',  '30000 DPI, sensor optico Focus Pro',           79.99, 18, 'raton_razer.jpg'),
  (5, 'SSD Samsung 1TB',            'NVMe M.2, lectura 7000MB/s',                   99.99, 25, 'ssd_samsung.jpg'),
  (5, 'Disco Duro Seagate 2TB',     'HDD 3.5", 7200RPM, SATA III',                  59.99, 20, 'hdd_seagate.jpg');

-- Usuarios de ejemplo (recuerda hashear las contraseñas con bcrypt en el codigo)
INSERT INTO usuarios (nombre, apellidos, email, password, administrador) VALUES
  ('Admin',  'TechStore',    'admin@techstore.com', 'hash_aqui', 1),
  ('Carlos', 'Garcia Lopez', 'carlos@email.com',    'hash_aqui', 0);
