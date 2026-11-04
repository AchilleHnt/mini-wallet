# MiniWallet

> Moteur de transferts d'argent simplifié, inspiré du Mobile Money, écrit en **PHP orienté objet** et exécuté en ligne de commande.

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-PSR--4-885630?logo=composer&logoColor=white)
![Licence](https://img.shields.io/badge/licence-MIT-green)

MiniWallet modélise le cœur d'un portefeuille électronique : des **comptes** qui contiennent de l'argent en FCFA, et un **service de transfert** qui déplace des fonds d'un compte à un autre en passant par une **passerelle de paiement**. Les passerelles sont **simulées** : aucun appel réseau n'est effectué. Le but du projet est de démontrer une architecture orientée objet propre, pas de brancher un vrai opérateur.

## Sommaire

- [Fonctionnalités](#fonctionnalités)
- [Règles métier](#règles-métier)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Architecture](#architecture)
- [Concepts POO illustrés](#concepts-poo-illustrés)
- [Ajouter une passerelle](#ajouter-une-passerelle)
- [Feuille de route](#feuille-de-route)
- [Auteur](#auteur)
- [Licence](#licence)

## Fonctionnalités

- Création de comptes avec un titulaire et un solde.
- Crédit et débit d'un compte, avec protection du solde.
- Transfert entre deux comptes via une passerelle interchangeable.
- Deux passerelles simulées au comportement différent (succès permanent, ou échec au-delà d'un plafond).
- Statuts de transaction typés (en attente, réussie, échouée) grâce à une énumération.
- Journalisation horodatée des opérations d'une passerelle.
- Exceptions métier explicites (montant invalide, solde insuffisant, passerelle indisponible).

## Règles métier

| Règle | Détail |
|---|---|
| Montant | Un nombre **entier** de FCFA, jamais négatif. |
| Solde | Il ne peut **jamais** être négatif, quel que soit le code appelant. |
| Transfert | Débit du compte source, passage par la passerelle, puis crédit du compte destinataire. |
| Échec de la passerelle | Le compte source retrouve exactement son solde d'avant. |
| Statut | Une transaction est en attente, réussie ou échouée. Réussie et échouée sont des statuts **finaux**. |
| Passerelle A | Réussit toujours. |
| Passerelle B | Échoue si le montant dépasse **500 000 FCFA**. |

## Prérequis

- **PHP 8.3** ou plus récent (`php -v`)
- **Composer** (`composer --version`)
- **Git**

Aucune base de données ni serveur web n'est nécessaire.

## Installation

```bash
git clone https://github.com/AchilleHnt/mini-wallet.git
cd mini-wallet
composer install
composer dump-autoload
```

## Utilisation

Le point d'entrée est `index.php`, qui contient un scénario de démonstration.

```bash
php index.php
```

### Exemple de code

```php
<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Compte;
use App\Montant;
use Paiement\PasserelleB;
use Service\TransfertService;

// Deux comptes de 3 000 FCFA
$a = new Compte('A', new Montant(3000));
$b = new Compte('B', new Montant(3000));

// On choisit la passerelle : c'est la seule ligne à changer pour en utiliser une autre
$passerelle = new PasserelleB();
$service    = new TransfertService($passerelle);

// A envoie 1 000 FCFA à B
$service->transferer($a, $b, new Montant(1000));

echo $passerelle->logs() . PHP_EOL;
echo "Solde de A : ".$a->getSolde()->showMontant()."\n";
echo "Solde de B : ".$b->getSolde()->showMontant()."\n";
```

Résultat attendu : le solde de A passe à 2 000 FCFA, celui de B à 4 000 FCFA, et la passerelle journalise l'opération.

### Scénarios à tester

| Scénario | Comportement attendu |
|---|---|
| Transfert de 1 000 FCFA avec la passerelle A ou B | Transfert réussi, soldes mis à jour. |
| Transfert supérieur au solde de la source | Une exception de solde insuffisant est levée, soldes inchangés. |
| Transfert de plus de 500 000 FCFA via la passerelle B | La passerelle échoue, la source est recréditée. |

## Architecture

```
MiniWallet/
├── composer.json                      # Autoload PSR-4
├── index.php                          # Scénario de démonstration
├── src/
│   ├── Bienvenue.php                  # Classe d'essai de l'autoload
│   ├── Compte.php                     # Compte avec solde protégé
│   ├── Montant.php                    # Objet valeur immuable (FCFA)
│   └── StatutTranscation.php          # Enum des statuts de transaction
├── Exception/
│   ├── MontantInvalide.php
│   ├── PasserelleIndisponible.php
│   └── SoldeInsuffisant.php
├── Paiement/
│   ├── PasserellePaiement.php         # Interface (le contrat)
│   ├── PasserelleAbstraite.php        # Code commun aux passerelles
│   ├── PasserelleA.php                # Réussit toujours
│   └── PasserelleB.php                # Échoue au-delà de 500 000 FCFA
├── Service/
│   └── TransfertService.php           # Orchestre le transfert
└── Traits/
    └── Horodatage.php                 # Horodatage des messages de journal
```

Autoload PSR-4 déclaré dans `composer.json` :

| Namespace | Dossier |
|---|---|
| `App\` | `src/` |
| `Exception\` | `Exception/` |
| `Paiement\` | `Paiement/` |
| `Service\` | `Service/` |
| `Traits\` | `Traits/` |

### Flux d'un transfert

```
TransfertService::transferer(source, destinataire, montant)
        │
        ├─ 1. débiter la source          (Compte)
        ├─ 2. exécuter via la passerelle (PasserellePaiement)
        │        ├─ succès  → 3. créditer le destinataire
        │        └─ échec   → recréditer la source, statut « échouée »
        └─ 4. journaliser l'opération    (trait d'horodatage)
```

## Concepts POO illustrés

| Concept | Où le voir |
|---|---|
| Objet valeur immuable | `Montant` : une opération renvoie un nouveau montant au lieu de modifier l'existant. |
| Encapsulation | `Compte` : le solde est privé, modifiable seulement par `crediter()` et `debiter()`. |
| Enum | Statut de transaction : plus aucune chaîne « magique » dans le code. |
| Interface | `PasserellePaiement` : le contrat commun à toutes les passerelles. |
| Classe abstraite | Code partagé entre les passerelles. |
| Trait | Horodatage des messages de journal. |
| Exceptions | Erreurs métier distinctes plutôt que des `false` ou des messages texte. |
| Injection de dépendances | `TransfertService` reçoit sa passerelle dans le constructeur. |
| Polymorphisme | Changer de passerelle sans toucher au service. |
| Autoloading PSR-4 | Aucune ligne `require` manuelle pour les classes. |

## Ajouter une passerelle

Grâce à l'interface et à l'injection de dépendances, une nouvelle passerelle demande **un seul nouveau fichier** :

1. Crée `Paiement/PasserelleC.php` dans le namespace `Paiement`.
2. Implémente `PasserellePaiement` (méthodes `executer()` et `nom()`), en étendant la classe abstraite si besoin.
3. Passe-la au service : `new TransfertService(new PasserelleC())`.

Aucun autre fichier n'est modifié.

## Feuille de route

- [ ] Tests unitaires avec PHPUnit ou Pest (montant négatif, immutabilité, débit refusé, échec de passerelle avec un faux objet)
- [ ] Fichier `.gitignore` et retrait du dossier `vendor/` du dépôt
- [ ] Historique des transactions avec leur statut
- [ ] Bonus PHP 8.4 / 8.5 : visibilité asymétrique, property hooks, `clone` avec modifications
- [ ] Étape suivante du parcours : application web de gestion de créances (MVC, PDO, MySQL)

## Auteur

**Achille Hounmonto** : [@AchilleHnt](https://github.com/AchilleHnt)

Projet réalisé dans le cadre d'un parcours d'apprentissage de la programmation orientée objet en PHP.

## Licence

Distribué sous licence MIT.