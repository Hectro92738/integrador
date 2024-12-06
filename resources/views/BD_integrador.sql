create table categoria(
       idcategoria integer primary key AUTO_INCREMENT,
       nombre varchar(50) not null unique,
       descripcion varchar(256) null,
       estado bit default(1)
);

INSERT INTO categoria (nombre, descripcion) VALUES
('Smartphones y Accesorios', 'Dispositivos móviles inteligentes y sus complementos'),
('Computadoras y Accesorios', 'Equipos de cómputo, componentes y accesorios relacionados'),
('Audio y Video', 'Dispositivos y accesorios para reproducción y grabación de sonido y video'),
('Gadgets', 'Dispositivos tecnológicos innovadores y accesorios portátiles');

CREATE TABLE articulo (
    idarticulo INTEGER PRIMARY KEY AUTO_INCREMENT,
    idcategoria INTEGER NOT NULL,
    codigo VARCHAR(50) NULL,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    precio_venta DECIMAL(11,2) NOT NULL,
    stock INTEGER NOT NULL,
    descripcion VARCHAR(256) NULL,
    estado BIT DEFAULT 1,
    FOREIGN KEY (idcategoria) REFERENCES categoria (idcategoria)
);

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion) VALUES
(1, 'SP001', 'iPhone 15 Pro Max', 1199.99, 10, 'Smartphone con chip A17 Pro y cámara avanzada'),
(1, 'SP002', 'Samsung Galaxy S23 Ultra', 1099.99, 15, 'Smartphone con pantalla AMOLED de 6.8 pulgadas'),
(1, 'SP003', 'Google Pixel 8 Pro', 999.99, 12, 'Smartphone con cámara de inteligencia artificial avanzada'),
(1, 'SP004', 'Cargador Inalámbrico', 49.99, 30, 'Cargador rápido compatible con Qi'),
(1, 'SP005', 'Funda Antigolpes', 19.99, 50, 'Funda protectora resistente a caídas para varios modelos'),
(1, 'SP006', 'Protector de Pantalla', 9.99, 100, 'Protector de vidrio templado para smartphones');

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion) VALUES
(2, 'PC001', 'Laptop Dell XPS 15', 1499.99, 8, 'Laptop ultradelgada con procesador Intel i7 y pantalla 4K'),
(2, 'PC002', 'MacBook Pro 16', 2499.99, 5, 'Portátil de alto rendimiento con chip M3 Pro'),
(2, 'PC003', 'Monitor LG Ultrawide', 499.99, 10, 'Monitor panorámico de 34 pulgadas para multitarea'),
(2, 'PC004', 'Teclado Mecánico RGB', 89.99, 25, 'Teclado mecánico con retroiluminación personalizable'),
(2, 'PC005', 'Mouse Inalámbrico Logitech', 39.99, 30, 'Ratón inalámbrico ergonómico y silencioso'),
(2, 'PC006', 'Disco Duro Externo 2TB', 69.99, 20, 'Almacenamiento portátil USB 3.0 de alta velocidad');

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion) VALUES
(3, 'AV001', 'Auriculares Sony WH-1000XM5', 399.99, 10, 'Auriculares inalámbricos con cancelación de ruido'),
(3, 'AV002', 'Barra de Sonido JBL', 299.99, 8, 'Sistema de sonido para cine en casa con Bluetooth'),
(3, 'AV003', 'Cámara GoPro Hero 12', 449.99, 12, 'Cámara de acción con grabación 5K y resistencia al agua'),
(3, 'AV004', 'Micrófono Blue Yeti', 129.99, 15, 'Micrófono USB para grabación y streaming profesional'),
(3, 'AV005', 'Proyector Epson Full HD', 599.99, 6, 'Proyector portátil con resolución 1080p y conectividad HDMI'),
(3, 'AV006', 'Bocina Portátil Bose', 249.99, 20, 'Bocina Bluetooth de alta calidad con batería de larga duración');

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion) VALUES
(4, 'GD001', 'Smartwatch Apple Watch Series 9', 399.99, 10, 'Reloj inteligente con monitoreo de salud y GPS'),
(4, 'GD002', 'Drone DJI Mini 3', 529.99, 7, 'Drone ultraligero con cámara 4K y tiempo de vuelo extendido'),
(4, 'GD003', 'Lentes de Realidad Virtual Meta Quest 3', 499.99, 5, 'Lentes VR autónomos con gráficos inmersivos'),
(4, 'GD004', 'Cargador Solar Portátil', 59.99, 25, 'Cargador solar compatible con múltiples dispositivos'),
(4, 'GD005', 'Traductor Inteligente Pocketalk', 299.99, 12, 'Dispositivo portátil para traducción en tiempo real'),
(4, 'GD006', 'Mini Proyector Portátil', 149.99, 18, 'Proyector compacto con conectividad Wi-Fi y Bluetooth');

create table persona(
       idpersona integer primary key AUTO_INCREMENT,
       tipo_persona varchar(20) not null,
       nombre varchar(100) not null,
       tipo_documento varchar(20) null,
       num_documento varchar(20) null,
       direccion varchar(70) null,
       telefono varchar(20) null,
       email varchar(50) null
);

INSERT INTO persona (tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) VALUES
('Proveedor', 'Distribuidora ABC', 'RUC', '1234567890', 'Av. Comercio 1000', '987654321', 'contacto@abc.com'),
('Proveedor', 'Tech Supplies S.A.', 'RUC', '0987654321', 'Av. Tecnología 500', '987123456', 'ventas@techsupplies.com');
-- -
RUC (Registro Único de Contribuyentes):
DNI (Documento Nacional de Identidad):
-- -
INSERT INTO persona (tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) VALUES
('Cliente', 'Juan Pérez', 'DNI', '98765432', 'Calle Ficticia 123', '912345678', 'juanperez@email.com'),
('Cliente', 'Ana Gómez', 'DNI', '87654321', 'Av. Real 456', '934567890', 'anagomez@email.com'),
('Cliente', 'Luis Rodríguez', 'DNI', '76543210', 'Calle Ejemplo 789', '945678901', 'luisrodriguez@email.com'),
('Cliente', 'Carlos Martínez', 'DNI', '65432109', 'Calle Muestra 321', '956789012', 'carlosmartinez@email.com');


create table rol(
       idrol integer primary key AUTO_INCREMENT,
       role varchar(30) not null,
       descripcion varchar(100) null,
       estado bit default(1)
);

CREATE TABLE usuario (
    idusuario INTEGER PRIMARY KEY AUTO_INCREMENT,
    idrol INTEGER NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    tipo_documento VARCHAR(20) NULL,
    num_documento VARCHAR(20) NULL,
    direccion VARCHAR(70) NULL,
    telefono VARCHAR(20) NULL,
    email VARCHAR(50) NOT NULL,
    password VARBINARY(255) NOT NULL, 
    estado BIT DEFAULT 1,
    FOREIGN KEY (idrol) REFERENCES rol (idrol)
);

create table ingreso(
       idingreso integer primary key AUTO_INCREMENT,
       idproveedor integer not null,
       idusuario integer not null,
       tipo_comprobante varchar(20) not null,
       serie_comprobante varchar(7) null,
       num_comprobante varchar (10) not null,
       fecha datetime not null,
       impuesto decimal (4,2) not null,
       total decimal (11,2) not null,
       estado varchar(20) not null,
       FOREIGN KEY (idproveedor) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

create table detalle_ingreso(
       iddetalle_ingreso integer primary key AUTO_INCREMENT,
       idingreso integer not null,
       idarticulo integer not null,
       cantidad integer not null,
       precio decimal(11,2) not null,
       FOREIGN KEY (idingreso) REFERENCES ingreso (idingreso) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);

create table venta(
       idventa integer primary key AUTO_INCREMENT,
       idcliente integer not null,
       idusuario integer not null,
       tipo_comprobante varchar(20) not null,
       serie_comprobante varchar(7) null,
       num_comprobante varchar (10) not null,
       fecha_hora datetime not null,
       impuesto decimal (4,2) not null,
       total decimal (11,2) not null,
       estado varchar(20) not null,
       FOREIGN KEY (idcliente) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

create table detalle_venta(
       iddetalle_venta integer primary key AUTO_INCREMENT,
       idventa integer not null,
       idarticulo integer not null,
       cantidad integer not null,
       precio decimal(11,2) not null,
       descuento decimal(11,2) not null,
       FOREIGN KEY (idventa) REFERENCES venta (idventa) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);