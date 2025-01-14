Notre site web :
https://ent.moubarak.butmmi.o2switch.site/index.php

Pour un étudiant : 

Identifiant : clara.moubarak

Mot de passe : clara

ou

Identifiant : alyssa.karahan

Mot de passe : alyssa

Pour l'administrateur : 

Identifiant : isabelle.rouas

Mot de passe : isabelle

--> Procédure à faire pour le MAMP : 

1. Lorsqu'on a déjà toute notre base de données sur le phpMyAdmin de Cpanel, il faut exporter la base de données en allant dans la rubrique en haut de la page "exporter", bien mettre le format en sql et ensuite appuyer sur le bouton exporter
2. Lorsque l'exportation est faite, on voit dans nos téléchargements le nom de notre base de données et on ouvre notre MAMP. 
3. Donc dans la rubrique "importer", on appuie sur "choisir un fichier" et ensuite on choisit la base de donnée qui se situe dans nos téléchargements. On vérifie bien que c'est en UTF-8 et lorsque tout est bon, on appuie sur go. 
4. Si tout fonctionne bien, on aura un message vert nous validant la bonne entrée de notre base de donnée dans le phpMyAdmin local.
5. Il faudra également à l'avenir modifier les noms d'utilisateur et mot de passe dans les codes php, car le nom de la base de données peut être différent, mais surtout les identifiants, par exemple sur mon MAMP, c'est root et root.



Fonctionnalités développées (Back-End)

Côté Étudiant

Gestion des notes :

Visualisation des notes selon le semestre.
Widget d'alerte sur la page d'accueil pour signaler les nouvelles notes.

Gestion des absences :

Justification des absences directement depuis la plateforme.
Widget d'alerte pour signaler les absences à justifier.

Rendus :

Possibilité d'ajouter des rendus personnels en plus de ceux fournis par les professeurs.
Mise à jour de l'état du rendu, possibilité de le marquer comme "pinned" (important) ou de le supprimer.
Widget d'alerte sur la page d'accueil pour les rendus en attente.

Messagerie :

Messagerie entièrement fonctionnelle permettant d'envoyer, répondre, transférer, archiver, et supprimer des messages.
Widget d'alerte pour notifier l'utilisateur en cas de nouveau message non lu.

Emploi du Temps :

Récupération automatique de l'emploi du temps via une sorte d'API faite maison, mise à jour tous les lundis à 6h grâce à une tâche cron.
Génération de l'emploi du temps directement depuis les données de l'université Gustave Eiffel.



Côté Back-Office

Gestion des utilisateurs :

Inscription des étudiants et des professeurs avec génération automatique de login, mail et numéro d'étudiant selon le nom et prénom.
Affichage de la liste des utilisateurs avec possibilité de suppression d'un utilisateur.

Gestion des absences :

Ajout des absences pour les étudiants.
Validation ou rejet des justificatifs envoyés par les étudiants.

Gestion des notes :

Ajout individuel des notes pour les étudiants.
Possibilité d'ajouter des notes à plusieurs élèves en une fois via l'importation d'un fichier PDF contenant les numéros d'étudiant (utilisation de la bibliothèque PDFParser).



Fonctionnalités Bonus

Mot de passe oublié :

Système de réinitialisation du mot de passe avec génération d'un mot de passe temporaire à l'inscription.




Tout le front a été développé

