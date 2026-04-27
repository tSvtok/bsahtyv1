# B-SSAHTY 🏅

B-SSAHTY is a modern social platform for athletes to connect, share their sports journey, find local matches, and discover sports spots. Built with **Laravel 12** and **Vue 3**, it focuses on high performance, mobile responsiveness, and a premium user experience.

## 🚀 Features

- **Dynamic Feed**: Share posts with images, tag sports, and interact with the community.
- **Local Matches**: Organize or join sports events near you.
- **Sports Spots**: Interactive map to find stadiums, courts, and parks.
- **Real-time Messaging**: Chat with other athletes (Foundations implemented).
- **Athlete Profiles**: Showcase your bio, location, and favorite sports.
- **Premium UI**: Glassmorphic components, smooth animations, and tailored skeletons.

## 🛠 Tech Stack

- **Backend**: Laravel 12, PHP 8.4
- **Frontend**: Vue 3, Vite, Tailwind CSS, Pinia
- **Database**: PostgreSQL / MySQL
- **Real-time**: Laravel Reverb
- **Containerization**: Docker (multi-repo architecture)

## 📦 Setup Instructions

### Prerequisites
- Docker & Docker Compose
- Node.js & npm (for local frontend dev)

### Backend Setup
1. Navigate to the `backend` directory.
2. Run `docker-compose up -d`.
3. Install dependencies: `docker exec -u 1000 ecomcom-app composer install`.
4. Run migrations & seed: `docker exec -u 1000 ecomcom-app php artisan db:fresh-light` (fast) or `php artisan migrate:fresh --seed` (full data).
5. Link storage: `docker exec -u 1000 ecomcom-app php artisan storage:link`.

**For development iterations, use:**
```bash
# Fast reset with minimal data (2 seconds) - Recommended for daily work
docker exec -u 1000 ecomcom-app php artisan db:fresh-light

# Full reset with realistic data (5 seconds) - For comprehensive testing
docker exec -u 1000 ecomcom-app php artisan db:fresh-full

# Just run pending migrations (preserve data)
docker exec -u 1000 ecomcom-app php artisan migrate
```

See [DEV_WORKFLOW.md](DEV_WORKFLOW.md) for detailed development commands and [MIGRATION_OPTIMIZATION_GUIDE.md](MIGRATION_OPTIMIZATION_GUIDE.md) for architecture details.

### Frontend Setup
1. Navigate to the `frontend` directory.
2. Run `npm install`.
3. Start development server: `npm run dev`.

## 🧪 Testing

Run backend feature tests:
```bash
docker exec -u 1000 ecomcom-app php artisan test
```

## 📂 Project Structure

- `backend/`: Laravel 12 API.
- `frontend/`: Vue 3 SPA with Vite.
- `shared/`: Shared assets or configurations (if applicable).

## 📄 License
MIT
