Script qui prend une chaîne de caractères en paramètre, qui représente une expression mathématique.

Elle évalue cette expression et retourne le résultat en tenant compte des priorités.

Exemple : php index.php "3+4*45+(3*(3-2)/2+(3-2)/2)%3-3"

Sans l'utilisation de la fonction eval() qui est très déconseillée car elle autorise l'exécution de code PHP arbitraire.