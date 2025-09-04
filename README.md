# 💼 AppliFrais - Application de Gestion des Notes de Frais

> 🎓 **Projet étudiant BTS SIO SLAM** - Réalisé en alternance  
> 📅 **Année** : 2023-2024  
> 🎯 **Objectif** : Développement d'une application web moderne pour la gestion des notes de frais

## 📋 À Propos

**AppliFrais** est une application web complète développée dans le cadre de ma formation BTS SIO spécialité SLAM (Solutions Logicielles et Applications Métiers) en alternance. Ce projet illustre ma capacité à concevoir et développer une solution métier moderne en utilisant les technologies web actuelles.

### 🎯 Fonctionnalités Principales

- **📝 Gestion des notes de frais** : Création, édition et suivi des frais professionnels
- **💰 Frais forfait et hors forfait** : Support complet des différents types de frais
- **📊 Tableau de bord interactif** : Visualisation des données avec des graphiques dynamiques
- **🔐 Authentification sécurisée** : Système de connexion et gestion des utilisateurs
- **📱 Interface responsive** : Design adaptatif pour tous les appareils
- **⚡ Temps réel** : Mise à jour dynamique sans rechargement de page

## 🛠️ Stack Technique

### Backend
- **🐘 PHP 8.4** - Langage serveur moderne
- **🔥 Laravel 11** - Framework PHP élégant et puissant
- **🗄️ PostgreSQL** - Base de données relationnelle robuste
- **🔒 Laravel Sanctum** - Authentification API sécurisée

### Frontend
- **🟢 Vue.js 3** - Framework JavaScript progressif
- **⚡ Support TypeScript** - Configuration et build avec TypeScript
- **🌊 Inertia.js** - SPA moderne sans API
- **🎨 Tailwind CSS** - Framework CSS utilitaire
- **📊 Chart.js** - Bibliothèque de graphiques interactifs
- **🎯 PrimeVue** - Composants UI professionnels

### Outils & DevOps
- **⚡ Vite** - Build tool ultra-rapide
- **🧪 Pest** - Framework de tests PHP moderne
- **📦 Composer** - Gestionnaire de dépendances PHP
- **📦 npm** - Gestionnaire de paquets JavaScript

## 🚀 Installation & Démarrage

### Prérequis
- PHP 8.4+
- Node.js 23.0+
- PostgreSQL 13+
- Composer

### Installation

```bash
# Cloner le repository
git clone https://github.com/CelianDev/appli-frais.git
cd appli-frais

# Installation des dépendances PHP
composer install

# Installation des dépendances JavaScript
npm install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Configuration de la base de données dans .env
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=appli_frais
# DB_USERNAME=votre_user
# DB_PASSWORD=votre_password

# Migration et seeders
php artisan migrate --seed
```

### Lancement

```bash
# Serveur de développement PHP
php artisan serve

# Dans un autre terminal - Build des assets
npm run dev
```

L'application sera accessible sur `http://localhost:8000`

## 📸 Aperçus

### 🔑 Comptes de démonstration
```
👤 Utilisateur standard
Email: zenscripter@example.com
Mot de passe: password

👨‍💼 Compte jury
Email: jury.2025@gsb.fr
Mot de passe: JURY.2025
```

## 🏗️ Architecture

```
appli-frais/
├── app/                    # Logique métier Laravel
│   ├── Http/Controllers/   # Contrôleurs
│   └── Models/            # Modèles Eloquent
├── database/              # Migrations et seeders
├── resources/
│   ├── js/
│   │   ├── Components/    # Composants Vue réutilisables
│   │   └── Pages/        # Pages de l'application
│   └── views/            # Templates Blade
├── routes/               # Définition des routes
└── tests/               # Tests automatisés
```

## 🎨 Fonctionnalités Détaillées

### Dashboard Interactif
- **📊 Graphiques dynamiques** avec Chart.js
- **📈 Statistiques en temps réel** des dépenses
- **🎯 Vue d'ensemble** des frais par période

### Gestion des Frais
- **➕ Ajout simple** de nouveaux frais
- **✏️ Modification** des frais existants
- **🗑️ Suppression** avec confirmation
- **📋 Historique complet** des modifications

### Interface Utilisateur
- **🎨 Design moderne** avec Tailwind CSS
- **📱 Responsive design** pour mobile et desktop
- **⚡ Navigation fluide** sans rechargements
- **🔔 Notifications** en temps réel

## 🧪 Tests

```bash
# Lancer les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 🎓 Compétences Démontrées

### Développement Backend
- ✅ Architecture MVC avec Laravel
- ✅ Gestion des bases de données avec Eloquent ORM
- ✅ API RESTful et authentification
- ✅ Validation des données et sécurité

### Développement Frontend
- ✅ Application SPA avec Vue.js 3
- ✅ Support TypeScript pour le build et la configuration
- ✅ Composants réutilisables et modulaires
- ✅ Intégration d'APIs et gestion d'état

### Bonnes Pratiques
- ✅ Code propre et documenté
- ✅ Tests automatisés
- ✅ Sécurité et protection des données
- ✅ Git workflow et versioning

## 📚 Contexte Pédagogique

Ce projet s'inscrit dans le cadre de ma formation **BTS SIO SLAM** en alternance et démontre :

- 🎯 **Analyse des besoins** et conception d'une solution métier
- 🛠️ **Développement full-stack** avec des technologies modernes
- 🔒 **Sécurisation** d'une application web
- 📊 **Intégration** de fonctionnalités de reporting
- 🚀 **Déploiement** et mise en production

## 📞 Contact

- 📧 **Email** : [votre-email]
- 💼 **LinkedIn** : [votre-linkedin]
- 🐙 **GitHub** : [votre-github]

---

### 🤝 À l'attention des recruteurs

Ce projet illustre ma capacité à :
- Développer une application web complète et moderne
- Maîtriser un stack technique varié (PHP/Laravel + Vue.js/TypeScript)
- Suivre les bonnes pratiques de développement
- Travailler de manière autonome et méthodique

N'hésitez pas à explorer le code et à me contacter pour toute question ! 😊

---

*⭐ Si ce projet vous plaît, n'hésitez pas à le starrer !*
