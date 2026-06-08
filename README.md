# Eastwestil Events

Eseménykezelő webalkalmazás. Laravel REST API backend + React frontend Bootstrap-pel.

---

## Projektstruktúra

```
eastwestil-events/
├── backend/        # Laravel API
├── frontend/       # React + Vite + Bootstrap
├── docker-compose.yml
└── README.md
```

---

## Környezeti változók

### Backend (`backend/.env`)

```env
APP_NAME="Events API"
APP_ENV=local
APP_KEY=                        # php artisan key:generate tölti ki
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1               # Dockerben: mysql (a service neve)
DB_PORT=3306
DB_DATABASE=events
DB_USERNAME=laravel
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### Frontend (`frontend/.env`)

```env
VITE_API_URL=http://localhost:8000/api
```

---

## Indítás – Docker (ajánlott)

### Követelmények
- Docker
- Docker Compose

### Elindítás

```bash
docker-compose up --build
```

Az alkalmazás elérhető:
- Frontend: `http://localhost:5173`
- Backend API: `http://localhost:8000/api`

### Leállítás

```bash
docker-compose down
```

### Adatbázis visszaállítása (törlés + migráció + seed)

```bash
docker exec event_backend php artisan migrate:fresh --seed
```

---

## Indítás – Lokálisan (Docker nélkül)

### Követelmények
- PHP 8.2+
- Composer
- Node.js 20+
- MySQL 8.0

### 1. Adatbázis létrehozása

```bash
mysql -u root -p
```

```sql
CREATE DATABASE events CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2. Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

A backend elérhető: `http://localhost:8000/api`

### 3. Frontend

Nyiss egy új terminált:

```bash
cd frontend
npm install
npm run dev
```

A frontend elérhető: `http://localhost:5173`

---

## API végpontok

| Metódus | URL | Leírás |
|---------|-----|--------|
| `GET` | `/api/events` | Összes esemény listája |
| `POST` | `/api/events` | Új esemény létrehozása |
| `GET` | `/api/events/{id}/attendees` | Esemény résztvevői |
| `POST` | `/api/events/{id}/register` | Regisztráció eseményre |

### Példa kérések

**Összes esemény:**
```bash
curl http://localhost:8000/api/events
```

**Új esemény:**
```bash
curl -X POST http://localhost:8000/api/events \
  -H "Content-Type: application/json" \
  -d '{"title": "Laravel Meetup", "date": "2025-10-01", "location": "Budapest"}'
```

**Regisztráció:**
```bash
curl -X POST http://localhost:8000/api/events/1/register \
  -H "Content-Type: application/json" \
  -d '{"name": "Kiss Péter", "email": "kiss.peter@example.com"}'
```

---

## Tesztek futtatása

```bash
cd backend
php artisan test
```

Dockerben:

```bash
docker exec event_backend php artisan test
```