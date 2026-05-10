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





OKay now we're in the CRUD 