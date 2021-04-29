
# wediscuss_

 Acceder à notre site 🖥 : https://wediscuss.fr

## Une introduction et la présentation de votre équipe

 <br>
Notre équipe est composée de deux étudiants : Clément Gambier et Thomas Mauran. <br>
Nous sommes tous les deux étudiants en première année de DUT Informatique à l’IUT de Montpellier.<br>
L’analyse de la problématique et notre solution pour y répondre <br>
A la lecture du sujet nous avons tout de suite pensé à réaliser un site web qui permettrait à tout le monde de déposer des informations sur lesquelles tout le monde pourrait débattre. <br>
Afin de combattre les fakes news nous laissons chaque utilisateurs voter pour ou contre sur chaque information. <br>
Pour connaître la fiabilité d’un article on peut également regarder le score de fiabilité de l’auteur qui est calculé selon le nombre de like et de dislike qu’il a reçu.<br>

## La présentation et justification de nos choix techniques <br>

**Les technologies employées :** <br>
Notre site web a été réalisé en HTML, CSS, PHP, SQL. <br>
Nous avons abordé au premier semestre la conception de site web avec l’HTML et le CSS donc nous avions quelques bases de plus nous avons participé ensemble à la Nuit de l’Info qui nous a également beaucoup appris. <br>
Ensuite pour le back end nous ne connaissions aucun langage donc nous avons choisi le PHP qui nous semblait le plus simple a assembler avec les autres technologies que nous avons choisi. <br>
Nous n’avions aucune connaissance dans ce langage donc nous avons suivi le cours disponible sur Openclassroom et des tutoriaux plus spécifiques sur youtube.<br>
A l’aide de nos cours de base de données nous savions écrire des requêtes SQL, il nous a fallu apprendre 2 syntaxe car sur certains tutoriels ils utilisaient mysqli et d’autres un PDO. <br>
Finalement, nous avons adapté nos fichiers et la majorité fonctionne avec un PDO car nous avons trouvé cela plus simple pour gérer plusieurs requêtes en même temps. <br>
Ensuite pour la gestion des bases de données nous avons utilisé PHPmyadmin, nous n’avons pas eu de grandes difficultés car c’est un outil que nous trouvons très facile à prendre en main.<br>
**Le serveur**<br>
Héberger un site web était aussi une expérience nouvelle pour nous. <br>
Nous avons décidé de nous tourner vers les services de Pulseheberg qui proposent des serveurs avec des prix très abordables, une capacité de stockage largement suffisante pour notre projet et enfin une interface web très pratique pour des novices comme nous. <br>
Une fois le serveur acquis nous avons acheté le nom de domaine wedisscus.fr et grâce a l’interface plesk proposée par pulseheberg il nous a été très simple de relier notre serveur a cette url. Toujours grâce à la même interface il nous a été possible de générer un certificat SSH gratuitement pour rendre notre site https.<br>
**Le style du site**<br>
Pour ce qui est du style graphique du site étant donné notre faible niveau en design nous avons décidé de partir sur un style épuré avec des logos simples à comprendre, des animations minimalistes et comme couleur principale le blanc et le lavande. <br>
## Notre organisation<br>

Pour ce qui est de l’organisation nous avons au début commencé avec github et l’IDE Atom mais n’étant absolument pas habitué à utiliser github nous avons vite commencé à directement modifier les fichier sur le serveur, ce qui n’est pas une très bonne habitude mais nous permettait de toujours travailler sur une version à jour. <br>
Un collègue de travail nous a montré visual studio code et une extension ftp qui permet de modifier directement les fichiers sur le serveur en sauvegardant ce qui nous a permis d’être bien plus productif.<br>
Cependant si nous avions voulu être plus responsable il nous aurait fallu mettre un place un système de versionnage avec github.<br>


## Les fonctionnalités de notre site web<br>

Avant d’aborder les fonctionnalités, voici une représentation de notre base de données afin de mieux appréhender nos démarches ( les flèches représentantes les clés étrangères présentes entre les tables).<br>
**Fonctionnalités importantes :** <br>


1) Déposer des articles<br>
Afin de pouvoir débattre d’un sujet, il faut tout d’abord créer une base à débattre. <br>C’est pour cela que tous les utilisateurs de wediscuss peuvent ajouter un article sur lequel tous les utilisateurs pourront venir débattre. Pour cela on utilise une page html qui sert de formulaire qui lorsqu'elle est complétée lance une requête INSERT dans la table article.<br>


2) Afficher des articles <br>
Pour l’affichage, c’est très simple : une première page affiche tout les articles avec uniquement le titre, l’auteur et le nombre de commentaires (afin de connaître les articles où les débats sont les plus acharnés ! ). Ensuite, si on veut voir le contenu de l’article il suffit de cliquer sur la loupe pour accéder à la page la plus avancée du site.  Cette page affiche le titre, l’auteur et son score de fiabilité, le contenu de l’article et ses sources.<br>
Afin d’afficher ces informations une simple requête à la base de données suffit.
Ensuite afin de donner une valeur numérique à l’avis des gens sur le sujet nous avons implémenté un système de like et dislike. <br>

3) Commentaire et sources <br>
La suite de la page afficher les articles se compose de deux champs de texte afin de rajouter une source ou encore un commentaire. Finalement on affiche l’espace commentaire qui est un endroit permettant a tout à chacun de débattre sur le sujet. 

4) Le score de fiabilité<br>
Pour savoir si un article est fiable, nous avons mis en place un score de fiabilité. <br>Chaque utilisateur possède un score en pourcentage qui indique s' il est plus ou moins fiable. <br>Ce score est calculé en fonction du nombre de like et de dislike que l’utilisateur a reçu sur ses articles.<br>
	

5) Barre de recherche <br>
Il nous semblait obligatoire de permettre aux utilisateurs de trouver un article. <br>C’est pour cela que notre barre recherche a été faite.<br> Grâce à elle vous pouvez chercher un utilisateur, cela vous montrera les articles qu’il a écrit.<br> Mais encore plus utile un nom d’article.<br> Une chose qui n’est pas encore aboutie c’est que si vous tapez un mot le système vous propose les articles où ce mot est présent, pour le futur nous voudrions améliorer la précision de ce système. <br>
D’ailleurs vous ne serez pas déçu si vous tapez n’importe quoi dans la barre de recherche (ne fonctionne pas sur safari …).<br>

6) Profil <br>
Nous avons mis en place une page de profil qui permet à tous les utilisateurs de modifier leurs biographies ainsi que leurs pseudonymes.<br> Ils peuvent aussi consulter leurs date d'inscription, leurs nombre d'articles et leur score de fiabilité sur cette même page. <br>En cliquant sur la photo de profil il est possible d’éditer les informations de son compte.<br>


7) Nous avons décidé de forcer la connexion <br>
En effet, nous avons forcé la connexion afin de faciliter l’utilisation du site. <br>Si vous n’étiez pas connecté vous ne pourrez pas accéder à toutes les fonctionnalités du site (car il vous faut un username afin de pouvoir écrire un article ou un commentaire). <br>Il aurait donc fallu rediriger l’utilisateur sur la page connexion et bloquer l’envoie des articles et des commentaires.<br>

8) Les tags<br>
Pour organiser chaque article, nous avons mis en place un système de tag qui permet de les différencier en fonction de leurs catégories. Voici la liste des tags présent sur le site :
Informatique
Mathématique
Science
Culture
Droit
Actualité
Nouvelle technologie
Autre


## Conclusion<br>

**Les difficultés :** <br>
L’apprentissage du PHP, la syntaxe est vraiment difficile à prendre en main. <br>
L’implémentation du CSS dans les fichiers PHP. Certaines fois cela fonctionnait, d’autres fois non, il se pourrait qu’il y ait un peu de CSS inline … pardon ...<br>
**Ce que l’on a appris :**<br>
Tout le long de ce projet on a énormément appris, alors tout dire prendrait du temps mais voici les choses les plus marquantes : 
Le PHP
La gestion de base de données.
Prise en main d’outils qui permettent de faciliter le développement.
Faire des briefing pour voir l’avancée du projet. <br>
**Autocritique** :<br>
Nous sommes très fiers de notre site web.<br> Comme précisé plus tôt, nous sommes en première année à l'IUT de Montpellier.<br> Ce projet nous a permis de découvrir comment mettre en pratique ces requêtes sql et les adapter à une page web.<br> Il manque quelques fonctionnalités mineures que nous n’avons pas eu le temps d'implémenter en raison d’un manque de temps.<br> Comme le fait de pouvoir consulter le profil des autres utilisateurs, faire une recherche par tag ou modifier sa photo de profil.<br> Nous nous sommes concentré sur les fonctionnalités majeures car chaque fonctionnalité nous a pris beaucoup de temps en raison de notre faible expérience.<br>
**Les erreurs :** <br>
Commencer par le front a été une erreur majeure qui nous a fait perdre beaucoup de temps, nous aurions dû commencer par concevoir toutes les fonctionnalités puis appliquer un style graphique à notre site.<br>
Faire un diagramme d'attributs pour la base de données aurait aussi permis de gagner du temps. <br>Car nous avons dû recréer plusieurs fois des tables.
Le fait de ne pas utiliser github nous a valu plusieurs fois des problèmes de version et donc une perte de temps considérable.<br>

**Nos réussites**<br>
Nous avons rempli la plupart des fonctionnalités désirées au départ qui étaient : 
pouvoir créer des articles, un système de like / dislike, la barre de recherche et le  score de fiabilité.<br>
Les perspectives de notre application.<br>
A l’avenir nous aimerions implémenter les fonctionnalités suivantes : <br>
1) Séparer toutes les informations en différentes pages.
2) Accéder au profil d’une personne
3) Pouvoir modifier sa photo de profil<br>

Merci de nous avoir permis de participer à ce projet, ce fut très enrichissant et on a pris beaucoup de plaisir à le réaliser. <br>
<br>
Thomas Mauran et Clément Gambier
