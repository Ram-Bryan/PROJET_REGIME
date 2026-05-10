There are frontend logic inside frontend. Normally it should call a Controller for that. 
Some funcitons of controllers literally returns a table.
I want pro SOC MVC but very simple and beginner simple: 
No logic inside frontend views.
A unified css. for everything.
No query logic inside Controller.
Folders are very messed up I want a structure like this: 
app/
└── Views/
    ├── backoffice/
    │   ├── layout.php
    │   ├── partials/
    │   │   ├── sidebar.php
    │   │   ├── navbar.php
    │   │   └── footer.php
    │   │
    │   ├── dashboard/
    │   │   └── index.php
    │   │
    │   ├── regime/
    │   │   ├── index.php
    │   │   ├── create.php
    │   │   ├── edit.php
    │   │   └── details.php
    │   │
    │   ├── utilisateur/
    │   └── commande/
    │
    ├── frontoffice/
    │   ├── layout.php
    │   ├── partials/
    │   │
    │   ├── home/
    │   ├── regime/
    │   ├── profile/
    │   └── commande/
    │
    ├── auth/
    │   ├── login.php
    │   └── register.php
    │
    └── errors/

This is not the real structure but I want a structure like this. Like frontoffic and backoffice with partials or Idk and auth all separted. 


Opus can remove some classes of html to totally rebuild the whole thing, It can even empty the hoel page to rebuild it form scratch. 

Why sometime it add index.php and osmetimes it doesnt ? 
Some stuff are hardcoded in conrollers and in frontend views. 


We're in backoffice

OKay now we're in the CRUD of COde PROMO:
Remove column ID
Column Utilsiatuer will be renamed as  Utilisé par: if user exist then display the name of the utilsiatuer. Else put empty.
Edit and delete are icons
Add filter min max montant. And a radio etat tout disponible utilse 

Creating:
Deja utilise checkbox doestn exit 

Now make this frontoffice-backoffice Code logique:
When a client enter a code promo (page code promo of frontoffice), It shouldnt direclty say that it is confirmer. INstead it can say code alreayd used. Or it does this: It waits. The admin connect and go ot validation code promo page, and see all teh people who sent codes. And then it can confirm if he accpet teh code or not. ANd also we should add a tooltip next to it (No code match or match) to see if the code listed has a match inside the list of availbale code.