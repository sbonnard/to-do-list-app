CREATE DATABASE jotit_doit;

CREATE TABLE task (
    id_task SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    emergency_level TINYINT UNSIGNED NOT NULL DEFAULT 2,
    status VARCHAR(20) NOT NULL DEFAULT 'TO DO',
    PRIMARY KEY (id_task)
);

INSERT INTO task (name, description, date, status, emergency_level)
VALUES ('Faire une liste', CURDATE(), 'To Do', 5);

INSERT INTO task (name, description, date, status, emergency_level)
VALUES ('Dépoussiérer ma guitare', CURDATE(), 2);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Acheter médiators', CURDATE(), 2);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Set List Concert', CURDATE(), 3);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Manger une tourte au poulet', CURDATE(), 1);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Colis Vinted', CURDATE(), 5);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Apprendre contrebasse', CURDATE(), 1);

INSERT INTO task (name, description, date, emergency_level)
VALUES ('Préparer voyage', CURDATE(), 2);

