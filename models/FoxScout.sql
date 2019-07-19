CREATE DATABASE foxscout;


use foxscout;

CREATE TABLE IF NOT EXISTS Tienda(
    id_tienda int not null auto_increment,
    Nombre varchar(25) not null,
    primary key(id_tienda)
)
auto_increment = 1,
engine = InnoDB;

CREATE TABLE IF NOT EXISTS Direccion(
    id_direccion int not null auto_increment,
    calle   varchar(40) not null,
    colonia varchar(60) not null,
    numero  varchar(10) not null,
    tienda_id int not null,
    ciudad_id int not null,
    primary key(id_direccion),


    CONSTRAINT rel_tienda
    FOREIGN KEY (tienda_id)
    REFERENCES Tienda(id_tienda)

    CONSTRAINT rel_ciudadD
    FOREIGN KEY (ciudad_id)
    REFERENCES Ciudad(id_ciudad)
)
auto_increment = 1,
engine = InnoDB;

-- Introducir categoria y subcategoria

CREATE TABLE IF NOT EXISTS Categoria(
    id_categoria int not null auto_increment,
    nombre      varchar(25),
    primary key(id_categoria)
)
auto_increment = 1,
engine = InnoDB;

CREATE TABLE IF NOT EXISTS Subcategoria(
    id_subcat int not null auto_increment,
    nombre    varchar(25),
    categoria_id int not null,
    primary key(id_subcat),

    CONSTRAINT rel_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES Categoria(id_categoria)
)
auto_increment = 1,
engine = InnoDB;

CREATE TABLE IF NOT EXISTS Producto(
    id_prod int not null auto_increment,
    nombre  varchar(70) not null,
    descripcion varchar(255) null,
    subcategoria_id int not null,
    codigoB  varchar(100) not null,
    primary key(id_prod),

    CONSTRAINT rel_subcategoria
    FOREIGN KEY (subcategoria_id)
    REFERENCES Subcategoria(id_subcat)

)
auto_increment = 1,
engine = InnoDB;

-- Tabla de precio por tienda
CREATE TABLE IF NOT EXISTS PrecioxTienda(
    id_PxTienda int not null auto_increment,
    precio      float(9,2) not null,
    prod_id int not null,
    direccion_id int not null,
    primary key(id_PxTienda),

    CONSTRAINT rel_producto
    FOREIGN KEY (prod_id)
    REFERENCES Producto(id_prod),


    CONSTRAINT rel_direccion
    FOREIGN KEY (direccion_id)
    REFERENCES Direccion(id_direccion)
)
auto_increment = 1,
engine = InnoDB;


CREATE TABLE IF NOT EXISTS Estado(
    id_estado int not null auto_increment,
    nombre      varchar(25) not null,
    primary key(id_estado)
)
auto_increment = 1,
engine = InnoDB;

CREATE TABLE IF NOT EXISTS Ciudad(
    id_ciudad   int not null auto_increment,
    nombre      varchar(25) not null,
    estado_id int not null,
    primary key(id_ciudad),

    CONSTRAINT rel_estado
    FOREIGN KEY (estado_id)
    REFERENCES Estado(id_estado)
)
auto_increment = 1,
engine = InnoDB;

CREATE TABLE IF NOT EXISTS Usuarios(
    id_usuario int not null auto_increment,
    nombre      varchar(50) not null,
    apellidoP   varchar(20) null,
    apellidoM   varchar(20) null,
    email       varchar(255) not null,
    contra      varchar(255) not null,
    admin       boolean not null,
    ciudad_id   int not null,

    CONSTRAINT rel_ciudad
    FOREIGN KEY (ciudad_id)
    REFERENCES Ciudad(id_ciudad)
)
auto_increment = 1,
engine = InnoDB;


CREATE TABLE IF NOT EXISTS Califa(
    id_califa   int not null auto_increment,
    nEstrellas  float(3,2) not null,
    prod_id     int not null,
    direccion_id int not null,
    usuario_id      int not null,

    CONSTRAINT rel_producto_califa
    FOREIGN KEY (prod_id)
    REFERENCES Producto(id_prod),

    CONSTRAINT rel_direccion_califa
    FOREIGN KEY (direccion_id)
    REFERENCES Direccion(id_direccion),

    CONSTRAINT rel_usuario_califa
    FOREIGN KEY (usuario_id)
    REFERENCES Usuarios(id_usuario)

)
auto_increment = 1,
engine = InnoDB;
