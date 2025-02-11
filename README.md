***


# **📚 Documentation de l'API du Festival**

## **🎯 Introduction**

Cette API privée permet de gérer les artistes, les lieux, les utilisateurs, et les sites liés au festival.\
Certains endpoints sont publics, tandis que d’autres nécessitent une authentification via un token JWT.

- **Base URL (Prod)** :[ https://api.festival.com](https://api.festival.com)

- **Base URL (Local)** :[ http://localhost:8000](http://localhost:8000)

- **Format des données** : application/json

- **Authentification** : JWT (avec rafraîchissement de token)

***


## **🔐 Authentification & Gestion des Tokens**

### **1️⃣ Connexion (Login)**

- **URL** : POST `/auth`

- **Accès** : Public ✅

- **Description** : Authentifie un utilisateur et retourne un token d’accès (JWT) + un refresh token.


#### **📥 Requête :**

json

CopyEdit

    { "email": "admin@festival.com", "password": "Password123!" }


#### **📤 Réponse :**

json

CopyEdit

    { "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...", "refresh_token": "741f6a52f4589c8ccd0851f005e05093..." }


### **2️⃣ Rafraîchir le Token d’Accès**

- **URL** : GET `/token/refresh`

- **Accès** : Public ✅

- **Description** : Permet d’obtenir un nouveau token d’accès grâce au refresh token.


#### **📥 Requête :**

json

CopyEdit

    { "refresh_token": "741f6a52f4589c8ccd0851f005e05093218ecdc3b7edd6e0338d0f223b6b0090..." }


#### **📤 Réponse :**

json

CopyEdit

    { "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." }


#### **🚀 Exemple d’utilisation :**

text

CopyEdit

    Authorization: Bearer <votre_token>

***


## **📋 Tableau des Permissions d'Accès**

|                      |              |           |                   |
| :------------------: | :----------: | :-------: | :---------------: |
|     **Endpoint**     |  **Méthode** | **Accès** |  **Rôle Requis**  |
|        `/auth`       |     POST     |   Public  |       Aucun       |
|   `/token/refresh`   |      GET     |   Public  |       Aucun       |
|    `/api/artistes`   |      GET     |   Public  |       Aucun       |
|    `/api/artistes`   |     POST     |   Privé   | Authentifié (JWT) |
| `/api/artistes/{id}` |      GET     |   Public  |       Aucun       |
| `/api/artistes/{id}` | PATCH/DELETE |   Privé   | Authentifié (JWT) |
|     `/api/places`    |      GET     |   Public  |       Aucun       |
|     `/api/places`    |     POST     |   Privé   | Authentifié (JWT) |
|   `/api/sites/{id}`  |      GET     |   Public  |       Aucun       |
|   `/api/sites/{id}`  |     PATCH    |   Privé   | Authentifié (JWT) |
|     `/api/users`     |   GET/POST   |   Privé   | Authentifié (JWT) |

***


## **🎤 Ressource : Artiste**

### **📥 GET** `/api/artistes`

- **Accès** : Public ✅

- **Description** : Récupère la liste des artistes.


#### **📤 Exemple de Réponse :**

json

CopyEdit

    [
      { "id": 1, "name": "DJ Sonic", "date": "2024-08-15T20:00:00Z", "time": "20:00", "stage": "Main Stage", "style": "Electro", "description": "Un DJ énergique", "videoLink": "https://youtube.com/xyz", "imageName": "dj_sonic.jpg" }
    ]


### **➕ POST** `/api/artistes`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Crée un nouvel artiste.


#### **📥 Requête :**

json

CopyEdit

    { "name": "The Rockers", "date": "2024-08-16T18:00:00Z", "time": "18:00", "stage": "Stage B", "style": "Rock", "description": "Groupe de rock alternatif", "videoLink": "https://youtube.com/therockers" }


### **🔍 GET** `/api/artistes/{id}`

- **Accès** : Public ✅

- **Description** : Récupère les détails d’un artiste spécifique.


### **✏️ PATCH** `/api/artistes/{id}`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Met à jour les informations d’un artiste.


### **🗑️ DELETE** `/api/artistes/{id}`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Supprime un artiste.

***


## **📍 Ressource : Place**

### **📥 GET** `/api/places`

- **Accès** : Public ✅

- **Description** : Liste des lieux du festival.


#### **📤 Exemple de Réponse :**

json

CopyEdit

    [ { "id": 1, "name": "Main Stage", "latitude": 48.8566, "longitude": 2.3522, "iconClass": "stage-icon", "category": "Concert", "opening": "2024-08-15T10:00:00Z", "closing": "2024-08-15T23:00:00Z", "description": "Scène principale" } ]


### **➕ POST** `/api/places`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Crée un lieu.

***


## **🌐 Ressource : Site**

### **🔍 GET** `/api/sites/{id}`

- **Accès** : Public ✅

- **Description** : Détails d’un site.


### **✏️ PATCH** `/api/sites/{id}`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Mise à jour des informations d’un site.

***


## **👥 Ressource : User**

### **📥 GET** `/api/users`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Liste des utilisateurs.


### **➕ POST** `/api/users`

- **Accès** : Privé 🔒 (JWT requis)

- **Description** : Crée un nouvel utilisateur.

***


## **⚠️ Gestion des Erreurs**

Toutes les erreurs sont renvoyées au format JSON :


#### **Exemple de Réponse d'Erreur :**

json

CopyEdit

    { "code": 401, "message": "Accès non autorisé" }


### **Codes d'erreur :**

|          |                                 |
| :------: | :-----------------------------: |
| **Code** |         **Description**         |
|    400   |         Mauvaise requête        |
|    401   |  Non autorisé (token manquant)  |
|    403   | Accès refusé (rôle insuffisant) |
|    404   |      Ressource non trouvée      |
|    500   |          Erreur serveur         |
