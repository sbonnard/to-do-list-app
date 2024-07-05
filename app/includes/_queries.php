<?php

$queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level, deadline FROM task WHERE status = 'TO DO' ORDER BY emergency_level DESC;");
$tasks = $queryGetTasks->fetchAll();

$queryGetThemes = $dbCo->query("SELECT id_theme, theme_name FROM themes;");
$themes = $queryGetThemes->fetchAll();