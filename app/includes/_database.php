<?php

// CONNECTION 
try {
    $dbCo = new PDO(
        'mysql:host=db;dbname=jotit_doit;charset=utf8',
        'app-crud',
        'dwwm2024'
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (EXCEPTION $error) {
    die('Échec de la connexion à la base de donnée.' . $error->getMessage());
}