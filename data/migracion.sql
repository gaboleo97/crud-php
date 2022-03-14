CREATE DATABASE farmacias;

use farmacias;

CREATE TABLE farmacia (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  direccion VARCHAR(30) NOT NULL,
  latitud VARCHAR(50) NOT NULL,
  longitud VARCHAR(50) NOT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);