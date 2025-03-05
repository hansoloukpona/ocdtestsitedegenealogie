Bonjour,

C'est la première fois que je dois passer un test pour un poste à ce stade du processus. Vous voudrez bien excuser le temps d'attente pour ma réponse. Je suis une personne relativement occupée.
Ceci dit, l'exercice était intéressant.

## Partie 1 et Partie 2

Je serais peut-être allé plus loin si je n'avais pas tant de choses à faire. Mais si vous me prenez en stage (et j'espère que le fait même de lire ceci vous convainc de ma motivation à celà) je serais ravi d'aller plus loin. 

Pour la recherche de degrée dans la **partie 2**, j'ai utilisé un _**parcours en largeur (BFS)**_ avec SQL brut. Je sais ce que c'est que l'algo en soi (je l'ai étudié en licence) mais il a fallu que Gpt me le suggère parmi d'autres options. 

Je dois aussi dire que bien que je comprends tout le code qui est écrit, je ne me suis pas gêné pour en faire écrire une partie par ChatGpt (j'espère que ça ne vous gêne pas non plus et je suis bien conscient que certains projets requièrent un niveau de confidentialité qui ne permettrait pas de faire ça).

## Partie 3 

* ### Structure de la base de données

(L'image est à la base du dossier, elle porte le nom : "ocd partie 3 Mcd")

J'ai choisi de faire un modèle conceptuel entre autre pour bien faire transparaître la distinction théorique que je fais entre un utilisateur (user) et son profil. Mais il faut savoir que dans un modèle physique user et person forment une même table.

Pareil pour les deux types de propositions que seront dans une seule table et dont la distinction se fera avec un attribut "type".

1. [x] users : Gestion des utilisateurs inscrits.
2.[x] person : Fiches des personnes avec les informations personnelles.
3.[x] relationships : Relations de parenté entre les personnes.
4.[x] proposition : Propositions de modifications ou d’ajouts de relations.
5.[x] evaluation : Historique des votes pour les propositions (acceptation ou refus).
6.[x] invitations : Gestion des invitations envoyées aux futurs membres.

* ### Description de l'évolution des données

+ #### Propositions de Modifications

1. Lorsqu'un utilisateur propose une modification :

    - Insertion dans "proposition" avec les détails de la modification. (Ici les détails sont stockés dans l'attribut details au format JSON. C'est peut-être une petite entorse aux formes normales en base de donnée. Mais c'est fait à dessein et pour optimiser.)

    - État initial : pending.

    - La proposition est visible par tout le monde

+ #### Validation des Modifications

1. Les utilisateurs votent via la table evaluation :

    - Insertion d’un vote avec user_id, proposal_id et vote (accepté ou refusé).

2. Si 3 votes positifs sont atteints :

    - Mise à jour de proposition à accepted.

    - Application de la modification dans les tables concernées (person ou relationships).

3. Si 3 votes négatifs sont atteints :

    - Mise à jour de proposition à rejected.


PS : Il y a une ambiguïté entre ce que dit "4 - Propositions de Modifications" et "5 - Validation des Modifications". 
En effet, le 4 parle de la validation par "au moins trois membres de la communauté" sans plus de condition. Cela suppose que n'importe quel membre de la communauté peut évaluer n'importe quelle proposition.
Pourtant, le 5 dit que "les propositions (...) sont examinées par chaque utilisateur concerné et peuvent être acceptées ou refusées." En l'état de la description et si je me fie à mes cours de Processus de développement Logiciel, rien n'oblige formellement que les utilisateurs concernés par la proposition expriment un avis et leur avis n'a pas plus de valeur que celui des autres.
Il y a donc un manque ou une absence de pertinence par rapport à la notion de concerné, à moins que le but soit uniquement et simplement de s'assurer que les utilisateurs concernés aient vu une proposition qui les concerne.


Hans OLOUKPONA-YINNON
