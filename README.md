#Nommage des snippets :

- Tout en minuscule
- Le double-tiret permet de séparer les différentes parties du nom

{technologie}--{fonctionnalite}.{language}

#Exemple :

```
drupal--hook_menu.php
```

#Using unix commands to search for snippets

search a snippet with "apples" OR "oranges" characters
E is automatic escaping for "|", just remove to search for a "|"

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
     

