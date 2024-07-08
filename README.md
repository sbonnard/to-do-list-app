# To Do List App

Vous devez créer une application web de gestion de listes de tâches. Pour cela vous devez importer ce fichier JSON sur Taïga pour obtenir le product backlog du projet.

Suivez les consignes suivantes :

Modéliser et créer la base de données qui va permettre de répondre aux 6 premières users stories présentent dans le Product Backlog.
Répondre aux besoins de chaque user story du projet dans l’ordre.
Si une user story nécessite un nouvel écran, respecter les étapes front-end avant de vous lancer dans le PHP.
- maquettage (même sommaire)
- page statique HTML / CSS
- dynamisation JavaScript et / ou PHP
L’application web a vocation à être utilisée en priorité sur mobile. Elle doit aussi offrir une interface adaptée et fonctionnelle sur un ordinateur.
Veuillez confirmer à l’utilisateur la prise en compte de ses actions via des notifications appropriées.
Si une user story nécessite une modification structurelle de la base de données, commencez par mettre à jour la modélisation avant de toucher à la base de données.

# Procédé

Ce projet étant un projet d'exercice en formation, j'ai répondu aux user stories avec les outils qui m'ont été fournis au fur et à mesure de leur complétion.

Afin de construire facilement du contenu à la todolist, le fichier quesries.sql permet de créer les tables nécessaire et à générer des données de base pour faire fonctionner l'application à 100%.

# LAMP ENVIRONMENT

## BUILD AND RUN

To build images and run all containers and volumes

```sh
docker-compose up -d
```