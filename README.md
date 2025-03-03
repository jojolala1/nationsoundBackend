***


# **📚 API Documentation for the Festival**

## **🎯 Introduction**

This private API allows managing artists, venues, users, and sites related to the festival.\
Some endpoints are public, while others require authentication via a JWT token.

- **Base URL (Prod)**: [https://api.festival.com](https://api.festival.com)

- **Base URL (Local)**: [http://localhost:8000](http://localhost:8000)

- **Data Format**: application/json

- **Authentication**: JWT (with token refresh)

***

## **🌐 Technologies**

- **Frontend**: [React.js](github: https://github.com/jojolala1/NationSound.git)
- **Framework Backend**: [Symfony]
- **Database**: [Mariadb]
- **Deployment**: [Hostinger vps]
- **Styling**: [Bootstrap CSS and scc custom]

## **🚀 Running Locally**

```bash
git clone https://github.com/jojolala1/nationsoundBackend.git
composer require
symfony server:start
```

## **🔐 Authentication & Token Management**

### **1️⃣ Login**

- **URL**: POST `/auth`

- **Access**: Public ✅

- **Description**: Authenticates a user and returns an access token (JWT) + a refresh token.


#### **📥 Request:**

json

```json
{ "email": "admin@festival.com", "password": "Password123!" }
```


#### **📤 Response:**

json

```json
{ "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...", "refresh_token": "741f6a52f4589c8ccd0851f005e05093..." }
```


### **2️⃣ Refresh Access Token**

- **URL**: GET `/token/refresh`

- **Access**: Public ✅

- **Description**: Allows obtaining a new access token using the refresh token.


#### **📥 Request:**

json

```json
{ "refresh_token": "741f6a52f4589c8ccd0851f005e05093218ecdc3b7edd6e0338d0f223b6b0090..." }
```


#### **📤 Response:**

json

```json
{ "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." }
```


#### **🚀 Example Usage:**

text

```text
Authorization: Bearer <your_token>
```

***


## **📋 Access Permissions Table**

|                      |              |           |                   |
| :------------------: | :----------: | :-------: | :---------------: |
|     **Endpoint**     |  **Method**  | **Access**|  **Required Role**|
|        `/auth`       |     POST     |   Public  |       None        |
|   `/token/refresh`   |      GET     |   Public  |       None        |
|    `/api/artists`    |      GET     |   Public  |       None        |
|    `/api/artists`    |     POST     |   Private | Authenticated (JWT)|
| `/api/artists/{id}`  |      GET     |   Public  |       None        |
| `/api/artists/{id}`  | PATCH/DELETE |   Private | Authenticated (JWT)|
|     `/api/places`    |      GET     |   Public  |       None        |
|     `/api/places`    |     POST     |   Private | Authenticated (JWT)|
|   `/api/sites/{id}`  |      GET     |   Public  |       None        |
|   `/api/sites/{id}`  |     PATCH    |   Private | Authenticated (JWT)|
|     `/api/users`     |   GET/POST   |   Private | Authenticated (JWT)|

***


## **🎤 Resource: Artist**

### **📥 GET** `/api/artists`

- **Access**: Public ✅

- **Description**: Retrieves the list of artists.


#### **📤 Example Response:**

json

```json
[
    { "id": 1, "name": "DJ Sonic", "date": "2024-08-15T20:00:00Z", "time": "20:00", "stage": "Main Stage", "style": "Electro", "description": "An energetic DJ", "videoLink": "https://youtube.com/xyz", "imageName": "dj_sonic.jpg" }
]
```


### **➕ POST** `/api/artists`

- **Access**: Private 🔒 (JWT required)

- **Description**: Creates a new artist.


#### **📥 Request:**

json

```json
{ "name": "The Rockers", "date": "2024-08-16T18:00:00Z", "time": "18:00", "stage": "Stage B", "style": "Rock", "description": "Alternative rock band", "videoLink": "https://youtube.com/therockers" }
```


### **🔍 GET** `/api/artists/{id}`

- **Access**: Public ✅

- **Description**: Retrieves details of a specific artist.


### **✏️ PATCH** `/api/artists/{id}`

- **Access**: Private 🔒 (JWT required)

- **Description**: Updates artist information.


### **🗑️ DELETE** `/api/artists/{id}`

- **Access**: Private 🔒 (JWT required)

- **Description**: Deletes an artist.

***


## **📍 Resource: Place**

### **📥 GET** `/api/places`

- **Access**: Public ✅

- **Description**: List of festival venues.


#### **📤 Example Response:**

json

```json
[ { "id": 1, "name": "Main Stage", "latitude": 48.8566, "longitude": 2.3522, "iconClass": "stage-icon", "category": "Concert", "opening": "2024-08-15T10:00:00Z", "closing": "2024-08-15T23:00:00Z", "description": "Main stage" } ]
```


### **➕ POST** `/api/places`

- **Access**: Private 🔒 (JWT required)

- **Description**: Creates a venue.

***


## **🌐 Resource: Site**

### **🔍 GET** `/api/sites/{id}`

- **Access**: Public ✅

- **Description**: Details of a site.


### **✏️ PATCH** `/api/sites/{id}`

- **Access**: Private 🔒 (JWT required)

- **Description**: Updates site information.

***


## **👥 Resource: User**

### **📥 GET** `/api/users`

- **Access**: Private 🔒 (JWT required)

- **Description**: List of users.


### **➕ POST** `/api/users`

- **Access**: Private 🔒 (JWT required)

- **Description**: Creates a new user.

***


## **⚠️ Error Handling**

All errors are returned in JSON format:


#### **Example Error Response:**

json

```json
{ "code": 401, "message": "Unauthorized access" }
```


### **Error Codes:**

|          |                                 |
| :------: | :-----------------------------: |
| **Code** |         **Description**         |
|    400   |         Bad Request             |
|    401   |  Unauthorized (missing token)   |
|    403   | Forbidden (insufficient role)   |
|    404   |      Resource Not Found         |
|    500   |          Server Error           |
