I've done the project. Now I want to refractor because it is messy. You're a profesional prompter to AI that create clean POMPTS and very clear. The goal now is that at the end of this conversation you'll create me CLAUDE.md, GOAL.md and RULES.md, SUMMARY.md to refractor this project so that Claude Opus will refractor it. We will also work in the UI\UX of the project.

CLAUDE.md = configure the AI to be a pro clean MVC SOC
GOAL.md = what the AI goals are, what he needs to do (just broad it. give him small steps but not very detailed.)
RULES.md = Refractoring rules. UI\UX rules
SUMMARY.md = What the project is

Now here are my complains:
There are backend logic inside frontend. Normally it should call a Controller for that. 
Some funcitons of controllers literally returns a table. Need to fix that
I want pro SOC MVC but very simple and beginner simple: 
No logic inside frontend views.
DB access is inside models
Controllers are the link

For UI:
Mobile first.
put css inside public\assets\css
delete every css style tag inside every views.
instead put them inside .css and import. Unify in a single .css if possible. And also we need to amke homogene the css of frontoffice and backoffice. 
There are also hardcode backend logic inside frontend. for exmpale there is a tbla einside a view where there is the repartition of composition of a regime. literaltelly hardcoded by name. it shouldnt be like that. Normally we should fetch somewhere and no hardcode.
I use graphs (cicular, trends,...). And their logic are inside the views pages themselves. So maybe we can fetch from a cnotroller if possible, Mayeb create a custom controller with functions inside. like getCricleOf or Idk. But dont put these logic inside views.
There are php functions inside views. dont do that instead call functions of controllers. Views should be very clean. no hardocre. no logic. only display
There are maybe datat processing in the views rn. Delete them and put them in controllers.

Opus should and must remove some classes of html to totally rebuild the whole thing, It can even empty the hoel page to rebuild it form scratch. because I want a really other feel of the pages. somhing really pro and new. 

No query logic inside Controller.

additonnal requests:
In dahsabord I want a chiffre d affiare trend (per date and the amount gained).

For JS logic
JS are very messy too inside the views. some are just a ingle functoin we direclty call. Maybe we can also check this.


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

This is not the real structure but I want a structure like this. Like frontoffic and backoffice with partials or Idk and auth all separted. I'll give you my current architecture. its like eveyrthing is separated and each folder has a inde.php. Read architecture.md to see it. 

What I really want is that:
OPus totally restructure everything in the architecture. delete folders and add folders. move files and stuff.

other notes:
Why sometime it add index.php and osmetimes it doesnt in the url ? see it.

It can use a lot of css files. 
NO cdn

There is no landing page in my actual app: there should be one.

1. Header:
logo, connexion inscirption admin 

✅ 2. Hero Section (MOST IMPORTANT):
Contains:

big title
subtitle
CTA button
illustration/image. 
the hero image is inside public\assets\img\hero.png

✅ 2. Trusted / Stats Section
Small credibility section.

Example:

+200 utilisateurs
+50 régimes
+10 activités sportives

Makes app feel real.

✅ 3. Features Section
“What does the app do?”

Usually cards/icons.

Example:

Calcul IMC
Régimes personnalisés
Activités sportives
Suivi des objectifs

This is one of the most important sections.
I have images inside public\assets\img\meal1.png or meal2 or sport

✅ 4. How It Works


Very common SaaS section.

Usually 3 steps.

Example:

Créez votre profil
Choisissez un objectif
Choisissez les regimes

SUPER important for clarity.

✅ 5. Featured Regimes / Showcase
Show some actual content from your app.

Example cards:

Keto
Fitness
Méditerranéen

Makes app tangible.

no hardcoded. must be fetched from db

✅ 7. Testimonials / Reviews

Even for school project you can simulate.

Example:

“J’ai perdu 5kg en 2 mois”

Adds emotional trust.

can hardcode in backend but we can use icons 

✅ 9. Final CTA Section 
Before footer.

Big final action:

Prêt à commencer votre transformation ?

Button:

[ Créer un compte ]

✅ 10. Footer

Contains:

logo
links
contact
social media
copyright

frontoffie backoffice folders

And the charts and stuff.

delete files that are not needed

i have icons of lucide inside public\assets\icons

Act as:
Very simple. Really simple code and beginner friendly but very powerful.
SoC and MVC clean
Pro

Must:
must never hardcode unless told so. Must always fetch from db.

What I expect:
Pro feeling of a regime app. Clean code. and Clean UI.I reallt encourage Opus to rebuild each views pages.
Rn the UI is very very messy. it can remove section and should. And add othe rsectinos to make it feel like a real pro diet app

Now if you dont undertsad something, ask quesitons. if you do undertand create the .md asked.