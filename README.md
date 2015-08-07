#Nommage des snippets :

- Tout en minuscule
- Le double-tiret permet de séparer les différentes parties du nom

{technologie}--{description-snippet}.{language}

#Exemple :

```
drupal--hook_menu.php
```

#Retrouver rapidement un snippet

Mettre la commande suivante dans le .bash du profil utilisateur
ss pour "snippet search" :
A la place de "/Applications/MAMP/htdocs/snippets", mettre le dossier contenant le dépot git des snippets.

```sh
function ss { cd /Applications/MAMP/htdocs/snippets; ls -1 | grep "$1.*$2.*$3\|$2.*$1.*$3\|$3.*$2.*$1\|$1.*$3.*$2\|$2.*$3.*$1\|$3.*$1.*$2"; }
```

La commande "ss" liste tous les plugins
Tous les mots suivants seront des critères de recherche sur le nom du fichier avec l'opérateur ET.
Exemple; la commande "ss redirect drupal user" retournera la fichier nommé "drupal-7--user-redirect-from-login.php"

Il est possible de chercher à l'intérieur des snippets avec grep :

grep -Erin 'apples|oranges' 

AND operator (ionic AND controller, in any order in the same line)
grep -Eril "ionic.*controller|controller.*ionic"

Create some alias in .bash

````sh
#search snippets in snippet database : ouput filename
function ss { grep -Erinl "$1" /Applications/MAMP/htdocs/snippets --exclude-dir=".git"; }

#search and open found snippets in vim
function sso { vim -o $(ss "$1");}

```
     

