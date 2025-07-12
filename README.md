# Système de Gestion de Magasin (Back-Office)

Un système de gestion de magasin complet développé avec Laravel et Laravel Nova pour la gestion interne d'une entreprise commerciale.

## Fonctionnalités

### 🔐 Gestion des administrateurs
- Authentification sécurisée pour le personnel interne
- Dashboard avec statistiques en temps réel
- Interface d'administration intuitive avec Laravel Nova

### 📊 Dashboard et Statistiques
- Nombre total de commandes
- Chiffre d'affaires
- Produits en stock faible
- Répartition des commandes par statut
- Alertes automatiques sur les stocks

### 🛍️ Gestion des produits
- CRUD complet des produits (nom, description, prix, stock, image)
- Organisation par catégories
- Suivi des stocks avec alertes automatiques
- Seuil d'alerte personnalisable par produit

### 📂 Gestion des catégories
- Création, modification et suppression de catégories
- Organisation hiérarchique des produits
- Interface intuitive pour la gestion

### 👥 Gestion des clients
- Enregistrement des informations clients (nom, adresse, téléphone, email)
- Modification et suppression des fiches clients
- Historique des commandes par client

### 📦 Gestion des commandes
- Saisie de nouvelles commandes pour un client
- Association des produits commandés avec leurs quantités
- Statuts de commande : En attente, Validée, Livrée, Annulée
- Décrément automatique du stock lors de la validation
- Calcul automatique du montant total

## Technologies utilisées

- **Backend** : Laravel 12.x
- **Interface d'administration** : Laravel Nova 5.x
- **Base de données** : MySQL
- **Déploiement** : Laravel Envoy

## Installation

### Prérequis
- PHP 8.2+
- Composer
- MySQL
- Node.js et NPM

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd todo
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
Modifiez le fichier `.env` avec vos informations de base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo
DB_USERNAME=root
DB_PASSWORD=
```

5. **Exécuter les migrations**
```bash
php artisan migrate
```

6. **Peupler la base de données**
```bash
php artisan db:seed
```

7. **Compiler les assets**
```bash
npm run build
```

8. **Démarrer le serveur**
```bash
php artisan serve
```

## Structure de la base de données

### Tables principales
- **users** : Administrateurs du système
- **categories** : Catégories de produits
- **products** : Produits avec stock
- **customers** : Clients
- **orders** : Commandes
- **order_items** : Éléments de commande (relation many-to-many)

### Relations
- Un produit appartient à une catégorie
- Un client peut avoir plusieurs commandes
- Une commande peut contenir plusieurs produits
- Les commandes ont différents statuts

## Utilisation

### Accès à l'interface d'administration
1. Accédez à `http://localhost:8000/nova`
2. Connectez-vous avec les identifiants d'administrateur

### Gestion des commandes
1. **Créer une commande** : Sélectionnez un client et ajoutez des produits
2. **Valider une commande** : Utilisez l'action "Valider la commande" (décrémente automatiquement les stocks)
3. **Marquer comme livrée** : Utilisez l'action "Marquer comme livrée"

### Gestion des stocks
- Les alertes de stock faible apparaissent automatiquement sur le dashboard
- Le stock est décrémenté automatiquement lors de la validation des commandes
- Chaque produit a un seuil d'alerte personnalisable

## Déploiement

### Avec Laravel Envoy

1. **Configurer le serveur**
Modifiez le fichier `Envoy.blade.php` avec vos informations de serveur.

2. **Déployer**
```bash
envoy run deploy
```

3. **Sauvegarder**
```bash
envoy run backup
```

4. **Rollback en cas de problème**
```bash
envoy run rollback
```

### Déploiement manuel

1. **Préparer le serveur**
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Configurer les permissions**
```bash
chown -R www-data:www-data /path/to/project
chmod -R 755 /path/to/project
chmod -R 775 /path/to/project/storage
chmod -R 775 /path/to/project/bootstrap/cache
```

## Sécurité

- Authentification sécurisée pour les administrateurs
- Validation des données côté serveur
- Protection CSRF
- Gestion sécurisée des sessions

## Maintenance

### Tâches de maintenance recommandées
- Sauvegardes régulières de la base de données
- Surveillance des logs d'erreur
- Mise à jour régulière des dépendances
- Nettoyage des caches

### Commandes utiles
```bash
# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Vérifier les stocks faibles
php artisan tinker
>>> App\Models\Product::whereRaw('stock <= stock_alert_threshold')->get();
```

## Support

Pour toute question ou problème, consultez la documentation Laravel et Laravel Nova, ou contactez l'équipe de développement.

## Licence

Ce projet est sous licence MIT.
