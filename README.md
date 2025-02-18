***

# **📚 Festival API Documentation**

## **🎯 Introduction**

This private API allows you to manage artists, venues, users, and the festival website.\
Some endpoints are public, while others require authentication via a JWT token.

- **Base URL (Prod)** :[ https://api.festival.com](https://api.festival.com)

- **Base URL (Local)** :[ http://localhost:8000](http://localhost:8000)

- **Data format** : application/json

- **Authentication** : JWT (with token refresh)

***

## **🔐 Authentication & Token Management**

### **1️⃣ Login**

- **URL** : POST `/auth`

- **Access** : Public ✅

- **Description** : Authenticates a user and returns an access token (JWT) + a refresh token.

#### **📥 Request:**

json

CopyEdit

{ "email": "admin@festival.com", "password": "Password123!" }

#### **📤 Response:**

json

CopyEdit

{ "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...", "refresh_token": "741f6a52f4589c8ccd0851f005e05093..." }

### **2️⃣ Refresh the Access Token**

- **URL** : GET `/token/refresh`

- **Access** : Public ✅

- **Description** : Allows you to obtain a new access token using the refresh token.

#### **📥 Request:**

json

CopyEdit

{ "refresh_token": "741f6a52f4589c8ccd0851f005e05093218ecdc3b7edd6e0338d0f223b6b0090..." }

#### **📤 Response:**

json

CopyEdit

{ "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." }

#### **🚀 Example of use:**

text

CopyEdit

Authorization: Bearer <your_token>

***

## **📋 Table of Access Permissions**

|                      |              |           |                   |
| :------------------: | :----------: | :-------: | :---------------: |
|     **Endpoint**     |  **Method** | **Access** |  **RequiredRole **  |
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


## **🎤 Resource: Artist**

### **📥 GET** `/api/artists`

- **Access**: Public ✅

- **Description**: Retrieves the list of artists.

#### **📤 Example Response:**

json

CopyEdit

[
{ "id": 1, "name": "DJ Sonic", "date": "2024-08-15T20:00:00Z", "time": "20:00", "stage": "Main Stage", "style": "Electro", "description": "An energetic DJ", "videoLink": "https://youtube.com/xyz", "imageName": "dj_sonic.jpg" }
]

### **➕ POST** `/api/artistes`

- **Access** : Private 🔒 (JWT required)

- **Description** : Creates a new artist.

#### **📥 Request:**

json

CopyEdit

{ "name": "The Rockers", "date": "2024-08-16T18:00:00Z", "time": "18:00", "stage": "Stage B", "style": "Rock", "description": "Alternative rock band", "videoLink": "https://youtube.com/therockers" }

### **🔍 GET** `/api/artists/{id}`

- **Access** : Public ✅

- **Description** : Get details of a specific artist.

### **✏️ PATCH** `/api/artists/{id}`

- **Access** : Private 🔒 (JWT required)

- **Description** : Update information of an artist.

### **🗑️ DELETE** `/api/artistes/{id}`

- **Access** : Private 🔒 (JWT required)

- **Description** : Delete an artist.

***

## **📍 Resource : Place**

### **📥 GET** `/api/places`

- **Access** : Public ✅

- **Description** : List of festival venues.

#### **📤 Example Response:**

json

CopyEdit

[ { "id": 1, "name": "Main Stage", "latitude": 48.8566, "longitude": 2.3522, "iconClass": "stage-icon", "category": "Concert", "opening": "2024-08-15T10:00:00Z", "closing": "2024-08-15T23:00:00Z", "description": "Main Stage" } ]

### **➕ POST** `/api/places`

- **Access** : Private 🔒 (JWT required)

- **Description** : Creates a venue.

***

## **🌐 Resource: Site**

### **🔍 GET** `/api/sites/{id}`

- **Access**: Public ✅

- **Description**: Details of a site.

### **✏️ PATCH** `/api/sites/{id}`

- **Access**: Private 🔒 (JWT required)

- **Description**: Update information of a site.

***

## **👥 Resource: User**

### **📥 GET** `/api/users`

- **Access**: Private 🔒 (JWT required)

- **Description**: List of users.

### **➕ POST** `/api/users`

- **Access** : Private 🔒 (JWT required)

- **Description** : Creates a new user.

***

## **⚠️ Error Handling**

All errors are returned in JSON format:

#### **Err Response Example
