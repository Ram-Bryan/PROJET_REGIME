historique des transaction:
Ne pas mettre prix duree

Mot de passe a 6 caractere dans login ?
Values par defualt direct dnas le login
Rn rouge les erreurs d'inscription et de login
Et si perte de piods et piods object different

Repete bcq de fois:
Solde insuffisant pour acheter ce regime
Ce code promo a deja ete utilse

Pas de "code promo introuvable" dans front office. Code promo confirmer par admin.

Eye sur le mdp

Cards confirmer achat ou encore deconexion.



Login page: 
Remove the "Minimum 6 caractere" and the funcitonality of this. Normally we dont show these in the a login page.

Inscription page:
add a tool progressbar above to see in whic step we are rn
add useful placeholders for each inputs

Everytime we enter something in the input and then we out of focus the input then there should be a green checkmark at the end of the input to see if what we did is correct to the standanrd of name or norm. Else there is a red cross and an little error at the bottom of the input to see what is wrong. SO ajax and validatoin works a lot.
For exmaple, make an ajax call to see if the email is alrady in use (search in db and stuff). Or to see if mdp is not okay or stuff like that. Every input should have a green\red validation.


step1:
email and mdp should be at the bottom 
Put an asterix * next to the inputs that are important: nom, email, mdp. Genre will be default to Autre (add this value inside database.sql) and date the naissance will then be NULL and in the profil page if null it will be <?= $user['date_naissance'] ?? 'Non renseignée' ?> if these are not filled. So these inputs are not required.

STep2:
if we're in step2 and When we go back to step1, we should stil keep the infos we enterered step1. Because rn step1 goes all blank.
Same validation goes for steps2 inputs.

THis is high UX\UI so be careful with this one:
When taille and poids are entered, we js ajax backend the calcualtion of its IMC (UserModel has the function to calcualte it), and e display it, and we say in what range the person is. Maybe you can add some kind of progress bar at the bottom of the inputs to taht moves according the the imc of the person. There are intervals and the green one is the IMC ideal and the ohtebr are red or yellow (see databse.sql for intervalls and their label to put in the progress bar.). 

Here is how I want the coherence of data to be: 
Better UX Flow
1. User enters
Taille
Poids actuel
1. User chooses ONE objective

Radio:

Perdre du poids
Prendre du poids
Atteindre mon IMC idéal

Keep this manual.
Do NOT auto-select the objective.

Why?
Because the user's intention matters more than your automatic logic.

Example:

someone slightly overweight may still want muscle gain,
someone in ideal IMC may still want weight loss for aesthetics.

So the system should guide, not force.

3. Dynamic fields appear
If "Perdre du poids"

Show:

“Poids cible”

Validation:

target weight must be LOWER than current weight
If "Prendre du poids"

Show:

“Poids cible”

Validation:

target weight must be HIGHER than current weight

If he is already in IMC ideal, then IMC idela radio is disabled (still add backend validation that he cant chose that obejctif.)

Also add this kind of logic in modifying the profil of the user.

Use AJAX ONLY for:

email already exists,
IMC live calculation,
maybe password strength meter.

That’s enough.

BAD USES of AJAX

Do NOT AJAX:

nom validity,
poids validity,
taille validity,
etc.

Use local JS validation for those.

Much faster and cleaner.

Neutral state

No icon initially.

Success

Small subtle green check.

Error

Red border + error text.

This is cleaner.

1. Password live validation

Good:

minimum length,
maybe uppercase,
maybe number.

So:

date_naissance nullable,
genre default "Autre".

Much cleaner.

Finally add a page of recap:
Final recap step

Before submit:

Récapitulatif
- Taille
- Poids
- IMC
- Objectif
- Poids cible

Then:

Créer mon compte

This would massively improve perceived professionalism.

USe CodeIgniter validation capacity for datas of Utilisateur
No CDN

I want professional SOC MVC code. Respeect UX rules and code profesionalism rules





When I want to login as admin it does a Whoops error. 
Also remove the se souvenir de moi checkbox and the mot de passe oublie


Utilisateur cards, on enelve le compte des admin, Donc normalemetn c est jsut 6.


GOLD: panel de voir offre et acheter Gold 



Read conception.md for context. You're now a profesional web dev with years of experience
We will do work on backoffice admin side:
We will first work on CRUD regime whic is related to CRUD DUree Regime and CRUD activite sortiive: 
Columns (keep it clean)
Nom du régime
Variation mensuelle (kg / mois)
Composition (viande / poisson / volaille)
Nb d’activités liées
Nb de durées disponibles

👉 Avoid dumping raw DB fields. Focus on decision info.

1. Regime Create / Edit page

This is where most logic lives.

Fields
Nom régime
Variation mensuelle (kg/month)
⚠️ clarify label: “kg / mois”, not “kg” alone
Composition:
% viande
% poisson
% volaille
Relations (important)
Activités sportives (multi-select)
Musculation, Running, etc.
Durées + prix (VERY IMPORTANT PART)
Add multiple rows:
nb_jours
prix
👉 This should be a dynamic table (add/remove rows)
3. Regime Detail page (READ ONLY)

This is where you show EVERYTHING structured:

Sections
🥗 Nutrition
Composition %
📉 Effet sur le poids
Variation mensuelle
Estimation perte/prise en 30/60/90 jours
🏃 Activités associées
List of sports
⏳ Durées disponibles
30 jours → 50 000 Ar
60 jours → 90 000 Ar
(etc.)
👤 Suggested users (optional advanced)
suited for “perdre du poids”
suited for “prise de masse”
suited for IMC ideal


Every page should still display teh sidebar in the left
Dont use CDN, use public\assets\icons

Side bar has utf 8 accents prob;eme, Dont use accent 





CRUD Duree-Prix 
CRUD Options
CRUD IMC 

No CDN