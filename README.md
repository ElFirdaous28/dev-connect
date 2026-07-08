# DevConnect - Réseau social pour développeurs

## 📌 Contexte
DevConnect est une application Laravel pensée pour les développeurs. Elle permet de partager du contenu technique, de mettre en avant son profil, de créer des connexions professionnelles et d'échanger autour de projets, compétences et opportunités.

## 🎯 Objectifs
- Faciliter la mise en relation entre développeurs.
- Offrir un espace pour publier du contenu technique et interagir avec d'autres profils.
- Valoriser les compétences, langages, projets et certifications de chaque utilisateur.
- Proposer des échanges rapides grâce aux commentaires, likes, messages privés et notifications.

## 🚀 Fonctionnalités clés

### 👤 Profil utilisateur enrichi
- Gestion d'un profil avec bio, headline et liens externes.
- Ajout de compétences techniques et de langages de programmation.
- Mise en avant des projets personnels et des certifications.

### 🔗 Connexions professionnelles
- Envoi de demandes de connexion à d'autres utilisateurs.
- Acceptation, rejet ou suppression d'une connexion.
- Consultation de la liste des connexions.

### 📝 Publications techniques
- Création, modification et suppression de posts.
- Ajout de hashtags pour organiser le contenu.
- Possibilité d'ajouter une image à une publication.

### ❤️ Interactions
- Likes sur les posts.
- Commentaires sur les publications.
- Mise à jour et suppression des commentaires.

### 💬 Messagerie privée
- Discussion directe entre utilisateurs connectés.
- Échange de messages dans un espace de chat dédié.

### 🔔 Notifications
- Notifications liées aux likes et aux commentaires.
- Base prête pour les échanges en temps réel.

### 🔍 Recherche
- Recherche de contenu et de profils via la page dédiée.

### 🎓 Portfolio développeur
- Gestion de projets.
- Gestion de certifications.
- Mise en avant des compétences techniques et des langages utilisés.

## 📜 User stories

### 1. Profil utilisateur
- En tant que développeur, je veux compléter mon profil avec mes compétences et mes projets afin de montrer mon expertise.
- En tant que développeur, je veux ajouter des liens vers mes profils externes afin de centraliser mon identité professionnelle.

### 2. Connexions
- En tant qu'utilisateur, je veux envoyer une demande de connexion à un autre développeur afin de développer mon réseau.
- En tant qu'utilisateur, je veux accepter ou refuser une demande afin de gérer mes relations professionnelles.

### 3. Publications
- En tant que développeur, je veux publier du contenu technique afin de partager mes connaissances.
- En tant que développeur, je veux modifier ou supprimer un post afin de garder mon contenu à jour.

### 4. Interactions
- En tant qu'utilisateur, je veux aimer un post afin de signaler mon intérêt.
- En tant qu'utilisateur, je veux commenter un post afin de poser une question ou apporter une précision.

### 5. Communication
- En tant qu'utilisateur, je veux envoyer un message privé à une connexion afin d'échanger plus facilement.

### 6. Recherche et organisation
- En tant qu'utilisateur, je veux utiliser des hashtags afin de classer les publications par thème.
- En tant qu'utilisateur, je veux rechercher un contenu ou un profil afin de retrouver rapidement ce qui m'intéresse.

## 🧱 Stack technique
- Laravel 10
- PHP 8.1+
- Tailwind CSS
- Vite
- Laravel Breeze
- Laravel Sanctum
- Pusher / Laravel Echo pour le temps réel

## ⚙️ Installation

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- Une base de données compatible Laravel

### Étapes
```bash
git clone <url-du-projet>
cd dev-connect
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

Pour lancer l'application en local :
```bash
php artisan serve
npm run dev
```

## 🧪 Tests
```bash
php artisan test
```

## 📁 Structure générale
- `app/` : modèles, contrôleurs, notifications et providers.
- `database/` : migrations, factories et seeders.
- `resources/` : vues, CSS et JavaScript.
- `routes/` : routes web, auth et canaux.
- `tests/` : tests Feature et Unit.

## ✅ État du projet
Le projet couvre déjà les bases d'un réseau social développeur : authentification, profil, posts, likes, commentaires, connexions, messagerie et recherche.

## 📌 Remarque
Ce README est volontairement orienté vers les fonctionnalités actuelles du projet. Il peut être complété avec des captures d'écran, un schéma de base de données ou des exemples d'utilisation si besoin.

