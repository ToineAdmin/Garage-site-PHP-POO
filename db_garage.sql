CREATE DATABASE IF NOT EXISTS db_garage;
CREATE TABLE IF NOT EXISTS users
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL
);

INSERT INTO users (username, password, role)
 VALUES
 ('Vincent', '$2y$10$Z6UpC2PaWdpTAfSWwntUPeULUviVMQ4xkvU5IazGw.3ieKZbObC.m', 1),
 ('Hubert', '$2y$10$FXHj7innBMbAyeockURn0.stoQ4ekSztrDsdDVv40xELonXC7MqAO', 2 ),
 ('Jean','$2y$10$so4QXuzYQVCuIu7SrEjNgeKth3.jpzr0wgBSqeyOb8EGTXQlY1dZq', 2);

CREATE TABLE IF NOT EXISTS services
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NOT NULL
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
	price INT NOT NULL,
    miles INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    info VARCHAR(255) NOT NULL,
    equipments VARCHAR(255) NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO cars (name, brand, year_of_circulation, price, miles, description,info,equipments)
VALUES
('Peugeot 208', 'Peugeot', 2010, 4000, 124000, 'La Peugeot 208 est une voiture dans l\'air du temps, polyvalente et particulièrement confortable pour un véhicule de sa catégorie. Elle est également écologique et économique et satisfait les automobilistes les plus exigeants, tant en matière de budget que de performances et d\'esthétisme.', 'Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui.' ),
('Citroën C4','Citroën', 2013, 5500, 112000, 'Voiture berline de tous les jours. Conduite très agréable. Beaux volumes. Confortable et fiable','Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui. Option sport: oui' ),
('Volvo EX30', 'Volvo', 2020, 12000, 98000, 'EX30. Des performances électriques impressionnantes dans un petit format. Conduite intuitive. Sécurisation optimale', 'Boite de vitesse: manuelle. Nombre de places: 5. Nombre de portes: 5.', 'climatisation:oui. Option: economie d\'energie');

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