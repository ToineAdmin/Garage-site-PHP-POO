CREATE DATABASE IF NOT EXISTS db_garage;
CREATE TABLE IF NOT EXISTS users
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL
);

INSERT INTO users (username, role)
 VALUES
 ('Vincent', 1),
 ('Hubert', 2 ),
 ('Jean', 2);

CREATE TABLE IF NOT EXISTS services
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES users(role)
);

INSERT INTO services(name)
VALUES
('Réparation'),
('Entretien'),
('Contrôle Technique'),
('Depannage');

CREATE TABLE IF NOT EXISTS cars
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    brand VARCHAR(150) NOT NULL,
    year_of_circulation INT(4) NOT NULL,
    slug VARCHAR(255) NULL,
    miles INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    info VARCHAR(255) NOT NULL,
    equipments VARCHAR(255) NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO cars (brand)
VALUES
('Peugeot'),
('Citroën'),
('Volvo');

CREATE TABLE IF NOT EXISTS medias
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    file VARCHAR(255) NOT NULL,
    car_id INT,
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

CREATE TABLE IF NOT EXISTS configs
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    value VARCHAR(200) NOT NULL
);

CREATE UNIQUE INDEX idx_configs_name ON configs (name);