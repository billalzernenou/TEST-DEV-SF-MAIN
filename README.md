test-dev
========

Un stagiaire à créer le code contenu dans le fichier src/Controller/Home.php

Celui permet de récupérer des urls via un flux RSS ou un appel à l’API NewsApi. 
Celles ci sont filtrées (si contient une image) et dé doublonnées. 
Enfin, il faut récupérer une image sur chacune de ces pages.

Le lead dev n'est pas très satisfait du résultat, il va falloir améliorer le code.

Pratique : 
1. Revoir complètement la conception du code (découper le code afin de pouvoir ajouter de nouveaux flux simplement) 


Questions théoriques : 
1. Que mettriez-vous en place afin d'améliorer les temps de réponses du script
2. Comment aborderiez-vous le fait de rendre scalable le script (plusieurs milliers de sources et images)

Réponses : 

1) 

-J'ai remarqué que la méthode utilisé par le stagiaire pour "validate l'url de 'l'image" prennait beacuoup de temps. 
 pour cela choisir la bonne méthodes pour réalisé ce genre de process est important.

 -algorithmiquement parlant il est important de garder la complexité du code le plus faible possible.

 -utiliser des fonctions comme array_merge , unique_array pour mapper car ce genre de fonction (arrayIterators) dont conçu de manière optimale. 
 -sécuriser le code avec des conditions ce qui nous évetera de faire des traitements inutiles. 

 -utiliser des solution de cache 
 -choisir le bon hosting 
 -Factorisation de code et utilisationde services. 
 


2) 
API : concevoir l'api d'une manière est ce qu'il permis d'envoyer des réponse type ?limit=x skip=y &sort=z. 
     - utiliser un middle api si l'api principal ne correspond pas à notre besoin front. 

client : 
-utiliser Webpack comme solution pour gérer et minifier les differents assets.

-progressive upload : 
    *Utiliser un button suivant pour effectuer une nouvelle query pour charger plus de data. 
    *Utiliser des composant dédié (FlatView au lieu de Scrollview avec ReactNative par exemple). 
- utiliser le stockage local de navigateur (cockies) pour éviter d'éffectuer des requêtes répétitives.