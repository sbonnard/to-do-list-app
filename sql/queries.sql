CREATE DATABASE jotit_doit;

CREATE TABLE task (
    id_task SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    emergency_level TINYINT UNSIGNED NOT NULL DEFAULT 2,
    status VARCHAR(20) NOT NULL DEFAULT 'TO DO',
    id_colours SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (id_task),
    FOREIGN KEY (id_colours) REFERENCES colours(id_colours)
);

INSERT INTO task (name, date, emergency_level)
VALUES ('Faire une liste', CURDATE(), 5);

INSERT INTO task (name, date, emergency_level)
VALUES ('Dépoussiérer ma guitare', CURDATE(), 2);

INSERT INTO task (name, date, emergency_level)
VALUES ('Acheter médiators', CURDATE(), 2);

INSERT INTO task (name, date, emergency_level)
VALUES ('Set List Concert', CURDATE(), 3);

INSERT INTO task (name, date, emergency_level)
VALUES ('Manger une tourte au poulet', CURDATE(), 1);

INSERT INTO task (name, date, emergency_level)
VALUES ('Colis Vinted', CURDATE(), 5);

INSERT INTO task (name, date, emergency_level)
VALUES ('Apprendre contrebasse', CURDATE(), 1);

INSERT INTO task (name, date, emergency_level)
VALUES ('Préparer voyage', CURDATE(), 2);

INSERT INTO task (name, date, emergency_level)
VALUES ('Acheter une Epiphone ES335 Cherry', CURDATE(), 1);

UPDATE task SET status = 'DONE' WHERE id_task = $task['id_task'];


CREATE TABLE colours (
    id_colours SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    hexa_code VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_colours)
);

INSERT INTO colours (name, hexa_code)
VALUES ('dark_green', '#1B7F79'), ('orange', '#CA4F0A'), ('zinzolin', '#A72E47');
 

ALTER TABLE task
ADD id_colours VARCHAR(255)

, `date` = CURDATE(), `emergency_level` = :emergency_level