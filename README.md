```
COACHPRO/
│
├── 📁 assets/
│   ├── 📁 css/
│   │   ├── style.css
│   │   ├── coach.css
│   │   └── sportif.css
│   │
│   ├── 📁 js/
│   │   ├── validation.js
│   │   ├── alert.js
│   │   └── calendrier.js
│   │
│   └── 📁 images/
│       ├── logo.png
│       ├── profil_default.png
│       └── background.jpg
│
├── 📁 auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── 📁 coach/
│   ├── dashboard.php         # Tableau de bord (réservations + statistiques)
│   └── profil.php            # Page simple pour modifier le profil du coach
│
├── 📁 sportif/
│   ├── dashboard.php         # Tableau de bord du sportif (coach list + réservations)
│   └── mes_reservations.php  # Historique et gestion des réservations
│
├── 📁 includes/
│   ├── header.php            # En-tête + navigation selon le rôle
│   ├── footer.php            # Pied de page
│   ├── nav_coach.php         # Barre de navigation pour coach
│   └── nav_sportif.php       # Barre de navigation pour sportif
│
├── 📁 config/
│   ├── config.php            # Connexion base de données (XAMPP)
│   └── fonctions.php         # Fonctions utilitaires (sécurité, redirection, etc.)
│
├── 📁 diagrams/
│   ├── ERD.png               # Diagramme de la base de données
│   └── usecase.png           # Diagramme des cas d’utilisation
│
├── database.sql              # Schéma complet de la base (français)
├── index.php                 # Page d’accueil principale
├── README.md                 # Documentation du projet (FR)
└── .gitignore
```