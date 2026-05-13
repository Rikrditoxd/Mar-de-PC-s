-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2026 a las 16:18:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mar_de_pcs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `id_producto`, `cantidad`) VALUES
(7, 7, 1, 2),
(8, 7, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Portatiles', 'Ordenadores portatiles de todas las gamas'),
(2, 'Smartphones', 'Telefonos moviles y accesorios'),
(3, 'Componentes PC', 'Procesadores, RAM, tarjetas graficas y mas'),
(4, 'Perifericos', 'Teclados, ratones, auriculares y webcams'),
(5, 'Almacenamiento', 'Discos duros, SSD y memorias USB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id_contacto` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `asunto` varchar(50) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id_contacto`, `nombre`, `email`, `telefono`, `asunto`, `mensaje`, `fecha`) VALUES
(1, 'prueba de contacto', 'prueba@gmail.com', '1234567', 'soporte', 'pc no enciende', '2026-05-04 15:32:24'),
(2, 'prueba de contacto', 'prueba@gmail.com', '1234567', 'consulta', 'mensaje largoasñdjaspdjaspdpasodpasodkpoasidpasoidpoasidpoiaspdoiaspoidaspoidpasoidpasoidpasoidpasoidpoasidpasoidpoasidaspoidaspoidpasoidpasoidpaosidpoasidpoasidpoasidpoasidpoasidpoasidpoasidpoasipdiaspodiaspodiapsoidpsaodipasodipasidpasoidpaosidpoasidpasidpaosidpasod', '2026-05-04 15:33:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  `direccion_envio` varchar(255) NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `estado`, `total`, `direccion_envio`, `creado_en`) VALUES
(5, 3, 'entregado', 699.99, 'Calle Santa Cecila 5, piso 5D, AVILÉS (33403)', '2026-05-04 12:58:04'),
(6, 6, 'enviado', 699.99, 'Calle Santa Cecila 5, piso 5D, AVILÉS (33403)', '2026-05-04 12:59:28'),
(7, 1, 'pendiente', 99.98, 'Calle Santa Cecila 5, piso 5D, AVILÉS (33403)', '2026-05-04 17:20:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id_item` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_items`
--

INSERT INTO `pedido_items` (`id_item`, `id_pedido`, `id_producto`, `cantidad`, `precio_unidad`) VALUES
(4, 5, 1, 1, 699.99),
(5, 6, 1, 1, 699.99),
(6, 7, 6, 2, 49.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen_url` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `id_subcategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre`, `descripcion`, `precio`, `stock`, `imagen_url`, `activo`, `creado_en`, `id_subcategoria`) VALUES
(1, 1, 'Portatil Asus VivoBook 15', 'Intel i5, 8GB RAM, 512GB SSD, pantalla 15.6', 699.99, 32, 'https://www.avisualpro.es/wp-content/uploads/2020/06/ordenador-portatil-asus-zenbook-14-8gb-512gb.jpg', 1, '2026-04-30 22:51:14', NULL),
(2, 1, 'Portatil Lenovo IdeaPad 3', 'AMD Ryzen 5, 8GB RAM, 256GB SSD', 10010.99, 8, 'https://dvn.com.vn/wp-content/uploads/lenovo-ideapad-3-5.jpg', 1, '2026-04-30 22:51:14', NULL),
(3, 2, 'Samsung Galaxy A55', '6.6\", 128GB, camara triple 50MP', 399.99, 20, 'https://img.global.news.samsung.com/mx/wp-content/uploads/2024/03/Galaxy-A55-5G-and-A35-5G_main2.jpg', 1, '2026-04-30 22:51:14', NULL),
(4, 2, 'Xiaomi Redmi Note 13', '6.67\", 256GB, bateria 5000mAh', 229.99, 15, 'https://i02.appmifile.com/mi-com-product/fly-birds/redmi-note-13/M/33f308b6070029de2882282a4303a32f.png', 1, '2026-04-30 22:51:14', NULL),
(5, 3, 'Tarjeta Grafica RTX 4060', 'NVIDIA RTX 4060 8GB GDDR6', 329.99, 5, 'https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ada/rtx-4060-4060ti/geforce-rtx-4060-ti-og-1200x630.jpg', 1, '2026-04-30 22:51:14', 1),
(6, 3, 'Memoria RAM Kingston 16GB', 'DDR4 3200MHz, 2x8GB', 49.99, 30, 'https://thumb.pccomponentes.com/w-530-530/articles/43/432674/1740-kingston-fury-beast-ddr4-3200-mhz-16gb-cl16.jpg', 1, '2026-04-30 22:51:14', 4),
(7, 4, 'Teclado Mecanico Logitech', 'Switch Red, retroiluminado RGB', 89.99, 12, 'https://i.blogs.es/d7d475/gpro2/450_1000.jpg', 1, '2026-04-30 22:51:14', 9),
(8, 4, 'Raton Razer DeathAdder V3', '30000 DPI, sensor optico Focus Pro', 79.99, 18, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQXkQQzbr_sPJl1D9HhGQgewSNoXgvPhcotw&s', 1, '2026-04-30 22:51:14', 8),
(9, 5, 'SSD Samsung 1TB', 'NVMe M.2, lectura 7000MB/s', 99.99, 25, 'https://thumbs.static-thomann.de/thumb/padthumb600x600/pics/bdb/_59/596652/20215651_800.jpg', 1, '2026-04-30 22:51:14', NULL),
(16, 2, 'Iphone 17 Pro MAX', 'El telefono mas genial del mundo', 999.99, 10, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-7inch-blacktitanium?wid=2560&hei=1440&fmt=jpeg&qlt=95&.v=1692845694698', 1, '2026-05-02 10:29:43', NULL),
(20, 3, 'AMD RX 7600', 'GPU AMD rendimiento equilibrado calidad-precio', 299.99, 8, 'https://tse1.mm.bing.net/th/id/OIP.wBoIiXDbGZP310CEbe_PTwHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:49:48', 1),
(21, 3, 'NVIDIA RTX 4070', 'Alta gama para gaming en 2K y 4K', 599.99, 5, 'https://tse2.mm.bing.net/th/id/OIP.jHA2Yzj8Gx5oqHNfMvD9pAHaF7?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:49:48', 1),
(28, 3, 'Intel i5-13400F', '10 núcleos gaming/productividad', 189.99, 12, 'https://tse3.mm.bing.net/th/id/OIP.Z15cSSGWAHXxcl913ownewHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:27', 2),
(29, 3, 'AMD Ryzen 5 5600X', 'CPU gaming equilibrada', 159.99, 15, 'https://www.amd.com/content/dam/amd/en/images/products/processors/ryzen/2505503-ryzen-5-5600x.jpg', 1, '2026-05-04 18:52:27', 2),
(30, 3, 'AMD Ryzen 7 5800X', 'Multitarea potente', 239.99, 6, 'https://tse3.mm.bing.net/th/id/OIP._u-itO8DqPjtshZ3qUDhfgHaEK?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:27', 2),
(31, 3, 'MSI B550 Tomahawk', 'Placa AM4 gaming', 139.99, 10, 'https://tse2.mm.bing.net/th/id/OIP.7EReFtmX9CsuPXXVzKjtrwHaFZ?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 3),
(32, 3, 'ASUS TUF B760', 'Intel 12/13 gen', 169.99, 7, 'https://microless.com/cdn/products/17a44bca596703de93ad9debc4f6f9c2-hi.jpg', 1, '2026-05-04 18:52:28', 3),
(33, 3, 'Gigabyte X670 AORUS', 'AM5 gama alta', 299.99, 4, 'https://tse1.mm.bing.net/th/id/OIP.9UxCqAB1OpUCaPo_22XUbgHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 3),
(34, 3, 'Corsair Vengeance 16GB', 'DDR4 3200MHz', 49.99, 20, 'https://tse4.mm.bing.net/th/id/OIP.HG11wQImeiWAGnrcO8hIfAHaD2?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 4),
(35, 3, 'Kingston Fury 32GB', 'DDR5 5600MHz', 109.99, 12, 'https://m.media-amazon.com/images/I/717cPftxQgL._AC_.jpg', 1, '2026-05-04 18:52:28', 4),
(37, 3, 'Samsung 970 EVO 1TB', 'SSD NVMe rápido', 79.99, 14, 'https://tse3.mm.bing.net/th/id/OIP.EtZwe7vf-zaCb12V6Q-PTQHaDV?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 5),
(38, 3, 'WD Blue 1TB', 'HDD fiable', 44.99, 25, 'https://img.pccomponentes.com/articles/25/258053/western-digital-blue-hdd-1tb-7200rpm-sata3-13d5bc76-86ab-40b2-8bdc-7642ef8a7cfd.jpg', 1, '2026-05-04 18:52:28', 5),
(39, 3, 'Crucial P3 500GB', 'SSD económico', 39.99, 30, 'https://tse1.mm.bing.net/th/id/OIP._jbvuLmEEQNhwfiqOHngJgHaHC?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 5),
(40, 3, 'Cooler Master Hyper 212', 'Disipador CPU', 29.99, 20, 'https://tse2.mm.bing.net/th/id/OIP.QjDs7UwAGI4S4rh2L0bGzwHaIJ?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 6),
(41, 3, 'NZXT Kraken X53', 'Refrigeración líquida', 129.99, 8, 'https://tse3.mm.bing.net/th/id/OIP.xo1J_C7mOjslt5vChDerRwHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 6),
(42, 3, 'Noctua NH-D15', 'Air cooler premium', 99.99, 6, 'https://www.custompc.com/wp-content/sites/custompc/2023/07/Noctua-NH-D15-review-001.jpg', 1, '2026-05-04 18:52:28', 6),
(43, 3, 'Corsair 650W', 'Fuente Bronze', 59.99, 15, 'https://katech.com.ar/wp-content/uploads/80P079.jpg', 1, '2026-05-04 18:52:28', 7),
(44, 3, 'EVGA 750W Gold', 'Alta eficiencia', 89.99, 10, 'https://tse2.mm.bing.net/th/id/OIP.BG67PCdX1YDjm60fJWVXsQHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 1, '2026-05-04 18:52:28', 7),
(45, 3, 'Seasonic 850W', 'Fuente premium', 129.99, 5, 'https://m.media-amazon.com/images/I/81Lo+vS9QBL.jpg', 1, '2026-05-04 18:52:28', 7),
(46, 4, 'Logitech G203', 'RGB gaming', 29.99, 25, 'https://m.media-amazon.com/images/I/61oE1NouXuL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 8),
(47, 4, 'Razer DeathAdder V2', 'Precisión alta', 59.99, 18, 'https://m.media-amazon.com/images/I/61HIJnrPojL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 8),
(48, 4, 'SteelSeries Rival 3', 'Ligero competitivo', 39.99, 20, 'https://m.media-amazon.com/images/I/51rrdDDRJ8L._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 8),
(49, 4, 'Redragon K552', 'Mecánico compacto', 49.99, 20, 'https://m.media-amazon.com/images/I/71lQnVCMmXL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 9),
(50, 4, 'Corsair K70', 'Gaming premium', 129.99, 10, 'https://m.media-amazon.com/images/I/71+t3yIyoOL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 9),
(51, 4, 'Logitech G213', 'Membrana RGB', 59.99, 15, 'https://m.media-amazon.com/images/I/61fG2Zep+CL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 9),
(52, 4, 'AOC 24G2', '144Hz gaming', 149.99, 12, 'https://m.media-amazon.com/images/I/716IWf-oGcL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 10),
(53, 4, 'Samsung Odyssey G5', 'Curvo QHD', 249.99, 8, 'https://m.media-amazon.com/images/I/71HI75e8GLL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 10),
(54, 4, 'LG 27GL850', 'IPS 144Hz', 299.99, 6, 'https://m.media-amazon.com/images/I/71WZNozt7UL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 10),
(55, 4, 'HyperX Cloud II', 'Top gaming', 69.99, 20, 'https://m.media-amazon.com/images/I/71ltsViEA8L._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 11),
(56, 4, 'SteelSeries Arctis 7', 'Wireless', 129.99, 10, 'https://m.media-amazon.com/images/I/61tOdMsuZZL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 11),
(57, 4, 'Razer Kraken X', 'Ligero', 49.99, 18, 'https://m.media-amazon.com/images/I/71pNzi4ROJL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 11),
(58, 4, 'Xbox Controller', 'PC/Xbox', 49.99, 20, 'https://m.media-amazon.com/images/I/71yx0fvTjQL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 12),
(59, 4, 'DualSense PS5', 'PC compatible', 59.99, 15, 'https://m.media-amazon.com/images/I/51KNE0DS4vS._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 12),
(60, 4, '8BitDo Pro 2', 'Retro pro', 39.99, 18, 'https://m.media-amazon.com/images/I/61CZm0lGiRL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 12),
(61, 4, 'Blue Yeti', 'Streaming mic', 99.99, 10, 'https://m.media-amazon.com/images/I/61egnO8q6ZL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 13),
(62, 4, 'Rode NT-USB', 'USB profesional', 129.99, 8, 'https://m.media-amazon.com/images/I/51xJFx5OrtL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 13),
(63, 4, 'Logitech Z623', 'Altavoces 2.1', 89.99, 12, 'https://m.media-amazon.com/images/I/81mH6U89qJL._AC_UL320_.jpg', 1, '2026-05-04 18:52:28', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`id_imagen`, `id_producto`, `imagen_url`) VALUES
(1, 2, 'https://tse3.mm.bing.net/th/id/OIP.m0qd04cE71DU8-9MvyFs5gHaFQ?r=0&rs=1&pid=ImgDetMain&o=7&rm=3'),
(2, 2, 'https://http2.mlstatic.com/D_NQ_NP_989992-MLA47934600734_102021-V.jpg'),
(3, 2, 'https://i5.walmartimages.com.mx/mg/gm/3pp/asr/5afb216f-4207-4585-93c9-1f62cc1b5fe8.aa554c754af544e623e3f153aeb7c23c.png?odnHeight=2000&odnWidth=2000&odnBg=ffffff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id_subcategoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id_subcategoria`, `id_categoria`, `nombre`, `descripcion`) VALUES
(1, 3, 'Tarjetas gráficas', 'GPUs NVIDIA y AMD'),
(2, 3, 'Procesadores', 'CPU Intel y AMD'),
(3, 3, 'Placas base', 'Motherboards'),
(4, 3, 'Memoria RAM', 'DDR4 y DDR5'),
(5, 3, 'Almacenamiento', 'SSD y HDD'),
(6, 3, 'Refrigeración', 'Disipadores y líquida'),
(7, 3, 'Fuentes de alimentación', 'PSU para PC'),
(8, 4, 'Ratones', 'Gaming y oficina'),
(9, 4, 'Teclados', 'Mecánicos y membrana'),
(10, 4, 'Monitores', 'Full HD, 2K, 4K'),
(11, 4, 'Auriculares', 'Gaming y multimedia'),
(12, 4, 'Mandos', 'Controllers PC y consola'),
(13, 4, 'Micrófonos', 'Audio y streaming');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = admin, 0 = cliente',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `email`, `password`, `telefono`, `direccion`, `ciudad`, `codigo_postal`, `administrador`, `activo`, `creado_en`) VALUES
(1, 'Admin', 'TechStore', 'admin@techstore.com', 'hash_aqui', NULL, NULL, NULL, NULL, 1, 1, '2026-04-30 22:51:14'),
(2, 'Carlos', 'Garcia Lopez', 'carlos@email.com', 'hash_aqui', NULL, NULL, NULL, NULL, 0, 1, '2026-04-30 22:51:14'),
(3, 'Ricardo', 'Vieira', 'RICARDOJESUSVIEIRAQUINTERO@GMAIL.COM', '$2y$10$ZTRw9FcXurYT/g08XQZoM.RECaBKJAKK03QqQjGArh50cAJ35Y2Fa', '684657344', 'waza', 'AVILÉS', '33403', 1, 1, '2026-05-01 00:06:40'),
(6, 'Cliente', 'Cliente', 'cliente@gmail.com', '$2y$10$qw0pBAy/UO5.ls34xzfqaOfPqtfE6402VAXRv.lT9e9rncqSKzPte', '1234567', '5', 'AVILÉS', '33403', 0, 1, '2026-05-01 13:50:56'),
(7, 'Londer', 'Pereda Torres', 'londerfarid@gmail.com', '$2y$10$4eIqVxPPJeU5Da7s7e5lF.v1X7T1rsO3flzzKJ44cSj5lIaXuLbYW', '652463048', 'c/Palacio Valdés n19 1ºA', 'Avilés', '33402', 0, 1, '2026-05-04 09:46:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `fk_productos_subcategoria` (`id_subcategoria`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `pedido_items_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_items_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_subcategoria` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategorias` (`id_subcategoria`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
