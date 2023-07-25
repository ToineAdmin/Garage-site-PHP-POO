CREATE DATABASE IF NOT EXISTS db_garage;

USE db_garage;

CREATE TABLE IF NOT EXISTS users
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL,
    job VARCHAR(50) NOT NULL
);

INSERT INTO users (email, password, role, job)
VALUES
('vincent@gmail.com', '$2y$10$Z6UpC2PaWdpTAfSWwntUPeULUviVMQ4xkvU5IazGw.3ieKZbObC.m', 1, 'Patron'),
('hubert@gmail.com', '$2y$10$FXHj7innBMbAyeockURn0.stoQ4ekSztrDsdDVv40xELonXC7MqAO', 2, 'Mécanicien'),
('jean@gmail.com', '$2y$10$so4QXuzYQVCuIu7SrEjNgeKth3.jpzr0wgBSqeyOb8EGTXQlY1dZq', 2, 'Mécanicien');

CREATE TABLE IF NOT EXISTS services
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NOT NULL
);

INSERT INTO services(name, description)
VALUES
('Réparation', 'Nous faisons tout type de réparations avec soins et professionnalisme.'),
('Entretien','Une voiture bien entretenue, c\'est une voiture qui dure. Avec nous elles le seront.'),
('Contrôle Technique', 'Depuis plus de 10ans nous effectuons les contrôles nécessaires à la sécurité de tous.'),
('Depannage', 'Un service de dépannage 24h/24h, pour que vous ayez l\'esprit tranquille.');

CREATE TABLE IF NOT EXISTS cars
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    brand VARCHAR(150) NOT NULL,
    year INT(4) NOT NULL,
    price INT NOT NULL,
    miles INT NOT NULL,
    description TEXT NOT NULL,
    caracteristics TEXT NOT NULL,
    equipement TEXT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO cars (name, brand, year, price, miles, description, caracteristics, equipement, user_id)
VALUES
('Peugeot 208', 'Peugeot', 2010, 4000, 124000, 'La Peugeot 208 est une voiture dans l\'air du temps, polyvalente et particulièrement confortable pour un véhicule de sa catégorie. Elle est également écologique et économique et satisfait les automobilistes les plus exigeants.', 'Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui.', 1),
('Citroën C4', 'Citroën', 2013, 5500, 112000, 'Voiture berline de tous les jours. Conduite très agréable. Beaux volumes. Confortable et fiable', 'Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui. Option sport: oui', 1),
('Volvo EX30', 'Volvo', 2020, 12000, 98000, 'EX30. Des performances électriques impressionnantes dans un petit format. Conduite intuitive. Sécurisation optimale', 'Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui. Option: economie d\'energie', 1);

CREATE TABLE IF NOT EXISTS media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  path VARCHAR(255) NOT NULL,
  user_id INT,
  car_id INT,
  FOREIGN KEY (car_id) REFERENCES cars(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO media (name, path, user_id, car_id)
VALUES
('profil-1.jpg', 'public/img/profil-1.jpg', '1', NULL),
('profil-3.jpg', 'public/img/profil-3.jpg', '2', NULL),
('profil-5.jpg', 'public/img/profil-5.jpg', '3', NULL),
('208(1).jpg', 'public/img/208(1).jpg', NULL, '1'),
('208(2).jpg', 'public/img/208(2).jpg', NULL, '1'),
('208(3).jpg', 'public/img/208(3).jpg', NULL, '1'),
('c4(1).jpg', 'public/img/c4(1).jpg', NULL, '2'),
('c4(2).jpg', 'public/img/c4(2).jpg', NULL, '2'),
('volvo1.jpg', 'public/img/volvo1.jpg', NULL, '3'),
('volvo2.jpg', 'public/img/volvo2.jpg', NULL, '3');

CREATE TABLE IF NOT EXISTS configs
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    value VARCHAR(200) NOT NULL
);

CREATE UNIQUE INDEX idx_configs_name ON configs (name);
