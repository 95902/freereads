# 📚 FreeReads - Application de Gestion et Partage de Livres

## Description
**FreeReads** est une application web qui permet aux utilisateurs de gérer leur collection de livres, de suivre leur progression de lecture, de noter et commenter des livres, et de partager leurs listes de lecture avec d'autres utilisateurs. Ce projet est conçu pour les passionnés de lecture, les clubs de lecture ou toute personne souhaitant organiser et partager ses lectures.

## Fonctionnalités
- **Gestion de livres** : Ajouter, éditer et supprimer des livres de votre collection.
- **Notation par étoiles** : Évaluer les livres sur une échelle de 1 à 5 étoiles.
- **Système de commentaires** : Ajouter des commentaires sur les livres.
- **Suivi de lecture** : Taguer un livre comme "Lu" pour suivre votre progression.
- **Partage de listes de lecture** : Partager votre collection ou votre liste de lecture sur les réseaux sociaux ou via un lien unique.
- **Authentification utilisateur** : Inscription et connexion sécurisées pour chaque utilisateur.
- **Interface d'administration** : Gestion centralisée des données via une interface d’administration (intégration avec EasyAdmin).

## Installation
### Prérequis
- [Node.js](https://nodejs.org/) (version X.X.X)
- [npm](https://www.npmjs.com/) ou [yarn](https://yarnpkg.com/) pour la gestion des dépendances
- [Composer](https://getcomposer.org/) pour les dépendances PHP (si backend en PHP)
- Une base de données MySQL.

### Étapes d'installation
1. **Clonez le dépôt :**
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
   cd votre-repo

   # Commande `app:create-admin`

## **app:create-admin**
La commande `app:create-admin` permet de créer un utilisateur administrateur dans l'application Symfony avec une adresse e-mail, un mot de passe, et éventuellement un pseudo spécifiés.

---

## **Usage**
```bash
symfony console app:create-admin <email> <password> <pseudo>

symfony console app:create-admin admin2@test.com azertyuiop admin2
